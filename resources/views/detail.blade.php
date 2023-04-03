<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta charset="utf-8">
    <meta name="divport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>转课详情</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
    body{
        margin:0;
    }
    .product-detail{
        display:block;
        position:relative;
        overflow:hidden;
        background-color:#f5f5f5;
    }

    .banner-swiper-box {
        width: 100vw;
        height: 249px;

    }

    .banner-swiper-box .banner-swiper {
        width: 100vw;
        height: 249px;
    }

    .banner-image {
        width: 100vw;
        height: 249px;
        object-fit: cover;
    }

    .href-nav {
        height: 45px;
        display: flex;
        background-color: #FFF;
        align-items: center;
        justify-content: space-around;
    }

    .href-nav .item {
        font-size: 12px;
        font-family: PingFang SC;
        font-weight: 400;
        color: #808080;
        transition: 0.3s;
        height: 100%;
        display: flex;
        align-items: center;
        position: relative;
    }

    .href-nav .item:hover {
        color: #333;
    }

    .part1 {
        padding: 5.33vw;
        background-color: #FFF;
        margin-top: 2.67vw;
    }

    .part1 .line1 {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        font-size: 14px;
        font-family: PingFang SC;
        font-weight: 500;
        color: #333333;
        line-height: 24px;
        margin-bottom: 7.33vw;
    }

    .part1 .line15 {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2.67vw;
    }

    .part1 .line2 {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .part1 .line2 .item {
        display: flex;
        align-items: flex-end;


        font-size: 3.2vw;
        font-family: PingFang SC;
        font-weight: 600;
        color: #333333;
        line-height: 6.4vw;
    }

    .part1 .line2 .item .t2 {

        font-size: 4.8vw;
        font-family: PingFang SC;
        font-weight: 600;
        color: #FF5252;
        line-height: 6.4vw;
    }

    .part1 .line2 .item.grey,
    .part1 .line15 .item.grey {

        font-size: 2.67vw;
        font-family: PingFang SC;
        font-weight: 500;
        color: #808080;
        line-height: 1;
    }

    .part1 .line3 {
        height: 13.33vw;
        border-top: 0.27vw solid #F5F7FA;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .part1 .line3 .left {

        font-size: 14px;
        font-family: PingFang SC;
        font-weight: 400;
        color: #333333;
        line-height: 6.4vw;
    }

    .part1 .line3 .right {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 0 5.33vw;
    }

    .part1 .line3 .right .tip {
        display: flex;
        align-items: center;

    }

    .part1 .line3 .right .tip .icon {
        width: 4.8vw;
        height: 4.8vw;
        object-fit: contain;
        margin-right: 2.13vw;
    }

    .part1 .line3 .right .tip .tip-name {

        font-size: 3.2vw;
        width: 4em;
        font-family: PingFang SC;
        font-weight: 400;
        color: #808080;
        line-height: 6.4vw;
    }

    .part1 .line3:last-child {
        border-bottom: 0.27vw solid #F5F7FA;
    }

    .part2 {
        background-color: #FFFFFF;
        margin-top: 2.67vw;
        padding: 0 5.33vw;
    }

    .part2 .line {
        padding: 3.47vw 0;
        border-bottom: 0.27vw solid #F5F7FA;
        display: flex;
        align-items: center;
    }

    .part2 .line .item {
        flex: 1;
        display: flex;
        align-items: center;
        padding-left: 5.07vw;
        /* border-right: 0.13vw solid #333333; */
        border-left: 0.13vw solid #333;

    }

    .part2 .line .item .name {
        white-space: nowrap;
        font-size: 14px;
        font-family: PingFang SC;
        font-weight: 400;
        color: #999999;
        margin-right: 3.2vw;
        line-height: 6.4vw;
    }

    .part2 .line .item .content {
        font-size: 14px;
        font-family: PingFang SC;
        font-weight: 400;
        color: #333333;
        line-height: 6.4vw;
    }

    .part2 .line .item .content1 {

        font-size: 14px;
        margin-right: 5.2vw;
        font-family: PingFang SC;
        font-weight: 500;
        color: #FF5252;
        line-height: 6.4vw;
    }

    .part2 .line .item .content2 {
        min-width: 11.73vw;
        height: 5.33vw;
        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 14px;
        font-family: PingFang SC;
        font-weight: 400;
        color: #FF5252;
        line-height: 6.4vw;
        background: #FFD1D1;
    }

    .part2 .line .item:first-child {
        border-left: 0;
        padding-left: 0;
    }

    .part2 .line .item:last-child {
        border-right: 0;
    }

    .part3 {
        padding: 4.8vw 5.34vw 6.67vw;
        background-color: #FFF;
        margin-top: 2.67vw;

    }

    .part3 .map {
        width: 89.33vw;
        height: 32.67vw;
        border-radius: 2.13vw;
        background-color: #808080;
    }

    .part3 .location-text {

        font-size: 14px;
        font-family: PingFang SC;
        font-weight: 400;
        margin-top: 2.8vw;
        color: #333333;
        line-height: 5.33vw;
    }

    .part3 .btn-come {

        font-size: 3.2vw;
        font-family: PingFang SC;
        font-weight: 400;
        color: #5297FF;
        width: 4em;
        margin: 2.67vw 0 4.93vw auto;

        line-height: 3.2vw;
    }

    .part3 .line {

        height: 0.27vw;
        background: #F5F7FA;
    }

    .part4 {
        margin-top: 2.67vw;
        height: 204vw;
        padding: 4.8vw 5.33vw;
        background-color: #FFF;
    }

    .part4 .user-info {
        width: 89.33vw;
        height: 16.67vw;
        padding: 4vw;
        box-sizing: border-box;
        border-radius: 2.13vw;
        background: linear-gradient(-45deg, #FF7070, #FF5252);
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

    }

    .part4 .user-info .left {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .part4 .user-info .left .icon {
        width: 11.73vw;
        height: 11.73vw;
        object-fit: cover;
        background-color: #808080;
        border-radius: 50%;
        margin-right: 4vw;
    }

    .part4 .user-info .left .infos .name {

        font-size: 14px;
        font-family: PingFang SC;
        font-weight: 600;
        color: #FFFFFF;
        line-height: 5.33vw;

    }

    .part4 .user-info .left .infos .phone {

        font-size: 3.2vw;
        font-family: PingFang SC;
        font-weight: 400;
        color: #FFFFFF;
        line-height: 1;
        margin-top: 1.87vw;
    }

    .part4 .user-info .right {

        font-size: 14px;
        font-family: PingFang SC;
        font-weight: 600;
        color: #FFFFFF;
        line-height: 5.33vw;
    }

    .part4 .transfer-progress {
        margin-top: 5.2vw;
    }

    .part4 .transfer-progress>.name {

        font-size: 30.27vw;
        font-family: PingFang SC;
        font-weight: 600;
        color: #333333;
        line-height: 24px;
        margin-bottom: 5.33vw;
    }

    .part4 .transfer-progress .item {
        display: flex;
        align-items: flex-start;
        justify-content: flex;
        height: 21.33vw;
    }

    .part4 .transfer-progress .item .left .circle {
        width: 5.33vw;
        height: 5.33vw;

        background: #E6E6E6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;


        font-size: 14px;
        font-family: PingFang SC;
        font-weight: 600;
        color: #FFFFFF;
        line-height: 24px;
        position: relative;
        margin-right: 4vw;

    }

    .part4 .transfer-progress .item .left .circle::after {
        content: '';
        width: 0.53vw;
        height: 8vw;
        left: 2.4vw;
        bottom: -8vw;
        background: #E6E6E6;
        position: absolute;
    }

    .part4 .transfer-progress .item .left .circle::before {
        content: '';
        width: 0.53vw;
        height: 8vw;
        left: 2.4vw;
        background: #E6E6E6;
        top: -8vw;
        position: absolute;
    }

    .part4 .transfer-progress .item:first-child .left .circle::before {
        display: none;
    }

    .part4 .transfer-progress .item:last-child .left .circle::after {
        display: none;
    }

    .part4 .transfer-progress .item .right .t1 {

        font-size: 4vw;
        font-family: PingFang SC;
        font-weight: 500;
        color: #cccccc;
        line-height: 24px;
    }

    .part4 .transfer-progress .item .right .t2 {
        margi-top: 1.87vw;
        font-size: 3.2vw;
        font-family: PingFang SC;
        font-weight: 400;
        color: #cccccc;
        line-height: 24px;
    }

    .part4 .transfer-progress .item.hover .right .t1 {
        color: #333;
    }

    .part4 .transfer-progress .item.hover .right .t2 {
        color: #808080;
    }

    .part4 .transfer-progress .item.hover .left .circle,
    .part4 .transfer-progress .item.hover .left .circle::before,
    .part4 .transfer-progress .item.hover .left .circle::after {

        background: #5197FF;
    }

    .thumbnail {
        object-fit: cover;
    }
    </style>
</head>

<body>
    <div class="product-detail">
        <div class="banner-swiper-box">
            <div class="banner-swiper">
                <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/transfer_info/tmp_499b35e1b7091c4efa3c891d7812dce6.png"
                    class="banner-image" />
            </div>
        </div>
        <div class="href-nav">
            <a class="item hover">课程信息</a>
            <a class="item">位置交通</a>
            <a class="item">订单流程</a>
            <a class="item">推荐课包</a>
        </div>

        <div class="part1 anchor1">
            <div class="line1">
              
                【年卡】ABC
             
            </div>
            <div class="line15">
                <div class="item"></div>
                <div class="item grey">
                  
                    发布于：2023-04-04
                </div>
            </div>

            <div class="line2">
                <div class="item">
                    <div class="t1">转让价格：</div>
                 
                    <div class="t2">¥255.00</div>
                </div>
                <div class="item">
                    <div class="t1">订金：</div>
                   
                    <div class="t2">¥256.00</div>
                </div>
                <div class="item grey">
                 
                    15人查看
                </div>
            </div>

            <div class="line3">
                <div class="left">认证荣誉</div>
                <div class="right">
                    <div class="tip">
                        <img class="icon"
                            src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/yishiren_icon%402x.png" />
                        <div class="tip-name">已实人</div>
                    </div>
                    <div class="tip">
                        <img class="icon"
                            src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/shimingrenzheng_icon%402x.png" />
                        <div class="tip-name">实名认证</div>
                    </div>
                    <div class="tip">
                        <img class="icon"
                            src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/shoujirenzheng_icon%402x.png" />
                        <div class="tip-name">手机认证</div>
                    </div>
                </div>
            </div>

            <div class="line3">
                <div class="left">交易保障</div>
                <div class="right">
                    <div class="tip">
                        <img class="icon"
                            src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/fenzhang_icon%402x.png" />
                        <div class="tip-name">专属客服</div>
                    </div>
                    <div class="tip">
                        <img class="icon"
                            src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/zhifu_icon%402x.png" />
                        <div class="tip-name">微信支付</div>
                    </div>
                    <div class="tip">
                        <img class="icon"
                            src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/xieyibaozhang_icon%402x.png" />
                        <div class="tip-name">协议保障</div>
                    </div>
                </div>
            </div>
          
        </div>

        <div class="part2">
            <div class="line">
                <div class="item">
                    <div class="name">品牌</div>
                    <div class="content">旦旦的品牌</div>
                </div>

            </div>

            <div class="line">
                <div class="item">
                    <div class="name">校区名称</div>
                    <div class="content">芜湖校区</div>
                </div>

            </div>
            <div class="line">
                <div class="item">
                    <div class="name">课程类型</div>
                    <div class="content">
                        舞蹈大类
                    </div>
                </div>
                <div class="item">
                    <div class="name">课程类别</div>
                    <div class="content">舞蹈</div>
                </div>
            </div>
            <div class="line">
                <div class="item">
                    <div class="name">课卡类型</div>
                    <div class="content">
                        年卡
                    </div>
                </div>
                <div class="item">
                    <div class="name">剩余课时</div>
                    <div class="content" >
                        25
                    </div>
                </div>
            </div>
            <div class="line">
                <div class="item">
                    <div class="name">适课年龄</div>
                    <div class="content">
                        3岁
                    </div>
                </div>
                <div class="item">
                    <div class="name">适课性别</div>
                    <div class="content">男宝宝</div>
                </div>
            </div>


            <div class="line">
                <div class="item">
                    <div class="name">合同原价</div>
                    <div class="content1">¥355.67</div>
                    <div class="content2">3.3折</div>
                </div>

            </div>

            <div class="line">
                <div class="item">
                    <div class="name">合同有效期</div>
                    <div class="content">2023-03-03</div>
                </div>
            </div>

            <div class="line">
                <div class="item">
                    <div class="name">转让介绍</div>
                    <div class="content">这就是转让！</div>
                </div>

            </div>
        </div>

        <div class="part3 anchor2">

            <!-- <map class="map" :longitude="detail.campus.campus.longitude" :markers="markers"
				:latitude="detail.campus.campus.latitude" scale="15"></map> -->

            <div class="location-text">
                安徽省芜湖市镜湖区侨鸿那我非农花园15栋701室
            </div>
            <div class="btn-come" >到这里去</div>
            <div class="line"></div>
        </div>

        

    </div>
</body>
<script type="text/javascript">
var id = "{{$id}}";
console.log("id=" + id)
</script>

</html>