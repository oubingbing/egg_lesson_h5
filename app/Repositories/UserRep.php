<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2020/12/27
 * Time: 15:57
 */

namespace App\Repositories;


use App\Models\WechatUser;

class UserRep extends BaseRepAbstract
{
    public function find($id)
    {
        $result = WechatUser::query()->find($id);
        return $result;
    }

    public function findByOpenId($openId)
    {
        return WechatUser::query()->where(WechatUser::FIELD_ID_OPENID,$openId)->first();
    }

}
