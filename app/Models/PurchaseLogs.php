<?php


namespace App\Models;


class PurchaseLogs extends BaseModel
{
    const TABLE_NAME = "purchase_logs";
    protected $table = self::TABLE_NAME;

    /** Field nickname **/
    const FIELD_NICKNAME = "nickname";

    /** Field avatar **/
    const FIELD_AVATAR = "avatar";

    /** Field lesson_category **/
    const FIELD_LESSON_CATEGORY = "lesson_category";

    /** lesson_id **/
    const FIELD_ID_LESSON = "lesson_id";

    /** amount **/
    const FIELD_AMOUNT = "amount";

    protected $fillable = [
        self::FIELD_NICKNAME,
        self::FIELD_AVATAR,
        self::FIELD_LESSON_CATEGORY,
        self::FIELD_ID_LESSON,
        self::FIELD_AMOUNT,
    ];
}
