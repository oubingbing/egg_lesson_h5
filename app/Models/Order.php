<?php


namespace App\Models;


class Order extends BaseModel
{
    const TABLE_NAME = "orders";
    protected $table = self::TABLE_NAME;

    /** Field buyer_id 买家 **/
    const FIELD_ID_BUYER = "buyer_id";

    /** Field seller_id 卖家 **/
    const FIELD_ID_SELLER = "seller_id";

    /** Field type 订单类型，1=微信小程序，2=h5 **/
    const FIELD_TYPE = "type";

    /** Field is_deposit 是否已支付定金，0=否，1=是 **/
    const FIELD_IS_DEPOSIT = "is_deposit";

    /** Field deposit 定金，单位分 **/
    const FIELD_DEPOSIT = "deposit";

    /** Field total_amount 总金额,单位分 **/
    const FIELD_TOTAL_AMOUNT = "total_amount";

    /** Field actual_amount 实际支付金额，单位分单位分 **/
    const FIELD_ACTUAL_AMOUNT = "actual_amount";

    /** Field order_number 平台订单号 **/
    const FIELD_ORDER_NUMBER = "order_number";

    /** Field transaction_id 微信支付订单号 **/
    const FIELD_ID_TRANSACTION = "transaction_id";

    /** Field payment_type 支付方式，1=微信支付，2=支付宝 **/
    const FIELD_PAYMENT_TYPE = "payment_type";

    /** Field status 订单状态1=待付订金 2=退款中 3=待卖家确认 4=待校方确认 5=待确认上课 6=待支付尾款  7=交易失败 8=交易已完成 9=退款失败，10=退款成功，11=支付超时,12=订单被取消 **/
    const FIELD_STATUS = "status";

    /** Field paid_at **/
    const FIELD_PAID_AT = "paid_at";

    /** Field trade_state **/
    const FIELD_TRADE_STATE = "trade_state";

    /** Field refund_at **/
    const FIELD_REFUND_AT = "refund_at";

    /** Field protocol 转让协议或者合同 **/
    const FIELD_PROTOCOL = "protocol";

    //订单类型 - 小程序
    const ENUM_TYPE_MINI = 1;
    //订单类型 - H5
    const ENUM_TYPE_H5 = 2;

    //是否定金订单 - 否
    const ENUM_IS_DEPOSIT_N = 0;
    //是否定金订单 - 是
    const ENUM_IS_DEPOSIT_Y = 1;

    //支付方式 - 微信
    const ENUM_PAYMENT_WX = 1;
    //支付方式 - 支付宝
    const ENUM_PAYMENT_ALI = 2;

    //1=待付订金 2=退款中 3=待卖家确认 4=待校方确认 5=待确认上课 6=待支付尾款  7=交易失败 8=交易已完成 9=退款失败，10=退款成功，11=支付超时,12=订单被取消
    //订单状态 - 待付订金
    const ENUM_STATUS_WAIT_PAY = 1;
    //订单状态 - 退款中
    const ENUM_STATUS_REFUNDING = 2;
    //订单状态 - 待卖家确认
    const ENUM_STATUS_WAIT_SELLER_CONFIRM = 3;
    //订单状态 - 待校方确认
    const ENUM_STATUS_WAIT_CAMPUS_CONFIRM = 4;
    //订单状态 - 待确认上课
    const ENUM_STATUS_WAIT_CONFIRM_LESSON = 5;
    //订单状态 - 待支付尾款
    const ENUM_STATUS_WAIT_PAY_LESS = 6;
    //订单状态 - 交易失败
    const ENUM_STATUS_WAIT_DEAL_FAIL = 7;
    //订单状态 - 交易已完成
    const ENUM_STATUS_WAIT_DEAL_SUCCESS = 8;
    //订单状态 - 退款失败
    const ENUM_STATUS_REFUND_FAIL = 9;
    //订单状态 - 退款成功
    const ENUM_STATUS_REFUND_SUCCESS = 10;
    //订单状态 - 支付超时
    const ENUM_STATUS_PAY_TIME_OUT = 11;
    //订单状态 - 订单取消
    const ENUM_STATUS_CANCEL = 12;

    protected $casts = [
        Order::FIELD_PROTOCOL => "array"
    ];

    protected $fillable = [
        self::FIELD_ID_SELLER,
        self::FIELD_ID_BUYER,
        self::FIELD_TYPE,
        self::FIELD_IS_DEPOSIT,
        self::FIELD_DEPOSIT,
        self::FIELD_TOTAL_AMOUNT,
        self::FIELD_ACTUAL_AMOUNT,
        self::FIELD_ORDER_NUMBER,
        self::FIELD_ID_TRANSACTION,
        self::FIELD_PAYMENT_TYPE,
        self::FIELD_STATUS,
        self::FIELD_TRADE_STATE,
        self::FIELD_PAID_AT,
        self::FIELD_REFUND_AT
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class,OrderItem::FIELD_ID_ORDER,self::FIELD_ID);
    }

    public function seller()
    {
        return $this->belongsTo(WechatUser::class,self::FIELD_ID_SELLER,WechatUser::FIELD_ID);
    }

    public function buyer()
    {
        return $this->belongsTo(WechatUser::class,self::FIELD_ID_BUYER,WechatUser::FIELD_ID);
    }
}
