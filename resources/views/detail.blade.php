<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="divport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="{{$goods_detail["campus"]["brand"]["name"] }}课程转让、早教课转让,舞蹈课转让,健身卡转让,艺术课转让,钢琴课转让,英语课转让,瑜伽课转让,武术课转让">
    <meta name="description" content="{{$goods_detail["transfer_info"]["introduce"]}}">
    <title>【{{$goods_detail["campus"]["campus"]["city"]}}】【{{$goods_detail["campus"]["campus"]["county"]}}】【{{$goods_detail["campus"]["brand"]["name"] }}课程转让】_{{$goods_detail["transfer_info"]["title"]}}_旦旦转课网</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="{{asset('css/global.css')}}" rel="stylesheet">
    <link href="{{asset('css/page/detail.css')}}" rel="stylesheet">
    <link href="{{asset('css/tool/swiper-bundle.min.css')}}" rel="stylesheet">

    <!-- Styles -->
    <script charset="utf-8" src="https://map.qq.com/api/gljs?v=2.exp&key=75ABZ-MJ76R-AZ7WK-W6ZLZ-45TBK-W7FJV"></script>
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/tool/loading.js')}}"></script>
    <script src="{{asset('js/popup.js')}}"></script>
    <script src="{{asset('js/tool/http.js')}}"></script>
    <script src="{{asset('js/page/detail.js')}}"></script>
    <script src="{{asset('js/tool/swiper-bundle.min.js')}}"></script>
    <script src="https://res2.wx.qq.com/open/js/jweixin-1.6.0.js"></script>
    <script src="{{asset('js/tool/wx.js')}}"></script>

</head>

