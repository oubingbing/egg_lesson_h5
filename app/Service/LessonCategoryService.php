<?php


namespace App\Service;


use App\Models\LessonCategory;
use App\Repositories\LessonCategoryRep;
use Illuminate\Support\Facades\Redis;

class LessonCategoryService extends BaseServiceAbstract
{
    const CACHE_KEY = "category_cache";
    const CACHE_EXPIRE = 86400;
    private $rep;

    public function __construct(LessonCategoryRep $rep)
    {
        $this->rep = $rep;
    }

    /**
     * 新增课程类型
     *
     * @author yezi
     * @param $creatId
     * @param $name
     * @param $sort
     * @param $type
     * @param $describe
     * @param $attachments
     * @return mixed
     */
    public function store($creatId,$name,$sort,$type,$describe,$attachments)
    {
        $result = LessonCategory::create([
            LessonCategory::FIELD_ID_CREATE   => $creatId,
            LessonCategory::FIELD_NAME        => $name,
            LessonCategory::FIELD_SORT        => $sort,
            LessonCategory::FIELD_TYPE        => $type,
            LessonCategory::FIELD_DESCRIBE    => $describe,
            LessonCategory::FIELD_ATTACHMENTS => $attachments
        ]);
        return $result;
    }

    /**
     * 获取所有的课程类型
     *
     * @author yezi
     * @param string $sort
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll($sort="desc")
    {
        $fields = [
            LessonCategory::FIELD_ID,
            LessonCategory::FIELD_NAME,
            LessonCategory::FIELD_ATTACHMENTS
        ];
        $result = $this->rep->get($sort,$fields);
        return $result;
        $result = Redis::get(self::CACHE_KEY);
        if ($result){
            return json_decode($result,true);
        }else{
            $fields = [
                LessonCategory::FIELD_ID,
                LessonCategory::FIELD_NAME,
                LessonCategory::FIELD_ATTACHMENTS
            ];
            $result = $this->rep->get($sort,$fields);
            if ($result){
                Redis::setex(self::CACHE_KEY,self::CACHE_EXPIRE,json_encode($result));
            }
            return $result;
        }
    }

    public function findById($id)
    {
        $result = $this->rep->find($id);
        return $result;
    }

}
