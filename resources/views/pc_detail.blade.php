<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    @if ($goods_detail["campus"])
    <meta name="keywords" content="{{$goods_detail["campus"]["brand"]["name"]
        }}课程转让、早教课转让,舞蹈课转让,健身卡转让,艺术课转让,钢琴课转让,英语课转让,瑜伽课转让,武术课转让">
        @endif
    <meta name="description" content="{{$goods_detail["transfer_info"]["introduce"]}}">
    <title>
        @if ($goods_detail["campus"] && $goods_detail["campus"]["campus"] )
        【{{$goods_detail["campus"]["campus"]["city"]}}】【{{$goods_detail["campus"]["campus"]["county"]}}】
        @endif
        @if ($goods_detail["campus"] && $goods_detail["campus"]["brand"])
        【{{$goods_detail["campus"]["brand"]["name"]
        }}课程转让】
        @endif
        _{{$goods_detail["transfer_info"]["title"]}}_旦旦转课网</title>

    <!-- Fonts -->
    <link rel="shortcut icon" href="{{asset('image/logo.png')}}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="{{asset('css/global_pc.css')}}" rel="stylesheet">
    <link href="{{asset('css/page/pc/detail_pc.css')}}" rel="stylesheet">
    <link href="{{asset('css/tool/swiper-bundle.min.css')}}" rel="stylesheet">

    <!-- Styles -->
    <script charset="utf-8" src="https://map.qq.com/api/gljs?v=2.exp&key=75ABZ-MJ76R-AZ7WK-W6ZLZ-45TBK-W7FJV"></script>
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/pc/tool/tool.js')}}"></script>
    <script src="{{asset('js/pc/tool/popup.js')}}"></script>
    <script src="{{asset('js/tool/http.js')}}"></script>
    <script src="{{asset('js/pc/page/detail.js')}}"></script>
    <script src="{{asset('js/tool/swiper-bundle.min.js')}}"></script>

</head>

