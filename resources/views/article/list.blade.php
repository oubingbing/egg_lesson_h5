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
    <link href="{{asset('css/page/article/list.css')}}" rel="stylesheet">
    <link href="{{asset('css/tool/animate.css')}}" rel="stylesheet">

    <!-- Styles -->
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/popup.js')}}"></script>
    <script src="{{asset('js/tool/loading.js')}}"></script>
    <script src="{{asset('js/tool/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('js/bottom_menu.js')}}"></script>
    <script src="{{asset('js/tool/http.js')}}"></script>
    <script src="{{asset('js/page/article/list.js')}}"></script>
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
    <div class="default_article_list" id="default_article_list"></div>
    <div class="article-list-container">
    <div class="title-bar">
            <div class="back-btn" style="background-image:url({{asset('image/back_btn_black.png')}});" onclick="goTo('article_index')"></div>
            旦旦编辑部
        </div>

        <div class="search-bg animate__fadeInDownBig">
        <div class="search-bar animate__bounceInLeft noshow">
            <div class="search-btn" style="background-image:url({{asset('image/search_btn.png')}})"></div>
            <input type="text"  class="search-input" placeholder="搜索" id="searchInput"/>
            
        </div>
        <div class="search-tips animate__backInDown noshow">有知识·有热度·有笑点</div>
    </div>
    <div class="breadcrumb">
    <a href="\\m.dandanzkw.com">首页</a><span>&nbsp;>&nbsp;</span>
            <a href="\\m.dandanzkw.com\article.html">旦旦编辑部</a><span>&nbsp;>&nbsp;</span>
            <a href="">文章列表</a><span></span>
    </div>
        <div class="items" id="articleList">
        
    </div>

    <div class="footer">
        <p style="padding:0 10px;">
            <a href="https://m.dandanzkw.com/" >首页</a> |
            <a href="https://m.dandanzkw.com/search?category_id=3" >舞蹈培训</a> |
            <a href="https://m.dandanzkw.com/search?category_id=7" >瑜伽健身</a> |
             <a href="https://m.dandanzkw.com/search?category_id=1" >早教亲子</a> |
             <a href="https://m.dandanzkw.com/search?category_id=2" >英语培训</a>|
             <a href="https://m.dandanzkw.com/search?category_id=4" >器乐文艺</a> |
             <a href="https://m.dandanzkw.com/search?category_id=5" >语种培训</a> |
             <a href="https://m.dandanzkw.com/search?category_id=6" >体育竞技</a> |
             <a href="https://m.dandanzkw.com/search?category_id=8" >Steam</a> |
             <a href="https://m.dandanzkw.com/search?category_id=10" >职业教育</a> |
             <a href="https://www.dandanzkw.com/aboutus/" >关于我们</a> |
             <a href="https://www.dandanzkw.com/yinsi/">注册条例</a> |
             <a href="https://www.dandanzkw.com/kechengleibie/">课程类别说明 </a>|
             <a href="https://www.dandanzkw.com/kechengfabu/" >课程发布条例</a> |
             <a href="https://www.dandanzkw.com/cooperate/" >联系我们 </a>
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