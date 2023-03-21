<?php


namespace App\Models;


class OrderItem extends BaseModel
{
    const TABLE_NAME = "order_items";
    protected $table = self::TABLE_NAME;

    /** Field order_id **/
    const FIELD_ID_ORDER = "order_id";

    /** Field goods_id **/
    const FIELD_ID_GOODS = "goods_id";

    /** Field price **/
    const FIELD_PRICE = "price";

    /** Field actual_price **/
    const FIELD_ACTUAL_PRICE = "actual_price";

    /** Field quantity **/
    const FIELD_QUANTITY = "quantity";

    /** Field status **/
    const FIELD_STATUS = "status";

    //子订单状态
    //正常状态 - normal
    const ENUM_STATUS_NORMAL = 1;

    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_ID_GOODS,
        self::FIELD_ID_ORDER,
        self::FIELD_PRICE,
        self::FIELD_ACTUAL_PRICE,
        self::FIELD_QUANTITY,
        self::FIELD_STATUS
    ];

    public function goods()
    {
        return $this->belongsTo(Goods::class,self::FIELD_ID_GOODS,Goods::FIELD_ID);
    }

    public function order()
    {
        return $this->belongsTo(Order::class,self::FIELD_ID_ORDER,Order::FIELD_ID);
    }

    public function snapshots()
    {
        return $this->belongsTo(OrderItemSnapshots::class,self::FIELD_ID,OrderItemSnapshots::FIELD_ID_ITEM);
    }
}
