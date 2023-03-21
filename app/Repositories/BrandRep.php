<?php


namespace App\Repositories;


use App\Models\Brand;

class BrandRep extends BaseRepAbstract
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
        $result = Brand::query()->find($id);
        return $result;
    }

    /**
     * 根据主键查找
     *
     * @author 叶子
     * @param $name
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]
     */
    public function findByName($name)
    {
        $result = Brand::query()->where(Brand::FIELD_NAME,$name)->first();
        return $result;
    }

    /**
     * 获取所有的品牌数据
     *
     * @author yezi
     * @param $sort
     * @param $fields
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get($sort,$type,$fields)
    {
        $brands = Brand::query()
            ->orderBy(Brand::FIELD_SORT,$sort)
            ->select($fields);
        if ($type == Brand::ENUM_TYPE_PLATFORM){
            $brands->where(Brand::FIELD_TYPE,$type);
        }

        return $brands->get();
    }

}
