<?php

namespace App\Enum;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/30 0030
 * Time: 16:23
 */
class ErrorEnum
{
    //用户相关 1000 ~ 1499
    //用户不存在
    const AUTH_USER_NOT_FOUND = 1000;
    //账号密码错误
    const AUTH_USER_PSW_ERR = 1001;
    //token已过有效期
    const AUTH_TOKEN_EXPIRE = 1002;
    //token非法
    const AUTH_TOKEN_VALID = 1003;
    //token异常
    const AUTH_TOKEN_ERR = 1004;
    //登录验证失败
    const AUTH_LOGIN_VERIFY_FAIL = 1005;
    //认证异常
    const AUTH_TOKEN_EXCEPT = 1006;
    //实名认证 - 人像面数据空
    const REAL_NAME_FRONT_NULL = 1007;
    //实名认证 - 国徽面数据空
    const REAL_NAME_BACKEND_NULL = 1008;
    //实名认证 - 数据保存失败
    const REAL_NAME_CREATE_FAIL = 1009;
    //实名认证 - 实名认证信息不存在
    const REAL_NAME_NOT_FOUND = 1010;
    //实名认证 - 更新实名认证状态失败
    const REAL_NAME_UPDATE_STATUS_FAIL = 1011;
    //实名认证 - 更新实名认证信息失败
    const REAL_NAME_UPDATE_FAIL = 1012;
    //实名认证 - 认证已完成，无需重复认证
    const REAL_NAME_REPEAT = 1013;
    //微信小程序登录失败
    const AUTH_MINI_PROGRAM_LOGIN_ERR = 1014;
    //用户不存在
    const USER_NOT_FOUND = 1015;
    //实名认证 - 更新身份证图片失败
    const REAL_NAME_UPDATE_IMAGE_FAIL = 1016;
    //用户已被拉入黑名单
    const USER_BE_BAN = 1017;

    //通用异常错误 1500 ~ 1999
    //路由错误
    const SYS_ROTE_NOTE_FOUND = 1500;
    //路由规格不匹配
    const SYS_ROUTE_NOT_MATCH = 1501;
    //路由方法错误
    const SYS_ROUTE_METHOD_ERR = 1502;
    //db error
    const SYS_DB_CONNECT_ERROR = 1503;
    //系统异常，未知错误
    const SYS_SERVICE_DOWN = 1504;
    //cos token获取异常
    const COS_GET_TOKEN_ERR = 1506;
    //cos token缓存设置失败
    const COS_GET_TOKEN_CACHE_ERR = 1507;

    //微信相关错误 2000 ~ 2499
    //获取用户信息失败
    const WX_GET_USER_ERR = 2000;
    //session_key error
    const WX_SESSION_ERR = 2001;
    //iv error
    const WX_IV_ERR = 2002;
    //用户信息解密失败
    const WX_PARSE_ERR = 2003;
    //APP_ID error
    const WX_APP_ERR = 2004;

    //商品相关 3000 ~ 3999
    //保存商品失败
    const GOODS_CREATE_FAIL = 3000;
    //合同资料保存失败
    const GOODS_CONTRACT_CREATE_FAIL = 3001;
    //合同转让信息保存失败
    const GOODS_TRANSFER_INFO_CREATE_FAIL = 3002;
    //参数为空
    const GOODS_PARAMS_NULL = 3003;
    //商品品牌不存在
    const GOODS_BRAND_NOT_FOUND = 3004;
    //商品校区参数错误
    const GOODS_CAMPUS_TYPE_ERR = 3005;
    //商品课程类型不存在
    const GOODS_LESSON_CATEGORY_NOT_FOUND = 3006;
    //商品校区不存在
    const GOODS_CAMPUS_NOT_FOUND = 3007;
    //商品合同课程课程年次卡类型错误
    const GOODS_LESSON_TIME_TYPE_ERR = 3008;
    //商品合同剩余金额不能小于0
    const GOODS_SURPLUS_AMOUNT_ERR = 3009;
    //商品合同剩余课时不能小于0
    const GOODS_SURPLUS_TIME_ERR = 3010;
    //商品适课性别错误
    const GOODS_CONTRACT_GENDER_ERR = 3011;
    //商品创建类型错误
    const GOODS_CREATE_TYPE_ERR = 3012;
    //商品发布失败
    const GOODS_SAVE_FAIL = 3013;
    //商品合同保存失败
    const GOODS_CONTRACT_SAVE_FAIL = 3014;
    //商品转让那个信息保存失败
    const GOODS_TRANSFER_SAVE_FAIL = 3015;
    //商品不存在
    const GOODS_NOT_EXISTS = 3016;
    //商品已下架
    const GOODS_SALE_STATUS_DOWN = 3017;
    //商品处于不可售状态
    const GOODS_STATUS_CANT_SALE = 3018;
    //商品无法锁定
    const GOODS_LOCK_FAIL = 3019;
    //商品跟新为转让中失败
    const GOODS_UPDATE_UNDER_TRANSFER_FAIL = 3020;
    //商品品牌查询中商品必须为数组类型
    const GOODS_BRAND_CANT_STR = 3021;
    //商品查询order by错误
    const GOODS_ORDER_BY_ERR = 3022;

