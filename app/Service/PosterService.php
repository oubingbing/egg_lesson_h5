<?php


namespace App\Service;


use App\Exceptions\ApiException;
use App\Service\Poster\poster;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class PosterService
{
    public function createPoster($openId,$nickname,$avatar,$title,$category,$goodsImg,$goodsId,$price,$contractPrice,$lessonType,$campus)
    {
        /*$redisKey = config("app.env").":goods_poster:{$openId}:{$goodsId}";
        $posterCache = Redis::get($redisKey);
        if ($posterCache){
            return $posterCache;
        }*/

        $accessToken = app(TokenService::class)->getAccessToken();
        $client = new Client;
        $wxUrl = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token={$accessToken}";
        $response = $client->request('POST', $wxUrl, [
            'json' => [
                "scene"=>$goodsId,
                "page"=>"pages/index/index",
            ],
        ]);

        //下载头像
        $avatarPath = storage_path("poster/avatar/");
        $avatarSavePath = $this->download($avatar,$avatarPath);

        //下载商品图片
        $goodsImagePath = storage_path("poster/goods_image/");
        $goodsSavePath = $this->download($goodsImg,$goodsImagePath);
        $goodsInfo = getimagesize($goodsSavePath); //width="1080" height="1188""

        //计算商品图片的宽高
        $goodsWith = 0;
        $goodsHeight = 0;
        $left = 0;
        if ($goodsInfo[0] > $goodsInfo[0]){
            $left = 0;
            $goodsWith = 700;
            $goodsHeight = 550;
        }else{
            $goodsHeight = 550;
            $goodsWith = $goodsInfo[0];
            if ($goodsWith > 700){
                $goodsWith = 700;
            }else{
                $goodsWith = ($goodsInfo[0]/$goodsInfo[1])*$goodsHeight;
            }
            $left = (700 - $goodsWith) / 2;
        }

        $this->resize_image($goodsSavePath, $goodsSavePath, $goodsWith, $goodsHeight);

        $config = array(
            'bg_url' => storage_path("poster/bg/bg123.jpg"),//背景图片路径
            'text' => array(
                array(
                    'text' => "{$nickname}给您分享了一个课包",//文本内容
                    'left' => 170, //左侧字体开始的位置
                    'top' => 80, //字体的下边框
                    'fontSize' => 25, //字号
                    'fontColor' => '79,79,79', //字体颜色
                    'angle' => 0,
                ),
                array(
                    'text' => $lessonType." | ".$category,//文本内容
                    'left' => 170, //左侧字体开始的位置
                    'top' => 130, //字体的下边框
                    'fontSize' => 20, //字号
                    'fontColor' => '79,79,79', //字体颜色
                    'angle' => 0,
                ),
                array(
                    'text' => $title,//文本内容
                    'left' => 50, //左侧字体开始的位置
                    'top' => 800, //字体的下边框
                    'fontSize' => 25, //字号
                    'fontColor' => '0,0,0', //字体颜色
                    'angle' => 0,
                ),
                array(
                    'text' => "原价：",//文本内容
                    'left' => 50, //左侧字体开始的位置
                    'top' => 850, //字体的下边框
                    'fontSize' => 20, //字号
                    'fontColor' => '0,0,0', //字体颜色
                    'angle' => 0,
                ),
                array(
                    'text' => "￥{$contractPrice}",//文本内容
                    'left' => 130, //左侧字体开始的位置
                    'top' => 850, //字体的下边框
                    'fontSize' => 20, //字号
                    'fontColor' => '255,0,0', //字体颜色
                    'angle' => 0,
                ),
                array(
                    'text' => "转让价：",//文本内容
                    'left' => 280, //左侧字体开始的位置
                    'top' => 850, //字体的下边框
                    'fontSize' => 20, //字号
                    'fontColor' => '0,0,0', //字体颜色
                    'angle' => 0,
                ),
                array(
                    'text' => "￥{$price}",//文本内容
                    'left' => 390, //左侧字体开始的位置
                    'top' => 850, //字体的下边框
                    'fontSize' => 20, //字号
                    'fontColor' => '255,0,0', //字体颜色
                    'angle' => 0,
                ),
                array(
                    'text' => "校区：{$campus}",//文本内容
                    'left' => 50, //左侧字体开始的位置
                    'top' => 900, //字体的下边框
                    'fontSize' => 18, //字号
                    'fontColor' => '169,169,169', //字体颜色
                    'angle' => 0,
                ),
                array(
                    'text' => '扫一扫或长按识别太阳码',//文本内容
                    'left' => 50, //左侧字体开始的位置
                    'top' => 980, //字体的下边框
                    'fontSize' => 20, //字号
                    'fontColor' => '169,169,169', //字体颜色
                    'angle' => 0,
                )
            ),
            'image' => array(
                array( //头像
                    'url' => $avatarSavePath,
                    'stream' => 0, //图片资源是否是字符串图像流
                    'left' => 40,
                    'top' =>40,
                    'right' => 0,
                    'bottom' => 0,
                    'width' => 100,
                    'height' => 100,
                    'radius' => 50,
                    'opacity' => 100
                ),
                array( //商品图片
                    'url' => $goodsSavePath,
                    'stream' => 0,
                    'left' => $left,
                    'top' => 177,
                    'right' => 0,
                    'bottom' => 0,
                    'width' => $goodsWith,//700
                    'height' => $goodsHeight,//550
                    'radius' => 0,
                    'opacity' => 100
                ),//
                array( //二维码
                    'url' => "",
                    'stream' =>$response->getBody(),
                    'left' => 550,
                    'top' => 890,
                    'right' => 0,
                    'bottom' => 0,
                    'width' => 100,
                    'height' => 100,
                    'radius' => 0,
                    'opacity' => 100
                )
            )
        );

        //设置海报背景图
        poster::setConfig($config);
        //用法一：设置保存路径
        $posterPath = storage_path("poster/goods_image/"."{$openId}-{$goodsId}".".jpg");
        Log::info("海报配置信息：".collect($config)->toJson());
        Log::info("海报保存地址：".$posterPath);
        poster::make($posterPath);

        //是否要清理缓存资源
        poster::clear();

        //上传到cos
        $key = "poster/goods/"."{$openId}-{$goodsId}".".jpg";
        $cosResult = app(CosService::class)->upload($key,$posterPath);
        if ($cosResult["code"] == 0){
            $redisKey = config("app.env").":goods_poster:{$openId}:{$goodsId}";
            $posterUrl = config("app.tc_cos_domain")."/".$key;
            Redis::setex($redisKey,60*60*24*3,$posterUrl);
            unlink($goodsSavePath);
            unlink($avatarSavePath);
            unlink($posterPath);
            return $posterUrl;
        }else{
            Log::error("生成海报异常：".collect($cosResult)->toJson());
            throw new ApiException("生成海报异常，请稍后再试");
        }
    }

    /**
     * 按照指定的尺寸压缩图片
     * @param string $source_path 原图路径
     * @param string $target_path 保存路径
     * @param string $imgWidth 目标宽度
     * @param string $imgHeight 目标高度
     * @return bool|string
     */
    function resize_image($source_path, $target_path, $imgWidth, $imgHeight)
    {
        $source_info = getimagesize($source_path);
        $source_mime = $source_info['mime'];
        switch ($source_mime) {
            case 'image/gif':
                $source_image = imagecreatefromgif($source_path);
                break;

            case 'image/jpeg':
                $source_image = imagecreatefromjpeg($source_path);
                break;

            case 'image/png':
                $source_image = imagecreatefrompng($source_path);
                break;

            default:
                return false;
                break;
        }
        $target_image = imagecreatetruecolor($imgWidth, $imgHeight); //创建一个彩色的底图
        imagecopyresampled($target_image, $source_image, 0, 0, 0, 0, $imgWidth, $imgHeight, $source_info[0], $source_info[1]);
        //保存图片到本地
        $fileName = $target_path;
        if (!imagejpeg($target_image, $fileName)) {
            $fileName = '';
        }
        return $fileName;
    }

    public function download($url, $path)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $file = curl_exec($ch);
        curl_close($ch);
        $filename = pathinfo($url, PATHINFO_BASENAME);
        $resource = fopen($path . $filename.".jpg", 'a');
        fwrite($resource, $file);
        fclose($resource);

        return $path . $filename.".jpg";
    }

}
