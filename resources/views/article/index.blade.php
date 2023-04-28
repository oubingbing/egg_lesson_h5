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
    <link rel="shortcut icon" href="{{asset('image/logo.png')}}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="{{asset('css/global.css')}}" rel="stylesheet">
    <link href="{{asset('css/tool/swiper-bundle.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/page/article/article_index.css')}}" rel="stylesheet">

    <!-- Styles -->
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/popup.js')}}"></script>
    <script src="{{asset('js/tool/loading.js')}}"></script>
    <script src="{{asset('js/tool/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('js/bottom_menu.js')}}"></script>
    <script src="{{asset('js/tool/http.js')}}"></script>
    <script src="{{asset('js/page/article/article_index.js')}}"></script>
    <script src="https://mapapi.qq.com/web/mapComponents/geoLocation/v/geolocation.min.js"></script>
    <script src="https://res2.wx.qq.com/open/js/jweixin-1.6.0.js"></script>
    <script src="{{asset('js/tool/wx.js')}}"></script>
    <script>
        var _hmt = _hmt || [];
        (function () {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?76d5019db85976241389e61a26a25473";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
</head>

<body>
    <div class="article-index-container">
        <!-- <img src="{{asset('image/pailie4.png')}}" style="position:absolute;top:1445px;left:0;width:100vw;"/> -->
        <div class="title-bar">
            <div class="back-btn" style="background-image:url({{asset('image/back_btn_black.png')}});"></div>
            阅读
        </div>

        <div class="search-bar">
            <div class="search-btn">搜索</div>
            <input type="text"  class="search-input" placeholder="搜索"/>
        </div>

        <div class="head-banner-box">
            <div class="banner"></div>
        </div>

        <div class="menu-nav">
            <div class="menu-btn hover">推荐</div>
            <div class="menu-btn">热门</div>
            <div class="menu-btn">最新</div>
            <div class="menu-btn">创意展览</div>
        </div>


        <div class="article-list-p">
            <div class="article-list">
                <div class="article-list-title">每日一读</div>
                <div class="articles">
                    <div class="item">
                        <div class="bg"></div>
                        <div class="name">如何成为一个程序员</div>
                        <div class="description">程序员的日常工作有哪些</div>
                    </div>
                    <div class="item">
                        <div class="bg"></div>
                        <div class="name">如何成为一个程序员</div>
                        <div class="description">程序员的日常工作有哪些</div>
                    </div>
                    <div class="item">
                        <div class="bg"></div>
                        <div class="name">如何成为一个程序员</div>
                        <div class="description">程序员的日常工作有哪些</div>
                    </div>
                </div>
            </div>
        </div>


        <div class="list2">
            <div class="article-list-title">最新文章</div>
            <div class="show-more">查看更多</div>
            <div class="items">
                <div class="item">
                    <div class="name">自然风光</div>
                </div>
                <div class="item">
                    <div class="name">自然风光</div>
                </div>
                <div class="item">
                    <div class="name">自然风光</div>
                </div>
                <div class="item">
                    <div class="name">自然风光</div>
                </div>
            </div>
        </div>

        <div class="list3 banner">
            <div class="article-list-title">热门推荐</div>
            <div class="show-more">查看更多</div>
            <div class="items">
                <div class="item">
                    <div class="name">百年孤独</div>
                </div>
            </div>
        </div>

        <div class="list4">
            <div class="article-list-title">热门推荐</div>
            <div class="show-more">查看更多</div>
            <div class="items">
                <div class="item">
                    <div class="thumbnail"></div>
                    <div class="created-at">2023-04-28</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>