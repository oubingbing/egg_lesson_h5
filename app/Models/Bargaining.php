<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2021/4/24
 * Time: 17:56
 */

namespace App\Models;


class Bargaining extends BaseModel
{
    const TABLE_NAME = "bargainings";
    protected $table = self::TABLE_NAME;

    /** Field user_id 用户 **/
    const FIELD_ID_USER = "user_id";

    /** Field goods_id 商品 **/
    const FIELD_ID_GOODS = "goods_id";

    /** Field seller_id 卖家 **/
    const FIELD_ID_SELLER = 'seller_id';

    /** Field price 议价价格 **/
    const FIELD_PRICE = "price";

    /** Field status 状态，1=待确认，2=同意，3=不同意 **/
    const FIELD_STATUS = "status";

    /** Field status 议价方，1=卖家，2=买家 **/
    const FIELD_TYPE = "type";

    //status - 待确认
    const ENUM_STATUS_WAIT = 1;
    //status - 同意
    const ENUM_STATUS_AGREE = 2;
    //status - 不同意
    const ENUM_STATUS_NOT_AGREE = 3;

    //type - 议价方
    const ENUM_TYPE_BUYER = 1;

    protected $fillable = [
        self::FIELD_ID_USER,
        self::FIELD_ID_GOODS,
        self::FIELD_STATUS,
        self::FIELD_PRICE,
        self::FIELD_TYPE,
        self::FIELD_ID,
        self::FIELD_ID_SELLER
    ];

    public function goods()
    {
        return $this->hasOne(Goods::class,Goods::FIELD_ID,self::FIELD_ID_GOODS);
    }

    public function seller()
    {
        return $this->belongsTo(WechatUser::class,self::FIELD_ID_SELLER,WechatUser::FIELD_ID);
    }

    public function buyer()
    {
        return $this->belongsTo(WechatUser::class,self::FIELD_ID_USER,WechatUser::FIELD_ID);
    }
}
