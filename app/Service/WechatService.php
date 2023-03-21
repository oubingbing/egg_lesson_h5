<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/4 0004
 * Time: 14:11
 */

namespace App\Service;

use App\Enum\ErrorEnum;
use App\Exceptions\ApiException;
use App\Models\RealName;
use App\Models\WechatAccessToken;
use App\Repositories\UserRep;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class WechatService
{
    protected $weChatLoginUrl = "https://api.weixin.qq.com/sns/jscode2session";
    private $appId = '';
    private $appSecret = '';

    public function __construct()
    {
        $this->appId = config("app.wx_mini_id");
        $this->appSecret = config("app.wx_mini_key");
    }

    /**
     * 检验数据的真实性，并且获取解密后的明文.
     * @param $encryptedData string 加密的用户数据
     * @param $iv string 与用户数据一同返回的初始向量
     * @param $data string 解密后的原文
     *
     * @return int 成功0，失败返回对应的错误码
     */
    public function decryptData($encryptedData, $iv, $sessionKey)
    {
        if (strlen($sessionKey) != 24) {
            throw new ApiException("session_key error",ErrorEnum::WX_SESSION_ERR);
        }

        $aesKey=base64_decode($sessionKey);
        if (strlen($iv) != 24) {
            throw new ApiException("iv error",ErrorEnum::WX_IV_ERR);
        }

        $aesIV=base64_decode($iv);
        $aesCipher=base64_decode($encryptedData);
        $result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);
        $dataObj=json_decode( $result );
        if( $dataObj  == NULL )
        {
            throw new ApiException("登录失败，请稍后重试",ErrorEnum::WX_PARSE_ERR);
        }

        if( $dataObj->watermark->appid != $this->appId )
        {
            throw new ApiException("登录失败，请稍后重试",ErrorEnum::WX_APP_ERR);
        }

        $data = $result;
        return $data;
    }

    /**
     * 获取微信access token
     *
     * @author yezi
     *
     * @param $appId
     * @return mixed
     */
    public function getAccessToken($appId)
    {
        $token = WechatAccessToken::query()->where(WechatAccessToken::FIELD_ID_APP,$appId)->where(WechatAccessToken::FIELD_EXPIRED_AT,'>',Carbon::now())->first();
        if(!$token){
            $result = $this->accessToken($appId);
            $token = WechatAccessToken::create([
                WechatAccessToken::FIELD_ID_APP     => $appId,
                WechatAccessToken::FIELD_TOKEN      => $result['access_token'],
                WechatAccessToken::FIELD_EXPIRED_AT => Carbon::now()->addSecond($result['expires_in'])
            ]);
        }

        return $token['token'];
    }

    /**
     * 微信小程序登录
     *
     * @param $encryptedData
     * @param $code
     * @param $iv
     * @return mixed
     * @throws ApiException
     */
    public function miniProgramLogin($encryptedData,$code,$iv)
    {
        $url         = $this->weChatLoginUrl.'?appid='.$this->appId.'&secret='.$this->appSecret.'&js_code='.$code.'&grant_type=authorization_code';
        $http        = new Client;
        $response    = $http->get($url);

        $result = json_decode((string) $response->getBody(), true);
        if(!isset($result['openid'])){
            Log::error("用户登录失败，微信登录返回结果：".(string) $response->getBody());
            throw new ApiException('登录失败，请稍后重试',ErrorEnum::AUTH_MINI_PROGRAM_LOGIN_ERR);
        }

        $parseData = $this->decryptData($encryptedData, $iv, $result["session_key"]);
        $userInfo = json_decode($parseData,true);
        $token = app(WechatUserService::class)->createMiniProgramToken($userInfo,$result['openid']);

        $realStatus = 0;
        $user = app(UserRep::class)->findByOpenId($result['openid']);
        if ($user){
            $real = app(RealNameService::class)->findByUserId($user->id);
            if ($real){
                if ($real->{RealName::FIELD_STATUS} == RealName::ENUM_STATUS_SUCCESS){
                    $realStatus = 1;
                }
            }
        }

        return ['token'=>$token,'nick_name'=>$userInfo["nickName"],'avatar_url'=>$userInfo['avatarUrl'],"real_status"=>$realStatus];
    }

    /**
     * 解密用户手机号
     *
     * @param $userId
     * @param $encryptedData
     * @param $code
     * @param $iv
     * @return mixed
     * @throws ApiException
     */
    public function getPhone($userId,$encryptedData,$code,$iv)
    {
        $url         = $this->weChatLoginUrl.'?appid='.$this->appId.'&secret='.$this->appSecret.'&js_code='.$code.'&grant_type=authorization_code';
        $http        = new Client;
        $response    = $http->get($url);

        $result = json_decode((string) $response->getBody(), true);
        if(!isset($result['openid'])){
            throw new ApiException('获取用户数据失败',ErrorEnum::AUTH_MINI_PROGRAM_LOGIN_ERR);
        }

        $parseData = $this->decryptData($encryptedData, $iv, $result["session_key"]);
        $userInfo = json_decode($parseData,true);
        if (!key_exists("purePhoneNumber",$userInfo)){
            throw new ApiException("获取手机号失败，请稍后重试");
        }

        $user = app(WechatUserService::class)->updatePhone($userId,$userInfo["purePhoneNumber"]);
        return $user;
    }
}
