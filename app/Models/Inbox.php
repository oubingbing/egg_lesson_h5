<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/13
 * Time: 下午2:58
 */

namespace App\Models;


class Inbox extends BaseModel
{
    protected $table = 'inboxes';

    /** field id */
    const FIELD_ID = 'id';

    /** field user_id 接收人 */
    const FIELD_ID_USER = 'user_id';

    /** field content 内容 */
    const FIELD_CONTENT = 'content';

    /** field obj_id 信箱涉及到的对象Id */
    const FIELD_ID_OBJ = 'obj_id';

    /** field obj_type 对象类型，1=课程，2=订单,如果没有对象，那就是0 */
    const FIELD_OBJ_TYPE = 'obj_type';

    /** field type 对象的类型 */
    const FIELD_TYPE = 'type';

    /** field post_at 发送的时间 */
    const FIELD_POST_AT = 'post_at';

    /** field read_at 读信的时间 */
    const FIELD_READ_AT = 'read_at';

    /** field created_at */
    const FIELD_CREATED_AT = 'created_at';

    /** field updated_at */
    const FIELD_UPDATED_AT = 'updated_at';

    /** field deleted_at */
    const FIELD_DELETED_AT = 'deleted_at';

    /** 账户，2=买家，3=卖家，4=公告 */
    const ENUM_TYPE_ACCOUNT = 1;
    /** 买家 */
    const ENUM_TYPE_BUYER = 2;
    /** 卖家 */
    const ENUM_TYPE_SALE = 3;
    /** 公告 */
    const ENUM_TYPE_SYSTEM = 4;
    /** 订单下单 */
    const ENUM_TYPE_ORDER_CREATE = 10;
    /** 课程审核 */
    const ENUM_TYPE_GOODS_REQUIRE_VERIFY = 11;
    /** 意见与建议 */
    const ENUM_TYPE_SUGGEST = 12;
    /** 订单申请退款 */
    const ENUM_TYPE_ORDER_REFUND = 13;

    /** 象类型 - 课程 */
    const ENUM_OBJ_TYPE_LESSON = 1;
    /** 对象类型 - 订单 */
    const ENUM_OBJ_TYPE_ORDER = 2;


    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_ID_USER,
        self::FIELD_ID_OBJ,
        self::FIELD_OBJ_TYPE,
        self::FIELD_CONTENT,
        self::FIELD_TYPE,
        self::FIELD_POST_AT,
        self::FIELD_READ_AT,
        self::CREATED_AT,
        self::FIELD_UPDATED_AT,
    ];

    public function user()
    {
        return $this->belongsTo(WechatUser::class,self::FIELD_ID_USER)->select(WechatUser::FIELD_ID,WechatUser::FIELD_NICKNAME,WechatUser::FIELD_AVATAR,WechatUser::FIELD_GENDER);
    }

}
