<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2021/4/24
 * Time: 17:56
 */

namespace App\Models;


class ArticleCategory extends BaseModel
{
    const TABLE_NAME = "article_categories";
    protected $table = self::TABLE_NAME;

    /** Field admin_id 用户 **/
    const FIELD_ID_ADMIN = "admin_id";

    /** Field father_id 用户 **/
    const FIELD_ID_FATHER = "father_id";

    /** Field name 分类名称 **/
    const FIELD_NAME = "name";

    /** Field sort 排序，数字越大越靠前 **/
    const FIELD_SORT = 'sort';

    /** Field status 状态，0=下架，1=上架 **/
    const FIELD_STATUS = "status";

    /** Field attachments 图片 **/
    const FIELD_ATTACHMENTS = "attachments";

    //status - 下架
    const ENUM_STATUS_DOWN = 0;
    //status - 上架
    const ENUM_STATUS_UP = 1;

    protected $fillable = [
        self::FIELD_ID_ADMIN,
        self::FIELD_NAME,
        self::FIELD_SORT,
        self::FIELD_STATUS,
        self::FIELD_ATTACHMENTS,
        self::FIELD_ID_FATHER
    ];

    protected $casts = [
        self::FIELD_ATTACHMENTS => "array"
    ];

}
