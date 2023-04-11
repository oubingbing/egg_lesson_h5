<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="divport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="早教课转让,舞蹈课转让,健身卡转让,艺术课转让,钢琴课转让,英语课转让,瑜伽课转让,武术课转让">  
    <meta name="description" content="旦旦转课网是全网首个课程转让交易平台,基于教培行业学费贵、退费难的现状,为用户提供一站式课程转让交易服务。"> 
    <title>旦旦转课网_全网首个课程转让交易平台</title>  
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="{{asset('css/global.css')}}" rel="stylesheet">
    <link href="{{asset('css/tool/swiper-bundle.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/page/index.css')}}" rel="stylesheet">

    <!-- Styles -->
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/popup.js')}}"></script>
    <script src="{{asset('js/tool/loading.js')}}"></script>
    <script src="{{asset('js/tool/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('js/bottom_menu.js')}}"></script>
    <script src="{{asset('js/tool/http.js')}}"></script>
    <script src="{{asset('js/page/index.js')}}"></script>
    <script src="https://mapapi.qq.com/web/mapComponents/geoLocation/v/geolocation.min.js"></script>
    <script>
       

    </script>
</head>

<body>
    <div class="page-index">
        <div class="page-header">旦旦转课网</div>
        <div class="search-bar">
            <div class="search-icon"
                style="background-image: url(&quot;https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/sousuo_icon%402x.png&quot;); background-position: 0% 0%; background-size: 100% 100%;">
            </div>
            <input type="text" class="search-input" placeholder="搜索课程,品牌" id="searchInput" />
            <div class="search-location" id="currentLocation">定位中</div>

        </div>
        <div class="banner-swiper-box mySwiper">
            <div class="banner-swiper swiper-wrapper" id="banners">

            </div>
        </div>

        <div class="type-list" id="lesson_categorys">
           
        </div>

        <div class="purchase">
            <div class="icon" style='background-image: url("{{asset('image/shouye_laba_icon.png')}}");
                background-position: center center; background-size: cover;'>
            </div>
            <div class="names-box">
                <div class="names" id="purchase_logs">

                </div>
            </div>
        </div>



        <!-- <div class="brands">
            <div class="title">
                <div class="left">品牌专区
                </div>

            </div>

            <div class="items" id="brands">

            </div>
        </div> -->

        <div class="hot-goods">
            <div class="title">
                <div class="left">热门推荐</div>
            </div>
            <div class="select-nav">
                <div class="select-nav-items">

                </div>

            </div>
            <div class="items">
                <div class="items-left">
                    <div class="items-left-infos" id="goods_left">
                        
                    </div>
                </div>
                <div class="items-right">
                    <div class="items-right-infos" id="goods_right">
                        
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="tabbar">
        <div class="tabbar-item" id="tabbar1">
            <div class="tabbar-item-pic pre" style='background-image: url("{{asset('image/tabbar/shouye_shouye_pre_icon.png')}}");'></div>
            <div class="tabbar-item-name">首页</div>
        </div>
        <div class="tabbar-item" id="tabbar2">
            <div class="tabbar-item-pic nor" style='background-image: url("{{asset('image/tabbar/shouye_fabu_nor_icon.png')}}");'></div>
            <div class="tabbar-item-name">发布</div>
        </div>
        <div class="tabbar-item" id="tabbar3">
            <div class="tabbar-item-pic nor" style='background-image: url("{{asset('image/tabbar/shouye_xiaoxi_nor_icon.png')}}");'></div>
            <div class="tabbar-item-name">消息</div>
        </div>
        <div class="tabbar-item" id="tabbar4">
            <div class="tabbar-item-pic nor" style='background-image: url("{{asset('image/tabbar/shouye_wode_nor_icon.png')}}");'></div>
            <div class="tabbar-item-name">我的</div>
        </div>
    </div>


</body>

</html>