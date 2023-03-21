<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/12/15
 * Time: 下午12:02
 */

namespace App\Service;

use App\Enum\ErrorEnum;
use App\Exceptions\ApiException;
use App\Models\Inbox;
use App\Models\WechatUser;
use Carbon\Carbon;

class InboxService extends BaseServiceAbstract
{
    private $rep;
    private $builder;

    /**
     * 往消息盒子投递信息
     *
     * @author yezi
     *
     * @param $userId
     * @param $objId
     * @param $objType
     * @param $content
     * @param $type
     * @param $postAt
     * @return mixed
     * @throws ApiException
     */
    public static function send($userId, $objId, $objType, $content, $type, $postAt)
    {
        $result = Inbox::create([
            Inbox::FIELD_ID_USER     => $userId,
            Inbox::FIELD_ID_OBJ      => $objId,
            Inbox::FIELD_OBJ_TYPE    => $objType,
            Inbox::FIELD_CONTENT     => $content,
            Inbox::FIELD_TYPE        => $type,
            Inbox::FIELD_POST_AT     => $postAt,
        ]);

        return $result;
    }

    /**
     * 标记消息为已读
     *
     * @author yezi
     *
     * @param $userId
     * @param null $inboxId
     * @return mixed
     */
    public function readInbox($userId, $inboxId=null)
    {
        $query = Inbox::query()
            ->where(Inbox::FIELD_TYPE,"<",Inbox::ENUM_TYPE_ORDER_CREATE)
            ->where(Inbox::FIELD_ID_USER, $userId);

        if ($inboxId){
            $query->where(Inbox::FIELD_ID, $inboxId);
        }

        $result = $query->update([Inbox::FIELD_READ_AT => Carbon::now()]);
        return $result;
    }

    /**
     * 获取用户未读消息数量
     *
     * @author yezi
     * @param $userId
     * @return int
     */
    public function getNewInboxByType($userId)
    {
        $result = Inbox::query()
            ->where(Inbox::FIELD_ID_USER, $userId)
            ->where(Inbox::FIELD_READ_AT, null)
            ->where(Inbox::FIELD_TYPE,"<",Inbox::ENUM_TYPE_ORDER_CREATE)
            ->count();

        return $result;
    }

    public function query($userId,$type,$read)
    {
        $this->builder = Inbox::query()
            ->where(Inbox::FIELD_TYPE,"<",Inbox::ENUM_TYPE_ORDER_CREATE)
            ->where(Inbox::FIELD_ID_USER,$userId);
        if ($type){
            $this->builder->where(Inbox::FIELD_TYPE,$type);
        }
        if ($read == 1){
            //获取未读消息
            $this->builder->whereNull(Inbox::FIELD_READ_AT);
        }

        return $this;
    }

    /**
     * 排序
     *
     * @author yezi
     * @param $orderBy
     * @param $sort
     * @return mixed
     */
    public function sort($orderBy="id",$sort="asc")
    {
        $this->builder->orderBy($orderBy,$sort);
        return $this;
    }

    /**
     * 返回查询构造器
     *
     * @author yezi
     * @return mixed
     */
    public function done()
    {
        return $this->builder;
    }

    public function formatPage($inbox)
    {
        return $inbox;
    }

    public function delete($userId,$id)
    {
        $result = Inbox::query()
            ->where(Inbox::FIELD_ID_USER,$userId)
            ->where(Inbox::FIELD_TYPE,"<",Inbox::ENUM_TYPE_ORDER_CREATE)
            ->where(Inbox::FIELD_ID,$id)
            ->delete();
        return $result;
    }

    public function findById($id)
    {
        $result = Inbox::query()->find($id);
        return $result;
    }

}
