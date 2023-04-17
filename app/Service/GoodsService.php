<?php


namespace App\Service;

use App\Enum\ErrorEnum;
use App\Exceptions\ApiException;
use App\Models\Bargaining;
use App\Models\Brand;
use App\Models\Campus;
use App\Models\Collection;
use App\Models\ContractLesson;
use App\Models\ContractTransferInfos;
use App\Models\Goods;
use App\Models\LessonCategory;
use App\Models\Order;
use App\Models\WechatUser;
use App\Repositories\GoodsRep;
use Carbon\Carbon;

class GoodsService extends BaseServiceAbstract
{
    private $goodsRep;
    private $builder;

    public function __construct(GoodsRep $goodsRep)
    {
        $this->goodsRep = $goodsRep;
    }

    public function findById($id)
    {
        $goods = $this->goodsRep->find($id);
        return $goods;
    }

    public function findByIdForLock($id)
    {
        $goods = $this->goodsRep->lockForUpdate($id);
        return $goods;
    }

    /**
     *保存商品相关数据
     *
     * @author yezi
     * @param array $goods
     * @param array $contact
     * @param array $tranferInfo
     * @return array
     * @throws ApiException
     */
    public function storeGoods(array $goods,array $contact,array $tranferInfo)
    {
        $goodsModel = new Goods();
        foreach ($goods as $key => $item){
            $goodsModel->{$key} = $item;
        }

        if (!in_array($goodsModel->{Goods::FIELD_TYPE},[Goods::ENUM_TYPE_USER,Goods::ENUM_TYPE_ADMIN])){
            throw new ApiException("商品创建类型错误",ErrorEnum::GOODS_CREATE_TYPE_ERR);
        }

        if ($goodsModel->{Goods::FIELD_PRICE} <= 0){
            throw new ApiException("商品价格不能小于等于0");
        }

        if ($goodsModel->{Goods::FIELD_DISCOUNT} < 0){
            throw new ApiException("商品折扣不能小于0");
        }

        if (!in_array($goodsModel->{Goods::FIELD_BARGAINING},[Goods::ENUM_BAR_Y,Goods::ENUM_BAR_N])){
            throw new ApiException("商品一口价参数错误");
        }

        if ($goodsModel->{Goods::FIELD_SERVICE_CHARGE} < 0){
            throw new ApiException("手续费不能小于0");
        }

        if ($goodsModel->{Goods::FIELD_ACTUAL_RECEIPT} < 0){
            throw new ApiException("卖家实际到账金额不能小于0");
        }

        if ($goodsModel->{Goods::FIELD_STATUS} <= 0 || $goodsModel->{Goods::FIELD_STATUS} > 7){
            throw new ApiException("商品状态错误");
        }

        $saveGoods = $this->goodsRep->store($goodsModel);
        if (!$saveGoods){
            throw new ApiException("发布课程失败",ErrorEnum::GOODS_SAVE_FAIL);
        }

        $contractResult = app(ContractLessonService::class)->storeContract($saveGoods->id,$contact);
        if (!$contractResult){
            throw new ApiException("课程合同信息保存事变",ErrorEnum::GOODS_CONTRACT_SAVE_FAIL);
        }

        $transferInfoResult = app(ContractTransService::class)->storeTransInfo($saveGoods->id,$tranferInfo);
        if (!$transferInfoResult){
            throw new ApiException("转让信息保存失败",ErrorEnum::GOODS_TRANSFER_SAVE_FAIL);
        }

        return [$saveGoods,$contractResult,$transferInfoResult];
    }

    /**
     * 校验商品的基本信息
     *
     * @author yezi
     * @param $request
     * @throws ApiException
     */
    static function validBaseParams($request)
    {
        $rules    = [
            'campus'        => 'required',
            'contact'       => 'required',
            'transfer_info' => 'required',
        ];
        $message = [
            'campus.required'        => '校区资料不能为空',
            'contact.required'       => '合同资料不能为空',
            'transfer_info.required' => '转让信息不能为空',
        ];
        $validator = \Validator::make($request->all(),$rules,$message);
        if ($validator->fails()) {
            $errors = $validator->errors();
            throw new ApiException($errors->first(),ErrorEnum::GOODS_PARAMS_NULL);
        }
    }

