<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2021/4/24
 * Time: 18:03
 */

namespace App\Service;


use App\Enum\ErrorEnum;
use App\Exceptions\ApiException;
use App\Models\Bargaining;
use App\Models\Brand;
use App\Models\Campus;
use App\Models\ContractLesson;
use App\Models\ContractTransferInfos;
use App\Models\Goods;
use App\Models\Inbox;
use App\Models\LessonCategory;
use App\Models\Order;
use App\Models\WechatUser;
use App\Repositories\BargainingRep;
use Carbon\Carbon;

class BargainingService extends BaseServiceAbstract
{
    private $rep;
    private $builder;

    public function __construct(BargainingRep $rep)
    {
        $this->rep = $rep;
    }

    /**
     * 校验
     *
     * @author yezi
     * @param $request
     * @throws ApiException
     */
    public function validStore($request)
    {
        $rules    = [
            'goods_id'  => 'required',
            'price'     => 'required',
        ];
        $message = [
            'goods_id.required'  => '商品不能为空',
            'price.required'     => '价格不能为空',
        ];
        $validator = \Validator::make($request->all(),$rules,$message);
        if ($validator->fails()) {
            $errors = $validator->errors();
            throw new ApiException($errors->first(),ErrorEnum::BARGAINING_PARAM_NULL);
        }
    }

    public function store($user,$goodsId,$price)
    {
        $goods = app(GoodsService::class)->findById($goodsId);
        if (!$goods){
            throw new ApiException("议价商品不存在",ErrorEnum::BARGAINING_GOODS_NOT_FOUND);
        }

        if ($goods->{Goods::FIELD_ID_CREATE} == $user->id){
            throw new ApiException("自己发布的商品不允许发起议价",ErrorEnum::BARGAINING_CAN_NOT_BY_OWN);
        }

        $buyerName = $user->{WechatUser::FIELD_NICKNAME};
        $money = toYuan($price);
        $subTypeName = $goods->{Goods::FIELD_SUB_COURSE_TYPE};
        $message = "用户【{$buyerName}】向您发布的课程【{$subTypeName}】发起了议价，议价价格为{$money}元";
        commonJob(InboxService::class,"send",[$goods->{Goods::FIELD_ID_CREATE}, $goods->id, Inbox::ENUM_OBJ_TYPE_LESSON, $message, Inbox::ENUM_TYPE_BUYER, Carbon::now()->toDateTimeString()]);

        $result = Bargaining::create([
            Bargaining::FIELD_ID_GOODS  => $goodsId,
            Bargaining::FIELD_ID_USER   => $user->id,
            Bargaining::FIELD_PRICE     => $price*100,
            Bargaining::FIELD_STATUS    => Bargaining::ENUM_STATUS_WAIT,
            Bargaining::FIELD_TYPE      => Bargaining::ENUM_TYPE_BUYER,
            Bargaining::FIELD_ID_SELLER => $goods->{Goods::FIELD_ID_CREATE},
        ]);

        //短信通知
        $user = app(WechatUserService::class)->findById($goods->{Goods::FIELD_ID_CREATE});
        if ($user){
            if ($user->{WechatUser::FIELD_PHONE}){
                $templateId = "1022125";
                commonJob(SmsService::class,"sendMessage",[$templateId,$user->{WechatUser::FIELD_PHONE},[]]);
            }
        }

        return $result;
    }

    public function canBargaining($userId,$goodsId)
    {
        $result = $this->rep->findLast($userId,$goodsId);
        if ($result){
            if ($result->{Bargaining::FIELD_STATUS} == Bargaining::ENUM_STATUS_WAIT){
                throw new ApiException("有未处理的议价，待卖家处理后才能重新发起议价",ErrorEnum::BARGAINING_WAIT_TO_DEAL);
            }

            $count = $this->rep->count($userId,$goodsId);
            if ($count >= 3){
                throw new ApiException("议价次数已超过三次，无法再发起议价",ErrorEnum::BARGAINING_COUNT_MORE_THAN_3);
            }
        }

        //判断课程是否是一口价，是的话不允许议价
        $goods = app(GoodsService::class)->findById($goodsId);
        if (!$goods){
            throw new ApiException("议价商品不存在",ErrorEnum::BARGAINING_CAN_NOT_BY_OWN);
        }

        if ($goods->{Goods::FIELD_BARGAINING} == Goods::ENUM_BAR_N){
            throw new ApiException("该课程为一口价课程，不支持议价",ErrorEnum::BARGAINING_CAN_NOT_BARGAINING);
        }

        return true;
    }

