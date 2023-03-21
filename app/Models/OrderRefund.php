<?php


namespace App\Models;


class OrderRefund extends BaseModel
{
    const TABLE_NAME = "order_refunds";
    protected $table = self::TABLE_NAME;

    /** field order_id **/
    const FIELD_ID_ORDER = "order_id";

    /** FIELD admin_id 申请人 **/
    const FIELD_ID_ADMIN = "admin_id";

    /** FIELD out_refund_no 退款订单号 **/
    const FIELD_OUT_REFUND_NO = "out_refund_no";

    /** FIELD refund_id 微信退款订单号 **/
    const FIELD_REFUND_ID = "refund_id";

    /** FIELD refund_fee 退款金额，单位分 **/
    const FIELD_REFUND_FEE = "refund_fee";

    /** FIELD result 退款反馈结果 **/
    const FIELD_RESULT = "result";

    /** FIELD status 退款状态，1=退款中，2=退款成功，3=退款失败 **/
    const FIELD_STATUS = "status";

    /** FIELD message 退款提示消息 **/
    const FIELD_MESSAGE = "message";

    /** FIELD type 退款类型，1=同意退款，2=拒绝退款 **/
    const FIELD_TYPE = "type";

    /** FIELD reason 退款原因 **/
    const FIELD_REASON = "reason";

    //状态 - 退款中
    const ENUM_STATUS_REFUNDING = 1;
    //状态 - 退款成功
    const ENUM_STATUS_REFUND_SUCCESS = 2;
    //状态 - 退款失败
    const ENUM_STATUS_REFUND_FAIL = 3;

    //退款类型 - 发起退款
    const ENUM_TYPE_BUILD = 0;
    //退款类型 - 同意退款
    const ENUM_TYPE_AGREE = 1;
    //退款类型 - 拒绝退款
    const ENUM_TYPE_REFUSE = 2;

    //订单退款原因 - 我不想要了（线下交易未开始）
    const ENUM_REFUND_DONT_WANT_1 = 1;
    //订单退款原因 - 我不想要了（线下交易已开始）
    const ENUM_REFUND_DONT_WANT_2 = 2;
    //订单退款原因 - 卖家不卖
    const ENUM_REFUND_SELLER_ABORT = 3;
    //订单退款原因 - 校区不让转
    const ENUM_REFUND_CAMPUS_ABORT = 4;

    protected $casts = [
        self::FIELD_RESULT => "array"
    ];

    protected $fillable = [
        self::FIELD_ID_ADMIN,
        self::FIELD_ID_ORDER,
        self::FIELD_OUT_REFUND_NO,
        self::FIELD_REFUND_ID,
        self::FIELD_REFUND_FEE,
        self::FIELD_RESULT,
        self::FIELD_STATUS,
        self::FIELD_MESSAGE,
        self::FIELD_TYPE,
        self::FIELD_REASON
    ];
}