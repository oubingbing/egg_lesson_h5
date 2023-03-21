<?php


namespace App\Models;


class OrderItemSnapshots extends BaseModel
{
    const TABLE_NAME = "order_item_snapshots";
    protected $table = self::TABLE_NAME;

    /** Field user_id 用户 **/
    const FIELD_ID_USER = "user_id";

    /** Field order_item_id **/
    const FIELD_ID_ITEM = "order_item_id";

    /** Field snapshots **/
    const FIELD_SNAPSHOTS = "snapshots";

    protected $casts = [
        self::FIELD_SNAPSHOTS => "array"
    ];

    protected $fillable = [
        self::FIELD_ID_USER,
        self::FIELD_ID_ITEM,
        self::FIELD_SNAPSHOTS
    ];
}
