<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2021/4/24
 * Time: 17:56
 */

namespace App\Models;


class Article extends BaseModel
{
    const TABLE_NAME = "articles";
    protected $table = self::TABLE_NAME;

    /** Field admin_id 用户 **/
    const FIELD_ID_ADMIN = "admin_id";

    /** Field category_id 文章类别 **/
    const FIELD_ID_CATEGORY = "category_id";

    /** Field category_father_id 文章类别 **/
    const FIELD_ID_CATEGORY_FATHER = "category_father_id";

    /** Field title 文章标题 **/
    const FIELD_TITLE = 'title';

    /** Field seo title 文章简介 **/
    const FIELD_SEO_TITLE = "seo_title";

    /** Field seo_key_word 文章标题 **/
    const FIELD_SEO_KEY_WROD = 'seo_key_word';

    /** Field seo_describe 文章简介 **/
    const FIELD_SEO_DESCRIBE = "seo_describe";

    /** Field content 文章内容 **/
    const FIELD_CONTENT = "content";

    /** Field source_type 来源，1=后台新建，2=Excel导入 **/
    const FIELD_SOURCE_TYPE = "source_type";

    /** Field conttopent 是否置顶，0=否，1=是 **/
    const FIELD_TOP = "top";

    /** Field sort 文章排序 **/
    const FIELD_SORT = "sort";

    /** Field status 状态，0=下架，1=上架 **/
    const FIELD_STATUS = "status";

    /** Field attachments 图片 **/
    const FIELD_ATTACHMENTS = "attachments";

    //status - 下架
    const ENUM_STATUS_DOWN = 0;
    //status - 上架
    const ENUM_STATUS_UP = 1;

    //文章来源 - 后台新建
    const ENUM_SOURCE_TYPE_ADMIN = 1;
    //文章来源 - EXCEL导入
    const ENUM_SOURCE_TYPE_EXCEL = 2;

    //是否置顶 - 否
    const ENUM_TOP_NO = 0;
    //是否置顶 - 是
    const ENUM_TOP_YES = 1;

    protected $fillable = [
        self::FIELD_ID_ADMIN,
        self::FIELD_ID_CATEGORY,
        self::FIELD_ID_CATEGORY_FATHER,
        self::FIELD_TITLE,
        self::FIELD_SEO_DESCRIBE,
        self::FIELD_CONTENT,
        self::FIELD_SOURCE_TYPE,
        self::FIELD_TOP,
        self::FIELD_SORT,
        self::FIELD_STATUS,
        self::FIELD_ATTACHMENTS,
        self::FIELD_SEO_TITLE,
        self::FIELD_SEO_KEY_WROD
    ];

    protected $casts = [
        self::FIELD_ATTACHMENTS => "array"
    ];

}
