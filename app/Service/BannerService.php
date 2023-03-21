<?php


namespace App\Service;


use App\Enum\ErrorEnum;
use App\Exceptions\ApiException;
use App\Models\Banner;
use App\Repositories\BannerRep;

class BannerService extends BaseServiceAbstract
{
    private $rep;
    private $builder;

    public function __construct(BannerRep $rep)
    {
        $this->rep = $rep;
    }

    /**
     * 校验新增参数
     *
     * @author 叶子
     * @param $request
     * @throws ApiException
     */
    public function validStore($requestData)
    {
        $rules = [
            'title'         => 'required',
            'attachments'   => 'required',
            'sort'          => 'required',
            'type'          => 'required',
        ];
        $message = [
            'title.required'       => '标题不能为空',
            'attachments.required' => '图片不能为空',
            'sort.required'        => '排序不能为空',
            'type.required'        => '类型不能为空',
        ];
        $this->valid($requestData,$rules,$message);
    }

    public function store($adminId,$title,$describe,$attachments,$sort,$type)
    {
        $result = Banner::create([
            Banner::FIELD_ID_ADMIN      => $adminId,
            Banner::FIELD_TITLE         => $title,
            Banner::FIELD_DESCRIBE      => $describe,
            Banner::FIELD_ATTACHMENTS   => $attachments,
            Banner::FIELD_SORT          => $sort,
            Banner::FIELD_TYPE          => $type,
            Banner::FIELD_STATUS        => Banner::ENUM_STATUS_DOWN,
        ]);
        return $result;
    }

    public function delete($adminId,$id)
    {
        return $this->rep->deleteById($adminId,$id);
    }

    public function update($adminId,$id,$title,$describe,$attachments,$sort,$type)
    {
        $banner = $this->rep->findById($id);
        if (!$banner){
            throw new ApiException("banner不存在",ErrorEnum::BANNER_NOT_FOUND);
        }

        if ($banner->{Banner::FIELD_ID_ADMIN} != $adminId){
            throw new ApiException("banner不存在",ErrorEnum::BANNER_NOT_FOUND);
        }

        $banner->{Banner::FIELD_TITLE}          = $title;
        $banner->{Banner::FIELD_DESCRIBE}       = $describe;
        $banner->{Banner::FIELD_ATTACHMENTS}    = $attachments;
        $banner->{Banner::FIELD_SORT}           = $sort;
        $banner->{Banner::FIELD_TYPE}           = $type;
        $result = $banner->save();
        if (!$result){
            throw new ApiException("更新失败",ErrorEnum::BANNER_UPDATE_FAIL);
        }

        return $banner;
    }

    public function updateStatus($adminId,$id,$status)
    {
        $banner = $this->rep->findById($id);
        if (!$banner){
            throw new ApiException("banner不存在",ErrorEnum::BANNER_NOT_FOUND);
        }

        if ($banner->{Banner::FIELD_ID_ADMIN} != $adminId){
            throw new ApiException("banner不存在",ErrorEnum::BANNER_NOT_FOUND);
        }

        $result = $this->rep->updateStatus($id,$status);
        return $result;
    }

    /**
     * 上架
     *
     * @param $adminId
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     * @throws ApiException
     */
    public function bannerUp($adminId,$id)
    {
        $result = $this->updateStatus($adminId,$id,Banner::ENUM_STATUS_UP);
        if (!$result){
            throw new ApiException("上架失败，请稍后再试",ErrorEnum::BANNER_UP_FAIL);
        }

        return $this->rep->findById($id);
    }

    /**
     * 下架
     *
     * @param $adminId
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     * @throws ApiException
     */
    public function bannerDown($adminId,$id)
    {
        $result = $this->updateStatus($adminId,$id,Banner::ENUM_STATUS_DOWN);
        if (!$result){
            throw new ApiException("下架失败，请稍后再试",ErrorEnum::BANNER_DOWN_FAIL);
        }

        return $this->rep->findById($id);
    }

    public function query($adminId,$status)
    {
        $this->builder = Banner::query()->where(Banner::FIELD_ID_ADMIN,$adminId);

        if (!is_null($status)){
            $this->builder->where(Banner::FIELD_STATUS,$status);
        }

        return $this;
    }

    public function orderBy($order,$sort)
    {
        $this->builder->orderBy($order,$sort);
        return $this;
    }

    public function done()
    {
        return $this->builder;
    }

    public function format($banner,$domain)
    {
        $banner = collect($banner)->toArray();
        foreach ($banner[Banner::FIELD_ATTACHMENTS] as $key => $item){
            $banner[Banner::FIELD_ATTACHMENTS][$key] = $domain."/".$item;
        }
        return $banner;
    }

    public function allUp()
    {
        $result = $this->rep->getByStatus(Banner::ENUM_STATUS_UP);
        return $result;
    }

}
