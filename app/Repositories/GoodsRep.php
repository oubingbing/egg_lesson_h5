<?php


namespace App\Repositories;


use App\Enum\ErrorEnum;
use App\Exceptions\ApiException;
use App\Models\Goods;

class GoodsRep extends BaseRepAbstract
{
    /**
     * 新增商品
     *
     * @author yezi
     * @param  $goods
     * @return mixed
     */
    public function store($goods)
    {
        $result = Goods::create(collect($goods)->toArray());
        return $result;
    }

    /**
     * 根据主键查找
     *
     * @author 叶子
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]
     */
    public function find($id)
    {
        $result = Goods::query()->find($id);
        return $result;
    }

    /**
     * 排它锁
     *
     * @author yezi
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function lockForUpdate($id)
    {
        $goods = Goods::query()->where(Goods::FIELD_ID, $id)->lockForUpdate()->first();
        return $goods;
    }

    public function updateStatus($id,$status)
    {
        $result = Goods::query()->where(Goods::FIELD_ID,$id)->update([Goods::FIELD_STATUS=>$status]);
        return $result;
    }

}
