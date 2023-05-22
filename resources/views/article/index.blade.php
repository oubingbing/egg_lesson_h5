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
    <link href="{{asset('css/tool/animate.css')}}" rel="stylesheet">

    <!-- Styles -->
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/popup.js')}}"></script>
    <script src="{{asset('js/tool/loading.js')}}"></script>
    <script src="{{asset('js/tool/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('js/bottom_menu.js')}}"></script>
    <script src="{{asset('js/tool/http.js')}}"></script>
    <script src="{{asset('js/moments.js')}}"></script>
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
    <div class="default_article_list" id="default_article_list">
        @if($top_article)
        @foreach ($top_article as $item)
        
        @foreach ($item['sub_category'] as $item_subca)
        @foreach ($item_subca['top_article'] as $item_sub_top)
        <a href="//m.dandanzkw.com/article/{{$item_sub_top['id']}}.html">{{$item_sub_top['title']}}_{{$item_sub_top['seo_key_word']}}_{{$item_sub_top['category_name']}}</a>
        @endforeach
        @endforeach

        @foreach ($item['top_article'] as $item_top)
        <a href="//m.dandanzkw.com/article/{{$item_top['id']}}.html">{{$item_top['title']}}_{{$item_top['seo_key_word']}}_{{$item_top['category_name']}}</a>
        @endforeach

        @endforeach
        @endif
    </div>
    <div class="article-index-container">
        <!-- <img src="{{asset('image/pailie4.png')}}" style="position:absolute;top:1445px;left:0;width:100vw;"/> -->
        <div class="title-bar">
            <div class="back-btn" style="background-image:url({{asset('image/back_btn_black.png')}});" onclick="goTo('index')"></div>
            旦旦编辑部
        </div>
        <div class="search-bg animate__fadeInDownBig">
        <div class="search-bar animate__bounceInLeft noshow">
        <div class="search-btn" style="background-image:url({{asset('image/search_btn.png')}})"></div>
            <input type="text"  class="search-input" placeholder="搜索" onclick="goTo('article_list','id',0)"/>
        </div>
        <div class="search-tips animate__backInDown noshow">有知识·有热度·有笑点</div>
    </div>
        <!-- <div class="head-banner-box mySwiper" >
<div class="swiper-wrapper head-banner" id="head_banner_box"></div>            
        </div> -->
<div class="menu-nav-box">
        <div class="menu-nav" id="menu_nav">
        </div>
    </div>

    


        <div class="article-list-p">
            <div class="article-list">
                <div class="article-list-title" id="list_1_title"></div>
                <div class="show-more" id="list_1_showmore">更多>></div>
                <div class="swiper-container articles-box">
                <div class="articles swiper-wrapper" id="list_1_items">

                </div>
            </div>
            </div>
        </div>


        <div class="list2">
            <div class="article-list-title" id="list_2_title"></div>
            <div class="show-more" id="list_2_showmore">更多>></div>
            <div class="items" id="list_2_items">
            </div>
        </div>

        <div class="list3 banner">
            <div class="article-list-title" id="list_3_title"></div>
            <div class="show-more" id="list_3_showmore">更多>></div>
            <div class="items mySwiper2" >
                <div class="swiper-wrapper" id="list_3_items"></div>
            </div>
        </div>

        <div class="list4">
            <div class="article-list-title" id="list_4_title"></div>
            <div class="show-more" id="list_4_showmore">更多>></div>
            <div class="items" id="list_4_items">
                
            </div>
        </div>

        <div class="tabbar">
            <div class="tabbar-item" id="tabbar1">
                <div class="tabbar-item-pic pre" style='background-image: url("{{asset('image/tabbar/shouye_shouye_nor_icon.png')}}");'></div>
                <div class="tabbar-item-name">首页</div>
            </div>
            <div class="tabbar-item" id="dandaneditor">
                <div class="tabbar-item-pic nor" style='background-image: url("{{asset('image/tabbar/shouye_editor_pre_icon.png')}}");'></div>
                <div class="tabbar-item-name">编辑部</div>
            </div>
            <div class="tabbar-item" id="tabbar2">
                <div class="tabbar-publish">
                <div class="tabbar-publish-icon" style='background-image: url("{{asset('image/tabbar/shouye_fabu_pre_icon.png')}}");'></div>
            </div>
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

        <div class="footer">
        <p style="padding:0 10px;">
            <a href="https://m.dandanzkw.com/" >首页</a> |
            <a href="https://m.dandanzkw.com/search/3.html" >舞蹈培训</a> |
            <a href="https://m.dandanzkw.com/search/7.html" >瑜伽健身</a> |
             <a href="https://m.dandanzkw.com/search/1.html" >早教亲子</a> |
             <a href="https://m.dandanzkw.com/search/2.html" >英语培训</a>|
             <a href="https://m.dandanzkw.com/search/4.html">器乐文艺</a> |
             <a href="https://m.dandanzkw.com/search/5.html">语种培训</a> |
             <a href="https://m.dandanzkw.com/search/6.html" >体育竞技</a> |
             <a href="https://m.dandanzkw.com/search/8.html" >Steam</a> |
             <a href="https://m.dandanzkw.com/search/10.html" >职业教育</a> |
             <a href="https://m.dandanzkw.com/article.html" >旦旦编辑部</a> |
             <a href="https://www.dandanzkw.com/aboutus/" >关于我们</a> |
             <a href="https://www.dandanzkw.com/yinsi/">注册条例</a> |
             <a href="https://www.dandanzkw.com/kechengleibie/">课程类别说明 </a>|
             <a href="https://www.dandanzkw.com/kechengfabu/" >课程发布条例</a> |
             <a href="https://www.dandanzkw.com/cooperate/" >联系我们 </a> |
             <a href="https://m.dandanzkw.com/sitemap.xml">网站地图 </a>
             </p>
        <div class="authentication">
            <div style="margin:0px auto;padding: 2px;">
                <a target="_blank" href="https://beian.miit.gov.cn" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;"><img src="{{asset('image/www_beian_gov_cn.png')}}" style="float:left; width: 20px; height: 20px;"><p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;">粤ICP备2021068181号-1</p></a>
            </div>
        </div>
        <div style="width:100%;font-size:12px;margin:0px auto;" class="f_copyright">
            <span>深圳市吉飞旦达科技有限公司 版权所有<a href="https://beian.miit.gov.cn/" target="_blank"></a><br>Copyright(C)2020-2023 dandanzkw.com All Rights Reserved.</span>
        </div>
    
        <p class="copyright-box">
            
            <a class="copyright copyright-3" href="http://www.cyberpolice.cn" target="_blank" rel="noopener noreferrer">
              网络警察提醒你
            </a>
            
            <a class="copyright copyright-5" href="http://www.12377.cn/" target="_blank" rel="noopener noreferrer">
              中国互联网举报中心
            </a>
            
            <a class="copyright copyright-7" href="http://www.shdf.gov.cn/shdf/channels/740.html" target="_blank" rel="noopener noreferrer">
              扫黄打非网举报专区
            </a>
            
            <a class="copyright copyright-9" href="http://ggfw.cnipa.gov.cn:8010/PatentCMS_Center?fromsite=www.jd.com" target="_blank" rel="noopener noreferrer">
              国家知识产权公共服务网
            </a>
          </p>
    </div>
    </div>
    
</body>

</html>