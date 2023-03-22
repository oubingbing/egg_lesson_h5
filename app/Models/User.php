<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2021/1/3
 * Time: 13:16
 */

namespace App\Models;


class User extends BaseModel
{
    const TABLE_NAME = 'users';
    protected $table = self::TABLE_NAME;

    /** Field email **/
    const FIELD_EMAIL = "email";

    /** Field password **/
    const FIELD_PASSWORD = "password";

    /** Field email_code **/
    const FIELD_EMAIL_CODE = "email_code";

    /** Field code_expire_at **/
    const FIELD_CODE_EXPIRE_AT = "code_expire_at";

    protected $fillable = [
        self::FIELD_EMAIL,
        self::FIELD_PASSWORD,
        self::FIELD_EMAIL_CODE,
        self::FIELD_CODE_EXPIRE_AT
    ];

}
