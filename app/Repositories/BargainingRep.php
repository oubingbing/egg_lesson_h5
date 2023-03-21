<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2021/4/24
 * Time: 18:08
 */

namespace App\Repositories;


use App\Models\Bargaining;

class BargainingRep extends BaseRepAbstract
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
        $result = Bargaining::query()->find($id);
        return $result;
    }

    public function findLast($userId,$goodsId,$status=null)
    {
        $query = Bargaining::query()->where(Bargaining::FIELD_ID_USER,$userId)
            ->where(Bargaining::FIELD_ID_GOODS,$goodsId)
            ->orderBy("id",'desc');

        if (!is_null($status)){
            $query->where(Bargaining::FIELD_STATUS,$status);
        }

        $result = $query->first();
        return $result;
    }

    public function count($userId,$goodsId)
    {
        $result = Bargaining::query()->where(Bargaining::FIELD_ID_USER,$userId)
            ->where(Bargaining::FIELD_ID_GOODS,$goodsId)
            ->count();
        return $result;
    }

}
