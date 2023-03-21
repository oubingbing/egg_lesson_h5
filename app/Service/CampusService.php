<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2020/12/27
 * Time: 16:33
 */

namespace App\Service;


use App\Enum\ErrorEnum;
use App\Exceptions\ApiException;
use App\Models\Campus;
use App\Repositories\CampusRep;
use Illuminate\Support\Facades\Redis;

class CampusService extends BaseServiceAbstract
{
    const CACHE_KEY = "campus_cache";
    const CACHE_EXPIRE = 86400;
    private $rep;

    public function __construct(CampusRep $rep)
    {
        $this->rep = $rep;
    }

    /**
     * 新建校区
     *
     * @author yezi
     * @param $userId
     * @param $name
     * @param $address
     * @param $type
     * @return mixed
     * @throws ApiException
     */
    public function store($userId,$name,$address,$type,$province,$city,$country,$latitude,$longitude)
    {
        if (!in_array($type,[Campus::ENUM_TYPE_USER,Campus::ENUM_TYPE_ADMIN])){
            throw new ApiException("校区参数错误",ErrorEnum::GOODS_CAMPUS_TYPE_ERR);
        }

        if ($type == Campus::ENUM_TYPE_USER){
            $user = app(WechatUserService::class)->findById($userId);
            if (!$user){
                throw new ApiException("用户不存在",ErrorEnum::AUTH_USER_NOT_FOUND);
            }
        }else{
            $user = app(AdminService::class)->findById($userId);
            if (!$user){
                throw new ApiException("用户不存在",ErrorEnum::AUTH_USER_NOT_FOUND);
            }
        }

        $result = $this->rep->store($userId,$name,$address,$type,$province,$city,$country,$latitude,$longitude);
        return $result;
    }

    public function findById($id)
    {
        $result = $this->rep->find($id);
        return $result;
    }

    public function updateLocation($id,$province,$city,$county)
    {
        $campus = $this->findById($id);
        if (!$campus){
            throw new ApiException("校区不存在");
        }

        $campus->{Campus::FIELD_PROVINCE} = $province;
        $campus->{Campus::FIELD_CITY}     = $city;
        $campus->{Campus::FIELD_COUNTY}   = $county;
        $result = $campus->save();
        if (!$result){
            throw new ApiException("校区更新失败");
        }

        return $campus;
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
        $result = Redis::get(self::CACHE_KEY);
        if ($result){
            return json_decode($result,true);
        }else{
            $fields = [
                Campus::FIELD_ID,
                Campus::FIELD_NAME
            ];
            $result = $this->rep->get($sort,$fields);
            if ($result){
                Redis::setex(self::CACHE_KEY,self::CACHE_EXPIRE,json_encode($result));
            }
            return $result;
        }
    }

    public function findByName($name)
    {
        $result = Campus::query()->where(Campus::FIELD_NAME,$name)->first();
        return $result;
    }
}
