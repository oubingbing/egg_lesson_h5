<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="divport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>旦旦转课</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="{{asset('css/global.css')}}" rel="stylesheet">

    <!-- Styles -->
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/popup.js')}}"></script>
    <script src="{{asset('js/bottom_menu.js')}}"></script>
    <script>
        //逻辑代码
        let test_fenlei = [{id:1,name:"早教亲子"},{id:2,name:"英语培训"},{id:3,name:"日语培训"}];
        test_fenlei = [{id:0,name:"全部"}].concat(test_fenlei);
        $(document).ready(()=>{
            for(let i in test_fenlei){
                console.log(i,i==0);
                let select_nav_item = document.createElement("div");
                select_nav_item.innerHTML=test_fenlei[i].name;
                select_nav_item.className="select-nav-item";
                select_nav_item.id=`selectNavItem_${test_fenlei[i].id}`;
                if(i==0){
                    select_nav_item.className="select-nav-item hover";

                }                
                $(".select-nav-items").append(select_nav_item);
            }
         
        //     for(let i=1;i<=4;i++){
        //         if(i>1){
        //             $("#tabbar"+i+" .pre").hide();
        //                 $("#tabbar"+i+" .nor").show();
        //         }else{
        //             $("#tabbar"+i+" .pre").show();
        //                 $("#tabbar"+i+" .nor").hide();
        //         }
        //         $("#tabbar"+i).click(()=>{
        //             for(let j=1;j<=4;j++){
        //                 if(j===i){
        //                     $("#tabbar"+j+" .pre").show();
        //             $("#tabbar"+j+" .nor").hide();
        //                     continue;
        //                 }
        //                 $("#tabbar"+j+" .pre").hide();
        //                 $("#tabbar"+j+" .nor").show();
        //             }
                   
        // })
        //     }

            $("#searchInput").keyup((e)=>{
                if(e.keyCode=="13"){                    
                    let searchInput = $("#searchInput").val();
                    sessionStorage.setItem("searchInput",searchInput);
                    window.open(window.location.href+"searchlist/"+searchInput);
                }
            })
            
       

        
        })
        
    </script>
    <style>
        input {
            outline: none;
            border: none;
            padding: 0;
            margin: 0;
            text-decoration: inherit;
        }

        

        .page-index {
            width:100vw;
            height:100vh;
            overflow-x: hidden;
            overflow-y: scroll;
            position: relative;
        }

        .page-header {
            position: relative;
            height: 44px;
            text-align: center;
            line-height: 44px;
        }

        .search-bar {
            width: 100%;
            padding: 0 1.25rem;
            display: flex;
            background-color: #FFF;
            box-sizing: border-box;
            align-items: center;
        }

        .search-bar .search-icon {
            width: 1.125rem;
            height: 1.125rem;
            object-fit: contain;
            display: block;
        }

        .search-bar .search-input {
            flex: 1;
            font-size: 0.8125rem;
            padding-left: 0.5rem;
            position: relative;

            display: block;
            height: 100%;
            background: none;
            color: inherit;
            opacity: 1;
            font: inherit;
            line-height: inherit;
            letter-spacing: inherit;
            text-align: inherit;
            text-indent: inherit;
            text-transform: inherit;
            text-shadow: inherit;
        }

        .search-bar .search-input::placeholder{
            font-size:0.8125rem;
        }

        .search-bar .search-location {
            min-width: 4em;
            text-align: right;
            font-size: 0.8125rem;
            padding-right: 0.9375rem;
            position: relative;
        }

        .search-bar .search-location::after {
            position: absolute;
            content: '';
            right: 0;
            top: 50%;
            margin-top: -0.15625rem;
            border-top: 0.3125rem solid #2C405A;
            border-left: 0.3125rem solid transparent;
            border-right: 0.3125rem solid transparent;
        }

        .banner-swiper-box {
            background-color: #fff;
            padding-top: 0.75rem;
            overflow: hidden;
        }

        .banner-swiper {
            margin-left: auto;
            margin-right: auto;
            width: 20.9375rem;
            height: 11.5625rem;
            position: relative;
            margin-top: 0.3125rem;
        }

        .banner-image {
            width: 100%;
            background-color: #000;
            height: 11.5625rem;
        }

        .type-list {
            border-bottom: 0.625rem solid #F5F7FA;
            background-color: #FFF;
            padding: 1.25rem 0;
            overflow-x: scroll;
            white-space: nowrap;
            width: 23.4375rem;
        }

        .type-list .item {
            vertical-align: middle;
            margin-left: 1.25rem;
            margin-right: 0.625rem;
            display: inline-flex;
            flex-direction: column;
            align-items: center;
        }

        .type-list .item .item-icon-box {
            width: 3.125rem;
            height: 3.125rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-image: linear-gradient(#FF9090, #FF5252);
        }

        .item-icon-box .item-icon {
            width: 60%;
            height: 60%;
            object-fit: contain;
        }

        .type-list .item .item-name {
            font-size: 0.75rem;
            color: #595959;
            line-height: 1;
            margin-top: 0.84375rem;
        }

        .purchase {
            background-color: #fff;
            height: 2.5rem;
            border-bottom: 0.1875rem solid #F5F7FA;
            display: flex;
            align-items: center;
            padding-left: 1.25rem;
            overflow: hidden;
        }

        .purchase .icon {
            width: 1.46875rem;
            height: 0.9375rem;
        }

        .purchase .names-box {
            height: 2.25rem;
            margin-left: 0.90625rem;
            overflow: hidden;
        }

        .purchase .names-box .names {
            animation: purchase 45s linear infinite;
        }

        .purchase .names-box .names .name {
            margin: 0.75rem auto;
            height: 2.25rem;
            line-height: 2.25rem;
            white-space: nowrap;
            color: #FF554C;
            font-size: 0.75rem;
        }

        @keyframes purchase {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-720px);
            }
        }

        .brands {
            padding: 20px 0 28px 0;
            background-color: #FFF;
            border-bottom: 10px solid #F5F7FA;
        }

        .hot-packages {
            padding: 1.25rem 0.9375rem 1.75rem 1.25rem;
            background-color: #FFF;
            border-bottom: 0.625rem solid #F5F7FA;
        }

        .hot-packages .title,
        .new-things .title,
        .brands .title {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brands .title {
            padding: 0 20px 15px 20px;
        }

        .new-things .title .left,
        .brands .title .left {
            color: #333;
            font-size: 1rem;
            font-family: DanDanFont;
            font-weight: bold;
            line-height: 1;
        }

        .hot-packages .title .left {
            font-size: 1rem;
            font-family: DanDanFont;
            font-weight: bold;
            color: #333333;
            line-height: 1;
            margin-bottom: 0.90625rem;
        }

        .hot-packages .title .right,
        .new-things .title .right,
        .brands .title .right {
            color: #808080;
            font-size: 3.2vw;
            line-height: 1;
            display: flex;
            align-items: center;
        }

        .more {
            line-height: 1;
            margin-right: 1.86vw;
        }

        .hot-packages .title .right .arrow-right,
        .new-things .title .right .arrow-right,
        .brands .title .right .arrow-right {
            transform: scaleY(0.8) scaleX(1.6);
            margin-left: 1.87vw;
            line-height: 1;

            display: inline-block;
            vertical-align: middle;
        }

        .hot-packages .select-nav {
            margin-bottom: 2.67vw;
            width: 100vw;
            margin-left: -5.33vw;
            padding: 0 2.67vw 1.33vw 2.67vw;
            box-sizing: border-box;
            position: sticky;
            top: 0;
            background-color: #fff;
            z-index: 2;
            overflow-x:scroll;
            overflow-y: hidden;

        }

        .hot-packages .select-nav .select-nav-items {
            white-space: nowrap;

        }

        .hot-packages .select-nav .select-nav-item {
            font-size: 0.75rem;
            font-family: DanDanFont;
            font-weight: 500;
            color: #808080;
            margin-right: 1.875rem;
            width: 3.125rem;
            display: inline-block;
            text-align: center;
            position: relative;
            padding-bottom: 0.5rem;
            transition: 0.3s;
        }

        .hot-packages .select-nav .select-nav-item.hover {
            color: #333;
            font-weight: bold;
        }

        .hot-packages .select-nav .select-nav-item::after {
            position: absolute;
            content: '';
            width: 2.13vw;
            bottom: 0;
            left: 50%;
            margin-left: -2.13vw;
            height: 0.53vw;
            background: transparent;
            border-radius: 0.26vw;
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
            margin-top: 1.33vw;
            margin-right: 1.33vw;
            width: 44vw;
            border-radius: 1.06vw;
            box-shadow: 0px 0.26vw 4vw 0px rgba(48, 50, 51, 0.1);
            overflow: hidden;
            display: inline-block;
            vertical-align: top;
            word-break: break-all;
        }

        .hot-packages .item .tag {
            width: 13.33vw;
            height: 2.13vw;
            background: rgba(255, 82, 82, 0.2);
            border-radius: 2.13vw;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.67vw;
            font-family: DanDanFont;
            font-weight: 500;
            color: #FF5656;
            vertical-align: middle;

        }



        .hot-packages .item .thumbnail {
            width: 100%;
            height: 40vw;
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
            width: 5.46vw;
            height: 5.46vw;
            border-radius: 50%;
        }

        .hot-packages .item .info-box .name {
            font-size: 3.2vw;
            font-family: DanDanFont;
            font-weight: bold;
            color: #FFFFFF;
            line-height: 1;
            margin-right: 2.26vw;
        }

        .hot-packages .item .info-box .status {
            font-size: 2.67vw;
            font-family: DanDanFont;
            font-weight: bold;
            color: #FFFFFF;
            line-height: 1;
        }

        .hot-packages .item .position-box {
            margin-top: -7.46vw;
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
            font-size: 2.93vw;
            font-family: DanDanFont;
            font-weight: bold;
            color: #FFFFFF;
            margin-right: 3.6vw;
            line-height: 1;
        }

        .hot-packages .item .position-box .distance {
            font-size: 2.93vw;
            font-family: DanDanFont;
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
            font-family: DanDanFont;
            font-weight: 500;
            color: #808080;
            margin-bottom: 1.73vw;
            line-height: 2.93vw;
        }

        .hot-packages .item .infos {
            padding: 0 2.13vw;
        }

        .hot-packages .item .infos .name {
            font-size: 3.73vw;
            font-family: DanDanFont;
            display: inline;
            font-weight: bold;
            color: #333333;
            line-height: 5.6vw;
        }

        .hot-packages .item .line2 {
            margin-top: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .hot-packages .item .line2 .price {
            font-size: 3.73vw;
            font-family: DanDanFont;
            font-weight: bold;
            color: #FF5252;
            line-height: 6.4vw;

        }

        .hot-packages .item .line2 .want {
            font-size: 2.67vw;
            font-family: DanDanFont;
            font-weight: 500;
            color: #808080;
            line-height: 6.4vw;
        }

        .hot-packages .item .line2 .discount {
            font-size: 3.73vw;
            font-family: DanDanFont;
            font-weight: bold;
            color: #FF5252;
            line-height: 6.4vw;
        }

        .hot-packages .item .line2 .discount .fonts {
            font-size: 2.67vw;

        }



        .hot-packages .item .infos .discount-icon {
            display: none;
            width: 4.53vw;
            height: 4.8vw;
            object-fit: contain;
            position: absolute;
            right: 0;
            bottom: 0.8vw;
        }

        .new-things .items {
            margin-top: 4vw;
            height: 46.66vw;
        }

        .new-things .items .item {
            width: 80VW;
            height: 45.33vw;
            background: #FFFFFF;
            border: 0.26vw solid #F0F1F5;
            border-radius: 2.13vw;
            margin-right: 4vw;
            overflow: hidden;

            margin-bottom: 4vw;
            position: relative;

        }

        .new-things .items .item .logo-left-top {
            width: 40vw;
            z-index: 0;
            height: 40vw;
            position: absolute;
            border-radius: 50%;
            top: -18vw;
            left: -18vw;
        }

        .new-things .items .item .t1 {
            top: 3.2vw;
            left: 4vw;
            color: #FFF;
            font-size: 8vw;
            position: absolute;
        }

        .new-things .items .item .t2 {
            position: relative;
            margin: 70rpx 2.67vw 1.33vw;
            font-size: 3.73vw;
            font-family: DanDanFont;
            font-weight: 500;
            color: #333333;
            line-height: 4.8vw;
        }

        .new-things .items .item .t3 {

            width: 77vw;
            margin-left: 2.67vw;
            font-size: 3.46vw;
            font-family: DanDanFont;
            font-weight: 400;
            color: #808080;
            position: relative;
            line-height: 5.86vw;
            white-space: normal;
        }

        .new-things .items .item .bottom-infos {
            border-top: 0.26vw solid #F0F2F5;
            padding: 0 4vw;
            box-sizing: border-box;
            height: 13.33vw;
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .new-things .items .item .bottom-infos>.text {
            font-size: 3.2vw;
            font-family: DanDanFont;
            font-weight: 400;
            color: #FF5252;
            line-height: 4.8vw;
            margin-right: 8vw;
            white-space: nowrap;
        }



        .new-things .items .item .logo-left-top.blue {
            background-color: #5197FF;
        }

        .new-things .items .item .logo-left-top.red {
            background-color: #FF5151;
        }

        .brands .items {
            position: relative;
        }

        .brands .items .item {
            display: inline-block;
            vertical-align: top;
            margin-top: 9.73vw;
            position: relative;
            margin-right: 2.67vw;
            width: 13.6vw;
            margin-left: 2.67vw;
        }

        .brands .items .item .logo {
            position: absolute;
            border-radius: 0.53vw;
            overflow: hidden;
            left: 50%;
            margin-left: -6.4vw;
            top: -6.4vw;
            z-index: 1;

            display: flex;
            align-items: center;
            justify-content: center;
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            width: 12vw;
            height: 12vw;
        }

        .brands .items .item .logo .logo-img {
            width: 12vw;
            height: 12vw;
        }

        .brands .items .item .name {
            margin: 7.73vw auto 0;
            text-align: center;
            font-size: 3.2vw;
            font-family: DanDanFont;
            font-weight: 100;
            color: #333333;
            line-height: 4.8vw;

        }

        .brands .items .item .desc {
            width: 20vw;
            margin: 1.46vw auto 0;
            font-size: 3.2vw;
            font-family: DanDanFont;
            font-weight: 400;
            color: #808080;
            line-height: 4.8vw;


            word-break: break-all;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        
    </style>
</head>

<body>
    <!-- <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Docs{{$goods}}</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div> -->
    <div class="page-index">
        <div class="page-header">旦旦转课网</div>
        <div class="search-bar">
            <div class="search-icon"
                style="background-image: url(&quot;https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/sousuo_icon%402x.png&quot;); background-position: 0% 0%; background-size: 100% 100%;">
            </div>
            <input type="text" class="search-input" placeholder="搜索课程,品牌" id="searchInput" />
            <div class="search-location">定位中</div>

        </div>
        <div class="banner-swiper-box">
            <div class="banner-swiper">
                <div class="banner-image"></div>
            </div>
        </div>

        <div class="type-list">
            <div class="item">
                <div class="item-icon-box">
                    <div class="item-icon"
                        style='background-image: url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/shouye_zaojiaoz_icon%402x.png"); background-position: 0% 0%; background-size: 100% 100%;'>
                    </div>
                </div>
                <div class="item-name">早教亲子</div>

            </div>
            <div class="item">
                <div class="item-icon-box">
                    <div class="item-icon"
                        style='background-image: url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/shouye_zaojiaoz_icon%402x.png"); background-position: 0% 0%; background-size: 100% 100%;'>
                    </div>
                </div>
                <div class="item-name">早教亲子</div>

            </div>
            <div class="item">
                <div class="item-icon-box">
                    <div class="item-icon"
                        style='background-image: url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/shouye_zaojiaoz_icon%402x.png"); background-position: 0% 0%; background-size: 100% 100%;'>
                    </div>
                </div>
                <div class="item-name">早教亲子</div>

            </div>

            <div class="item">
                <div class="item-icon-box">
                    <div class="item-icon"
                        style='background-image: url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/shouye_zaojiaoz_icon%402x.png"); background-position: 0% 0%; background-size: 100% 100%;'>
                    </div>
                </div>
                <div class="item-name">早教亲子</div>

            </div>

            <div class="item">
                <div class="item-icon-box">
                    <div class="item-icon"
                        style='background-image: url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/shouye_zaojiaoz_icon%402x.png"); background-position: 0% 0%; background-size: 100% 100%;'>
                    </div>
                </div>
                <div class="item-name">早教亲子</div>

            </div>

            <div class="item">
                <div class="item-icon-box">
                    <div class="item-icon"
                        style='background-image: url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/shouye_zaojiaoz_icon%402x.png"); background-position: 0% 0%; background-size: 100% 100%;'>
                    </div>
                </div>
                <div class="item-name">早教亲子</div>

            </div>

        </div>

        <div class="purchase">
            <div class="icon" style='background-image: url("{{asset('../image/shouye_laba_icon.png')}}");
                background-position: center center; background-size: cover;'>
            </div>
            <div class="names-box">
                <div class="names">
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                </div>
            </div>
        </div>



        <div class="brands">
            <div class="title">
                <div class="left">品牌专区
                </div>

            </div>

            <div class="items">
                <!-- <div v-for="item in brands" :key="item.id" class="item" @click="goTo('search',item.name)"> -->
                <div class="item">
                    <div class="logo"
                        style='background-image:url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/brands/jswudao.jpg");'>
                    </div>
                    <div class="name">JS舞蹈</div>
                    <div class="desc"></div>
                </div>

                <div class="item">
                    <div class="logo"
                        style='background-image:url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/brands/jswudao.jpg")'>
                    </div>
                    <div class="name">JS舞蹈</div>
                    <div class="desc"></div>
                </div>

                <div class="item">
                    <div class="logo"
                        style='background-image:url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/brands/jswudao.jpg")'>
                    </div>
                    <div class="name">JS舞蹈</div>
                    <div class="desc"></div>
                </div>

                <div class="item">
                    <div class="logo"
                        style='background-image:url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/brands/jswudao.jpg")'>
                    </div>
                    <div class="name">JS舞蹈</div>
                    <div class="desc"></div>
                </div>

                <div class="item">
                    <div class="logo"
                        style='background-image:url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/brands/jswudao.jpg")'>
                    </div>
                    <div class="name">JS舞蹈</div>
                    <div class="desc"></div>
                </div>

                <div class="item">
                    <div class="logo"
                        style='background-image:url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/brands/jswudao.jpg")'>
                    </div>
                    <div class="name">JS舞蹈</div>
                    <div class="desc"></div>
                </div>


            </div>
        </div>

        <div class="hot-packages">
            <div class="title">
                <div class="left">推荐课包</div>
            </div>
            <div class="select-nav">
                <div class="select-nav-items">
                    
                </div>

            </div>
            <div class="items">
                <div class="items-left">
                    <div class="items-left-infos">
                        <div class="item">
                            <div class="thumbnail" style="background-image: url('https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/transfer_info/tmp_e6e5ebc46269e177e52c8f052eff529b.png'); background-position: center center; background-size: cover;"></div>
                            <div class="position-box">
                                <div class="icon" style='background-image: url("image/dingwei_icon.png"); background-position: center center; background-size: cover;''></div>
                                <div class="address">浙江省杭州市上城区</div>
                                <div class="distance"></div>
                            </div>
                            <div class="infos">
                                <div class="line1">
                                    <div class="tag">卖家自转</div>
                                    <div class="name">【年卡 |教练班】舞蹈学校教练班转让</div>
                                </div>
                                <div class="line2">
                                    <div class="price"> ¥10000</div>
                                    <div class="want">0人想要</div>
                                    <div class="discount">5.3<span class="fonts">折</span></div>
                                    
                                </div>
                                <div class="line3">
                                    <div class="t">戴斯尔舞蹈学院</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="tabbar">
        <div class="tabbar-item" id="tabbar1">
            <div class="tabbar-item-pic pre" style='background-image: url("{{asset('../image/tabbar/shouye_shouye_pre_icon.png')}}");'></div>
            <div class="tabbar-item-name">首页</div>
        </div>
        <div class="tabbar-item" id="tabbar2">
            <div class="tabbar-item-pic nor" style='background-image: url("{{asset('../image/tabbar/shouye_fabu_nor_icon.png')}}");'></div>
            <div class="tabbar-item-name">发布</div>
        </div>
        <div class="tabbar-item" id="tabbar3">
            <div class="tabbar-item-pic nor" style='background-image: url("{{asset('../image/tabbar/shouye_xiaoxi_nor_icon.png')}}");'></div>
            <div class="tabbar-item-name">消息</div>
        </div>
        <div class="tabbar-item" id="tabbar4">
            <div class="tabbar-item-pic nor" style='background-image: url("{{asset('../image/tabbar/shouye_wode_nor_icon.png')}}");'></div>
            <div class="tabbar-item-name">我的</div>
        </div>
    </div>


</body>

</html>