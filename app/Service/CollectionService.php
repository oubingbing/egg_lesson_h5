<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2021/4/24
 * Time: 15:55
 */

namespace App\Service;


use App\Enum\ErrorEnum;
use App\Exceptions\ApiException;
use App\Models\Collection;
use App\Repositories\CollectionRep;

class CollectionService extends BaseServiceAbstract
{
    private $rep;

    public function __construct(CollectionRep $rep)
    {
        $this->rep = $rep;
    }

    /**
     * 校验收藏
     *
     * @author yezi
     * @param $request
     * @throws ApiException
     */
    public function validStore($request)
    {
        $rules    = [
            'object_id' => 'required',
            //'type'      => 'required',
        ];
        $message = [
            'object_id.required' => '收藏对象不能为空',
            //'type.required'      => '收藏类型不能为空',
        ];
        $validator = \Validator::make($request->all(),$rules,$message);
        if ($validator->fails()) {
            $errors = $validator->errors();
            throw new ApiException($errors->first(),ErrorEnum::COLLECTION_PARAMS_NULL);
        }
    }

    public function store($userId,$objectId)
    {
        $result = Collection::create([
            Collection::FIELD_ID_USER=>$userId,
            Collection::FIELD_ID_OBJECT=>$objectId,
            Collection::FIELD_TYPE=>Collection::ENUM_GOODS,
            Collection::FIELD_STATUS=>Collection::ENUM_STATUS_Y
        ]);
        return $result;
    }

    public function collect($userId,$objectId)
    {
        $collection = $this->rep->findUserCollect($userId,$objectId);
        if ($collection){
            $collection->{Collection::FIELD_STATUS} = Collection::ENUM_STATUS_Y;
            $result = $collection->save();
            if (!$result){
                throw new ApiException("收藏失败",ErrorEnum::COLLECTION_UPDATE_STATUS_FAIL);
            }
            return $collection;
        }

        $collection = $this->store($userId,$objectId);
        if (!$collection){
            throw new ApiException("收藏失败",ErrorEnum::COLLECTION_SAVE_FAIL);
        }

        return $collection;
    }

    public function cancel($userId,$objectId)
    {
        $collection = $this->rep->findUserCollect($userId,$objectId);
        if ($collection){
            $collection->{Collection::FIELD_STATUS} = Collection::ENUM_STATUS_N;
            $result = $collection->save();
            if (!$result){
                throw new ApiException("收藏失败",ErrorEnum::COLLECTION_UPDATE_STATUS_FAIL);
            }
            return $collection;
        }

        return true;
    }

}