<body>

    <div class="product-detail">
    <div class="goback" style="background-image:url('{{asset('image/back_btn.png')}}')" onclick="goTo('search',null,null)"></div>
        <div class="banner-swiper-box mySwiper">
            <div class="banner-swiper swiper-wrapper" id="banners">
                @for ($goods_detail["transfer_info"]["attachments"] as $item) 
                    <div class="banner-image swiper-slide">
                        <div style="background-image: url('{{$item}}');background-size:cover;background-position:center;width:100%;height:100%"/>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="href-nav sticky">
            <a class="item hover" onclick="letsScrollTo('.anchor1','.product-detail')">课程信息</a>
            <a class="item" onclick="letsScrollTo('.anchor2','.product-detail')">位置交通</a>
            <a class="item" onclick="letsScrollTo('.anchor3','.product-detail')">订单流程</a>
            <a class="item" onclick="letsScrollTo('.anchor4','.product-detail')">热门推荐</a>
        </div>

        <div class="part1 anchor1" id="part1">
            <div class="line1">

                {{$goods_detail["reset_title"]}}
             
            </div>
            <div class="line15">
                <div class="item"></div>
                <div class="item grey">
                  
                    发布于：{{$goods_detail["created_at"]}}
                </div>
            </div>
    
            <div class="line2">
                <div class="item">
                    <div class="t1">转让价格：</div>
                 
                    <div class="t2">¥{{$goods_detail["transfer_info"]["price"]}}</div>
                </div>
                <div class="item">
                    <div class="t1">订金：</div>
                   @if ($goods_detail["transfer_info"]["deposit"])
                   <div class="t2">¥{{$goods_detail["transfer_info"]["deposit"]}}</div>
                   @else
                   <div class="t2">---</div>
                   @endif
                    
                </div>
                <div class="item grey">
                 
                    {{$goods_detail["view_num"]}}人查看
                </div>
            </div>
    
            <div class="line3">
                <div class="left">认证荣誉</div>
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
                <div class="left">交易保障</div>
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

        <div class="part2" id="part2">
            <div class="line">
                <div class="item">
                    <div class="name">品牌</div>
                    <div class="content">{{$goods_detail["campus"]["brand"]["name"]}}</div>
                </div>
        
            </div>
        
            <div class="line">
                <div class="item">
                    <div class="name">校区名称</div>
                    <div class="content">{{$goods_detail["campus"]["campus"]["name"]}}</div>
                </div>
        
            </div>
            <div class="line">
                <div class="item">
                    <div class="name">课程类型</div>
                    <div class="content">
                        {{$goods_detail["campus"]["lesson_category"]["name"]}}
                    </div>
                </div>
                <div class="item">
                    <div class="name">课程类别</div>
                    <div class="content"> {{$goods_detail["campus"]["sub_course_type"]}}</div>
                </div>
            </div>
            <div class="line">
                <div class="item">
                    <div class="name">课卡类型</div>
                    <div class="content">
                        <!-- ['','次卡','年卡'][{{$goods_detail["contact"]["lesson_type"]}} -->
                    </div>
                </div>
                <div class="item">
                <div class="name">剩余课时</div>
                @if ($goods_detail["contact"]["lesson_type"] !== 2)
                <div class="content" id="surplusLessonTime">{{$goods_detail["contact"]["surplus_lesson_time"]}}</div>
                @else
                <div class="content" id="surplusLessonTime">--</div>
                @endif
                </div>
            </div>
            <div class="line">
                <div class="item">
                    <div class="name">适课年龄</div>
                    <div class="content">
                        {{$goods_detail["contact"]["min_year"]}}-{{$goods_detail["contact"]["max_year"]}}岁
                    </div>
                </div>
                <div class="item">
                    <div class="name">适课性别</div>
                    <div class="content">${['','男宝宝','女宝宝','不限'][{{$goods_detail["contact"]["lesson_gender"]}}]}</div>
                </div>
            </div>
        
        
            <div class="line">
                <div class="item">
                    <div class="name">合同原价</div>
                    <div class="content1">¥{{$goods_detail["contact"]["surplus_amount"]}}</div>
                    <div class="content2">{{$goods_detail["transfer_info"]["discount"]}}折</div>
                </div>
        
            </div>
        
            <div class="line">
                <div class="item">
                    <div class="name">合同有效期</div>
                    <div class="content">{{$goods_detail["contact"]["contract_expired"]}}</div>
                </div>
            </div>
        
            <div class="line">
                <div class="item">
                    <div class="name">转让介绍</div>
                    <div class="content">{{$goods_detail["transfer_info"]["introduce"]}}</div>
                </div>
        
            </div>
        </div>

        <div class="part3 anchor2" id="part3">
            <div class="map-container" id="map_container"></div><div class="location-text">
                {{$goods_detail["campus"]["campus"]["address"]}}
            </div>
            <div class="btn-come" onclick="showMap()">到这里去</div>
            <div class="line"></div>
        </div>

        <div class="part4 anchor3" id="part4">
            <div class="user-info" id="sellerInfo">
                <div class="left">
                    <img class="icon" src="{{$goods_detail["seller"]["avatar"]}}" />
                    <div class="infos">
                        <div class="name">{{$goods_detail["seller"]["nickname"]}}</div>
                         <!-- <div class="phone">${{{$goods_detail["seller"]["phone"]}}.substring(0,3)}****${{{$goods_detail["seller"]["phone"]}}.substring(7,11)}</div> -->
                    </div>
                    </div>
                    <div class="right">
                    已入驻旦旦{{$goods_detail["seller"]["settle_in"]}}天
                    </div>
            </div>

            <div class="transfer-progress">
                <div class="name">转让流程</div>
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
            <div class="mianze">
                <div class="t1">免责声明</div>
                <div class="t2">
                    <div>1.本平台所展示的课程供求信息由卖方自行提供，该信息已经过平台的前置审核，其真实性、准确性和合法性由信息发布人负责。</div>
                    <div>2.商品课程实际信息以买家到店后取得的合同资料为准。</div>
                    <div>3.本平台不对课程质量、课程效果做任何担保。</div>

                    <div>4.本平台提供的数字化商品根据商品性质在双方交易完成后不支持七天无理由退货及三包服务。</div>
                </div>
            </div>

            <div class="hot-goods anchor4">
                <div class="title">
                    <div class="left">热门推荐
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

    </div>

    <div class="bottom-btns">
        <div class="left">
            <div class="item" id="do_collection" onclick="doCollection(1)">
                <div class="icon" style="background-image: url('https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/shoucang_nor_icon%402x.png');">
            </div>
                <div class="name">收藏</div>
            </div>

            <div class="item hide" id="do_uncollection" onclick="doCollection(0)">
                <div class="icon" style="background-image: url('https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/shoucang_pre_icon%402x.png')">
                </div>
                <div class="name">收藏</div>
            </div>
            <div class="item" onclick="showService()">
                <div class="icon" style="background-image: url('https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/kefu_nor_icon%402x.png')">
                </div>
                <div class="name">客服</div>
            </div>
            <div class="item" onclick="createPoster()">
                <div class="icon" style="background-image: url('https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/zhuanfa_nor_icon%402x.png')">
                </div>
                <div class="name">转发</div>
            </div>
            <div class="item" onclick="handleValueChange('show_discuss',true)">
                <div class="icon" style="background-image: url('https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/yijia_nor_icon%402x.png')">
                </div>
                <div class="name">议价</div>
            </div>

        </div>
        <!-- <div class="right" onclick="handleValueChange('show_payment_types',true)">
            选择下单方式
        </div> -->
        <div class="right" onclick="createOrder()">
            立即下单
        </div>
    </div>
</body>
<script type="text/javascript">
console.log("debug","{{$debug}}")
console.log("beta","{{$beta}}")
console.log("appId","{{$appId}}")
console.log("nonceStr","{{$nonceStr}}")
console.log("timestamp","{{$timestamp}}")
console.log("url","{{$url}}")
console.log("jsApiList","{{$jsApiList}}")
let res = {
            "debug":"{{$debug}}",
            "beta":"{{$beta}}",
            "appId":"{{$appId}}",
            "nonceStr":"{{$nonceStr}}",
            "timestamp":parseInt("{{$timestamp}}"),
            "url":"{{$url}}",
            "signature":"{{$signature}}"
        };
getSignature(res);
</script>
</html>