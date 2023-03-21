<?php


namespace App\Models;

/**
 * 品牌
 *
 * @author
 * Class contractTransferInfos
 * @package App\Models
 */
class Brand extends BaseModel
{
    const TABLE_NAME = "brands";
    protected $table = self::TABLE_NAME;

    /** field creater_id 创建人 **/
    const FIELD_ID_CREATE = "creater_id";

    /** field name 品牌名称 **/
    const FIELD_NAME = "name";

    /** field sort 排序 **/
    const FIELD_SORT = "sort";

    /** field type 品牌类型，1=平台创建，2=商户创建，3=系统导入 **/
    const FIELD_TYPE = "type";

    /** field describe 品牌描述 **/
    const FIELD_DESCRIBE = "describe";

    /** field attachments 附件 **/
    const FIELD_ATTACHMENTS = "attachments";

    //type - platform
    const ENUM_TYPE_PLATFORM = 1;
    //type - 用户创建
    const ENUM_TYPE_USER = 2;
    //type - Excel导入
    const ENUM_TYPE_EXCEL = 3;

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
