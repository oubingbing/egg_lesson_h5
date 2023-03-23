<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>旦旦转课</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        input {
            outline: none;
            border: none;
            padding: 0;
            margin: 0;
            text-decoration: inherit;
        }

        html,
        body {
            -webkit-user-select: none;
            user-select: none;
            width: 100vw;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .page-index {}

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
            <input type="text" class="search-input" placeholder="搜索课程,品牌" />
            <div class="search-location">定位中</div>

        </div>
        <div class="banner-swiper">
            <div class="banner-image"></div>
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
            <div class="icon"
                style="background-image: url('/static/image/shouye_laba_icon.png'); background-position: center center; background-size: cover;">
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
    </div>


</body>

</html>