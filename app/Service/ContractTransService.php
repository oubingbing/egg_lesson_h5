<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2020/12/27
 * Time: 17:26
 */

namespace App\Service;


use App\Models\ContractTransferInfos;
use App\Repositories\TransferInfosRep;

class ContractTransService extends BaseServiceAbstract
{
    private $rep;

    public function __construct(TransferInfosRep $rep)
    {
        $this->rep = $rep;
    }

    public function storeTransInfo($goodsId,$data)
    {
        $transferInfo = new ContractTransferInfos();
        foreach ($data as $key => $item){
            $transferInfo->{$key} = $item;
        }
        $transferInfo->{ContractTransferInfos::FIELD_ID_GOODS} = $goodsId;

        //添加默认的校区图片
        if (empty($transferInfo->{ContractTransferInfos::FIELD_ATTACHMENTS})){
            $defaultImg = [
                "/default-lesson/default-1_20210707155413.png",
                "/default-lesson/default-2_20210707155429.jpg",
                "/default-lesson/default-3_20210707155510.png",
                "/default-lesson/default-4_20210707155524.jpg"
            ];
            $index = random_int(0,3);
            $transferInfo->{ContractTransferInfos::FIELD_ATTACHMENTS} = [$defaultImg[$index]];
        }

        $result = $this->rep->store($transferInfo);
        return $result;
    }

}
