<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/25 0025
 * Time: 15:28
 */

namespace App\Models;

/**
 * 微信Access token
 *
 * @author 叶子
 * Class contractTransferInfos
 * @package App\Models
 */
class WechatAccessToken extends BaseModel
{
    const TABLE_NAME = 'wechat_access_tokens';
    protected $table = self::TABLE_NAME;

    /** Field id */
    const FIELD_ID = 'id';

    /** Field app_id */
    const FIELD_ID_APP = 'app_id';

    /** Field token */
    const FIELD_TOKEN = 'token';

    /** Field expired_at */
    const FIELD_EXPIRED_AT = 'expired_at';

    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_ID_APP,
        self::FIELD_TOKEN,
        self::FIELD_EXPIRED_AT
    ];

}
