<?php


namespace App\Service;


use App\Enum\ErrorEnum;
use App\Exceptions\ApiException;
use App\Models\Brand;
use App\Repositories\BrandRep;
use Illuminate\Support\Facades\Redis;

class BrandService extends BaseServiceAbstract
{
    const CACHE_KEY = "brand_cache";
    const CACHE_EXPIRE = 86400;
    private $rep;

    public function __construct(BrandRep $rep)
    {
        $this->rep = $rep;
    }

    /**
     * 新增品牌
     *
     * @author yezi
     * @param $createId
     * @param $name
     * @param $sort
     * @param $type
     * @param $describe
     * @param $attachments
     * @return mixed
     */
    public function store($createId,$name,$sort,$type,$describe,$attachments)
    {
        $result = Brand::create([
            Brand::FIELD_ID_CREATE   => $createId,
            Brand::FIELD_NAME        => $name,
            Brand::FIELD_SORT        => $sort,
            Brand::FIELD_TYPE        => $type,
            Brand::FIELD_DESCRIBE    => $describe,
            Brand::FIELD_ATTACHMENTS => $attachments
        ]);
        return $result;
    }

    public function getAll($sort,$type)
    {
        $fields = [
            Brand::FIELD_ID,
            Brand::FIELD_NAME,
            Brand::FIELD_ATTACHMENTS,
            Brand::FIELD_DESCRIBE
        ];
        $result = $this->rep->get($sort,$type,$fields);
        return $result;
    }

    public function findById($id)
    {
        $result = $this->rep->find($id);
        return $result;
    }

    public function findByName($name)
    {
        $result = $this->rep->findByName($name);
        return $result;
    }

}
