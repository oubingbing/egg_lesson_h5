<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2020/12/27
 * Time: 16:20
 */

namespace App\Models;


class Campus extends BaseModel
{
    const TABLE_NAME = "campus";
    protected $table = self::TABLE_NAME;

    /** Field user_id 创建人，可以是管理员，也可以是用户 **/
    const FIELD_ID_USER = "user_id";

    /** Field name 校区名称 **/
    const FIELD_NAME = "name";

    /** Field address 校区地址 **/
    const FIELD_ADDRESS = "address";

    /** Field province **/
    const FIELD_PROVINCE = "province";

    /** Field city **/
    const FIELD_CITY = "city";

    /** Field county 区/县 **/
    const FIELD_COUNTY = "county";

    /** Field longitude 经度 **/
    const FIELD_LONGITUDE = "longitude";

    /** Field latitude 纬度 **/
    const FIELD_LATITUDE = "latitude";

    /** Field type 创建人类型，1=用户，2=管理员 **/
    const FIELD_TYPE = "type";

    //创建类型 - 用户
    const ENUM_TYPE_USER = 1;
    //创建类型 - 管理员
    const ENUM_TYPE_ADMIN = 2;

    protected $fillable = [
        self::FIELD_ID_USER,
        self::FIELD_NAME,
        self::FIELD_ADDRESS,
        self::FIELD_PROVINCE,
        self::FIELD_CITY,
        self::FIELD_COUNTY,
        self::FIELD_LONGITUDE,
        self::FIELD_LATITUDE,
        self::FIELD_TYPE
    ];

}