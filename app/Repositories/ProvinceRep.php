<?php


namespace App\Repositories;


use App\Models\City;
use App\Models\Country;
use App\Models\Province;

class ProvinceRep
{
    public function province()
    {
        return Province::query()->with(["city"=>function($query){
                $query->with(["country"=>function($query){
                    $query->select([
                        Country::FIELD_ID,
                        Country::FIELD_NAME,
                        Country::FIELD_PROVINCE_ID,
                        Country::FIELD_CITY_ID
                    ]);
                }])->select([
                    City::FIELD_ID,
                    City::FIELD_NAME,
                    City::FIELD_CITY_ID,
                    City::FIELD_PROVINCE_ID
                ]);
            }])
            ->get([
            Province::FIELD_ID,
            Province::FIELD_PROVINCE_ID,
            Province::FIELD_NAME
        ]);
    }

}
