<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/4 0004
 * Time: 14:12
 */

namespace App\Models;

/**
 * 微信用户表
 *
 * @author 叶子
 * Class contractTransferInfos
 * @package App\Models
 */
class WechatUser extends BaseModel
{

    const TABLE_NAME = "wechat_users";
    protected $table = self::TABLE_NAME;

    /** field id 用户Id */
    const FIELD_ID = 'id';

    /** field phone手机号 **/
    const FIELD_PHONE = "phone";

    /** field nickname 用户昵称 */
    const FIELD_NICKNAME = 'nickname';

    /** field open_id */
    const FIELD_ID_OPENID = 'open_id';

    /** file union_id */
    const FIELD_ID_UNION = 'union_id';

    /** field avatar 头像 */
    const FIELD_AVATAR = 'avatar';

    /** field gender 性别 */
    const FIELD_GENDER = 'gender';

    /** field city 所在城市 */
    const FIELD_CITY = 'city';

    /** field country 国家 */
    const FIELD_COUNTRY = 'country';

    /** field language 语言 */
    const FIELD_LANGUAGE = 'language';

    /** field province 省份 */
    const FIELD_PROVINCE = 'province';

    /** field from_type 来源类型 */
    const FIELD_FROM_TYPE = 'from_type';

    /** field status 状态，0=正常，1=封禁 **/
    const FIELD_STATUS = "status";

    /** status - 正常 **/
    const ENUM_STATUS_NORMAL = 0;
    /** status - 封禁 **/
    const ENUM_STATUS_BAN = 1;

    /** gender-男 */
    const ENUM_GENDER_BOY = 1;
    /** gender-女 */
    const ENUM_GENDER_GIRL = 2;
    /** gender 未知 */
    const ENUM_GENDER_UN_KNOW = 0;

    /** from type 小程序 **/
    const ENUM_FROM_TYPE_MINI_PROGRAM = 1;
    /** from type 手机号 **/
    const ENUM_FROM_TYPE_PHONE = 2;
    /** from type 微信公众号 **/
    const ENUM_FROM_TYPE_MINI_WECHAT = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::FIELD_PHONE,
        self::FIELD_NICKNAME,
        self::FIELD_ID_OPENID,
        self::FIELD_ID_UNION,
        self::FIELD_AVATAR,
        self::FIELD_GENDER,
        self::FIELD_CITY,
        self::FIELD_COUNTRY,
        self::FIELD_LANGUAGE,
        self::FIELD_PROVINCE,
        self::FIELD_FROM_TYPE
    ];

    public function getNicknameAttribute($nickname)
    {
        return urldecode($nickname);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
