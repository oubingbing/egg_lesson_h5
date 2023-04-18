<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
    <meta charset="utf-8">
    <meta name="divport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>个人中心</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{asset('css/global.css')}}" rel="stylesheet">
        <link href="{{asset('css/my.css')}}" rel="stylesheet">

        <!-- Styles -->
        <link rel="shortcut icon" href="{{asset('image/logo.png')}}" type="image/x-icon">
        <script src="{{asset('js/jquery.js')}}"></script>
        <script src="{{asset('js/bottom_menu.js')}}"></script>
        <script src="{{asset('js/popup.js?show=0')}}"></script>
        <script>
            $(document).ready(()=>{
               $(".funC_handleValueChange").click((e)=>{
                console.log(e);
                document.getElementsByClassName("updating-view")[0].className="updating-view show";
               })
               $(".funC_showUpdating").click(()=>{
              document.getElementsByClassName("updating-view")[0].className="updating-view show";
               })
               $(".funC_goTo").click((e)=>{
                console.log(e.currentTarget.attributes["page"]);
                document.getElementsByClassName("updating-view")[0].className="updating-view show";
               })
            })
        </script>
    </head>

    <body>
        <div class="container">
            <div class="get-phone-box hide">
                <div class="cover"></div>
                <div class="get-phone">
                    <div class='t'>
                        <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/logo.jpg"
                            class="logo" />&nbsp;手机号授权认证
                    </div>
                    <div class='content'>平台需要获取您的微信绑定手机号进行用户信息认证，请您授权。</div>
                    <div class="btns">
                        <div class="refuse-phone funC_closeNeedPhone">拒绝授权</div>

                        <btn class="need-phone">同意授权</btn>
                    </div>

                </div>
            </div>
            <div class="part1">
                <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/wode_img01%402x.png"
                    class="bg1"/>
                <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/wode_img02%402x.png"
                    class="bg2"/>
                <img id="avatar"
                    src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/touxiang_icon%402x.png"
                    class="avatar"/>
                <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/shezhi_icon%402x.png"
                    class="setting funC_goTo" page="setting"/>
                <div class="info1">

                        <a class="need-login need-login-h5 funC_showUpdating">点击登录</a>



                    <!-- <block v-else>
                        <div class="line1">
                            <div class="name">未登录</div>
                            <div class="renzheng">未认证</div>
                        </div>
                        <div class="line2">
                            开通实人通行证，提升曝光度，商品更快出售！
                        </div>
                    </block> -->



                </div>

                <div class="info2 funC_goTo" page="balance">
                    <div class="line1">
                        <div class="left">
                            我的余额
                        </div>
                        <div class="right">
                            提现/充值
                        </div>
                    </div>
                    <div class="line2">
                        <div class="left">¥&nbsp;0.00</div>
                        <div class="right funC_goTo" page="account_detail">账户明细</div>
                    </div>
                </div>
            </div>

            <div class="part2">
                <div class="title">买家管理</div>
                <div class="item funC_goTo" page="buyer_management" params="status=0">
                    <img
                        src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/maijia_quanbu_icon%402x.png"
                        class="icon"/>
                    <div class="name">全部</div>
                </div>
                <div class="item funC_goTo" page="buyer_management" params="status=1">
                    <img
                        src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/maijiaguanli_dingjinguanli_icon%402x.png"
                        class="icon"/>
                    <div class="name">订金管理</div>
                </div>
                <div class="item funC_goTo" page="buyer_management" params="status=2">
                    <img
                        src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/maijiaguanli_zhuangrangzhong_icon%402x.png"
                        class="icon"/>
                    <div class="name">转让中</div>
                </div>
                <!-- <div class="item">
                    <img
                        src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/maijiaguanli_weikuanchuli_icon%402x.png"
                        class="icon"/>
                    <div class="name">尾款管理</div>
                </div> -->
                <div class="item funC_goTo" page="buyer_management" params="status=5">
                    <img
                        src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/maijiaguanli_weikuanchuli_icon%402x.png"
                        class="icon"/>
                    <div class="name">已完成</div>
                </div>
                <div class="item funC_goTo" page="collection_list">
                    <img
                        src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/maijiaguanli_wodeshoucang_icon%402x.png"
                        class="icon"/>
                    <div class="name">我的收藏</div>
                </div>
                <div class="item  funC_goTo" page="discuss_list" params="type=1">
                    <img
                        src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/maijiaguanli_yijia_icon%402x.png"
                        class="icon"/>
                    <div class="name">发出的议价</div>
                </div>
            </div>

            <div class="part3">
                <div class="title">卖家管理</div>
                <div class="item funC_goTo" page="seller_management">
                    <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/quanbu_icon%402x.png"
                        class="icon"/>
                    <div class="name">全部</div>
                </div>
                <div class="item funC_goTo" page="seller_management" params="status=seller_status.ZHUANRANGZHONG">
                    <img
                        src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/zhuangrangzhong_icon%402x.png"
                        class="icon"/>
                    <div class="name">转让中</div>
                </div>
                <div class="item funC_goTo" page="seller_management" params="status=seller_status.YIWANCHENG">
                    <img
                        src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/yiwancheng_icon%402x.png"
                        class="icon"/>
                    <div class="name">已完成</div>
                </div>
                <div class="item funC_goTo" page="discuss_list" params="type=2">
                    <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/pingjia_icon%402x.png"
                        class="icon"/>
                    <div class="name">收到的议价</div>
                </div>
                <div class="item funC_goTo" page="seller_management" params="status=seller_status.DAISHENHE">
                    <img
                        src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/daishenhe_icon%402x.png"
                        class="icon"/>
                    <div class="name">待审核</div>
                </div>
                <div class="item funC_goTo" page="seller_management" params="status=seller_status.YISHANGJIA">
                    <img
                        src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/yishangjia_icon%402x.png"
                        class="icon"/>
                    <div class="name">已上架</div>
                </div>
                <div class="item funC_goTo" page="seller_management" params="status=seller_status.YIXIAJIA">
                    <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/yixiajia_icon%402x.png"
                        class="icon"/>
                    <div class="name">已下架</div>
                </div>
            </div>

            <div class="part4">
                <div class="title">自助服务</div>
                <div class="item showAboutUs">
                    <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/guanyu_icon%402x.png"
                        class="icon"/>
                    <div class="name">关注公众号</div>
                </div>
                <div class="item showService">
                    <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/kefu_icon%402x.png"
                        class="icon"/>
                    <div class="name">客服中心</div>
                </div>
                <div class="item funC_goTo" page="text_yinsizhengce">
                    <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/yinsi_icon%402x.png"
                        class="icon"/>
                    <div class="name">隐私政策</div>
                </div>
                <div class="item funC_goTo" page="text_kechengleibie">
                    <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/xieyi_icon%402x.png"
                        class="icon"/>
                    <div class="name">课程类别说明</div>
                </div>
                <div class="item funC_goTo" page="text_zhucetiaoli">
                    <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/tiaoli%402x.png"
                        class="icon"/>
                    <div class="name">注册条例</div>
                </div>
                <!-- 			<div class="item" @click="goTo('official_account')">
                    <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/jianyi_icon%402x.png"
                        class="icon"/>
                    <div class="name">关注公众号</div>
                </div>
                 -->
                <div class="item funC_goTo" page="rate_publicity">
                    <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/my/jianyi_icon%402x.png"
                        class="icon"/>
                    <div class="name">费率公示</div>
                </div>
            </div>

            <div class="modal-bottom hide">
                <div class="cover  funC_handleValueChange" params="show_yijian=false"></div>

                <div class="modal-yijian">
                    <div class="modal-yijian-content">
                        <div class="title">意见与建议</div>
                        <textarea class="filling-box" id="updateJianyiParams"></textarea>

                    </div>

                    <div class="btn-submit">提&nbsp;交</div>
                    <div class="btn-cancel  funC_handleValueChange" params="show_yijian=false">取&nbsp;消</div>
                </div>
            </div>
        </div>
        <div class="tabbar">
            <div class="tabbar-item" id="tabbar1">
                <div class="tabbar-item-pic nor" style='background-image: url("{{asset('../image/tabbar/shouye_shouye_nor_icon.png')}}");'></div>
                <div class="tabbar-item-name">首页</div>
            </div>
            <div class="tabbar-item" id="tabbar2">
                <div class="tabbar-item-pic nor" style='background-image: url("{{asset('../image/tabbar/shouye_fabu_nor_icon.png')}}");'></div>
                <div class="tabbar-item-name">发布</div>
            </div>
            <div class="tabbar-item" id="tabbar3">
                <div class="tabbar-item-pic nor" style='background-image: url("{{asset('../image/tabbar/shouye_xiaoxi_nor_icon.png')}}");'></div>
                <div class="tabbar-item-name">消息</div>
            </div>
            <div class="tabbar-item" id="tabbar4">
                <div class="tabbar-item-pic pre" style='background-image: url("{{asset('../image/tabbar/shouye_wode_pre_icon.png')}}");'></div>
                <div class="tabbar-item-name">我的</div>
            </div>
        </div>
    </body>
</html>
