<?php


namespace App\Models;


class Banner extends BaseModel
{
    protected $table = "banners";

    /** admin_id **/
    const FIELD_ID_ADMIN = 'admin_id';

    /** title banner标题 **/
    const FIELD_TITLE = 'title';

    /** describe 描述 **/
    const FIELD_DESCRIBE = 'describe';

    /** attachments banner 图片 **/
    const FIELD_ATTACHMENTS = 'attachments';

    /** sort 排序，越靠前越大 **/
    const FIELD_SORT = 'sort';

    /** type 类型，1=图片，2=视频 **/
    const FIELD_TYPE = 'type';

    /** status 状态，0=下架，1=上架 **/
    const FIELD_STATUS = 'status';

    /** type - 图片 **/
    const ENUM_TYPE_IMAGE = 1;
    /** type - 视频 **/
    const ENUM_TYPE_VIDEOS = 2;

    /** status - 上架 **/
    const ENUM_STATUS_UP = 1;
    /** status - 下架 **/
    const ENUM_STATUS_DOWN = 2;

    protected $casts = [
        self::FIELD_ATTACHMENTS => "array"
    ];

    protected $fillable = [
        self::FIELD_ID_ADMIN,
        self::FIELD_TITLE,
        self::FIELD_DESCRIBE,
        self::FIELD_ATTACHMENTS,
        self::FIELD_SORT,
        self::FIELD_TYPE,
        self::FIELD_STATUS
    ];

}
