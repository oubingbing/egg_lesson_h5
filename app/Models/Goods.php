<?php


namespace App\Models;

/**
 * 商品表
 *
 * @author 叶子
 * Class contractTransferInfos
 * @package App\Models
 */
class Goods extends BaseModel
{
    const TABLE_NAME = "goods";
    protected $table = self::TABLE_NAME;

    /** field creater_id 创建人 **/
    const FIELD_ID_CREATE = "creater_id";

    /** field brand_id 所属品牌 **/
    const FIELD_ID_BRAND = "brand_id";

    /** field course_type_id 所属课程类型 **/
    const FIELD_ID_CATEGORY_LESSON = "course_type_id";

    /** field sub_course_type 所属课程类型 **/
    const FIELD_SUB_COURSE_TYPE = "sub_course_type";

    /** FIELD campus_id 所属校区 **/
    const FIELD_ID_CAMPUS = "campus_id";

    /** province_id **/
    const FIELD_PROVINCE = 'province';

    /** city **/
    const FIELD_CITY = 'city';

    /** county **/
    const FIELD_COUNTY = 'county';

    /** FIELD type 创建人，1=用户，2=管理员 **/
    const FIELD_TYPE = "type";

    /** field price 价格 **/
    const FIELD_PRICE = "price";

    /** field deposit 订金 **/
    const FIELD_DEPOSIT = 'deposit';

    /** field discount 折扣 **/
    const FIELD_DISCOUNT = "discount";

    /** field bargaining 是否可以议价,0=一口价,1可以商议价格 **/
    const FIELD_BARGAINING = "bargaining";

    /** field service_charge 手续费，单位分 **/
    const FIELD_SERVICE_CHARGE = "service_charge";

    /** FIELD actual_receipt 卖家实际到账金额，单位分 **/
    const FIELD_ACTUAL_RECEIPT = "actual_receipt";

    /** field status 商品状态，1=审核中，2=审核不通过，3=审核通过，4=转让中，5=转让失败,6=转让成功 **/
    const FIELD_STATUS = "status";

    /** Field sales_status 销售状态，0=下架中，1=上架中 **/
    const FIELD_SALES_STATUS = "sales_status";

    /** Field protocol 转让协议或者合同 **/
    const FIELD_PROTOCOL = "protocol";

    /** Field reject_reason 审核拒绝原因 **/
    const FIELD_REJECT_REASON = "reject_reason";

    /** Field view_num 查看人数 **/
    const FIELD_VIEW_NUM = "view_num";

    //创建人类型 - 用户
    const ENUM_TYPE_USER = 1;
    //创建人类型 - 管理员
    const ENUM_TYPE_ADMIN = 2;

    //是否可以议价 - 是
    const ENUM_BAR_Y = 0;
    //是否可以议价 - 否
    const ENUM_BAR_N = 1;

    //商品状态 - 审核中
    const ENUM_STATUS_VERIFY = 1;
    //商品状态 - 审核不通过
    const ENUM_STATUS_VERIFY_FAIL = 2;
    //商品状态 - 审核通过
    const ENUM_STATUS_VERIFY_SUCCESS = 3;
    //商品状态 - 转让中
    const ENUM_STATUS_UNDER_TRANSFER = 4;
    //商品状态 - 转让成功
    const ENUM_STATUS_TRANSFER_SUCCESS = 5;
    //商品状态 - 转让失败
    const ENUM_STATUS_TRANSFER_FAIL = 6;

    //销售状态 - 下架中
    const ENUM_SALES_STATUS_DOWN = 0;
    //销售状态 - 上架中
    const ENUM_SALES_STATUS_UP = 1;

    protected $fillable = [
        self::FIELD_ID_CREATE,
        self::FIELD_ID_BRAND,
        self::FIELD_ID_CAMPUS,
        self::FIELD_PROVINCE,
        self::FIELD_CITY,
        self::FIELD_COUNTY,
        self::FIELD_ID_CATEGORY_LESSON,
        self::FIELD_TYPE,
        self::FIELD_PRICE,
        self::FIELD_DEPOSIT,
        self::FIELD_DISCOUNT,
        self::FIELD_BARGAINING,
        self::FIELD_SERVICE_CHARGE,
        self::FIELD_ACTUAL_RECEIPT,
        self::FIELD_STATUS,
        self::FIELD_SALES_STATUS,
        self::FIELD_SUB_COURSE_TYPE,
        self::FIELD_REJECT_REASON,
        self::FIELD_VIEW_NUM
    ];

    /**
     * 品牌
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function brand()
    {
        return $this->hasOne(Brand::class,Brand::FIELD_ID,self::FIELD_ID_BRAND);
    }

    /**
     * 校区
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne(LessonCategory::class,LessonCategory::FIELD_ID,self::FIELD_ID_CATEGORY_LESSON);
    }

    /**
     * 校区
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function campus()
    {
        return $this->hasOne(Campus::class,Campus::FIELD_ID,self::FIELD_ID_CAMPUS);
    }

    /**
     * 课程类型
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lesson_category()
    {
        return $this->hasOne(LessonCategory::class,LessonCategory::FIELD_ID,self::FIELD_ID_CATEGORY_LESSON);
    }

    public function contact()
    {
        return $this->hasOne(ContractLesson::class, ContractLesson::FIELD_ID_GOODS,self::FIELD_ID);
    }

    public function transfer_info()
    {
        return $this->hasOne(ContractTransferInfos::class,ContractTransferInfos::FIELD_ID_GOODS,self::FIELD_ID);
    }

    /**
     * 校区
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function seller()
    {
        return $this->hasOne(WechatUser::class,WechatUser::FIELD_ID,self::FIELD_ID_CREATE);
    }

    /**
     * 收藏
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function collection()
    {
        return $this->hasOne(Collection::class,Collection::FIELD_ID_OBJECT,self::FIELD_ID);
    }

    /**
     * 议价
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bargainings()
    {
        return $this->hasMany(Bargaining::class,Bargaining::FIELD_ID_GOODS,self::FIELD_ID);
    }

    /**
     * 商品
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order_item()
    {
        return $this->hasOne(OrderItem::class,OrderItem::FIELD_ID_GOODS,self::FIELD_ID);
    }
}
