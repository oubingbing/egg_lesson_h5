<?php


namespace App\Repositories;


use App\Models\Banner;

class BannerRep
{
    public function findById($id)
    {
        $banner = Banner::query()->find($id);
        return $banner;
    }

    public function deleteById($adminID,$id)
    {
        $result = Banner::query()
            ->where(Banner::FIELD_ID_ADMIN,$adminID)
            ->where(Banner::FIELD_ID,$id)
            ->delete();
        return $result;
    }

    public function updateStatus($id,$status)
    {
        $result = Banner::query()->where(Banner::FIELD_ID,$id)->update([Banner::FIELD_STATUS=>$status]);
        return $result;
    }

    /**
     * 根据状态获取banner
     *
     * @param $gameId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getByStatus($status)
    {
        $result = Banner::query()
            ->where(Banner::FIELD_STATUS,$status)
            ->orderBy(Banner::FIELD_SORT,"asc")
            ->get([
                Banner::FIELD_ID,
                Banner::FIELD_STATUS,
                Banner::FIELD_TITLE,
                Banner::FIELD_DESCRIBE,
                Banner::FIELD_ATTACHMENTS,
                Banner::FIELD_STATUS,
                Banner::FIELD_SORT
            ]);

        return $result;
    }

}
