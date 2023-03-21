<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2020/12/27
 * Time: 17:26
 */

namespace App\Service;


use App\Enum\ErrorEnum;
use App\Exceptions\ApiException;
use App\Models\ContractLesson;
use App\Repositories\ContractLessonRep;

class ContractLessonService extends BaseServiceAbstract
{
    private $rep;

    public function __construct(ContractLessonRep $lessonRep)
    {
        $this->rep = $lessonRep;
    }

    public function findById($id)
    {
        $result = $this->rep->find($id);
        return $result;
    }

    /**
     * 新增合同
     *
     * @author yezi
     * @param $contract
     * @return mixed
     * @throws ApiException
     */
    public function storeContract($goodsId,$contract)
    {
        $contractModel = new ContractLesson();
        foreach ($contract as $key => $item){
            $contractModel->{$key} = $item;
        }

        $contractModel->{ContractLesson::FIELD_ID_GOODS} = $goodsId;

        if (!in_array(
            $contractModel->{ContractLesson::FIELD_LESSON_TYPE},
            [ContractLesson::ENUM_LESSON_TYPE_TIME,ContractLesson::ENUM_LESSON_TYPE_YEAR]
        )){
            throw new ApiException("课程类型错误，只能是年卡和次卡",ErrorEnum::GOODS_LESSON_TIME_TYPE_ERR);
        }

        if ($contractModel->{ContractLesson::FIELD_SURPLUS_AMOUNT} < 0){
            throw new ApiException("合同剩余金额不能小于0",ErrorEnum::GOODS_SURPLUS_AMOUNT_ERR);
        }

        if ($contractModel->{ContractLesson::FIELD_SURPLUS_LESSON_TIME} < 0){
            throw new ApiException("合同剩余课时不能小于0",ErrorEnum::GOODS_SURPLUS_TIME_ERR);
        }

        if (!in_array(
            $contractModel->{ContractLesson::FIELD_LESSON_GENDER},
            [ContractLesson::ENUM_GENDER_BOY,ContractLesson::ENUM_GENDER_GIRL,ContractLesson::ENUM_GENDER_NO]
        )){
            throw new ApiException("适课性别",ErrorEnum::GOODS_CONTRACT_GENDER_ERR);
        }

        $result = $this->rep->store($contractModel);
        return $result;
    }

}