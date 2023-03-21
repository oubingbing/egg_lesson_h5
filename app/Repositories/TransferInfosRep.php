<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2020/12/19
 * Time: 17:08
 */

namespace App\Repositories;


use App\Models\ContractTransferInfos as TransInfo;

class TransferInfosRep extends BaseRepAbstract
{
    /**
     * 保存合同转让信息
     *
     * @author yezi
     * @param  $info
     * @return mixed
     */
    public function store($info)
    {
        $result = TransInfo::create(collect($info)->toArray());
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
        $result = TransInfo::query()->find($id);
        return $result;
    }

}