    //订单相关 4000 ~ 4999
    //母订单入库失败
    const ORDER_CREATE_FAIL = 4000;
    //子订单入库失败
    const ORDER_ITEM_CREATE_FAIL = 4001;
    //子订单快照入库失败
    const ORDER_SNAP_CREATE_FAIL = 4002;
    //母订单不存在
    const ORDER_NOt_FOUND = 4003;
    //母订单用户不一致
    const ORDER_USER_NOt_FOUND = 4004;
    //母订单状态错误，不能进行卖家确认操作
    const ORDER_CANT_SELLER_VERIFY = 4005;
    //母订单卖家确认失败
    const ORDER_SELLER_VERIFY_FAIL = 4006;
    //母订单所属的子订单不存在
    const ORDER_ITEM_NOT_FOUND = 4007;
    //母订单更新为退款状态失败
    const ORDER_UPDATE_TO_REFUND_ERROR = 4008;
    //母订退款参数不能为空
    const ORDER_REFUND_ID_NOT_NULL = 4009;
    //母订退款原因错误
    const ORDER_REFUND_REFUND_ERR = 4010;
    //母订退款参数不能为空
    const ORDER_REFUND_CREATE_ERR = 4011;
    //退款订单更新失败
    const ORDER_REFUND_UPDATE_ERR = 4012;
    //退款状态更新失败
    const ORDER_REFUND__STATUS_UPDATE_ERR = 4013;


    //收藏相关 5000 ~ 5999
    const COLLECTION_PARAMS_NULL = 5000;
    //收藏 - 更新收藏状态失败
    const COLLECTION_UPDATE_STATUS_FAIL = 5001;
    //收藏 - 保存收藏失败
    const COLLECTION_SAVE_FAIL = 5002;
    //收藏 - 取消收藏失败
    const COLLECTION_CANCEL_FAIL = 5003;

    //议价相关 6000 ~ 6999
    const BARGAINING_PARAM_NULL = 6000;
    //议价 - 有未处理的议价
    const BARGAINING_WAIT_TO_DEAL = 6001;
    //议价 - 议价次数已超过三次，无法再发起议价
    const BARGAINING_COUNT_MORE_THAN_3 = 6002;
    //议价 - 议价不存在
    const BARGAINING_NOT_FOUND = 6003;
    //议价 - 议价不是待处理状态
    const BARGAINING_STATUS_NOT_WAIT = 6004;
    //议价 - 议价更新失败
    const BARGAINING_UPDATE_FAIL = 6005;
    //议价 - 议价商品不存在
    const BARGAINING_GOODS_NOT_FOUND = 6006;
    //议价 - 议价对象错误
    const BARGAINING_CAN_NOT_BY_OWN = 6007;
    //议价 - 课程不支持议价
    const BARGAINING_CAN_NOT_BARGAINING = 6008;

    /** banner 7000 ~ 7499 **/
    //banner 不存在
    const BANNER_NOT_FOUND = 7000;
    //banner更新失败
    const BANNER_UPDATE_FAIL = 7001;
    //banner新增失败
    const BANNER_CREATE_FAIL = 7002;
    //banner类型参数错误
    const BANNER_TYPE_ERROR = 7003;
    //banner删除失败
    const BANNER_DELETE_FAIL = 7004;
    //banner上架失败
    const BANNER_UP_FAIL = 7005;
    //banner下架失败
    const BANNER_DOWN_FAIL = 7006;
    //banner状态错误
    const BANNER_STATUS_ERR = 7007;

    /** user 7500 ~ 7999 **/
    //用户更新失败
    const USER_UPDATE_ERR = 7500;
    //用户邮件发送失败
    const USER_EMAIL_CODE_SEND_ERR = 7501;
    //用户不存在
    const USER_EMAIL_NOT_FOUND = 7502;
    //用户邮箱验证码错误
    const USER_EMAIL_CODE_ERR = 7503;
    //用户邮箱验证码已过期
    const USER_EMAIL_CODE_EXPIRE = 7504;
}
