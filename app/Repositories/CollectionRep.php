<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2021/4/24
 * Time: 15:54
 */

namespace App\Repositories;


use App\Models\Collection;

class CollectionRep extends BaseRepAbstract
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
        $result = Collection::query()->find($id);
        return $result;
    }

    public function findById($id)
    {
        $result = Collection::find($id);
        return $result;
    }

    public function findUserCollect($userId,$objectId)
    {
        $result = Collection::query()
            ->where(Collection::FIELD_ID_OBJECT,$objectId)
            ->where(Collection::FIELD_ID_USER,$userId)
            ->first();
        return $result;
    }

}