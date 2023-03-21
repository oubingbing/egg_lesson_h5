<?php

namespace App\Service;

use App\Exceptions\ApiException;
use App\Models\AccessToken;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;

class TokenService
{

    /**
     * 请求微信服务器获取access token
     *
     * @author yezi
     *
     * @param $appId
     * @return mixed
     * @throws ApiException
     */
    public function accessToken()
    {
        $weChatAppId = config("app.wx_mini_id");
        $secret = config("app.wx_mini_key");
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$weChatAppId&secret=$secret";
        $http = new Client;
        $response = $http->get($url);
        $result = json_decode((string) $response->getBody(), true);
        return $result;
    }

    /**
     * 获取微信access token
     *
     * @author yezi
     *
     * @param $appId
     * @return mixed
     */
    public function getAccessToken()
    {
        $result = $this->accessToken();
        return $result['access_token'];

        //$token = AccessToken::query()->where(AccessToken::FIELD_EXPIRED_AT,'>',Carbon::now())->first();
        $key = "wx_access_token";
        $token = Redis::get($key);
        if(!$token){
            $result = $this->accessToken();
            $token = AccessToken::create([
                AccessToken::FIELD_ID_APP     => 1,
                AccessToken::FIELD_TOKEN      => $result['access_token'],
                AccessToken::FIELD_EXPIRED_AT => Carbon::now()->addSecond($result['expires_in'])
            ]);
            Redis::setex($key,$result['expires_in'],$result['access_token']);
        }

        return $token;
    }

}
