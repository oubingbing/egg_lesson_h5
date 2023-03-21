<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2020/12/19
 * Time: 17:19
 */

namespace App\Repositories;


use App\Models\ContractLesson;

class ContractLessonRep extends BaseRepAbstract
{
    /**
     * 保存合同信息
     *
     * @author yezi
     * @param ContractLesson $contractLesson
     * @return mixed
     */
    public function store(ContractLesson $contractLesson)
    {
        $result = ContractLesson::create(collect($contractLesson)->toArray());
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
        $result = ContractLesson::query()->find($id);
        return $result;
    }

}