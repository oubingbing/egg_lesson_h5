<?php


namespace App\Service;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class LocationService extends BaseServiceAbstract
{
    /**
     * 写入校区省市区信息
     *
     * @param $goodsId
     * @param $campusId
     * @param $longitude
     * @param $latitude
     * @return false
     */
    public static function updateCampusLocation($goodsId,$campusId,$longitude,$latitude)
    {
        $result = self::getLocationInfo($longitude,$latitude);
        if (!$result){
            Log::error("获取地理信息失败,longitude={$longitude},latitude={$latitude},result=".json_encode($result,JSON_UNESCAPED_UNICODE));
            return false;
        }

        if ($result["status"] != 0){
            Log::error("获取地理信息失败,longitude={$longitude},latitude={$latitude},result=".json_encode($result,JSON_UNESCAPED_UNICODE));
            return false;
        }

        $data     = $result["result"];
        $adInfo   = $data["ad_info"];
        $province = $adInfo["province"];
        $city     = $adInfo["city"];
        $county   = $adInfo["district"];
        //更新校区省市区
        app(CampusService::class)->updateLocation($campusId,$province,$city,$county);

        //更新商品省市区
        app(GoodsService::class)->updateLocation($goodsId,$province,$city,$county);
    }

    /**
     * 获取腾讯地理信息
     *
     * @param $longitude
     * @param $latitude
     * @return mixed
     */
    public static function getLocationInfo($longitude,$latitude)
    {
        $client = new Client();
        $key = config("app.tc_mp_key");
        $url = "https://apis.map.qq.com/ws/geocoder/v1/?location={$latitude},{$longitude}&key={$key}";
        $response = $client->request('GET', $url);
        $result = json_decode((string) $response->getBody(), true);
        return $result;
    }
}
