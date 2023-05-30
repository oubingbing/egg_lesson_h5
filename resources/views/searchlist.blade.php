<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="divport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @if ($category_name)
        @switch ($category_id)
        @case (7)
        <meta name="keywords" content="二手健身卡,健身卡,瑜伽卡,二手瑜伽卡,健身卡信息,瑜伽卡信息,健身卡平台,瑜伽卡平台,课程转让平台,便宜健身卡,便宜瑜伽卡">
        <meta name="description" content="在旦旦转课网，您可以找到二手健身卡和瑜伽卡的转让信息。我们提供真实有效的健身卡和瑜伽卡转让信息，帮助您以更低的价格享受高质量的课程。快来旦旦转课网寻找适合自己的健身卡或瑜伽卡吧！">
        @break
        @case (3)
        <meta name="keywords" content="二手舞蹈卡,舞蹈课转卡,舞蹈课转卡费,舞蹈课信息,舞蹈课平台,舞蹈卡怎么转出去,课程转让平台">
        <meta name="description" content="在旦旦转课网，您可以找到二手舞蹈卡的转让信息，了解如何将舞蹈卡转出去、舞蹈课转卡费用等相关信息。我们提供真实有效的舞蹈课转让信息，帮助您以更低的价格享受高质量的舞蹈课程。快来舞蹈课转让平台上寻找适合自己的舞蹈卡吧！">
        @break
        @case (1)
        <meta name="keywords" content="早教课转让信息,早教课转让平台,二手游泳卡,滑轮课,儿童兴趣课,课程转让平台,二手早教课">
        <meta name="description" content="在旦旦转课网，您可以方便地找到各种早教课程、游泳卡、滑轮课和儿童兴趣课的转让信息。我们提供真实有效的课程转让服务，帮助您以更低的价格享受高质量的课程。快来旦旦转课网寻找适合自己的课程吧！">
        @break
        @case (2)
        <meta name="keywords" content="英语课,英语课转让,二手英语课,便宜英语课,课程转让平台">
        <meta name="description" content="在旦旦转课网，您可以找到二手英语课的转让信息，也可以发布自己的英语课转让信息。我们提供真实有效的英语课转让平台和课程转让平台，帮助您以更低的价格享受高质量的英语课程。快来旦旦转课网寻找适合自己的英语课程吧！">
        @break
        @case (4)
        <meta name="keywords" content="美术课,绘画课,艺术课,音乐课,课程平台,便宜美术课,低价绘画课">
        <meta name="description" content="在旦旦转课网，您可以找到便宜的美术、绘画、艺术和音乐课程的转让信息。我们提供真实有效的课程，帮助您以更低的价格享受高质量的课程。无论您是想学习绘画、音乐还是其他艺术课程，快来旦旦转课网寻找适合自己的低价课程吧！">
        @break
        @case (5)
        <meta name="keywords" content="日语课,法语课程,德语课程,葡萄牙语课程,韩语课程,俄语课程,小语种课程">
        <meta name="description" content="在旦旦转课网，我们提供丰富多样的小语种课程转让服务，包括日语、法语、德语、葡萄牙语、韩语、俄语和其他小语种课程，我们提供真实有效的小语种课程，帮助您以更低的价格享受高质量的小语种课程。快来旦旦转课网寻找适合自己的小语种课程吧！">
        @break
        @case (10)
        <meta name="keywords" content="美容课程,美发课程,机修课程,计算机课程,挖掘机课程,装载机课程,面点课程,西点课程,烘焙课程,课程转让平台,职业教育课程">
        <meta name="description" content="在旦旦转课网，我们提供丰富多样的职业教育课程转让服务，包括美容美发、机修、计算机、面点、烘焙、西点和其他职业教育课程，我们提供真实有效的职教课程，帮助您以更低的价格享受高质量的职教课程。快来旦旦转课网寻找适合自己的职教课程吧！">
        @break
        @case (8)
        <meta name="keywords" content="少儿编程课程,乐高机器人课程,科学实验课程,工程实践课程,手工艺术DIY课程,课程转让平台">
        <meta name="description" content="在旦旦转课网，我们提供丰富多样的STEAM课程转让服务，包括少儿编程、乐高机器人、科学实验、工程实践、手工DIY,我们提供真实有效的STEAM课程，也能帮助您以更低的价格享受高质量的STEAM课程。快来旦旦转课网寻找适合自己的STEAM课程吧！">
        @break
        @case (6)
        <meta name="keywords" content="篮球课程,足球课程,羽毛球课程,拳击课程,武术课程,柔术课程,跆拳道课程,马术课程,课程转让平台">
        <meta name="description" content="在旦旦转课网，我们提供丰富多样的体育课程转让服务，包括篮球、足球、羽毛球、拳击、武术、柔术、跆拳道、马术等真实有效的体育课程，也能帮助您以更低的价格享受高质量的体育课程。快来旦旦转课网寻找适合自己的体育课程吧！">
        @break
        @endswitch
        

        <title>{{$category_name}}_旦旦转课网_全网首个课程转让交易平台</title>
        @else
        <meta name="keywords" content="早教课转让,舞蹈课转让,健身卡转让,艺术课转让,钢琴课转让,英语课转让,瑜伽课转让,武术课转让">
        <meta name="description" content="旦旦转课网是全网首个课程转让交易平台,基于教培行业学费贵、退费难的现状,为用户提供一站式课程转让交易服务。">

        <title>旦旦转课网_全网首个课程转让交易平台</title>
        
        @endif


        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{asset('css/global.css')}}" rel="stylesheet">
        <link href="{{asset('css/page/searchlist.css')}}" rel="stylesheet">

        <!-- Styles -->
        <link rel="shortcut icon" href="{{asset('image/logo.png')}}" type="image/x-icon">
        <script src="{{asset('js/jquery.js')}}"></script>
        <script src="{{asset('js/tool/loading.js')}}"></script>
        <script src="{{asset('js/tool/http.js')}}"></script>
        <script src="{{asset('js/page/searchlist.js')}}"></script>
        <script src="http://res2.wx.qq.com/open/js/jweixin-1.6.0.js"></script>
        <script>
            var _hmt = _hmt || [];
            (function() {
              var hm = document.createElement("script");
              hm.src = "https://hm.baidu.com/hm.js?76d5019db85976241389e61a26a25473";
              var s = document.getElementsByTagName("script")[0]; 
              s.parentNode.insertBefore(hm, s);
            })();
            </script>
        <script src="https://mapapi.qq.com/web/mapComponents/geoLocation/v/geolocation.min.js"></script>
        <style>


        </style>
    </head>
    <body>
        <div class="container">
        <div class="goback" style="background-image:url('{{asset('image/back_btn.png')}}')" onclick="goTo('index',null,null)"></div>
            <div class="search-nav-box">
                <div class="search-nav">
                    <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/sousuo_icon%402x.png" class="search-icon"/>
                    <input type="text" class="search-input" id="searchInput" placeholder="搜索课程，品牌" type="search"/>
                </div>
            </div>
    <!-- show_search_menu -->
                <!-- <div class="history-search show">
                    <div class="line1">
                        <div class="t1">历史搜索</div>
                        <img class="btn-clean" onclick="cleanHistory()"
                            src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/laji_icon%402x.png"/>
                    </div>

                    <div class="item" onclick="quickSearch('item')">
                        item
                    </div>
                </div> -->
                <!-- <div class="hot-search">
                    <div class="t1">热门搜索</div>
                    <div class="item" onclick="quickSearch('item.name')">
                        热门1
                    </div>
                    <div class="item" onclick="quickSearch('item.name')">
                        热门2
                    </div>
                    <div class="item" onclick="quickSearch('item.name')">
                        热门3
                    </div>
                </div> -->
                <!-- <div class="btn-hide-search" onclick="handleValueChange('show_search_menu',false)">取消</div> -->
                <div class="select-nav" id="searchNav">
                </div>

                @if($category_name)
                <div class="breadcrumb-navigation"><a href="//m.dandanzkw.com">首页</a>&nbsp;>&nbsp;<a href="">{{$category_name}}</a>&nbsp;>&nbsp;商品列表</div>
                @else
                <div class="breadcrumb-navigation"><a href="//m.dandanzkw.com">首页</a>&nbsp;>&nbsp;<a href="">商品列表</a></div>
                @endif

                <div class="default_goods_list">
                    @foreach ($goods_list as $item)
                    <a class="item" href="https://m.dandanzkw.com/detail/{{$item['goods_id']}}.html">
                        <div class="part1">
                            @if($item['transfer_info'] && $item['transfer_info']['attachments'] && $item['transfer_info']['attachments'][0])
                            <div class="thumbnail" style="background-image:url({{$item['transfer_info']['attachments'][0]}});"></div>
                            @else
                            <div class="thumbnail" style="background-image:url('https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/banner/微信图片_20210628113403.png');"></div>
                            @endif
                            
                            <div class="infos">
                                <div class="t1">
                                    【
                                    @if($item['contact']['lesson_type'] == 1)
                                    {{$item['contact']['surplus_lesson_time']}}节
                                    @else
                                    年卡
                                    @endif
                                    |{{$item['campus']['sub_course_type']}}】{{$item['transfer_info']['title']}}
                                </div>
                                <div class="t2">有效期：{{$item['contact']['contract_expired']}}</div>
                    
                                <div class="t3">
                                    <div>课程类型：{{$item['campus']['lesson_category']['name']}}</div>
                                    <div>
                                        课卡类型：
                                        @if($item['contact']['lesson_type'] == 1)
                                        次卡&nbsp;&nbsp;
                                        @elseif ($item['contact']['lesson_type'] == 2)
                                        年卡&nbsp;&nbsp;
                                        @endif
                                        剩余课时：{{$item['contact']['surplus_lesson_time']}}节
                                    </div>
                                    <div>
                                        适课年龄：{{$item['contact']['min_year']}}-{{$item['contact']['max_year']}}岁&nbsp;&nbsp;
                                        适课性别：
                                        @if($item['contact']['lesson_gender'] == 1)
                                        男
                                        @elseif ($item['contact']['lesson_gender'] == 2)
                                        女
                                        @elseif ($item['contact']['lesson_gender'] == 3)
                                        不限
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="part2">
                            {{$item['transfer_info']['title']}}
                        </div>
                        <div class="part3">
                            <div class="price">¥{{$item['transfer_info']['price']}}</div>
                            <div class="discount">{{$item['transfer_info']['discount']}}折</div>
                            @if($item['distance'])
                            <div class='distance'>{{$item['distance']}}km</div>
                            @else
                            <div class='distance'></div>
                            @endif
                        </div>
                    </a>
                    @endforeach
                </div>

                <div  class="goods" id="goods">
                    
                </div>
                <div class="modal-select-list">
                    <div class="cover" onclick="handleValueChange('show_select_modal',-1)"></div>
                    <div class="modal-select-list-2-content">
                        <div class="input-box">
                            <input oninput="updateParams('min_price')" id="min_price" type="text" class="input-min" placeholder-class="input-min-placeholder"
                               placeholder="最低价格" />
                            <div class="to"></div>
                            <input oninput="updateParams('max_price')" id="max_price" type="text" class="input-max" placeholder-class="input-max-placeholder"
                               placeholder="最高价格" />
                        </div>

                        <div class="prices" id="prices">

                        </div>

                        <div class="btns">
                            <div class="btn-cancel" onclick="resetParams()">重&nbsp;置</div>
                            <div class="btn-ok" onclick="submit()">确&nbsp;认</div>
                        </div>
                    </div>

                    <div class="modal-select-list-3-content">
                        <div class="line1">
                            <div class="left">
                                <div class="t1">当前位置：</div>
                                <div class="t2">深圳</div>
                            </div>
                            <div class="right">
                                <div class="t1">刷新</div>
                                <img class="icon"
                                    src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/shuaxin_icon%402x.png"/>
                            </div>
                        </div>
                        <div class="areas">
                            <div class="item hover"
                                key="item.value" onclick="updateParams('now_location','item.id')">item.name</div>
                        </div>
                    </div>

                    <div class="modal-select-list-4-content">
                        <div class="select-list">


                            <div class="sub-list">
                                <div class="name">课程类型</div>
                                <div class="items" id="lessonCategories">
                                </div>
                            </div>






                        </div>
                        <div class="btns">
                            <div class="btn-cancel" onclick="resetParams()">重&nbsp;置</div>
                            <div class="btn-ok" onclick="submit()">确&nbsp;认</div>
                        </div>
                    </div>
                </div>




        </div>
    </body>
    <script type="text/javascript">
        var data = "{{$data}}";
        var categoryId = "{{$category_id}}";

        </script>
</html>
