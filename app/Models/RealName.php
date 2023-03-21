<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2021/1/3
 * Time: 13:16
 */

namespace App\Models;


class RealName extends BaseModel
{
    const TABLE_NAME = 'real_names';
    protected $table = self::TABLE_NAME;

    /** Field user_id **/
    const FIELD_ID_USER = "user_id";

    /** Field name **/
    const FIELD_NAME = "name";

    /** Field sex **/
    const FIELD_SEX = "sex";

    /** Field nation **/
    const FIELD_NATION = "nation";

    /** Field birth **/
    const FIELD_BIRTH = "birth";

    /** Field address **/
    const FIELD_ADDRESS = "address";

    /** Field id_num **/
    const FIELD_ID_NUM = "id_num";

    /** Field authority 认证机构 **/
    const FIELD_AUTHORITY = "authority";

    /** Field valid_date 身份证有效期 **/
    const FIELD_VALID_DATE = "valid_date";

    /** Field status ,验证状态，1=验证中，2=验证失败，3=验证成功 **/
    const FIELD_STATUS = "status";

    /** Field attachments **/
    const FIELD_ATTACHMENTS = "attachments";

    /** Field verify_message 验证提示信息 **/
    const FIELD_VERIFY_MESSAGE = "verify_message";

    /** Field verify_result 验证结果 **/
    const FIELD_VERIFY_RESULT = "verify_result";

    //status - 未认证
    const ENUM_STATUS_NOT = 0;
    //status - 验证中
    const ENUM_STATUS_VERIFYING = 1;
    //status - 验证失败
    const ENUM_STATUS_FAIL = 2;
    //status - 验证成功
    const ENUM_STATUS_SUCCESS = 3;

    protected $casts = [
        self::FIELD_ATTACHMENTS => "array"
    ];

    protected $fillable = [
        self::FIELD_ID_USER,
        self::FIELD_NAME,
        self::FIELD_SEX,
        self::FIELD_NATION,
        self::FIELD_BIRTH,
        self::FIELD_ADDRESS,
        self::FIELD_ID_NUM,
        self::FIELD_AUTHORITY,
        self::FIELD_VALID_DATE,
        self::FIELD_STATUS,
        self::FIELD_ATTACHMENTS,
        self::FIELD_VERIFY_MESSAGE,
        self::FIELD_VERIFY_RESULT
    ];

}
