<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="divport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>转课详情</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="{{asset('css/global.css')}}" rel="stylesheet">
    <link href="{{asset('css/page/detail.css')}}" rel="stylesheet">
    <link href="{{asset('css/tool/swiper-bundle.min.css')}}" rel="stylesheet">

    <!-- Styles -->

    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/tool/loading.js')}}"></script>
    <script src="{{asset('js/tool/http.js')}}"></script>
    <script src="{{asset('js/page/detail.js')}}"></script>
    <script src="{{asset('js/tool/swiper-bundle.min.js')}}"></script>

</head>

<body>
    <div class="product-detail">
        <div class="banner-swiper-box mySwiper">
            <div class="banner-swiper swiper-wrapper" id="banners">

            </div>
        </div>
        <div class="href-nav">
            <a class="item hover">课程信息</a>
            <a class="item">位置交通</a>
            <a class="item">订单流程</a>
            <a class="item">推荐课包</a>
        </div>

        <div class="part1 anchor1" id="part1">


        </div>

        <div class="part2" id="part2">

        </div>

        <div class="part3 anchor2" id="part3">



        </div>

        <div class="part4 anchor3" id="part4">
            <div class="user-info" id="sellerInfo">

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

            <div class="hot-goods">
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
</body>
<script type="text/javascript">
var id = "{{$id}}";
console.log("id=" + id)
</script>

</html>