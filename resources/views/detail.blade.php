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
        min-height: 204vw;
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

        font-size: 16px;
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

    .mianze .t2 {
		margin-top: 2.13vw;
		font-size: 12px;
		font-family: PingFang SC;
		font-weight: 400;
		color: #808080;
		line-height: 16px;
	}

	.bottom-btns {
		position: fixed;
		width: 100%;
		z-index: 10;
		bottom: 0;
		left: 0;
		height: 13.33vw;
		display: flex;
		align-items: center;
		background-color: #fff;
		box-shadow: 0 0 1.07vw 0px rgba(0, 0, 0, 0.3);
	}

	.bottom-btns .left {
		margin-right: 2.67vw;
		display: flex;
		align-items: center;
		flex: 1;
		justify-content: space-around;
		background-color: #fff;
		height: 100%;

	}

	.bottom-btns .left .item {
		display: flex;
		align-items: center;
		justify-content: center;
		flex-direction: column;
	}

	.bottom-btns .left .item .icon {
		width: 5.33vw;
		height: 5.33vw;
		object-fit: contain;
	}

	.bottom-btns .left .item .name {

		font-size:11px;
		font-family: PingFang SC;
		font-weight: 400;
		color: #808080;
		margin-top:  1.33vw;
	}

	.bottom-btns .right {
		width: 49.06vw;
		height: 100%;
		background: linear-gradient(-45deg, #FF7070, #FF5252);
		display: flex;
		align-items: center;
		justify-content: center;

		font-size: 15px;
		font-family: PingFang SC;
		font-weight: 600;
		color: #FFFFFF;
	}

	.modal-payment-type-list {
		position: fixed;
		left: 0;
		top: 0;
		width: 100vw;
		height: 100vh;
		z-index: 11;
		display: flex;
		flex-direction: column;
		align-items: center;

	}

	.modal-payment-type-list {
		justify-content: flex-end;
	}

	.modal-discuss {
		justify-content: center;
	}

	.modal-payment-type-list.hide {
		z-index: -1;
	}

	.modal-payment-type-list.hide .cover {
		opacity: 0;
	}

	.modal-payment-type-list .cover {
		transition: 0.3s;
		opacity: 1;
		background-color: rgba(0, 0, 0, 0.6);
		position: absolute;
		width: 100vw;
		height: 100vh;
	}

	.modal-payment-type-list.hide .payment-type-list {
		transform: translateY(100vh);
	}

	.modal-payment-type-list .payment-type-list {
		position: relative;
		transition: 0.3s;
		transform: translateY(0);

	}

	.modal-payment-type-list .payment-type-list .item {
		padding: 4.8vw 17.6v;
		background-color: #fff;
		border-radius: 2.13vw;
		position: relative;
		display: flex;
		align-items: center;
		justify-content: center;
		flex-direction: column;
		margin-top: 4vw;
	}

	.modal-payment-type-list .payment-type-list .item .t1 {

		font-size: 15px;
		font-family: PingFang SC;
		font-weight: 500;
		color: #FF5252;
		line-height: 5.33vw;
	}

	.modal-payment-type-list .payment-type-list .item .t2 {
		margin-top: 2.67vw;
		font-size: 12px;
		font-family: PingFang SC;
		font-weight: 400;
		color: #999999;
		line-height: 16px;
	}

	.modal-payment-type-list .payment-type-list .item .t3 {

		font-size: 15px;
		font-family: PingFang SC;
		font-weight: 400;
		color: #808080;
		line-height: 5.33vw;
	}

	.modal-payment-type-list .payment-type-list .item.bottom {
		height: 22.13vw;
		padding: 0;
		border-bottom-left-radius: 0;
		border-bottom-right-radius: 0;
	}



	.hot-packages {
		padding: 5.33vw 0 7.47vw 0;
		background-color: #FFF;
		border-bottom: 2.67vw solid #F5F7FA;
	}

	.hot-packages .title {
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	.hot-packages .title .left {
		font-size: 16px;
		font-family: PingFang SC;
		font-weight: bold;
		color: #333333;
		line-height: 1;
		margin-bottom: 3.87vw;
	}

	.hot-packages .title .right {
		color: #808080;
		font-size: 12px;
		line-height: 1;
		display: flex;
		align-items: center;
	}

	.hot-packages .title .right .arrow-right {
		transform: scaleY(0.8) scaleX(1.6);
		margin-left: 1.87vw;
		line-height: 1;

		display: inline-block;
		vertical-align: middle;
	}

	.hot-packages .select-nav {
		margin-bottom: 2.67vw;
		width: 100vw;
		margin-left: -40px;
		padding: 0 2.67vw  1.33vw 2.67vw;
		box-sizing: border-box;
		position: sticky;
		top: 0;
		background-color: #fff;
		z-index: 2;

	}

	.hot-packages .select-nav .select-nav-items {
		white-space: nowrap;

	}

	.hot-packages .select-nav .select-nav-item {
		font-size: 12px;
		font-family: PingFang SC;
		font-weight: 500;
		color: #808080;
		margin-right: 60px;
		width: 13.33vw;
		display: inline-block;
		text-align: center;
		position: relative;
		padding-bottom: 2.13vw;
		transition: 0.3s;
	}

	.hot-packages .select-nav .select-nav-item.hover {
		color: #333;
		font-weight: bold;
	}

	.hot-packages .select-nav .select-nav-item::after {
		position: absolute;
		content: '';
		width: 4.27vw;
		bottom: 0;
		left: 50%;
		margin-left: -2.13vw;
		height: 2px;
		background: transparent;
		border-radius: 1px;
		transition: 0.3s;
	}

	.hot-packages .select-nav .select-nav-item.hover::after {
		background: #FF5252;
	}

	.hot-packages .items {
		display: flex;
		vertical-align: top;
	}

	.hot-packages .item {
		position: relative;
		margin-top:  1.33vw;
		margin-right:  1.33vw;
		width: 43.846vw;
		border-radius: 1.07vw;
		box-shadow: 0px 1px 4vw 0px rgba(48, 50, 51, 0.1);
		overflow: hidden;
		display: inline-block;
		vertical-align: top;
		word-break: break-all;
	}

	.hot-packages .item .tag {
		width: 13.33vw;
		height: 4.27vw;
		background: rgba(255, 82, 82, 0.2);
		border-radius: 2.13vw;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		font-size: 2.67vw;
		font-family: PingFang SC;
		font-weight: 500;
		color: #FF5656;
		vertical-align: middle;

	}



	.hot-packages .item .thumbnail {
		width: 100%;
		height:156px;
	}
	
	.hot-packages .item .info-box {
		top: 3.2vw;
		left: 2.67vw;
		display: flex;
		align-items: center;
		position: absolute;
		z-index: 1;
	}

	.hot-packages .item .info-box .avatar {
		width: 5.47vw;
		height: 5.47vw;
		border-radius: 50%;
	}

	.hot-packages .item .info-box .name {
		font-size: 12px;
		font-family: PingFang SC;
		font-weight: bold;
		color: #FFFFFF;
		line-height: 1;
		margin-right: 2.27vw;
	}

	.hot-packages .item .info-box .status {
		font-size: 2.67vw;
		font-family: PingFang SC;
		font-weight: bold;
		color: #FFFFFF;
		line-height: 1;
	}

	.hot-packages .item .position-box {
		margin-top: -7.47vw;
		left: 4vw;
		display: flex;
		position: absolute;
		z-index: 1;
		align-items: center;
	}

	.hot-packages .item .position-box .icon {
		width: 2.4vw;
		height: 3.2vw;
		margin-right: 2vw;
	}

	.hot-packages .item .position-box .address {
		width: 7em;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		font-size:11px;
		font-family: PingFang SC;
		font-weight: bold;
		color: #FFFFFF;
		margin-right: 3.6vw;
		line-height: 1;
	}

	.hot-packages .item .position-box .distance {
		font-size:11px;
		font-family: PingFang SC;
		font-weight: bold;
		color: #FFFFFF;
		line-height: 1;
	}

	.hot-packages .item .line3 {
		padding-top: 2.13vw;
		padding-bottom: 2.8vw;
	}

	.hot-packages .item .line3 .t {
		font-size: 2.67vw;
		font-family: PingFang SC;
		font-weight: 500;
		color: #808080;
		margin-bottom: 1.73vw;
		line-height: 11px;
	}

	.hot-packages .item .infos {
		padding: 0 4.27vw;
	}

	.hot-packages .item .infos .name {
		font-size: 7px;
		font-family: PingFang SC;
		display: inline;
		font-weight: bold;
		color: #333333;
		line-height: 21px;
	}

	.hot-packages .item .line2 {
		margin-top: 3.87vw;
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	.hot-packages .item .line2 .price {
		font-size: 7px;
		font-family: PingFang SC;
		font-weight: bold;
		color: #FF5252;
		line-height: 24px;

	}

	.hot-packages .item .line2 .want {
		font-size: 2.67vw;
		font-family: PingFang SC;
		font-weight: 500;
		color: #808080;
		line-height: 24px;
	}

	.hot-packages .item .line2 .discount {
		font-size: 7px;
		font-family: PingFang SC;
		font-weight: bold;
		color: #FF5252;
		line-height: 24px;
	}

	.hot-packages .item .line2 .discount .fonts {
		font-size: 2.67vw;

	}



	.hot-packages .item .infos .discount-icon {
		display: none;
		width: 4.54vw;
		height: 4.8vw;
		object-fit: contain;
		position: absolute;
		right: 0;
		bottom: 0.8vw;
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

         
            <div class="location-text">
                安徽省芜湖市镜湖区侨鸿那我非农花园15栋701室
            </div>
            <div class="btn-come" >到这里去</div>
            <div class="line"></div>
        </div>

        <div class="part4 anchor3">
            <div class="user-info">
                <div class="left">
                    <img class="icon" src="" />
                    <div class="infos">
                        <div class="name">尼克奈姆</div>
                         <div class="phone">未知号码</div>
                    </div>
                </div>
                <div class="right">
                   已入驻旦旦3天
                </div>
            </div>

            <div class="transfer-progress">
                <div class="name">转让流程</div>
                <div class="progress-list">
                    <div class="item hover">
                        <div class="left">
                            <div class="circle">
                                1
                            </div>
                        </div>
                        <div class="right">
                            <div class="t1">
                                订单审核
                            </div>
                            <div class="t2">
                                平台客服审核卖家订单真实有效
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="left">
                            <div class="circle">
                                2
                            </div>
                        </div>
                        <div class="right">
                            <div class="t1">
                                买家支付订金
                            </div>
                            <div class="t2">
                                买家支付课程订金，该订单正式进入交易流程
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="left">
                            <div class="circle">
                                3
                            </div>
                        </div>
                        <div class="right">
                            <div class="t1">
                                客服建群
                            </div>
                            <div class="t2">
                                平台客服拉企业微信群，买卖双方在群内确定转让时间和转让细节
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="left">
                            <div class="circle">
                                4
                            </div>
                        </div>
                        <div class="right">
                            <div class="t1">
                                交易完成
                            </div>
                            <div class="t2">
                                买卖双方线下签订课程转让合同，买家确定上课并支付卖家尾款（扣除平台服务费）
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mianze">
                <div class="t1">免责声明</div>
                <div class="t2">
                    <div>1.本平台所展示的课程供求信息由卖方自行提供，该信息已经过平台的前置审核，其真实性、准确性和合法性由信息发布人负责。</div>
                    <div>2.商品课程实际信息以买家到店后取得的合同资料为准。</div>
                    <div>3.本平台不对课程质量、课程效果做任何担保。</div>

                    <div>4.本平台提供的数字化商品根据商品性质在双方交易完成后不支持七天无理由退货及三包服务。</div>
                </div>
            </div>
            
            <div class="hot-packages">
                <div class="title">
                    <div class="left">推荐课包
                    </div>
                  </div>


                <div class="items">
                    <div class="items-left">
                        <div class="item-left-infos" id="listLeft">
                            <div class="item">
                                 <img src="" class="thumbnail" />

                                <div class="position-box">
                                    <div class="address">安徽省芜湖市镜湖区侨鸿那我非农花园15栋701室</div>
                                    <div class="distance">3.6km</div>
                                </div>


                                <div class="infos">
                                    <div class="line1">
                                        <div class="tag">卖家自转</div>
                                        <div class="name">
                                            哈哈哈

                                        </div>
                                    </div>
                                    <div class="line2">
                                        <div class="price">
                                           ¥10万
                                        </div>
                                        <div class="want">3人想要</div>
                                        <div class="discount">
                                          
                                            6.7
                                            <text class="fonts">折</text>
                                        </div>
                                    </div>

                                    <div class="line3">
                                      
                                        <div class="t">品牌名称</div>
                                    </div>

                                    <img class="discount-icon"
                                        src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/remen_icon%402x.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="items-right">
                        <div class="item-right-infos" id="listRight">
                            <div class="item">
                                <img src="" class="thumbnail" />
                                <div class="position-box">
                                    <img src="../../static/image/dingwei_icon.png" class="icon">
                                    </image>
                                    <div class="address">地址</div>
                                    <div class="distance">距离</div>
                                </div>


                                <div class="infos">
                                    <div class="line1">
                                        <div class="tag">卖家自转</div>
                                        <div class="name">
                                            重命名的抬头


                                        </div>
                                    </div>
                                    <div class="line2">
                                        <div class="price">
                                            ¥10万
                                        </div>
                                        <div class="want">3人想要</div>
                                        <div class="discount">
                                            9<text class="fonts">折</text>
                                        </div>
        </div>

                                    <div class="line3">
                                        
                                        <div class="t">品牌名称</div>
                                    </div>

                                    <img class="discount-icon"
                                        src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/remen_icon%402x.png" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
    </body>
    <script type="text/javascript">
        var id = "{{$id}}";
console.log("id=" + id)
    </script>

</html>