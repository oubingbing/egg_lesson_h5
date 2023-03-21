<?php


namespace App\Models;

/**
 * 合同表
 *
 * author 叶子
 * Class ContractLesson
 * @package App\Models
 */
class ContractLesson extends BaseModel
{
    const TABLE_NAME = "contract_lessons";
    protected $table = self::TABLE_NAME;

    /** Field goods_id所属商品 **/
    const FIELD_ID_GOODS = "goods_id";

    /** Field members 合同会员 **/
    const FIELD_MEMBERS = "members";

    /** Field parent_contact_info 家长联系方式，手机号/微信 **/
    const FIELD_PARENT_CONTACT_INFO = "parent_contact_info";

    /** Field campus_contact_info 校区联系方式，手机号/微信 **/
    const FIELD_CAMPUS_CONTACT_INFO = "campus_contact_info";

    /** Field contract_no 合同编号 **/
    const FIELD_CONTRACT_NO = "contract_no";

    /** Field contract_expired 合同有效期 **/
    const FIELD_CONTRACT_EXPIRED = "contract_expired";

    /** Field lesson_type 课程类型，1=次卡，2=年卡 **/
    const FIELD_LESSON_TYPE = "lesson_type";

    /** Field surplus_amount 合同剩余金额，单位分 **/
    const FIELD_SURPLUS_AMOUNT = "surplus_amount";

    /** Field surplus_lesson_time 合同剩余课时 **/
    const FIELD_SURPLUS_LESSON_TIME = "surplus_lesson_time";

    /** Field min_year 最小适课年龄 **/
    const FIELD_MIN_YEAR = "min_year";

    /** Field max_year 最大适课年龄 **/
    const FIELD_MAX_YEAR = "max_year";
    //FIELD_LESSON_MONTH

    /** Field lesson_gender 适课性别，1=男，2=女，3=不限 **/
    const FIELD_LESSON_GENDER = "lesson_gender";

    /** Field attachments 合同附件 **/
    const FIELD_ATTACHMENTS = "attachments";

    //课程类型 - 次卡
    const ENUM_LESSON_TYPE_TIME  = 1;
    //课程类型 - 年卡
    const ENUM_LESSON_TYPE_YEAR = 2;

    //适课性别 - 男
    const ENUM_GENDER_BOY = 1;
    //适课性别 - 女
    const ENUM_GENDER_GIRL = 2;
    //适课性别 - 不限
    const ENUM_GENDER_NO = 3;

    protected $casts = [
        self::FIELD_ATTACHMENTS => "array"
    ];

    protected $fillable = [
        self::FIELD_ID_GOODS,
        self::FIELD_MEMBERS,
        self::FIELD_PARENT_CONTACT_INFO,
        self::FIELD_CAMPUS_CONTACT_INFO,
        self::FIELD_CONTRACT_NO,
        self::FIELD_CONTRACT_EXPIRED,
        self::FIELD_LESSON_TYPE,
        self::FIELD_SURPLUS_AMOUNT,
        self::FIELD_SURPLUS_LESSON_TIME,
        self::FIELD_MIN_YEAR,
        self::FIELD_MAX_YEAR,
        self::FIELD_LESSON_TYPE,
        self::FIELD_LESSON_GENDER,
        self::FIELD_ATTACHMENTS
    ];

    public function getSurplusLessonTimeAttribute($item)
    {
        return (float)$item;
    }

}
