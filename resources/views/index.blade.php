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
            input{
                outline: none;
    border: none;
    padding: 0;
    margin: 0;
    text-decoration: inherit;
            }
            html, body {
                -webkit-user-select: none;
    user-select: none;
    width: 100vw;
    height:100vh;
    margin:0;
    padding:0;
            }
            .page-index{

            }
            .page-header{
               position:relative;
               height:44px;
               text-align:center;
             line-height:44px;
            }
            .search-bar{
                width: 100%;
    padding: 0 1.25rem;
    display: flex;
    background-color: #FFF;
    box-sizing: border-box;
    align-items: center;
            }
            .search-bar .search-icon{
                width: 1.125rem;
    height: 1.125rem;
    object-fit: contain;
    display: block;
            }
            .search-bar .search-input{
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
            .search-bar .search-location{
                min-width: 4em;
    text-align: right;
    font-size: 0.8125rem;
    padding-right: 0.9375rem;
    position: relative;
            }
            .search-bar .search-location::after{
                position: absolute;
    content: '';
    right: 0;
    top: 50%;
    margin-top: -0.15625rem;
    border-top: 0.3125rem solid #2C405A;
    border-left: 0.3125rem solid transparent;
    border-right: 0.3125rem solid transparent;
            }
            .banner-swiper{
                margin-left: auto;
    margin-right: auto;
    width: 20.9375rem;
    height: 11.5625rem;
    position: relative;
    margin-top: 0.3125rem;
            }
            .banner-image{
                width:100%;
                background-color:#000;
                height: 11.5625rem;
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
                <div class="search-icon" style="background-image: url(&quot;https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/sousuo_icon%402x.png&quot;); background-position: 0% 0%; background-size: 100% 100%;"></div>
                    <input type="text" class="search-input" placeholder="搜索课程,品牌"/>
                    <div class="search-location">定位中</div>

             </div>
             <div class="banner-swiper">
                <div class="banner-image"></div>
                </div>
        </div>
       

    </body>
</html>