    /**
     * 拒绝议价
     *
     * @param $user
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]
     * @throws ApiException
     */
    public function doNotAgreePrice($user,$id)
    {
        $result = $this->updateStatus($user->id,$id,Bargaining::ENUM_STATUS_NOT_AGREE);

        $goods = $result->goods;
        $buyerName = $user->{WechatUser::FIELD_NICKNAME};
        $money = toYuan($result->{Bargaining::FIELD_PRICE});
        $subTypeName = $goods->{Goods::FIELD_SUB_COURSE_TYPE};
        $message = "您对用户【{$buyerName}】的课程【{$subTypeName}】发起的议价【{$money}】元被拒绝了，请及时处理";
        commonJob(InboxService::class,"send",[$goods->{Goods::FIELD_ID_CREATE}, $goods->id, Inbox::ENUM_OBJ_TYPE_LESSON, $message, Inbox::ENUM_TYPE_BUYER, Carbon::now()->toDateTimeString()]);

        return $result;
    }

    /**
     * 同意议价
     *
     * @param $user
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]
     * @throws ApiException
     */
    public function agreePrice($user,$id)
    {
        $result = $this->updateStatus($user->id,$id,Bargaining::ENUM_STATUS_AGREE);

        $goods = $result->goods;
        $buyerName = $user->{WechatUser::FIELD_NICKNAME};
        $money = toYuan($result->{Bargaining::FIELD_PRICE});
        $subTypeName = $goods->{Goods::FIELD_SUB_COURSE_TYPE};
        $message = "您对用户【{$buyerName}】的课程【{$subTypeName}】发起的议价【{$money}】元被接受了，请快去下定金吧";
        commonJob(InboxService::class,"send",[$goods->{Goods::FIELD_ID_CREATE}, $goods->id, Inbox::ENUM_OBJ_TYPE_LESSON, $message, Inbox::ENUM_TYPE_BUYER, Carbon::now()->toDateTimeString()]);

        //短信通知
        $user = app(WechatUserService::class)->findById($goods->{Goods::FIELD_ID_CREATE});
        if ($user){
            if ($user->{WechatUser::FIELD_PHONE}){
                $templateId = "1022130";
                commonJob(SmsService::class,"sendMessage",[$templateId,$user->{WechatUser::FIELD_PHONE},[]]);
            }
        }

        return $result;
    }

    public function updateStatus($userId,$id,$status)
    {
        $result = $this->rep->find($id);
        if (!$result){
            throw new ApiException("议价不存在",ErrorEnum::BARGAINING_NOT_FOUND);
        }

        if ($result->{Bargaining::FIELD_STATUS} != Bargaining::ENUM_STATUS_WAIT){
            throw new ApiException("议价状态错误",ErrorEnum::BARGAINING_STATUS_NOT_WAIT);
        }

        $goods = app(GoodsService::class)->findById($result->{Bargaining::FIELD_ID_GOODS});
        if (!$goods){
            throw new ApiException("议价商品不存在",ErrorEnum::BARGAINING_CAN_NOT_BY_OWN);
        }

        if ($goods->{Goods::FIELD_ID_CREATE} != $userId){
            throw new ApiException("该商品不是您发布的，不允许操作",ErrorEnum::BARGAINING_CAN_NOT_BY_OWN);
        }

        $result->{Bargaining::FIELD_STATUS} = $status;
        $update = $result->save();
        if (!$update){
            throw new ApiException("议价更新失败",ErrorEnum::BARGAINING_UPDATE_FAIL);
        }

        return $result;
    }

