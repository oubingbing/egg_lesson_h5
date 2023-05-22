<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="divport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="{{$article['seo_key_word']}}">
    <meta name="description" content="{{$article['seo_describe']}}">
    <title>{{$article['title']}}_{{$article['category_name']}}_旦旦转课网_全网首个课程转让交易平台</title>
    <!-- Fonts -->
    <link rel="shortcut icon" href="{{asset('image/logo.png')}}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="{{asset('css/global.css')}}" rel="stylesheet">
    <link href="{{asset('css/tool/swiper-bundle.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/page/article/detail.css')}}" rel="stylesheet">

    <!-- Styles -->
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/popup.js')}}"></script>
    <script src="{{asset('js/tool/loading.js')}}"></script>
    <script src="{{asset('js/tool/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('js/bottom_menu.js')}}"></script>
    <script src="{{asset('js/tool/http.js')}}"></script>
    <script src="{{asset('js/page/article/detail.js')}}"></script>
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

        function showArticleContent(){
            return;
            let content = `{{$article["content"]}}`;
            content = content.replace(/&lt;/g,"<");
            content = content.replace(/&gt;/g,">");
            content =  content.replace(/&quot;/g,`"`);
            console.log(content);
            document.getElementById("article_content").innerHTML =content;
        }

    </script>
</head>

<body onload="showArticleContent()">
    <div class="article-list-container">
    <div class="title-bar">
            <div class="back-btn" style="background-image:url({{asset('image/back_btn_black.png')}});" onclick="goBack()"></div>
            旦旦编辑部
        </div>

        <div class="breadcrumb">
            <a href="\\m.dandanzkw.com">首页</a><span>&nbsp;>&nbsp;</span>
            <a href="\\m.dandanzkw.com\article.html">{{$article["category_father_name"]}}</a><span>&nbsp;>&nbsp;</span>
            <a href="\\m.dandanzkw.com\article.html">{{$article["category_name"]}}</a><span>&nbsp;>&nbsp;</span>
            <a href="">{{$article["title"]}}</a><span></span>
        </div>

        <div class="article-content">
            <div class="article-title">{{$article["title"]}}</div>
            <div class="article-info">发布时间：{{$article["created_at"]}}&nbsp;&nbsp;&nbsp;&nbsp;浏览次数：{{$article['browse_num']}}</div>
            <div class="article-text" id="article_content">{!!$article["content"]!!}</div>
        </div>

        <div class="other-page">
            @if ($article['pre'] && $article['pre']['title'])
            <div class="btn"><span>上一篇：</span><a onclick="goTo('article_detail','id',{{$article['pre']['id']}})">{{$article['pre']['title']}}</a></div>
            @else
            <div class="btn"><span>上一篇：</span><a>没有了</a></div>
            @endif
            @if ($article['next'] && $article['next']['title'])
            <div class="btn"><span>下一篇：</span><a onclick="goTo('article_detail','id',{{$article['next']['id']}})">{{$article['next']['title']}}</a></div>
            @else
            <div class="btn"><span>下一篇：</span><a>没有了</a></div>
            @endif
        </div>

        <div class="tips">
        文章来源于网络，如有侵权请联系本站删除
        </div>

        <div class="article-list-p">
            <div class="article-list">
                <div class="article-list-title" id="list_1_title">相关推荐</div>
                <div class="swiper-container">
                <div class="articles swiper-wrapper" id="list_1_items">
                @if($article["same_list"])
                @foreach ($article["same_list"] as $item)
                <div class="item swiper-slide"  onclick="goTo('article_detail','id',{{$item['id']}})"><div class="bg" style="background-image:url('{{isset($item['attachments'][0])?$item['attachments'][0]:""}}')"></div>
                            <div class="name">{{$item['title']}}</div>
                            <div class="category">{{$item['category_name']}}</div>
                        </div>
                @endforeach
                @endif
                </div>
                </div>
            </div>
        </div>

        <div class="list4">
            <div class="article-list-title" id="list_4_title">更多推荐</div>
            <div class="show-more" onclick="goTo('article_list','category_id',
            @if ($article['category_father_id'])
            {{$article['category_father_id']}}
            @else
            {{$article['category_id']}}
            @endif
            )">查看更多</div>
            <div class="items" id="list_4_items">
                @if($article["more_list"])
            @foreach ($article["more_list"] as $item)
                <div class="item"  onclick="goTo('article_detail','id',{{$item['id']}})">
                    <div class="thumbnail" style="background-image:url('{{isset($item['attachments'][0])?$item['attachments'][0]:""}}')"></div>
                    <div class="info">
                        <div class="name">{{$item['title']}}</div>
                        <div class="category">{{$item['category_name']}}</div>
                        <div class="created-at">2023-04-28</div>
                    </div>

                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="default_article_list">
        @if($article["same_list"])
        @foreach ($article["same_list"] as $item)
        <a  href="https://m.dandanzkw.com/article/{{$item['id']}}.html">{{$item['title']}}_{{$item['category_name']}}</a>
        @endforeach
        @endif

        @if($article["more_list"])
        @foreach ($article["more_list"] as $item)
        <a  href="https://m.dandanzkw.com/article/{{$item['id']}}.html">{{$item['title']}}_{{$item['category_name']}}</a>
        @endforeach
        @endif
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
</body>

</html>
