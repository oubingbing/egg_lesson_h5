<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2021/4/24
 * Time: 15:51
 */

namespace App\Models;


class Collection extends BaseModel
{
    const TABLE_NAME = "collections";
    protected $table = self::TABLE_NAME;

    /** field object_id 收藏对象 **/
    const FIELD_ID_OBJECT = 'object_id';

    /** field user_id 收藏人 **/
    const FIELD_ID_USER = 'user_id';

    /** field type 收藏类型，1=商品 **/
    const FIELD_TYPE = 'type';

    /** field status 1=收藏，2=取消收藏 **/
    const FIELD_STATUS = 'status';

    //type - 商品
    const ENUM_GOODS = 1;

    //status - 收藏
    const ENUM_STATUS_Y = 1;
    //status - 取消收藏收藏
    const ENUM_STATUS_N = 0;

    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_ID_USER,
        self::FIELD_ID_OBJECT,
        self::FIELD_TYPE,
        self::FIELD_STATUS
    ];
}