    /**
     * 检测参数是否为空
     *
     * @author yezi
     * @param array $requires
     * @param array $data
     * @throws ApiException
     */
    static public function checkParams(array $requires,array $data)
    {
        foreach ($requires as $key=>$item){
            if (!key_exists($key,$data)){
                throw new ApiException("{$item}不能为空",ErrorEnum::GOODS_PARAMS_NULL);
            }
        }
    }

    public function checkDateFormat($date)
    {
        //匹配日期格式
        if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts))
        {
            //检测是否为日期
            if(checkdate($parts[2],$parts[3],$parts[1]))
                return true;
            else
                return false;
        }
        else
            return false;
    }

    /**
     * 校验校区资料
     *
     * @author yezi
     * @param array $data
     * @throws ApiException
     */
    static public function checkCampusDataExist(array $data){
        /*$brand = app(BrandService::class)->findById($data["brand_id"]);
        if (!$brand){
            throw new ApiException("品牌不存在",ErrorEnum::GOODS_BRAND_NOT_FOUND);
        }*/

        if (key_exists("course_type_id",$data)){
            $category = app(LessonCategoryService::class)->findById($data["course_type_id"]);
            if (!$category){
                throw new ApiException("课程类型不存在",ErrorEnum::GOODS_LESSON_CATEGORY_NOT_FOUND);
            }
        }

        if (key_exists("lesson_category_id",$data)){
            $category = app(LessonCategoryService::class)->findById($data["lesson_category_id"]);
            if (!$category){
                throw new ApiException("课程类型不存在",ErrorEnum::GOODS_LESSON_CATEGORY_NOT_FOUND);
            }
        }

        /*if (key_exists("campus_id",$data)){
            $campus = app(CampusService::class)->findById($data["campus_id"]);
            if (!$campus){
                throw new ApiException("校区不存在",ErrorEnum::GOODS_CAMPUS_NOT_FOUND);
            }
        }*/
    }

    public function detail($userId,$id)
    {
        $collectionQuery = [
            "collection"=>function($query)use($userId){
                $query->select([
                    Collection::FIELD_ID,
                    Collection::FIELD_ID_OBJECT,
                    Collection::FIELD_ID_USER,
                    Collection::FIELD_STATUS
                ]);
                if ($userId){
                    $query->where(Collection::FIELD_ID_USER,$userId);
                }
            },
            "bargainings"=>function($query)use($userId){
                $query->select([
                    Bargaining::FIELD_ID,
                    Bargaining::FIELD_ID_USER,
                    Bargaining::FIELD_ID_GOODS,
                    Bargaining::FIELD_STATUS
                ])->orderBy(Bargaining::FIELD_ID,'desc');
                if ($userId){
                    $query->where(Collection::FIELD_ID_USER,$userId);
                }
            }
        ];

        $collectionQuery = is_null($userId)?[]:$collectionQuery;

        $result = Goods::query()->with(array_merge(["brand"=>function($query){
            $query->select([Brand::FIELD_ID,Brand::FIELD_NAME]);
        },"campus"=>function($query){
            $query->select([Campus::FIELD_ID,Campus::FIELD_NAME,Campus::FIELD_ADDRESS,Campus::FIELD_LATITUDE,Campus::FIELD_LONGITUDE,Campus::FIELD_CITY,Campus::FIELD_COUNTY]);
        },"lesson_category"=>function($query){
            $query->select([LessonCategory::FIELD_ID,LessonCategory::FIELD_NAME]);
        },"contact"=>function($query){
            $query->select([
                ContractLesson::FIELD_ID,
                ContractLesson::FIELD_ID_GOODS,
                ContractLesson::FIELD_MEMBERS,
                ContractLesson::FIELD_PARENT_CONTACT_INFO,
                ContractLesson::FIELD_CAMPUS_CONTACT_INFO,
                ContractLesson::FIELD_CONTRACT_NO,
                ContractLesson::FIELD_CONTRACT_EXPIRED,
                ContractLesson::FIELD_LESSON_TYPE,
                ContractLesson::FIELD_SURPLUS_AMOUNT,
                ContractLesson::FIELD_SURPLUS_LESSON_TIME,
                ContractLesson::FIELD_MIN_YEAR,
                ContractLesson::FIELD_MAX_YEAR,
                ContractLesson::FIELD_LESSON_GENDER,
                //ContractLesson::FIELD_ATTACHMENTS,
                ContractLesson::FIELD_CREATED_AT,
            ]);
        },"transfer_info"=>function($query){
            $query->select([
                ContractTransferInfos::FIELD_ID,
                ContractTransferInfos::FIELD_ID_GOODS,
                ContractTransferInfos::FIELD_TITLE,
                ContractTransferInfos::FIELD_INTRODUCE,
                ContractTransferInfos::FIELD_ATTACHMENTS
            ]);
        },"seller"=>function($query){
            $query->select([
                WechatUser::FIELD_ID,
                WechatUser::FIELD_NICKNAME,
                WechatUser::FIELD_AVATAR,
                WechatUser::FIELD_PHONE,
                WechatUser::FIELD_CREATED_AT
            ]);
        }],$collectionQuery))->find($id);
        return $result;
    }

    /**
     * 构造查询器
     *
     * @author yezi
     * @return $this
     */
    public function queryLocation($user,$type,$brands,$lessonCategoryIds,$minPrice,$maxPrice,$collection,$city,$longitude=null,$latitude=null,$ids=[])
    {

        $query = Goods::query()
            ->whereIn(Goods::FIELD_STATUS,[
                Goods::ENUM_STATUS_VERIFY_SUCCESS,
                Goods::ENUM_STATUS_TRANSFER_FAIL,
            ])
            ->where(Goods::FIELD_SALES_STATUS,Goods::ENUM_SALES_STATUS_UP);

        //筛选价格
        if ($minPrice){
            $query->where(Goods::FIELD_PRICE,">=",toPenny($minPrice));
        }
        if ($maxPrice){
            $query->where(Goods::FIELD_PRICE,"<=",toPenny($maxPrice));
        }

        //根据品牌关键字筛选
        if ($brands){
            $query->whereExists(function ($query) use($brands){
                $query->select(\DB::raw(1))
                    ->from(Brand::TABLE_NAME)
                    ->where(Brand::TABLE_NAME.'.'.Brand::FIELD_NAME,"like","%{$brands}%")
                    ->whereRaw(Brand::TABLE_NAME.'.'.Brand::FIELD_ID."=".Goods::TABLE_NAME.'.'.Goods::FIELD_ID_BRAND);
            });
        }

        //筛选课类
        if (!empty($lessonCategoryIds) && $lessonCategoryIds != "null" && $lessonCategoryIds != null){
            $query->where(Goods::FIELD_ID_CATEGORY_LESSON,$lessonCategoryIds);
        }

        //筛选城市
        if ($city){
            $query->where(Goods::FIELD_CITY,"like","%{$city}%");
        }

        //筛选我收藏的课程
        if ($collection &&$user){
            $query->whereExists(function ($query) use($user){
                $query->select(\DB::raw(1))
                    ->from(Collection::TABLE_NAME)
                    ->whereRaw(Collection::TABLE_NAME.'.'.Collection::FIELD_ID_USER."={$user->id}")
                    ->whereRaw(Collection::TABLE_NAME.'.'.Collection::FIELD_STATUS."=1")
                    ->whereRaw(Collection::TABLE_NAME.'.'.Collection::FIELD_ID_OBJECT."=".Goods::TABLE_NAME.'.'.Goods::FIELD_ID);
            });
        }

        if ($longitude && $latitude){
            $query->whereIn(Goods::FIELD_ID,$ids);
        }

        return collect($query->pluck("id"))->toArray();
    }

    /**
     * 构造查询器
     *
     * @author yezi
     * @return $this
     */
    public function query($user,$type,$brands,$lessonCategoryIds,$minPrice,$maxPrice,$collection,$city,$longitude=null,$latitude=null,$ids=[])
    {
        $collectionQuery = [
            "collection"=>function($query)use($user){
                $query->select([
                    Collection::FIELD_ID,
                    Collection::FIELD_ID_OBJECT,
                    Collection::FIELD_ID_USER,
                    Collection::FIELD_STATUS
                ]);
                if ($user){
                    $query->where(Collection::FIELD_ID_USER,$user->id);
                }
            },
            "bargainings"=>function($query)use($user){
                $query->select([
                    Bargaining::FIELD_ID,
                    Bargaining::FIELD_ID_USER,
                    Bargaining::FIELD_ID_GOODS,
                    Bargaining::FIELD_STATUS
                ])->orderBy(Bargaining::FIELD_ID,'desc');
                if ($user){
                    $query->where(Collection::FIELD_ID_USER,$user->id);
                }
            }
        ];

        $collectionQuery = is_null($user)?[]:$collectionQuery;

        $this->builder = Goods::query()
            ->whereIn(Goods::FIELD_STATUS,[
                Goods::ENUM_STATUS_VERIFY_SUCCESS,
                Goods::ENUM_STATUS_TRANSFER_FAIL,
            ])
            ->where(Goods::FIELD_SALES_STATUS,Goods::ENUM_SALES_STATUS_UP)
            ->with(array_merge(["brand"=>function($query){
            $query->select([Brand::FIELD_ID,Brand::FIELD_NAME]);
        },"campus"=>function($query){
            $query->select([Campus::FIELD_ID,Campus::FIELD_ADDRESS,Campus::FIELD_LONGITUDE,Campus::FIELD_LATITUDE]);
        },"lesson_category"=>function($query){
            $query->select([LessonCategory::FIELD_ID,LessonCategory::FIELD_NAME]);
        },"contact"=>function($query){
            $query->select([
                ContractLesson::FIELD_ID,
                ContractLesson::FIELD_ID_GOODS,
                ContractLesson::FIELD_CONTRACT_EXPIRED,
                ContractLesson::FIELD_LESSON_TYPE,
                ContractLesson::FIELD_SURPLUS_LESSON_TIME,
                ContractLesson::FIELD_MIN_YEAR,
                ContractLesson::FIELD_MAX_YEAR,
                ContractLesson::FIELD_LESSON_GENDER,
                ContractLesson::FIELD_SURPLUS_AMOUNT,
            ]);
        },"transfer_info"=>function($query){
            $query->select([
                ContractTransferInfos::FIELD_ID,
                ContractTransferInfos::FIELD_ID_GOODS,
                ContractTransferInfos::FIELD_TITLE,
                ContractTransferInfos::FIELD_ATTACHMENTS
            ]);
        }],$collectionQuery));

        //筛选价格
        if ($minPrice){
            $this->builder->where(Goods::FIELD_PRICE,">=",toPenny($minPrice));
        }
        if ($maxPrice){
            $this->builder->where(Goods::FIELD_PRICE,"<=",toPenny($maxPrice));
        }

        //根据品牌关键字筛选
        if ($brands){
            $this->builder->whereExists(function ($query) use($brands){
                $query->select(\DB::raw(1))
                    ->from(Brand::TABLE_NAME)
                    ->where(Brand::TABLE_NAME.'.'.Brand::FIELD_NAME,"like","%{$brands}%")
                    ->whereRaw(Brand::TABLE_NAME.'.'.Brand::FIELD_ID."=".Goods::TABLE_NAME.'.'.Goods::FIELD_ID_BRAND);
            });
        }

        //筛选课类
        if (!empty($lessonCategoryIds) && $lessonCategoryIds != "null" && $lessonCategoryIds != null){
            $this->builder->where(Goods::FIELD_ID_CATEGORY_LESSON,$lessonCategoryIds);
        }

        //筛选城市
        if ($city){
            $this->builder->where(Goods::FIELD_CITY,"like","%{$city}%");
        }

        //筛选我收藏的课程
        if ($collection &&$user){
            $this->builder->whereExists(function ($query) use($user){
                $query->select(\DB::raw(1))
                    ->from(Collection::TABLE_NAME)
                    ->whereRaw(Collection::TABLE_NAME.'.'.Collection::FIELD_ID_USER."={$user->id}")
                    ->whereRaw(Collection::TABLE_NAME.'.'.Collection::FIELD_STATUS."=1")
                    ->whereRaw(Collection::TABLE_NAME.'.'.Collection::FIELD_ID_OBJECT."=".Goods::TABLE_NAME.'.'.Goods::FIELD_ID);
            });
        }

        if ($longitude && $latitude && $type == 4){
            $this->builder->whereIn(Goods::FIELD_ID,$ids);
        }

        return $this;
    }

    /**
     * 构造查询器
     *
     * @author yezi
     * @return $this
     */
    public function queryByUser($user,$status,$salesStatus)
    {
        $this->builder = Goods::query()
            ->where(Goods::FIELD_ID_CREATE,$user->id)
            ->with(array_merge(["brand"=>function($query){
                $query->select([Brand::FIELD_ID,Brand::FIELD_NAME]);
            },"campus"=>function($query){
                $query->select([Campus::FIELD_ID,Campus::FIELD_ADDRESS,Campus::FIELD_LONGITUDE,Campus::FIELD_LATITUDE]);
            },"lesson_category"=>function($query){
                $query->select([LessonCategory::FIELD_ID,LessonCategory::FIELD_NAME]);
            },"contact"=>function($query){
                $query->select([
                    ContractLesson::FIELD_ID,
                    ContractLesson::FIELD_ID_GOODS,
                    ContractLesson::FIELD_CONTRACT_EXPIRED,
                    ContractLesson::FIELD_LESSON_TYPE,
                    ContractLesson::FIELD_SURPLUS_LESSON_TIME,
                    ContractLesson::FIELD_MIN_YEAR,
                    ContractLesson::FIELD_MAX_YEAR,
                    ContractLesson::FIELD_LESSON_GENDER,
                    ContractLesson::FIELD_SURPLUS_AMOUNT,
                ]);
            },"transfer_info"=>function($query){
                $query->select([
                    ContractTransferInfos::FIELD_ID,
                    ContractTransferInfos::FIELD_ID_GOODS,
                    ContractTransferInfos::FIELD_TITLE,
                    ContractTransferInfos::FIELD_ATTACHMENTS,
                    ContractTransferInfos::FIELD_INTRODUCE,
                ]);
            },"order_item.order.buyer"=>function($query){
                $query->select([
                    WechatUser::FIELD_ID,
                    WechatUser::FIELD_NICKNAME,
                    WechatUser::FIELD_AVATAR,
                    WechatUser::FIELD_PHONE,
                    WechatUser::FIELD_CREATED_AT
                ]);
            },"bargainings"=>function($query)use($user){
                $query->select([
                    Bargaining::FIELD_ID,
                    Bargaining::FIELD_ID_USER,
                    Bargaining::FIELD_ID_GOODS,
                    Bargaining::FIELD_STATUS
                ])->orderBy(Bargaining::FIELD_ID,'desc');
                if ($user){
                    $query->where(Collection::FIELD_ID_USER,$user->id);
                }
            }]));

        if (!is_null($salesStatus)){
            $this->builder->where(Goods::FIELD_SALES_STATUS,$salesStatus);
            if ($salesStatus == Goods::ENUM_SALES_STATUS_UP){
                $this->builder->whereIn(Goods::FIELD_STATUS,[Goods::ENUM_STATUS_VERIFY_SUCCESS,Goods::ENUM_STATUS_UNDER_TRANSFER]);
            }
            if ($salesStatus == Goods::ENUM_SALES_STATUS_DOWN){
                $this->builder->whereNotIn(Goods::FIELD_STATUS,[Goods::ENUM_STATUS_VERIFY]);
            }
        }

        if (!empty($status)){
            $this->builder->whereIn(Goods::FIELD_STATUS,$status);
        }

        return $this;
    }

    /**
     * 排序
     *
     * @author yezi
     * @param $orderBy
     * @param $sort
     * @return mixed
     */
    public function sort($orderBy="id",$sort="asc",$ids=null)
    {
        if (!in_array($orderBy,[Goods::FIELD_ID,Goods::FIELD_CREATED_AT,Goods::FIELD_DISCOUNT])){
            throw new ApiException("order by参数错误",ErrorEnum::GOODS_ORDER_BY_ERR);
        }

        if (empty($ids)){
            $this->builder->orderBy($orderBy,$sort);
        }

        return $this;
    }

    /**
     * 返回查询构造器
     *
     * @author yezi
     * @return mixed
     */
    public function done()
    {
        return $this->builder;
    }

    /**
     * 格式化返回单条数据
     *
     * @param $goods
     * @return array
     */
    public function formatSingle($goods)
    {
        $goods = collect($goods)->toArray();
        $transferInfo = [
            Goods::FIELD_PRICE      => toYuan($goods[Goods::FIELD_PRICE]),
            Goods::FIELD_DEPOSIT    => toYuan($goods[Goods::FIELD_DEPOSIT]),
            Goods::FIELD_DISCOUNT   => $goods[Goods::FIELD_DISCOUNT],
            Goods::FIELD_BARGAINING => $goods[Goods::FIELD_BARGAINING],
            Goods::FIELD_STATUS     => $goods[Goods::FIELD_STATUS],
            Goods::FIELD_CREATED_AT => $goods[Goods::FIELD_CREATED_AT],
        ];
        $campus = [
            "campus"          => $goods["campus"],
            "brand"           => $goods["brand"],
            "lesson_category" => $goods["lesson_category"],
            "sub_course_type" => $goods["sub_course_type"]
        ];

        $seller = "";
        if (key_exists("seller",$goods)){
            $seller = $goods["seller"];
            $seller["settle_in"] = Carbon::parse($seller[WechatUser::FIELD_CREATED_AT])->diffInDays()+1;
        }

        $collection = 0;
        if (isset($goods["collection"])){
            $collection = $goods["collection"]["status"] == 1?1:0;
        }

        $domain = config("app.tc_cos_domain");
        if (!empty($goods["transfer_info"])){
            $transferImage = $goods["transfer_info"]["attachments"];
            if (!empty($transferImage)){
                if (!is_array($transferImage)){
                    $transferImage = json_decode($transferImage,true);
                }
                foreach ($transferImage as &$t){
                    $t = $domain.$t."?imageMogr2/format/webp/thumbnail/400x";
                }
                $goods["transfer_info"]["attachments"] = $transferImage;
            }
        }

        $goods["contact"]["surplus_amount"] = toYuan($goods["contact"]["surplus_amount"]);

        return [
            "goods_id"      => $goods["id"],
            "status"        => $goods["status"],
            "sub_course_type" => $goods["sub_course_type"],
            "sales_status"  => $goods["sales_status"],
            "created_at"    => $goods[Goods::FIELD_CREATED_AT],
            "campus"        => $campus,
            "contact"       => $goods["contact"],
            "seller"        => $seller,
            "transfer_info" => array_merge($transferInfo,$goods["transfer_info"]),
            "bargainings"   => key_exists("bargainings",$goods)?$goods["bargainings"]:null,
            "collection"    => $collection,
            "view_num"      => isset($goods["view_num"])?$goods["view_num"]:0
        ];
    }

    /**
     * 格式化返回分页数据
     *
     * @param $goods
     * @return array
     */
    public function formatPage($goods,$domain,$locations=null,$longitude=null,$latitude=null,$type=0)
    {
        $goods = collect($goods)->toArray();
        $transferInfo = [
            Goods::FIELD_PRICE      => toYuan($goods[Goods::FIELD_PRICE]),
            Goods::FIELD_DEPOSIT    => toYuan($goods[Goods::FIELD_DEPOSIT]),
            Goods::FIELD_DISCOUNT   => (float)$goods[Goods::FIELD_DISCOUNT],
            Goods::FIELD_STATUS     => $goods[Goods::FIELD_STATUS],
            Goods::FIELD_CREATED_AT => $goods[Goods::FIELD_CREATED_AT],
        ];
        $campus = [
            "campus"          => $goods["campus"],
            "brand"           => $goods["brand"],
            "lesson_category" => $goods["lesson_category"],
            "sub_course_type" => $goods["sub_course_type"]
        ];

        $collection = 0;
        if (isset($goods["collection"])){
            $collection = $goods["collection"]["status"] == 1?1:0;
        }

        //处理合同图片
        $order = isset($goods["order_item"]["order"])?$goods["order_item"]["order"]:null;
        if ($order){
            $protocol = $order[Order::FIELD_PROTOCOL];
            if (!empty($protocol)){
                foreach ($protocol as &$p){
                    $p = $domain.$p;
                }
                $order[Order::FIELD_PROTOCOL] = $protocol;
            }
        }

        if (!empty($goods["transfer_info"])){
            $transferImage = $goods["transfer_info"]["attachments"];
            if (!empty($transferImage)){
                if (!is_array($transferImage)){
                    $transferImage = json_decode($transferImage,true);
                }
                foreach ($transferImage as &$t){
                    $t = $domain.$t."?imageMogr2/format/webp/thumbnail/400x";
                }
                $goods["transfer_info"]["attachments"] = $transferImage;
            }
        }

        $goods["contact"]["surplus_amount"] = toYuan($goods["contact"]["surplus_amount"]);
        $goods["contact"]["surplus_lesson_time"] = (float)($goods["contact"]["surplus_lesson_time"]);

        $distance = 0;
        if (!is_null($locations) && !empty($locations) && $type == 4){
            if (key_exists($goods["id"],$locations)){
                $distance = round($locations[$goods["id"]][0][1],1);
            }
        }else{
            if (!is_null($longitude) && !empty($latitude)){
                $distance = $this->getdistance($longitude,$latitude,$campus["campus"]["longitude"],$campus["campus"]["latitude"]);
                $distance = round($distance/1000,1);
            }else{
                $distance = 0;
            }
        }

        $goodsStatus = null;
        if (key_exists("order_item", $goods)) {
            return [
                "goods_id"      => $goods["id"],
                "status"        => $goods["status"],
                "reject_reason" => $goods["reject_reason"],
                "sales_status"  => $goods["sales_status"],
                "sub_course_type" => $goods["sub_course_type"],
                "campus"        => $campus,
                "contact"       => $goods["contact"],
                "transfer_info" => array_merge($transferInfo,$goods["transfer_info"]),
                "bargainings"   => isset($goods["bargainings"])?$goods["bargainings"]:null,
                "collection"    => $collection,
                "order"         => isset($goods["order_item"]["order"])?$goods["order_item"]["order"]:null,
                "distance"      => $distance,
                "view_num"      => isset($goods["view_num"])?$goods["view_num"]:0
            ];
        }else{
            return [
                "goods_id"      => $goods["id"],
                "status"        => $goodsStatus,
                "sales_status"  => $goods["sales_status"],
                "sub_course_type" => $goods["sub_course_type"],
                "campus"        => $campus,
                "contact"       => $goods["contact"],
                "transfer_info" => array_merge($transferInfo,$goods["transfer_info"]),
                "bargainings"   => isset($goods["bargainings"])?$goods["bargainings"]:null,
                "collection"    => $collection,
                "distance"      => $distance,
                "view_num"      => isset($goods["view_num"])?$goods["view_num"]:0
            ];
        }
    }

    function getdistance($lng1, $lat1, $lng2, $lat2) {
        // 将角度转为狐度
        $radLat1 = deg2rad($lat1); //deg2rad()函数将角度转换为弧度
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
        return $s;
    }

    public function checkGoodsSaleStatus(Goods $goods)
    {
        if ($goods->{Goods::FIELD_SALES_STATUS} == Goods::ENUM_SALES_STATUS_DOWN){
            throw new ApiException("课程已下架",ErrorEnum::GOODS_SALE_STATUS_DOWN);
        }

        if ($goods->{Goods::FIELD_STATUS} != Goods::ENUM_STATUS_VERIFY_SUCCESS){
            throw new ApiException("课程处于不可售状态",ErrorEnum::GOODS_STATUS_CANT_SALE);
        }
    }

    /**
     * 让商品处于转让中
     *
     * @author yezi
     * @param $id
     * @return int
     */
    public function underTransfer($id)
    {
        $result = $this->goodsRep->updateStatus($id,Goods::ENUM_STATUS_UNDER_TRANSFER);
        return $result;
    }

    /**
     * 统计在售的课程
     *
     * @param $createId
     * @return int
     */
    public function countSelling($createId)
    {
        $num = Goods::query()->where(Goods::FIELD_ID_CREATE,$createId)
            ->whereIn(Goods::FIELD_STATUS,[Goods::ENUM_STATUS_VERIFY,Goods::ENUM_STATUS_VERIFY_SUCCESS,Goods::ENUM_STATUS_UNDER_TRANSFER])
            ->where(Goods::FIELD_SALES_STATUS,Goods::ENUM_SALES_STATUS_UP)
            ->count("id");
        return $num;
    }

    public function finishGoods($id,$status)
    {
        $result = $this->goodsRep->updateStatus($id,$status);
        return $result;
    }

    /**
     * 订单上下架操作
     *
     * @param $user
     * @param $id
     * @param $saleStatus
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]
     * @throws ApiException
     */
    public function updateSale($user,$id,$saleStatus)
    {
        $goods = $this->findById($id);
        if (!$goods){
            throw new ApiException("商品不存在");
        }

        if ($goods->{Goods::FIELD_ID_CREATE} != $user->id){
            throw new ApiException("商品不存在");
        }

        if ($saleStatus == Goods::ENUM_SALES_STATUS_UP){
            if ($goods->{Goods::FIELD_SALES_STATUS} == $saleStatus){
                throw new ApiException("商品已是上架状态");
            }
            if ($goods->{Goods::FIELD_STATUS} < Goods::ENUM_STATUS_VERIFY_SUCCESS){
                throw new ApiException("订单需审核通过后才能进行上架操作");
            }
        }

        if ($saleStatus == Goods::ENUM_SALES_STATUS_DOWN){
            if ($goods->{Goods::FIELD_SALES_STATUS} == $saleStatus){
                throw new ApiException("商品已是下架状态");
            }
            if ($goods->{Goods::FIELD_STATUS} == Goods::ENUM_STATUS_UNDER_TRANSFER){
                throw new ApiException("订单转让中，无法进行下架操作");
            }
        }

        $goods->{Goods::FIELD_SALES_STATUS} = $saleStatus;
        $result = $goods->save();
        if (!$result){
            throw new ApiException("操作失败，请稍后重试");
        }

        $result = Goods::query()
            ->where(Goods::FIELD_ID_CREATE,$user->id)
            ->where(Goods::FIELD_ID,$goods->id)
            ->with(array_merge(["brand"=>function($query){
                $query->select([Brand::FIELD_ID,Brand::FIELD_NAME]);
            },"campus"=>function($query){
                $query->select([Campus::FIELD_ID,Campus::FIELD_ADDRESS,Campus::FIELD_LONGITUDE,Campus::FIELD_LATITUDE]);
            },"lesson_category"=>function($query){
                $query->select([LessonCategory::FIELD_ID,LessonCategory::FIELD_NAME]);
            },"contact"=>function($query){
                $query->select([
                    ContractLesson::FIELD_ID,
                    ContractLesson::FIELD_ID_GOODS,
                    ContractLesson::FIELD_CONTRACT_EXPIRED,
                    ContractLesson::FIELD_LESSON_TYPE,
                    ContractLesson::FIELD_SURPLUS_LESSON_TIME,
                    ContractLesson::FIELD_MIN_YEAR,
                    ContractLesson::FIELD_MAX_YEAR,
                    ContractLesson::FIELD_LESSON_GENDER,
                    ContractLesson::FIELD_SURPLUS_AMOUNT
                ]);
            },"transfer_info"=>function($query){
                $query->select([
                    ContractTransferInfos::FIELD_ID,
                    ContractTransferInfos::FIELD_ID_GOODS,
                    ContractTransferInfos::FIELD_TITLE,
                    ContractTransferInfos::FIELD_ATTACHMENTS,
                    ContractTransferInfos::FIELD_INTRODUCE,
                ]);
            },"order_item.order.buyer"=>function($query){
                $query->select([
                    WechatUser::FIELD_ID,
                    WechatUser::FIELD_NICKNAME,
                    WechatUser::FIELD_AVATAR,
                    WechatUser::FIELD_PHONE,
                    WechatUser::FIELD_CREATED_AT
                ]);
            },"bargainings"=>function($query)use($user){
                $query->select([
                    Bargaining::FIELD_ID,
                    Bargaining::FIELD_ID_USER,
                    Bargaining::FIELD_ID_GOODS,
                    Bargaining::FIELD_STATUS
                ])->orderBy(Bargaining::FIELD_ID,'desc');
                if ($user){
                    $query->where(Collection::FIELD_ID_USER,$user->id);
                }
            }]))
            ->first();
        $domain = config("app.tc_cos_domain");
        return $this->formatPage($result,$domain);
    }

    public function updateLocation($goodsId,$province,$city,$county){
        $goods = $this->findById($goodsId);
        if (!$goods){
            throw new ApiException("商品不存在");
        }

        $goods->{Goods::FIELD_PROVINCE} = $province;
        $goods->{Goods::FIELD_CITY} = $city;
        $goods->{Goods::FIELD_COUNTY} = $county;
        $result = $goods->save();
        if (!$result){
            throw new ApiException("商品更新失败");
        }

        return $goods;
    }

    /**
     * 查看人数加
     *
     * @param $goodsId
     * @param $num
     * @return int
     */
    public static function increaseViewNum($goodsId,$num)
    {
        $goods = Goods::query()->find($goodsId);
        if (!$goods){
            return 0;
        }

        $goods->{Goods::FIELD_VIEW_NUM} += $num;
        $result = $goods->save();
        if (!$result){
            return 0;
        }

        return 1;
    }

}