    public function query($userId,$type)
    {
        $user = [];
        if ($type == 1){
            //买家查询
            $user = [
                "seller"=>function($query){
                    $query->select([
                        WechatUser::FIELD_ID,
                        WechatUser::FIELD_NICKNAME,
                        WechatUser::FIELD_AVATAR,
                        WechatUser::FIELD_PHONE,
                        WechatUser::FIELD_CREATED_AT
                    ]);
                }
            ];
        }else{
            //卖家查询
            $user = [
                "buyer"=>function($query){
                    $query->select([
                        WechatUser::FIELD_ID,
                        WechatUser::FIELD_NICKNAME,
                        WechatUser::FIELD_AVATAR,
                        WechatUser::FIELD_PHONE,
                        WechatUser::FIELD_CREATED_AT
                    ]);
                }
            ];
        }

        $this->builder = Bargaining::query()
            ->with(array_merge(["goods.brand"=>function($query){
                $query->select([Brand::FIELD_ID,Brand::FIELD_NAME]);
            },"goods.campus"=>function($query){
                $query->select([Campus::FIELD_ID,Campus::FIELD_NAME,Campus::FIELD_ADDRESS,Campus::FIELD_LATITUDE,Campus::FIELD_LONGITUDE]);
            },"goods.lesson_category"=>function($query){
                $query->select([LessonCategory::FIELD_ID,LessonCategory::FIELD_NAME]);
            },"goods.contact"=>function($query){
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
                    ContractLesson::FIELD_ATTACHMENTS,
                    ContractLesson::FIELD_CREATED_AT,
                ]);
            },"goods.transfer_info"=>function($query){
                $query->select([
                    ContractTransferInfos::FIELD_ID,
                    ContractTransferInfos::FIELD_ID_GOODS,
                    ContractTransferInfos::FIELD_TITLE,
                    ContractTransferInfos::FIELD_INTRODUCE,
                    ContractTransferInfos::FIELD_ATTACHMENTS
                ]);
            }],$user));

        if ($type == 1){
            //买家查询
            $this->builder->where(Bargaining::FIELD_ID_USER,$userId);
        }else{
            //卖家查询
            $this->builder->where(Bargaining::FIELD_ID_SELLER,$userId);
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
    public function sort($orderBy="id",$sort="asc")
    {
        $this->builder->orderBy($orderBy,$sort);
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

    public function formatPage($item)
    {
        $item = collect($item)->toArray();
        $goods = collect($item["goods"])->toArray();

        $transferInfo = [
            Goods::FIELD_PRICE      => toYuan($goods[Goods::FIELD_PRICE]),
            Goods::FIELD_DISCOUNT   => $goods[Goods::FIELD_DISCOUNT],
            Goods::FIELD_STATUS     => $goods[Goods::FIELD_STATUS],
            Goods::FIELD_CREATED_AT => $goods[Goods::FIELD_CREATED_AT],
        ];
        $campus = [
            "campus"          => array_merge($goods["campus"],["sub_course_type" => $goods["sub_course_type"]]),
            "brand"           => $goods["brand"],
            "lesson_category" => $goods["lesson_category"],
            "sub_course_type" => $goods["sub_course_type"]
        ];

        $domain = config("app.tc_cos_domain");
        if (!empty($goods["transfer_info"])){
            $transferImage = $goods["transfer_info"]["attachments"];
            if (!empty($transferImage)){
                if (!is_array($transferImage)){
                    $transferImage = json_decode($transferImage,true);
                }
                foreach ($transferImage as &$t){
                    $t = $domain.$t;
                }
                $goods["transfer_info"]["attachments"] = $transferImage;
            }
        }

        return [
            "id"            => $item["id"],
            "user_id"       => $item["user_id"],
            "status"        => $item["status"],
            "price"         => $item["price"]/100,
            "created_at"    => Carbon::parse($item["created_at"])->toDateTimeString(),
            "goods_id"      => $goods["id"],
            "sub_course_type" => $goods["sub_course_type"],
            "campus"        => $campus,
            "contact"       => $goods["contact"],
            "transfer_info" => array_merge($transferInfo,$goods["transfer_info"]),
            "seller"        => isset($item["seller"])?$item["seller"]:null,
            "buyer"         => isset($item["buyer"])?$item["buyer"]:null,
        ];
        return $item;
    }

}
