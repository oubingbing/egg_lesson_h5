<?php


namespace App\Service;


use App\Enum\ErrorEnum;
use App\Exceptions\ApiException;
use App\Models\Bargaining;
use App\Models\Goods;
use App\Models\Inbox;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemSnapshots;
use App\Models\OrderRefund;
use App\Models\WechatUser;
use App\Repositories\BargainingRep;
use App\Repositories\GoodsRep;
use App\Repositories\OrderRep;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService extends BaseServiceAbstract
{
    private $rep;
    private $builder;

    public function __construct(OrderRep $rep)
    {
        $this->rep = $rep;
    }

    public function findById($id)
    {
        $order = $this->rep->find($id);
        return $order;
    }

    /**
     * 校验商品的基本信息
     *
     * @author yezi
     * @param $request
     * @throws ApiException
     */
    static function validCreateOrder($request)
    {
        $rules    = [
            'goods_id' => 'required',
            //'type'     => ['required',Rule::in([Order::ENUM_IS_DEPOSIT_N, Order::ENUM_IS_DEPOSIT_Y])],
            'is_deposit'     => 'required',
        ];
        $message = [
            'goods_id.required' => '商品不能为空',
            'is_deposit.required'     => '订单类型不能为空',
            //'type.in'           => '订单类型参数必须是1或2', //TODO 第一次测试不通过，后面需要完善
        ];
        $validator = \Validator::make($request->all(),$rules,$message);
        if ($validator->fails()) {
            $errors = $validator->errors();
            throw new ApiException($errors->first(),ErrorEnum::GOODS_PARAMS_NULL);
        }
    }

    /**
     * 尝试进行下单
     *
     * @author yeiz
     * @param $userId 用户
     * @param $orderNo 订单编号
     * @param $goodsItems 子订单信息，商品id数组
     * @param $clientType 订单类型
     * @param $depositType 订金订单还是免费订金订单
     * @param $payment 支付方式
     * @return mixed|null
     * @throws \Exception
     */
    public function attemptTakeOrder($userId,$orderNo,array $goodsItems,$clientType,$depositType,$payment)
    {
        $deposit = 1;
        $result = null;
        try {
            DB::beginTransaction();

            $totalAmount = 0; //总金额
            $actualAmount = 0;//实际总金额
            $orderItem = [];
            $sellerId = 0;

            foreach ($goodsItems as $goodsId){
                //查看是否有议价的记录，有就使用议价价格
                $bargaining = app(BargainingRep::class)->findLast($userId,$goodsId,Bargaining::ENUM_STATUS_AGREE);
                $goods = app(GoodsService::class)->findByIdForLock($goodsId);
                if (!$goods){
                    throw new ApiException("课程不存在");
                }

                //检测商品是否可以销售
                app(GoodsService::class)->checkGoodsSaleStatus($goods);
                if ($bargaining){
                    //更新商品的订金手续费和折扣
                    $goods->{Goods::FIELD_PRICE}          = $result->{Bargaining::FIELD_PRICE};
                    $goods->{Goods::FIELD_DISCOUNT}       = decimal($result->{Bargaining::FIELD_PRICE}/$goods->{Goods::FIELD_PRICE},2)*10;
                    $goods->{Goods::FIELD_DEPOSIT}        = getDeposit($result->{Bargaining::FIELD_PRICE}); //不免费后需要恢复 getDeposit($result->{Bargaining::FIELD_PRICE})
                    $goods->{Goods::FIELD_SERVICE_CHARGE} = getDeposit($result->{Bargaining::FIELD_PRICE});
                    $goods->{Goods::FIELD_ACTUAL_RECEIPT} = $result->{Bargaining::FIELD_PRICE};
                }

                $deposit = $goods->{Goods::FIELD_DEPOSIT};
                //订单状态修改为转让中
                $goods->{Goods::FIELD_STATUS} = Goods::ENUM_STATUS_UNDER_TRANSFER;
                $saveGoods = $goods->save();
                if (!$saveGoods){
                    throw new ApiException("商品信息更新失败");
                }

                $sellerId = $goods->{Goods::FIELD_ID_CREATE};
                //$goods->{Goods::FIELD_PRICE} = $deposit; //todo 不免费后需要恢复
                //计算订单的实际金额,单位分
                $itemActualAmount = $deposit;//$goods->{Goods::FIELD_PRICE}
                $actualAmount     += $itemActualAmount;
                $totalAmount      += $deposit;

                //拼接子订单数据
                array_push($orderItem,[
                    OrderItem::FIELD_ID_GOODS       => $goodsId,
                    OrderItem::FIELD_PRICE          => $goods->{Goods::FIELD_PRICE},
                    OrderItem::FIELD_ACTUAL_PRICE   => $itemActualAmount,
                    OrderItem::FIELD_QUANTITY       => 1, //暂时默认为1
                    OrderItem::FIELD_STATUS         => OrderItem::ENUM_STATUS_NORMAL, //暂时默认为
                    "goods" => $goods
                ]);
            }

            //写入母订单
            $order = new Order();
            $order->{Order::FIELD_ID_BUYER} = $userId;
            $order->{Order::FIELD_ID_SELLER} = $sellerId;
            $order->{Order::FIELD_ORDER_NUMBER} = $orderNo;
            $order->{Order::FIELD_TYPE} = $clientType;
            $order->{Order::FIELD_IS_DEPOSIT} = $depositType;
            //订金订单,订单金额暂为1%，非订金订单金额为0
            $order->{Order::FIELD_DEPOSIT} = $deposit;
            //$order->{Order::FIELD_DEPOSIT} = $depositType == Order::ENUM_IS_DEPOSIT_Y ? $deposit : 0;
            $order->{Order::FIELD_TOTAL_AMOUNT} = $totalAmount;
            $order->{Order::FIELD_ACTUAL_AMOUNT} = $actualAmount;
            $order->{Order::FIELD_PAYMENT_TYPE} = $payment;
            $order->{Order::FIELD_STATUS} = Order::ENUM_STATUS_WAIT_PAY;
            $order = $this->rep->store($order);
            if (!$order){
                throw new ApiException("订单创建失败",ErrorEnum::ORDER_CREATE_FAIL);
            }

            //写入子订单
            $saveItemsResult = $this->storeOrderItems($userId,$order->id,$orderItem);
            if (!$saveItemsResult){
                throw new ApiException("订单入库失败",ErrorEnum::ORDER_ITEM_CREATE_FAIL);
            }

            $result = $order;

            DB::commit();
        }catch (\Exception $exception){
            //todo 记录下单失败
            throw $exception;
        }

        return $result;
    }

    /**
     * 写入子订单
     *
     * @param $userId
     * @param $orderId
     * @param $orderItems
     * @return bool
     * @throws ApiException
     */
    public function storeOrderItems($userId,$orderId,$orderItems)
    {
        $snapshots = [];
        $now = Carbon::now()->toDateTimeString();
        foreach ($orderItems as &$item){
            $item[OrderItem::FIELD_ID_ORDER] = $orderId;
            $goods = $item["goods"];
            unset($item["goods"]);
            $result = $this->rep->saveItems($item);
            if (!$result){
                throw new ApiException("订单入库失败",ErrorEnum::ORDER_ITEM_CREATE_FAIL);
            }

            $goodsDetail = app(GoodsService::class)->detail($userId,$goods->id);
            $goodsDetailResult = app(GoodsService::class)->formatSingle($goodsDetail);
            array_push($snapshots,[
                OrderItemSnapshots::FIELD_ID_USER => $userId,
                OrderItemSnapshots::FIELD_ID_ITEM => $result->id,
                OrderItemSnapshots::FIELD_SNAPSHOTS => json_encode($goodsDetailResult),
                OrderItemSnapshots::FIELD_CREATED_AT => $now,
                OrderItemSnapshots::FIELD_UPDATED_AT => $now,
            ]);
        }

        if (!empty($snapshots)){
            $result = $this->rep->multiSaveSnapshot($snapshots);
            if (!$result){
                throw new ApiException("商品快照入库失败",ErrorEnum::ORDER_SNAP_CREATE_FAIL);
            }
        }

        return true;
    }

    /**
     * 卖家确认订单，废弃
     *
     * @author yezi
     * @param $user
     * @param $orderId
     * @return bool
     * @throws ApiException
     */
    public function sellerConfirm($user,$orderId)
    {
        $order = $this->findById($orderId);
        if (!$order){
            throw new ApiException("订单不存在",ErrorEnum::ORDER_NOt_FOUND);
        }

        //校验用户
        $orderItems = $order->orderItems;
        if (collect($orderItems)->isEmpty()){
            throw new ApiException("商品不存在",ErrorEnum::ORDER_ITEM_NOT_FOUND);
        }
        $orderItem = collect($orderItems)->first();
        $goods = $orderItem->goods;
        if (!$goods){
            throw new ApiException("商品不存在",ErrorEnum::GOODS_NOT_EXISTS);
        }
        if ($goods->{Goods::FIELD_ID_CREATE} != $user->id){
            throw new ApiException("订单不存在",ErrorEnum::ORDER_USER_NOt_FOUND);
        }

        if ($order->{Order::FIELD_STATUS} != Order::ENUM_STATUS_WAIT_SELLER_CONFIRM){
            throw new ApiException("订单状态错误",ErrorEnum::ORDER_CANT_SELLER_VERIFY);
        }

        $updateResult = $this->rep->updateStatus($orderId,Order::ENUM_STATUS_WAIT_SELLER_CONFIRM);
        if (!$updateResult){
            throw new ApiException("确认失败，请稍后再试",ErrorEnum::ORDER_SELLER_VERIFY_FAIL);
        }

        return 1;
    }

    /**
     * 买家确认上课
     *
     * @author yezi
     * @param $user
     * @param $orderId
     * @return bool
     * @throws ApiException
     */
    public function buyerConfirm($user,$orderId)
    {
        $order = $this->findById($orderId);
        if (!$order){
            throw new ApiException("订单不存在",ErrorEnum::ORDER_NOt_FOUND);
        }

        if ($order->{Order::FIELD_ID_BUYER} != $user->id){
            throw new ApiException("订单不存在",ErrorEnum::ORDER_USER_NOt_FOUND);
        }

        if ($order->{Order::FIELD_STATUS} != Order::ENUM_STATUS_WAIT_CONFIRM_LESSON){
            throw new ApiException("订单状态错误",ErrorEnum::ORDER_CANT_SELLER_VERIFY);
        }

        $updateResult = $this->rep->updateStatus($orderId,Order::ENUM_STATUS_WAIT_DEAL_SUCCESS);
        if (!$updateResult){
            throw new ApiException("确认失败，请稍后再试",ErrorEnum::ORDER_SELLER_VERIFY_FAIL);
        }

        //修改商品状态为已完成
        $orderItems = $order->orderItems;
        foreach ($orderItems as $item){
            $result = app(GoodsService::class)->finishGoods($item->{OrderItem::FIELD_ID_GOODS},Goods::ENUM_STATUS_TRANSFER_SUCCESS);
            if (!$result){
                throw new ApiException("商品跟新失败，请稍后重试");
            }
        }

        //短信通知
        $user = app(WechatUserService::class)->findById($order->{Order::FIELD_ID_BUYER});
        if ($user){
            if ($user->{WechatUser::FIELD_PHONE}){
                $templateId = "979732";
                commonJob(SmsService::class,"sendMessage",[$templateId,$user->{WechatUser::FIELD_PHONE},[$order->{Order::FIELD_ORDER_NUMBER}]]);
            }
        }

        return 1;
    }

    /**
     * 构造查询器
     *
     * @author yezi
     * @return $this
     */
    public function query($userId,$type,$status)
    {
        if ($type == 1){
            //买家
            $role = 'buyer';
        }else {
            //卖家
            $role = 'seller';
        }
        $player = [$role=>function($query){
            $query->select([
                WechatUser::FIELD_ID,
                WechatUser::FIELD_NICKNAME,
                WechatUser::FIELD_PHONE
            ]);
        }];

        $this->builder = Order::query()
            ->with(array_merge(["orderItems"=>function($query){
                $query->with(["snapshots"])->select([
                    OrderItem::FIELD_ID,
                    OrderItem::FIELD_ID_ORDER,
                    OrderItem::FIELD_ID_GOODS,
                    OrderItem::FIELD_PRICE,
                    OrderItem::FIELD_ACTUAL_PRICE,
                    OrderItem::FIELD_QUANTITY,
                    OrderItem::FIELD_STATUS
                ]);
            }],$player))
            ->select([
                Order::FIELD_ID,
                Order::FIELD_ID_SELLER,
                Order::FIELD_ID_BUYER,
                Order::FIELD_ORDER_NUMBER,
                Order::FIELD_TYPE,
                Order::FIELD_DEPOSIT,
                Order::FIELD_TOTAL_AMOUNT,
                Order::FIELD_ACTUAL_AMOUNT,
                Order::FIELD_ID_TRANSACTION,
                Order::FIELD_PAYMENT_TYPE,
                Order::FIELD_STATUS,
                Order::FIELD_PAID_AT,
                Order::FIELD_REFUND_AT,
                Order::FIELD_CREATED_AT,
                Order::FIELD_PROTOCOL
            ]);

        if ($type == 1){
            //买家
            $this->builder->where(Order::FIELD_ID_BUYER,$userId);
        }else {
            //卖家
            $this->builder->where(Order::FIELD_ID_SELLER,$userId);
        }

        if ($status){
            $statusArr = [];
            switch ($status){
                case 1:
                    //待付订金
                    $statusArr = [
                        Order::ENUM_STATUS_WAIT_PAY,
                    ];
                    break;
                case 2:
                    //转让中
                    $statusArr = [
                        Order::ENUM_STATUS_WAIT_SELLER_CONFIRM,
                        Order::ENUM_STATUS_WAIT_CAMPUS_CONFIRM,
                        Order::ENUM_STATUS_WAIT_PAY_LESS
                    ];
                    break;
                case 3:
                    //待确认上课
                    $statusArr = [
                        Order::ENUM_STATUS_WAIT_CONFIRM_LESSON
                    ];
                    break;
                case 5:
                    //已完成
                    $statusArr = [
                        Order::ENUM_STATUS_WAIT_DEAL_SUCCESS
                    ];
                    break;
            }
            $this->builder->whereIn(Order::FIELD_STATUS,$statusArr);
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

    /**
     * 格式化订单
     *
     * @param $order
     * @param $brand
     * @param $campus
     * @param $lessonCategory
     * @return array
     */
    public function formatPage($order,$domain)
    {
        $protocol = $order->{Order::FIELD_PROTOCOL};
        $order = collect($order)->toArray();
        if (key_exists("order_items",$order)){
            foreach ($order["order_items"] as &$item){
                $goods = $item["snapshots"]["snapshots"];
                unset($item["snapshots"]);
                $goods["contact"]["surplus_lesson_time"] = (float)($goods["contact"]["surplus_lesson_time"]);
                $goods["contact"]["surplus_amount"] = toYuan($goods["contact"]["surplus_amount"]);
                $item["snapshots"] = $goods;
            }
        }

        if (!empty($protocol)){
            foreach ($protocol as &$p){
                $p = $domain.$p;
            }
        }

        $order[Order::FIELD_PROTOCOL]      = $protocol;
        $order[Order::FIELD_DEPOSIT]       = toYuan($order[Order::FIELD_DEPOSIT]);
        $order[Order::FIELD_TOTAL_AMOUNT]  = toYuan($order[Order::FIELD_TOTAL_AMOUNT]);
        $order[Order::FIELD_ACTUAL_AMOUNT] = toYuan($order[Order::FIELD_ACTUAL_AMOUNT]);

        return $order;
    }

    /**
     * 根据订单号查询订单
     *
     * @param $orderNumber
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function findOrderByNumber($orderNumber)
    {
        $order = $this->rep->findByOrderNo($orderNumber);
        return $order;
    }

    /**
     * 支付定金，装填变更为待买家确认
     *
     * @param $id
     * @return int
     */
    public function payDeposit($order,$actualAmount,$transactionId,$tradeState,$payAt,$payType,$status,$isDeposit)
    {
        $order->{Order::FIELD_STATUS} = $status;
        $order->{Order::FIELD_ACTUAL_AMOUNT} = $actualAmount;
        $order->{Order::FIELD_ID_TRANSACTION} = $transactionId;
        $order->{Order::FIELD_TRADE_STATE} = $tradeState;
        $order->{Order::FIELD_PAYMENT_TYPE} = $payType;
        $order->{Order::FIELD_PAID_AT} = date("Y-m-d H:i:s",strtotime($payAt));
        $order->{Order::FIELD_IS_DEPOSIT} = $isDeposit;
        $result = $order->save();
        return $result;
    }

    public function findDetailByOrderNum($orderNumber)
    {
        $player = ["buyer"=>function($query){
            $query->select([
                WechatUser::FIELD_ID,
                WechatUser::FIELD_NICKNAME,
                WechatUser::FIELD_PHONE
            ]);},
            "seller"=>function($query){
                $query->select([
                    WechatUser::FIELD_ID,
                    WechatUser::FIELD_NICKNAME,
                    WechatUser::FIELD_PHONE
                ]);}
        ];

        $result = Order::query()
            ->where(Order::FIELD_ORDER_NUMBER,$orderNumber)
            ->with(array_merge(["orderItems"=>function($query){
                $query->with(["snapshots"])->select([
                    OrderItem::FIELD_ID,
                    OrderItem::FIELD_ID_ORDER,
                    OrderItem::FIELD_ID_GOODS,
                    OrderItem::FIELD_PRICE,
                    OrderItem::FIELD_ACTUAL_PRICE,
                    OrderItem::FIELD_QUANTITY,
                    OrderItem::FIELD_STATUS
                ]);
            }],$player))
            ->select([
                Order::FIELD_ID,
                Order::FIELD_ID_SELLER,
                Order::FIELD_ID_BUYER,
                Order::FIELD_ORDER_NUMBER,
                Order::FIELD_TYPE,
                Order::FIELD_DEPOSIT,
                Order::FIELD_TOTAL_AMOUNT,
                Order::FIELD_ACTUAL_AMOUNT,
                Order::FIELD_ID_TRANSACTION,
                Order::FIELD_PAYMENT_TYPE,
                Order::FIELD_STATUS,
                Order::FIELD_PAID_AT,
                Order::FIELD_PROTOCOL,
                Order::FIELD_REFUND_AT,
                Order::FIELD_CREATED_AT
            ])
            ->first();

        return $result;
    }

    public function refundOrder($userId,$orderId,$reason)
    {
        $order = $this->findById($orderId);
        if (!$order){
            throw new ApiException("订单不存在",ErrorEnum::ORDER_NOt_FOUND);
        }

        if ($order->{Order::FIELD_ID_BUYER} != $userId){
            throw new ApiException("订单不存在",ErrorEnum::ORDER_USER_NOt_FOUND);
        }

        if ($order->{Order::FIELD_STATUS} == Order::ENUM_STATUS_WAIT_DEAL_SUCCESS){
            throw new ApiException("订单已完结，不能申请退款");
        }

        if ($order->{Order::FIELD_STATUS} == Order::ENUM_STATUS_REFUNDING){
            throw new ApiException("订单已处于退款审核中，请耐心等候审核结果");
        }

        if (!in_array($order->{Order::FIELD_STATUS},[
            Order::ENUM_STATUS_WAIT_SELLER_CONFIRM,
            Order::ENUM_STATUS_WAIT_CAMPUS_CONFIRM,
            Order::ENUM_STATUS_WAIT_CONFIRM_LESSON,
            Order::ENUM_STATUS_WAIT_PAY_LESS,
            Order::ENUM_STATUS_REFUND_FAIL
        ])){
            throw new ApiException("订单不允许进行退款操作",ErrorEnum::ORDER_CANT_SELLER_VERIFY);
        }

        //需要提交退款的金额
        $refundNumber = generateRefundOrderNo();
        $refundModel = OrderRefund::create([
            OrderRefund::FIELD_ID_ADMIN      => 0,
            OrderRefund::FIELD_ID_ORDER      => $order->{Order::FIELD_ID},
            OrderRefund::FIELD_OUT_REFUND_NO => $refundNumber,
            OrderRefund::FIELD_REFUND_FEE    => $order->{Order::FIELD_ACTUAL_AMOUNT},
            OrderRefund::FIELD_STATUS        => OrderRefund::ENUM_STATUS_REFUNDING,
            OrderRefund::FIELD_RESULT        => [],
            OrderRefund::FIELD_REASON        => $reason,
            OrderRefund::FIELD_TYPE          => OrderRefund::ENUM_TYPE_BUILD,
        ]);
        if (!$refundModel){
            throw new ApiException("退款订单保存失败，请稍后重试",ErrorEnum::ORDER_REFUND_CREATE_ERR);
        }

        $order->{Order::FIELD_STATUS} = Order::ENUM_STATUS_REFUNDING;//订单进入退款中状态
        $result = $order->save();
        if (!$result){
            throw new ApiException("更新订单状态失败",ErrorEnum::ORDER_UPDATE_TO_REFUND_ERROR);
        }

        //通知管理员，用户申请了退款
        $user = app(WechatUserService::class)->findById($userId);
        if ($user){
            $nickname = $user->{WechatUser::FIELD_NICKNAME};
            $orderNum = $order->{Order::FIELD_ORDER_NUMBER};
            $managerMessage = "用户【{$nickname}】提交了订金退款申请，订单号：{$orderNum}，请及跟进";
            commonJob(InboxService::class,"send",[1, $order->id, Inbox::ENUM_OBJ_TYPE_ORDER, $managerMessage, Inbox::ENUM_TYPE_ORDER_REFUND, Carbon::now()->toDateTimeString()]);
        }

        return $order;
    }

    /**
     * 遍历超时支付的订单
     */
    public static function scanTimeoutOrder()
    {
        $orders = Order::query()->where(Order::FIELD_STATUS,Order::ENUM_STATUS_WAIT_PAY)->get();
        $now = time();
        $timeoutLine = 900;
        foreach ($orders as $order){
            if ($now - strtotime($order->{Order::FIELD_CREATED_AT}) > $timeoutLine){
                //订单超时
                commonJob(OrderService::class,"timeOutPay",[$order->id]);
            }
        }
    }

    /**
     * 处理订单超时支付
     *
     * @param $orderId
     */
    public static function timeOutPay($orderId)
    {
        try {
            DB::beginTransaction();
            //锁定订单
            $order = Order::query()->where(Order::FIELD_ID, $orderId)->lockForUpdate()->first();
            if (!$order){
                Log::error("获取订单表锁失败-order_id：".$orderId);
                throw new ApiException("订单不存在");
            }

            if ($order->{Order::FIELD_STATUS} != Order::ENUM_STATUS_WAIT_PAY){
                throw new ApiException("订单状态错误");
            }

            $orderItems = $order->orderItems;
            foreach ($orderItems as $item){
                //将订单商品重新更新回审核通过状态
                $updateGoods = app(GoodsRep::class)->updateStatus($item->{OrderItem::FIELD_ID_GOODS},Goods::ENUM_STATUS_VERIFY_SUCCESS);
                if (!$updateGoods){
                    Log::info("将商品重置会已通过审核时发生错误：".$orderId);
                    throw new ApiException("将商品重置会已通过审核时发生错误");
                }
            }

            $result = app(OrderRep::class)->updateStatus($orderId,Order::ENUM_STATUS_PAY_TIME_OUT);
            if (!$result){
                throw new ApiException("更新订单状态失败");
            }

            Log::info("处理完成超时订单：".$orderId);
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * 订单取消
     *
     * @param $userId
     * @param $orderId
     * @throws ApiException
     */
    public function cancel($userId,$orderId)
    {
        try {
            DB::beginTransaction();
            //锁定订单
            $order = Order::query()->where(Order::FIELD_ID, $orderId)->first();
            if (!$order){
                throw new ApiException("订单不存在");
            }

            if ($order->{Order::FIELD_ID_BUYER} != $userId){
                throw new ApiException("订单错误，您无法取消");
            }

            if ($order->{Order::FIELD_STATUS} != Order::ENUM_STATUS_WAIT_PAY){
                throw new ApiException("订单状态错误");
            }

            $orderItems = $order->orderItems;
            foreach ($orderItems as $item){
                //将订单商品重新更新回审核通过状态
                $updateGoods = app(GoodsRep::class)->updateStatus($item->{OrderItem::FIELD_ID_GOODS},Goods::ENUM_STATUS_VERIFY_SUCCESS);
                if (!$updateGoods){
                    Log::info("将商品重置会已通过审核时发生错误：".$orderId);
                    throw new ApiException("处理商品发生错误");
                }
            }

            $result = app(OrderRep::class)->updateStatus($orderId,Order::ENUM_STATUS_CANCEL);
            if (!$result){
                throw new ApiException("更新订单状态失败");
            }

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            throw $exception;
        }

        return $order->{Order::FIELD_ORDER_NUMBER};
    }

    public function existOrder($userId,$goodsId)
    {
        $item = OrderItem::query()->where(OrderItem::FIELD_ID_GOODS,$goodsId)->first();
        if (!$item){
            return null;
        }

        $order = $item->order;
        if (!$order){
            return null;
        }

        if ($order->{Order::FIELD_ID_BUYER} != $userId){
            return null;
        }

        return $order;
    }

    public function deleteOrder($userId,$orderId)
    {
        $order = $this->findById($orderId);
        if (!$order){
            throw new ApiException("订单不存在");
        }

        if ($order->{Order::FIELD_ID_BUYER} != $userId){
            throw new ApiException("订单不存在");
        }

        if (!in_array($order->{Order::FIELD_STATUS},[Order::ENUM_STATUS_CANCEL,Order::ENUM_STATUS_PAY_TIME_OUT])){
            throw new ApiException("订单不是取消或超时支付状态，无法删除");
        }

        $result = $order->delete();
        if (!$result){
            throw new ApiException("删除失败，请稍后重试");
        }

        $itemResult = OrderItem::query()->where(OrderItem::FIELD_ID_ORDER,$orderId)->delete();
        if (!$itemResult){
            throw new ApiException("删除失败，请稍候重试");
        }
    }

}
