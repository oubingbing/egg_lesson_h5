<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2021/1/2
 * Time: 15:52
 */

namespace App\Service;


use App\Enum\ErrorEnum;
use App\Exceptions\ApiException;
use App\Models\RealName;
use App\Repositories\RealNameRep;
use TencentCloud\Common\Credential;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Ocr\V20181119\Models\IDCardOCRRequest;
use TencentCloud\Ocr\V20181119\OcrClient;

class RealNameService extends BaseServiceAbstract
{
    private $rep;
    private $secretId;
    private $secretKey;

    public function __construct(RealNameRep $realNameRep)
    {
        $this->rep = $realNameRep;
        $this->secretId = config("app.tc_secret_id");
        $this->secretKey = config("app.tc_secret_key");
    }

    public function findByUserId($userId)
    {
        $result = $this->rep->findByUserId($userId);
        return $result;
    }

    public function store($userId,$front,$backend)
    {
        $realName = new RealName();
        $realName->{RealName::FIELD_ID_USER} = $userId;
        $realName->{RealName::FIELD_STATUS} = RealName::ENUM_STATUS_VERIFYING;
        $realName->{RealName::FIELD_ATTACHMENTS} = [
            "front"=>$front,
            "backend"=>$backend
        ];
        $result = $this->rep->store($realName);
        return $result;
    }

    /**
     * 识别身份证号码
     *
     * @author yezi
     * @param $image
     * @return array
     */
    public function getIdCardInfo($image)
    {
        try {
            $cred = new Credential($this->secretId, $this->secretKey);
            $httpProfile = new HttpProfile();
            $httpProfile->setEndpoint("ocr.tencentcloudapi.com");

            $clientProfile = new ClientProfile();
            $clientProfile->setHttpProfile($httpProfile);
            $client = new OcrClient($cred, "ap-guangzhou", $clientProfile);
            $req = new IDCardOCRRequest();
            $params = array(
                "ImageUrl" => $image
            );
            $req->fromJsonString(json_encode($params));
            $resp = $client->IDCardOCR($req);

            return [
                "code"=>0,
                "data"=>json_decode($resp->toJsonString(),true)
            ];
        }
        catch(TencentCloudSDKException $e) {
            return [
                "code"=>1,
                "data"=>$e->getMessage()
            ];
        }

    }

    public function doRealName($id)
    {
        $realName = $this->rep->find($id);
        if (!$realName){
            throw new ApiException("实名认证信息不存在",ErrorEnum::REAL_NAME_NOT_FOUND);
        }

        if ($realName->{RealName::FIELD_STATUS} == RealName::ENUM_STATUS_SUCCESS){
            throw new ApiException("实名认证已完成，无需重复认证",ErrorEnum::REAL_NAME_REPEAT);
        }

        $front = $realName->{RealName::FIELD_ATTACHMENTS}["front"];
        $backend = $realName->{RealName::FIELD_ATTACHMENTS}["backend"];
        $cosDomain = config("app.tc_cos_domain");
        $front = $cosDomain."/".urlencode($front);
        $backend = $cosDomain."/".urlencode($backend);

        $verifyMessage = "";
        $frontResult = $this->getIdCardInfo($front);

        $status = RealName::ENUM_STATUS_SUCCESS;
        if ($frontResult["code"] != 0){
            //todo 记录日志
            $verifyMessage .= "人像面认证失败";
            $status = RealName::ENUM_STATUS_FAIL;
        }else{
            $frontData = $frontResult["data"];
            $realName->{RealName::FIELD_NAME} = $frontData["Name"];
            $realName->{RealName::FIELD_SEX} = $frontData["Sex"];
            $realName->{RealName::FIELD_NATION} = $frontData["Nation"];
            $realName->{RealName::FIELD_BIRTH} = $frontData["Birth"];
            $realName->{RealName::FIELD_ADDRESS} = $frontData["Address"];
            $realName->{RealName::FIELD_ID_NUM} = $frontData["IdNum"];
        }

        $backendResult = $this->getIdCardInfo($backend);

        if ($backendResult["code"] != 0){
            //todo 记录日志
            $verifyMessage .= "国徽面认证失败";
            $status = RealName::ENUM_STATUS_FAIL;
        }else{
            $backendData = $backendResult["data"];
            $realName->{RealName::FIELD_AUTHORITY} = $backendData["Authority"];
            $realName->{RealName::FIELD_VALID_DATE} = $backendData["ValidDate"];
        }

        $realName->{RealName::FIELD_VERIFY_MESSAGE} = $verifyMessage;
        $realName->{RealName::FIELD_VERIFY_RESULT} = ["front"=>$frontResult,"backend"=>$backendResult];
        $realName->{RealName::FIELD_STATUS} = $status;
        $result = $realName->save();
        if (!$result){
            throw new ApiException("更新身份证信息失败",ErrorEnum::REAL_NAME_UPDATE_FAIL);
        }

        return $result;
    }

}
