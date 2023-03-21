<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2021/1/3
 * Time: 13:30
 */

namespace App\Repositories;


use App\Models\RealName;

class RealNameRep extends BaseRepAbstract
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
        $result = RealName::query()->find($id);
        return $result;
    }

    public function findByUserId($userId)
    {
        $result = RealName::query()->where(RealName::FIELD_ID_USER,$userId)->first();
        return $result;
    }

    public function store(RealName $realName)
    {
        $result = RealName::create(collect($realName)->toArray());
        return $result;
    }

    public function updateStatus($id,$status)
    {
        $result = RealName::query()->where(RealName::FIELD_ID,$id)->update([RealName::FIELD_STATUS=>$status]);
        return $result;
    }

}