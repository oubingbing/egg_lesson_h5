<?php


namespace App\Service;


use App\Repositories\ProvinceRep;
use Illuminate\Support\Facades\Redis;

class AddressService
{
    const CACHE_CITY_KEY = "city_list";
    const EXPIRE_SECOND = 86400;

    /**
     * 获取省市区数据
     *
     * @return mixed
     */
    public function getCityList()
    {
        $result = Redis::get(self::CACHE_CITY_KEY);
        if ($result){
            return json_decode($result,true);
        }else{
            $provinceList = app(ProvinceRep::class)->province();
            Redis::setex(self::CACHE_CITY_KEY,self::EXPIRE_SECOND,json_encode($provinceList));
            return $provinceList;
        }
    }

}
