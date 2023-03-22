<?php

use App\Exceptions\ApiException;
use App\Jobs\SendMail;
use App\Models\Game;
use App\Service\CosService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
/**
 * 分页
 */
if(!function_exists("paginate")){
    function paginate($query, $pageParams, $columns = null, $map = null){
        if ($columns === null || !is_array($columns)) {
            $columns = ['*'];
        }

        $perPage     = $pageParams['page_size'] ? $pageParams['page_size'] : 10;
        $currentPage = $pageParams['page_number'] ? $pageParams['page_number'] : 1;

        $result = $query->paginate($perPage, $columns, null, $currentPage);
        $items  = $result->getCollection();
        if ($map != null) {
            $items = $items->map($map);
        }

        return [
            'page'      => [
                'size'        => $perPage,
                'number'      => $currentPage,
                'total-pages' => $result->lastPage(),
                'total_items' => $result->total(),
            ],
            'page_data' => $items
        ];
    }
}

/**
 * 生成uuid
 */
if (!function_exists("uuid")){
    function uuid(){
        $pid = \Illuminate\Support\Str::uuid();
        return str_replace('-','', $pid);
    }
}

/**
 * 生成订单号
 */
if (!function_exists("generateOrderNo")){
    function generateOrderNo($type){
        $uuid = date("YmdHis").rand(10000,100000);
        return $type == \App\Models\Order::ENUM_TYPE_MINI ? "W".$uuid : "H".$uuid;
    }
}

/**
 * 计算订金
 */
if (!function_exists("getDeposit")){
    function getDeposit($amount){
        $deposit = 0;
        switch ($amount){
            case $amount <= 2000:
                $deposit = 85;
                break;
            case $amount <= 3000:
                $deposit = 115;
                break;
            case $amount <= 4000:
                $deposit = 150;
                break;
            case $amount <= 5000:
                $deposit = 180;
                break;
            case $amount <= 6000:
                $deposit = 200;
                break;
            case $amount <= 7000:
                $deposit = 230;
                break;
            case $amount <= 8000:
                $deposit = 260;
                break;
            case $amount <= 9000:
                $deposit = 290;
                break;
            case $amount <= 10000:
                $deposit = 300;
                break;
            case $amount <= 11000:
                $deposit = 325;
                break;
            case $amount <= 12000:
                $deposit = 350;
                break;
            case $amount <= 13000:
                $deposit = 375;
                break;
            case $amount <= 14000:
                $deposit = 400;
                break;
            case $amount <= 15000:
                $deposit = 400;
                break;
            case $amount <= 16000:
                $deposit = 420;
                break;
            case $amount <= 17000:
                $deposit = 440;
                break;
            case $amount <= 18000:
                $deposit = 460;
                break;
            case $amount <= 19000:
                $deposit = 480;
                break;
            case $amount <= 20000:
                $deposit = 500;
                break;
            case $amount <= 30000:
                $deposit = 600;
                break;
            case $amount <= 40000:
                $deposit = 800;
                break;
            case $amount <= 50000:
                $deposit = 1000;
                break;
            case $amount <= 60000:
                $deposit = 1100;
                break;
            case $amount <= 70000:
                $deposit = 1350;
                break;
            case $amount <= 80000:
                $deposit = 1600;
                break;
            case $amount <= 90000:
                $deposit = 2150;
                break;
            case $amount <= 100000:
                $deposit = 2700;
                break;
            case $amount <= 120000:
                $deposit = 3600;
                break;
            case $amount <= 140000:
                $deposit = 4700;
                break;
            case $amount <= 160000:
                $deposit = 5800;
                break;
            case $amount <= 180000:
                $deposit = 6900;
                break;
            case $amount <= 200000:
                $deposit = 8000;
                break;
            case $amount <= 300000:
                $deposit = 13000;
                break;
            case $amount <= 500000:
                $deposit = 20500;
                break;
            case $amount <= 1000000:
                $deposit = 25000;
                break;
            case $amount <= 2000000:
                $deposit = 40000;
                break;
            case $amount > 2000000:
                $deposit = $amount*0.02;
                break;
        }

        return $deposit;
    }
}

/**
 * 暴露n位小数
 *
 * @author yezi
 */
if(!function_exists("decimal")){
    function decimal($num,$length=2){
        $result =  $num == 0 ? '0.00' : $num;
        return substr($result,0,2+$length);
    }
}

/**
 * 转换成分
 */
if(!function_exists("toPenny")){
    function toPenny($money){
        return $money*100;
    }
}

/**
 * 转换成元
 */
if(!function_exists("toYuan")){
    function toYuan($money){
        return (float)$money/100;
    }
}

/**
 * 生成退款订单号
 */
if (!function_exists("generateRefundOrderNo")){
    function generateRefundOrderNo(){
        $uuid = date("YmdHis").rand(10000,100000);
        return "R".$uuid;
    }
}

if(!function_exists("towPointDistance")) {
     function towPointDistance($lat1,$lat2,$lng1,$lng2){
         // 将角度转为狐度
         $radLat1 = deg2rad($lat1); //deg2rad()函数将角度转换为弧度
         $radLat2 = deg2rad($lat2);
         $radLng1 = deg2rad($lng1);
         $radLng2 = deg2rad($lng2);
         $a = $radLat1 - $radLat2;
         $b = $radLng1 - $radLng2;
         $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
         return $s;
    }
}

/**
 * 生成随机字符串
 */
if(!function_exists("randomKeys")){
    function randomKeys($length){
        $pattern = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ";
        $key = "";
        for($i=0;$i<$length;$i++){
            $key .= $pattern{mt_rand(0,60)}; //生成php随机数
        }
        return $key;
    }
}

if (!function_exists("getIP")) {
    function getIP($type = 0) {
        $type       =  $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if( isset( $_SERVER['HTTP_X_REAL_IP'] ) ){//nginx 代理模式下，获取客户端真实IP
            $ip=$_SERVER['HTTP_X_REAL_IP'];
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {//客户端的ip
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {//浏览当前页面的用户计算机的网关
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];//浏览当前页面的用户计算机的ip地址
        }else{
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}

