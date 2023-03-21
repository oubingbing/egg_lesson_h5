<?php


namespace App\Repositories;


use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemSnapshots;
use Illuminate\Support\Facades\DB;

class OrderRep extends BaseRepAbstract
{
    /**
     * 根据主键查找
     *
     * @author 叶子
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]
     */
    public function find($id)
    {
        $result = Order::query()->find($id);
        return $result;
    }

    public function findByOrderNo($orderNo)
    {
        $order = Order::query()->where(Order::FIELD_ORDER_NUMBER,$orderNo)->first();
        return $order;
    }

    /**
     * 保存合同转让信息
     *
     * @author yezi
     * @param  $order
     * @return mixed
     */
    public function store($order)
    {
        $result = Order::create(collect($order)->toArray());
        return $result;
    }

    /**
     * 批量插入子订单
     *
     * @param $orderItem
     * @return bool
     */
    public function saveItems($orderItem)
    {
        $result = OrderItem::create($orderItem);
        return $result;
    }

    public function multiSaveSnapshot($data)
    {
        $result = DB::table(OrderItemSnapshots::TABLE_NAME)->insert($data);
        return $result;
    }

    public function updateStatus($id,$status)
    {
        $result = Order::query()->where(Order::FIELD_ID,$id)->update([Order::FIELD_STATUS=>$status]);
        return $result;
    }

}
