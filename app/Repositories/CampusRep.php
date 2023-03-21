<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2020/12/27
 * Time: 16:28
 */

namespace App\Repositories;


use App\Models\Campus;

class CampusRep extends BaseRepAbstract
{
    /**
     * 根据主键查找
     *
     * @author 叶子
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]
     */
    public function find($id)
    {
        $result = Campus::query()->find($id);
        return $result;
    }

    /**
     * 新增
     *
     * @param $userId
     * @param $name
     * @param $address
     * @param $type
     * @return mixed
     */
    public function store($userId,$name,$address,$type,$province,$city,$country,$latitude,$longitude)
    {
        $result = Campus::create([
            Campus::FIELD_ID_USER => $userId,
            Campus::FIELD_NAME    => $name,
            Campus::FIELD_ADDRESS => $address,
            Campus::FIELD_TYPE    => $type,
            Campus::FIELD_PROVINCE=> $province,
            Campus::FIELD_CITY    => $city,
            Campus::FIELD_COUNTY  => $country,
            Campus::FIELD_LATITUDE  => $latitude,
            Campus::FIELD_LONGITUDE => $longitude,
        ]);
        return $result;
    }

    /**
     * 获取所有
     *
     * @author yezi
     * @param $sort
     * @param $fields
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get($sort,$fields)
    {
        $brands = Campus::query()
            ->orderBy(Campus::FIELD_ID,$sort)
            ->select($fields)
            ->get();
        return $brands;
    }

}