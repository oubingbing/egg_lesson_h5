<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/4 0004
 * Time: 14:41
 */

namespace App\Service;


use App\Exceptions\ApiException;
use App\Models\RealName;
use App\Models\WechatUser;
use App\Repositories\UserRep;
use Overtrue\Socialite\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class WechatUserService
{
    private $rep;

    public function __construct(UserRep $userRep)
    {
        $this->rep = $userRep;
    }

    /**
     * 新增用户
     *
     * @author yezi
     * @param $userInfo
     * @return mixed
     */
    public function createWeChatUser($userInfo,$openId)
    {
        $result = WechatUser::create([
            WechatUser::FIELD_ID_OPENID => $openId,
            WechatUser::FIELD_NICKNAME  => urlencode($userInfo['nickName']),
            WechatUser::FIELD_GENDER    => $userInfo['gender'] ? $userInfo['gender'] : 0,
            WechatUser::FIELD_AVATAR    => $userInfo['avatarUrl'],
            WechatUser::FIELD_CITY      => $userInfo['city'] ? $userInfo['city'] : '无',
            WechatUser::FIELD_COUNTRY   => $userInfo['country'] ? $userInfo['country'] : '无',
            WechatUser::FIELD_PROVINCE  => $userInfo['province'] ? $userInfo['province'] : '无',
            WechatUser::FIELD_LANGUAGE  => $userInfo['language']
        ]);

        return $result;
    }

    /**
     * 获取微信小程序用户登录token
     *
     * @author yezi
     *
     * @param $user
     * @return mixed
     */
    public function getWecChatToken($user)
    {
        $user->{WechatUser::FIELD_ID_OPENID} = "";
        $user->{WechatUser::FIELD_ID_UNION} = "";
        $token = JWTAuth::fromUser($user);

        return $token;
    }

    /**
     * 根据用户id查找
     *
     * @author yezi
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function findById($id)
    {
        $result = $this->rep->find($id);
        return $result;
    }

    /**
     * 获取token
     *
     * @author yezi
     *
     * @return mixed
     * @throws Exception
     */
    public function createMiniProgramToken($userInfo,$openId)
    {
        if (empty($openId) || empty($userInfo)){
            throw new ApiException('用户信息不用为空',6000);
        }

        $user = WechatUser::where(WechatUser::FIELD_ID_OPENID,$openId)->first();
        if(!$user){
            $user      = $this->createWeChatUser($userInfo,$openId);
        }else{
            $user->{WechatUser::FIELD_NICKNAME} = urlencode($userInfo['nickName']);
            $user->{WechatUser::FIELD_AVATAR} = $userInfo['avatarUrl'];
            $user->save();
        }

        $token = $this->getWecChatToken($user);
        return $token;
    }

    public function updatePhone($userId,$phone)
    {
        $user = $this->findById($userId);
        if (!$user){
            throw new ApiException("用户不存在");
        }

        $user->{WechatUser::FIELD_PHONE} = $phone;
        $result = $user->save();
        if (!$result){
            throw new ApiException("保存用户信息失败");
        }

        return $user;
    }

    public function format($user)
    {
        $realStatus = RealName::ENUM_STATUS_NOT;
        $realMessage = "";
        $real = app(RealNameService::class)->findByUserId($user["id"]);
        if ($real){
            $realStatus = $real->{RealName::FIELD_STATUS};
            $realMessage = $real->{RealName::FIELD_VERIFY_MESSAGE};
        }

        return [
            'nick_name'     => $user[WechatUser::FIELD_NICKNAME],
            'avatar_url'    => $user[WechatUser::FIELD_AVATAR],
            'phone'         => $user[WechatUser::FIELD_PHONE],
            "real_status"   => $realStatus,
            "real_message"  => $realMessage
        ];
    }

}
