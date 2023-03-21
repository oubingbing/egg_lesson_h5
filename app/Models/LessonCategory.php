<?php


namespace App\Models;

/**
 * 课程类型表
 *
 * @author 叶子
 * Class contractTransferInfos
 * @package App\Models
 */
class LessonCategory extends BaseModel
{
    const TABLE_NAME = "lesson_categories";
    protected $table = self::TABLE_NAME;

    /** field creater_id 创建人 **/
    const FIELD_ID_CREATE = "creater_id";

    /** field name 品牌名称 **/
    const FIELD_NAME = "name";

    /** field sort 排序 **/
    const FIELD_SORT = "sort";

    /** field type 品牌类型，1=平台创建，2=商户创建 **/
    const FIELD_TYPE = "type";

    /** field describe 品牌描述 **/
    const FIELD_DESCRIBE = "describe";

    /** field attachments 附件 **/
    const FIELD_ATTACHMENTS = "attachments";

    protected $casts = [
        self::FIELD_ATTACHMENTS => "array",
        self::FIELD_DESCRIBE    => "array"
    ];

    protected $fillable = [
        self::FIELD_ID_CREATE,
        self::FIELD_NAME,
        self::FIELD_SORT,
        self::FIELD_TYPE,
        self::FIELD_DESCRIBE,
        self::FIELD_ATTACHMENTS
    ];

}
