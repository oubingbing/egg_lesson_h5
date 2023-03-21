<?php

namespace App\Service;

use App\Exceptions\ApiException;
use TencentCloud\Common\Credential;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Sms\V20190711\Models\SendSmsRequest;
use TencentCloud\Sms\V20190711\SmsClient;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/7/14 0014
 * Time: 11:45
 */
class SmsService extends BaseServiceAbstract
{
    private $appId;
    private $secretId;
    private $secretKey;
    private $sign;
    private $templateId;
    private $region;

    public function __construct($sign,$templateId)
    {
        $this->appId = config("app.tc_sms_app_id");
        $this->secretId = config("app.tc_secret_id");
        $this->secretKey = config("app.tc_secret_key");
        $this->region = config("app.tc_cos_region");
        $this->sign = $sign;
        $this->templateId = $templateId;
    }

    /**
     * 发送短信
     *
     * @param array $phones
     * @param array $message
     * @return array
     * @throws ApiException
     */
    public function send(array $phones,array $message)
    {
        try {
            $cred   = new Credential($this->secretId, $this->secretKey);
            $client = new SmsClient($cred, "ap-guangzhou");
            $req    = new SendSmsRequest();

            foreach ($phones as &$phone) {
                $phone = "+86".$phone;
            }

            $req->SmsSdkAppid   = $this->appId;
            $req->Sign          = $this->sign;
            $req->ExtendCode    = "0";
            /**
             * 下发手机号码，采用 e.164 标准，+[国家或地区码][手机号]
             * 例如+8613711112222， 其中前面有一个+号 ，86为国家码，13711112222为手机号，最多不要超过200个手机号
             */
            $req->PhoneNumberSet = $phones;
            $req->SenderId = "";
            $req->SessionContext = "";
            $req->TemplateID = $this->templateId;
            $req->TemplateParamSet = $message;

            $resp = $client->SendSms($req);
            $success = [];
            $fail = [];
            foreach ($resp->SendStatusSet as $item){
                if ($item->Code != "Ok"){
                    array_push($fail,["phone_number"=>$item->PhoneNumber,"message"=>$item->Message,"code"=>$item->Code]);
                }else{
                    array_push($success,["phone_number"=>$item->PhoneNumber,"message"=>$item->Message,"code"=>$item->Code]);
                }
            }
            return ["success"=>$success,"fail"=>$fail];
        }
        catch(TencentCloudSDKException $e) {
            throw new ApiException($e->getMessage(),500);
        }
    }

    public static function sendMessage($templateId,$phone,$message)
    {
        $sign = "旦旦转课网";
        $phones = [$phone];
        $sms = new \App\Service\SmsService($sign,$templateId);
        $sms->send($phones,$message);
    }
}
