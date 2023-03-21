<?php


namespace App\Models;

/**
 * 转让信息表
 *
 * @author 叶子
 * Class contractTransferInfos
 * @package App\Models
 */
class ContractTransferInfos extends BaseModel
{
    const TABLE_NAME = "contract_transfer_infos";
    protected $table = self::TABLE_NAME;

    /** Field goods_id所属商品 **/
    const FIELD_ID_GOODS = "goods_id";

    /** Field title 转让标题 **/
    const FIELD_TITLE = "title";

    /** Field introduce 转让介绍 **/
    const FIELD_INTRODUCE = "introduce";

    /** Field attachments 转让附件 **/
    const FIELD_ATTACHMENTS = "attachments";

    protected $casts = [
        self::FIELD_ATTACHMENTS => "array"
    ];

    protected $fillable = [
        self::FIELD_ID_GOODS,
        self::FIELD_TITLE,
        self::FIELD_INTRODUCE,
        self::FIELD_ATTACHMENTS,
    ];

}
