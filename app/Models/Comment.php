<?php


namespace App\Models;


class Comment extends BaseModel
{
    const TABLE_NAME = "comments";
    protected $table = self::TABLE_NAME;

    /** Field user_id 用户 **/
    const FIELD_ID_USER = "user_id";

    /** Field parent_id 评论的父级对象 **/
    const FIELD_ID_PARENT = "parent_id";

    /** Field object_id 评论对象 **/
    const FIELD_ID_OBJECT = "object_id";

    /** Field type 评论对象类型，1=订单，2=评论 **/
    const FIELD_TYPE = "type";

    /** Field title 评论标题 **/
    const FIELD_TITLE = "title";

    /** Field content 评论内容 **/
    const FIELD_CONTENT = "content";

    /** Field attachments 评论图片视频等资源 **/
    const FIELD_ATTACHMENTS = "attachments";

    /** Field star 评价是多少星，最高五星，最低一星 **/
    const FIELD_STAR = "star";

    //评论对象类型 - 订单
    const FIELD_TYPE_ORDER = 1;
    //评论对象类型 - 评论
    const FIELD_TYPE_COMMENT = 2;

    //评论等级 - 1星
    const ENUM_STAR_1 = 1;
    //评论等级 - 2星
    const ENUM_STAR_2 = 2;
    //评论等级 - 3星
    const ENUM_STAR_3 = 3;
    //评论等级 - 4星
    const ENUM_STAR_4 = 4;
    //评论等级 - 5星
    const ENUM_STAR_5 = 5;

    protected $casts = [
        self::FIELD_ATTACHMENTS => "array"
    ];

    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_ID_PARENT,
        self::FIELD_ID_OBJECT,
        self::FIELD_TYPE,
        self::FIELD_TITLE,
        self::FIELD_CONTENT,
        self::FIELD_ATTACHMENTS,
        self::FIELD_STAR
    ];
}
