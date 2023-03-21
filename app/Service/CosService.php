<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2021/1/2
 * Time: 16:45
 */

namespace App\Service;


use App\Enum\ErrorEnum;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Redis;
use Qcloud\Cos\Client;
use QCloud\COSSTS\Sts;

class CosService extends BaseServiceAbstract
{
    private $secretId;
    private $secretKey;
    private $bucket;
    private $region;

    public function __construct()
    {
        $this->secretId = config("app.tc_secret_id");
        $this->secretKey = config("app.tc_secret_key");
        $this->bucket = config("app.tc_cos_bucket");
        $this->region = config("app.tc_cos_region");
    }

    public function upload($k,$file)
    {
        $secretId = $this->secretId;
        $secretKey = $this->secretKey;
        $region = $this->region; //设置一个默认的存储桶地域
        $cosClient = new Client(
            array(
                'region' => $region,
                'schema' => 'https', //协议头部，默认为http
                'credentials'=> array(
                    'secretId'  => $secretId ,
                    'secretKey' => $secretKey)));
        $local_path = $file;
        try {
            $result = $cosClient->upload(
                $bucket = $this->bucket,
                $key = $k,
                $body = fopen($local_path, 'rb')
            );
           return ["code"=>0,"data"=>$result,"msg"=>"上传成功"];
        } catch (\Exception $e) {
            // 请求失败
            return ["code"=>1,"data"=>null,"msg"=>$e->getMessage()];
        }
    }

    public function accessToken()
    {
        $sts = new Sts();
        $config = array(
            'url' => 'https://sts.tencentcloudapi.com/',
            'domain' => 'sts.tencentcloudapi.com',
            'proxy' => '',
            'secretId' => $this->secretId,
            'secretKey' => $this->secretKey,
            'bucket' => $this->bucket, // 换成你的 bucket
            'region' => $this->region, // 换成 bucket 所在园区
            'durationSeconds' => 1800, // 密钥有效期
            'allowPrefix' => '*', // 这里改成允许的路径前缀，可以根据自己网站的用户登录态判断允许上传的具体路径，例子： a.jpg 或者 a/* 或者 * (使用通配符*存在重大安全风险, 请谨慎评估使用)
            // 密钥的权限列表。简单上传和分片需要以下的权限，其他权限列表请看 https://cloud.tencent.com/document/product/436/31923
            'allowActions' => array (
                // 简单上传
                'name/cos:PutObject',
                //删除操作
                'name/cos:DeleteObject',
                // 表单上传
                'name/cos:PostObject',
                // 分片上传： 初始化分片
                'name/cos:InitiateMultipartUpload',
                // 分片上传： 查询 bucket 中未完成分片上传的UploadId
                "name/cos:ListMultipartUploads",
                // 分片上传： 查询已上传的分片
                "name/cos:ListParts",
                // 分片上传： 上传分片块
                "name/cos:UploadPart",
                // 分片上传： 完成分片上传
                "name/cos:CompleteMultipartUpload"
            )
        );

        try {
            $tempKeys = $sts->getTempKeys($config);
            return ["code"=>0,"data"=>$tempKeys,"msg"=>"ok"];
        } catch (\Exception $e) {
            // 请求失败
            return ["code"=>1,"data"=>null,"msg"=>$e->getMessage()];
        }
    }

    public function getAccessToken()
    {
        $key = "egg_lesson:cos_token";
        $data = Redis::get($key);
        if (!$data){
            $result = $this->accessToken();
            if ($result["code"] != 0){
                throw new ApiException("获取cos token失败,".$result["msg"],ErrorEnum::COS_GET_TOKEN_ERR);
            }
            $data = $result["data"];
            $expire = $data["expiredTime"] - time();
            $data["domain"] = env("TC_COS_DOMAIN");
            $data["bucket"] = env("TC_COS_BUCKET");
            $data["region"] = env("TC_COS_REGION");
            $setResult = Redis::setex($key,$expire,json_encode($data));
            if (!$setResult){
                throw new ApiException("设置cos缓存失败",ErrorEnum::COS_GET_TOKEN_CACHE_ERR);
            }
            return $data;
        }
        return json_decode($data,true);
    }
}
