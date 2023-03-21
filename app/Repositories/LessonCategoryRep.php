<?php


namespace App\Repositories;


use App\Models\LessonCategory;

class LessonCategoryRep extends BaseRepAbstract
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
        $result = LessonCategory::query()->find($id);
        return $result;
    }

    /**
     * 获取所有的课程类型数据
     *
     * @author yezi
     * @param $sort
     * @param $fields
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get($sort,$fields)
    {
        $brands = LessonCategory::query()
            ->orderBy(LessonCategory::FIELD_SORT,$sort)
            ->select($fields)
            ->get();
        return $brands;
    }

}