<!-- <body onload="createTitleNav"> -->
<body>
<div class="pc" id="pc">
<div class="product-detail">
    <div class="box1">
        <div class="title">
        <div class="bfont">  {{$goods_detail["reset_title"]}}</div>
        <div class="banner-title-code"> 发布于：{{$goods_detail["created_at"]}}</div>
        </div>
    </div>
    <div class="box2">
        <div class="lp">
        <div class="banner-swiper-box mySwiper">
            <div class="banner-swiper swiper-wrapper" id="banners">
            @if ($goods_detail["transfer_info"] && $goods_detail["transfer_info"]["attachments"])
                @foreach ($goods_detail["transfer_info"]["attachments"] as $item)
                <div class="banner-image swiper-slide">
                    <img
                        src="{{$item}}" alt="{{$goods_detail['campus']['brand']['name']}}课程转让" style="width:100%;height:100%;object-fit:cover;" />
                </div>
                @endforeach
                @else
                <img
                        src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/banner/banner.jpg" alt="{{$goods_detail['campus']['brand']['name']}}课程转让" style="width:100%;height:100%;object-fit:cover;" />
                @endif
            </div>
        </div>

        <div class="breadcrumb-navigation"><a href="//m.dandanzkw.com">首页</a>&nbsp;>&nbsp;<a href="//m.dandanzkw.com/pc/search?category_id={{$goods_detail["campus"]["lesson_category"]["id"]}}">
            @if ($goods_detail["campus"] && $goods_detail["campus"]["lesson_category"])
                        {{$goods_detail["campus"]["lesson_category"]["name"]}}
                        @endif
                    </a>&nbsp;>&nbsp;<span>{{$goods_detail["reset_title"]}}</span></div>

        <div class="part1 anchor1" id="part1">
            <div class="line3">
                <!-- <div class="left">认证荣誉</div> -->
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
                <!-- <div class="left">交易保障</div> -->
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


        <div class="details">
            <div class="title">课程详情</div>
            <table class="table">
                <tr>
                    <td> <span class="name">品牌名称</span>
                    <span class="content">
                        @if ($goods_detail["campus"] && $goods_detail["campus"]["brand"])
                        {{$goods_detail["campus"]["brand"]["name"]}}
                    @endif
    </span></td>
                    
                    <td>
                    <span class="name">校区名称</span>
                    <span class="content">
                        @if ($goods_detail["campus"] && $goods_detail["campus"]["campus"])
                        {{$goods_detail["campus"]["campus"]["name"]}}
                        @endif
                       </span>
                    </td>
                </tr>

                <tr>
                    <td>   <span class="name">课程类型</span>
                    <span class="content">
                        @if ($goods_detail["campus"] && $goods_detail["campus"]["lesson_category"])
                        {{$goods_detail["campus"]["lesson_category"]["name"]}}
                        @endif
                    </span></td>
                    
                    <td>
                    <span class="name">课程类别</span>
                    <span class="content">
                    @if ($goods_detail["campus"])
                        {{$goods_detail["campus"]["sub_course_type"]}}
                    @endif
                       </span>
                    </td>
                </tr>

                <tr>
                    <td>   <span class="name">课卡类型</span>
                    <span class="content">
                    @if ($goods_detail["contact"]["lesson_type"] === 1)
                        次卡
                        @elseif ($goods_detail["contact"]["lesson_type"] === 2)
                        年卡
                        @endif
                    </span></td>
                    
                    <td>
                    <span class="name">剩余课时</span>
                    @if ($goods_detail["contact"]["lesson_type"] !== 2)
                    <span class="content" id="surplusLessonTime">{{$goods_detail["contact"]["surplus_lesson_time"]}}
                    </span>
                    @else
                    <span class="content" id="surplusLessonTime">--</span>
                    @endif
                    </td>
                </tr>

                <tr>
                <td>
                    <span class="name">适课年龄</span>
                    <span class="content">
                        {{$goods_detail["contact"]["min_year"]}}-{{$goods_detail["contact"]["max_year"]}}岁
    </span>
    </td>
                <td>
                    <span class="name">适课性别</span>
                    <span class="content">
                        @switch($goods_detail["contact"]["lesson_gender"])
                        @case(1)
                        男宝宝
                        @break

                        @case(2)
                        女宝宝
                        @break

                        @case(3)
                        不限
                        @endswitch

    </span>
    </td>
                </tr>

                <tr>
                <td>
                    <span class="name">合同原价</span>
                    <span class="content1">¥{{$goods_detail["contact"]["surplus_amount"]}}</span>
                    <span class="content2">{{$goods_detail["transfer_info"]["discount"]}}折</span>
                    </td>

                    <td>
                    <span class="name">合同有效期</span>
                    <span class="content">{{$goods_detail["contact"]["contract_expired"]}}</span>
    </td>
                </tr>


            </table>

            <div class="title">转让介绍</div>
            <table class="table">
                <tr>
                   
    <td>
        <span class="name"> {{$goods_detail["transfer_info"]["introduce"]}}</span>
    </td>
                </tr>

                <tr>
                    
    </tr>
    </table>
        </div>


        <div class="transfer-progress">
                <div class="title">转让流程</div>
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

            <div class="map-container-box anchor2" id="part3">
            <div class="title">地图导航</div>
            <div class="map-container" id="map_container"></div>
            <div class="location-text">
                @if ($goods_detail["campus"] && $goods_detail["campus"]["campus"])
                {{$goods_detail["campus"]["campus"]["address"]}}
                @endif
            </div>
            <div class="btn-come" onclick="showMap()">到这里去</div>
            <div class="line"></div>
        </div>

        </div>
        <div class="rp">

        <div class="user-info" id="sellerInfo">
                <div class="left">
                    <img class="icon" src="{{$goods_detail["seller"]["avatar"]}}" />
                    <div class="infos">
                        <div class="name">{{$goods_detail["seller"]["nickname"]}}</div>
                        <div class="phone">{{$goods_detail["hidden_phone"]}}</div>
                    </div>
                </div>
                <div class="right">
                    已入驻旦旦{{$goods_detail["seller"]["settle_in"]}}天
                </div>
            </div>

            <div class="goods-price">
                        <span class="font12 color999 m-l16">转让价格</span>
                        <span class="font24 colorFF5 m-l16">￥</span>
                        <span class="font36 colorFF5 bold " id="mainPrice">{{$goods_detail["transfer_info"]["price"]}}</span>
                                <span class="icon-icon31">{{$goods_detail["transfer_info"]["discount"]}}折</span>
                                <span class="font12 colorFF5 m-l16">订金：￥</span>
                                <span class="font24 colorFF5 bold"> @if ($goods_detail["transfer_info"]["deposit"])
                        {{$goods_detail["transfer_info"]["deposit"]}}
                        @else
                        ---
                        @endif</span>
                        <span class="font12 m-l16 floatright">人查看</span>
                        <span class="font24 colorFF5 floatright">{{$goods_detail["view_num"]}}</span>
                    </div>

        <div class="goods-list anchor4">
        
                    <div class="line1">相关推荐
                    </div>
                <div class="goods" id="goods_list">
                
                </div>
            </div>
    </div>
    </div>
        <div class="goback" style="background-image:url('{{asset('image/back_btn.png')}}')"
            onclick="goTo('search',null,null)"></div>

        

      
            

            
            <div class="mianze">
                <div class="t1">免责声明</div>
                <div class="t2">
                    <div>1.本平台所展示的课程供求信息由卖方自行提供，该信息已经过平台的前置审核，其真实性、准确性和合法性由信息发布人负责。</div>
                    <div>2.商品课程实际信息以买家到店后取得的合同资料为准。</div>
                    <div>3.本平台不对课程质量、课程效果做任何担保。</div>

                    <div>4.本平台提供的数字化商品根据商品性质在双方交易完成后不支持七天无理由退货及三包服务。</div>
                </div>
            </div>

        

    </div>

    <div class="bottom-btns">
        <div class="top">
            <div class="item" id="do_collection" onclick="doCollection(1)">
                <div class="icon"
                    style="background-image: url('https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/shoucang_nor_icon%402x.png');">
                </div>
                <div class="name">收藏</div>
            </div>

            <div class="item hide" id="do_uncollection" onclick="doCollection(0)">
                <div class="icon"
                    style="background-image: url('https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/shoucang_pre_icon%402x.png')">
                </div>
                <div class="name">收藏</div>
            </div>
            <div class="item" onclick="showService()">
                <div class="icon"
                    style="background-image: url('https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/kefu_nor_icon%402x.png')">
                </div>
                <div class="name">客服</div>
            </div>
            <div class="item" onclick="createPoster()">
                <div class="icon"
                    style="background-image: url('https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/zhuanfa_nor_icon%402x.png')">
                </div>
                <div class="name">转发</div>
            </div>
            <div class="item" onclick="handleValueChange('show_discuss',true)">
                <div class="icon"
                    style="background-image: url('https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/yijia_nor_icon%402x.png')">
                </div>
                <div class="name">议价</div>
            </div>

        </div>
        <!-- <div class="right" onclick="handleValueChange('show_payment_types',true)">
            选择下单方式
        </div> -->
        <div class="submit" onclick="createOrder()">
            立即下单
        </div>
    </div>
</div>

    
</body>
<script type="text/javascript">
    sessionStorage.setItem("current_goods_id","{{$goods_detail["goods_id"]}}");
    getGoodsDetail("{{$goods_detail["goods_id"]}}");
    // console.log("debug", "{{$debug}}")
    // console.log("beta", "{{$beta}}")
    // console.log("appId", "{{$appId}}")
    // console.log("nonceStr", "{{$nonceStr}}")
    // console.log("timestamp", "{{$timestamp}}")
    // console.log("url", "{{$url}}")
    // console.log("jsApiList", "{{$jsApiList}}")
    // let res = {
    //     "debug": "{{$debug}}",
    //     "beta": "{{$beta}}",
    //     "appId": "{{$appId}}",
    //     "nonceStr": "{{$nonceStr}}",
    //     "timestamp": parseInt("{{$timestamp}}"),
    //     "url": "{{$url}}",
    //     "signature": "{{$signature}}"
    // };
    // getSignature(res);

    document.body.onload = ()=>{createTitleNav();}
</script>

</html>
