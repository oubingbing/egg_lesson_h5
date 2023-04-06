<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="divport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>旦旦转课</title>

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
    <script>
        //逻辑代码
        let test_fenlei = [{id:1,name:"早教亲子"},{id:2,name:"英语培训"},{id:3,name:"日语培训"}];
        test_fenlei = [{id:0,name:"全部"}].concat(test_fenlei);
        $(document).ready(()=>{

            var swiper = new Swiper(".mySwiper", {
                loop:true,
                autoplay:true
            });

            
            for(let i in test_fenlei){
                console.log(i,i==0);
                let select_nav_item = document.createElement("div");
                select_nav_item.innerHTML=test_fenlei[i].name;
                select_nav_item.className="select-nav-item";
                select_nav_item.id=`selectNavItem_${test_fenlei[i].id}`;
                if(i==0){
                    select_nav_item.className="select-nav-item hover";

                }                
                $(".select-nav-items").append(select_nav_item);
            }
         
        //     for(let i=1;i<=4;i++){
        //         if(i>1){
        //             $("#tabbar"+i+" .pre").hide();
        //                 $("#tabbar"+i+" .nor").show();
        //         }else{
        //             $("#tabbar"+i+" .pre").show();
        //                 $("#tabbar"+i+" .nor").hide();
        //         }
        //         $("#tabbar"+i).click(()=>{
        //             for(let j=1;j<=4;j++){
        //                 if(j===i){
        //                     $("#tabbar"+j+" .pre").show();
        //             $("#tabbar"+j+" .nor").hide();
        //                     continue;
        //                 }
        //                 $("#tabbar"+j+" .pre").hide();
        //                 $("#tabbar"+j+" .nor").show();
        //             }
                   
        // })
        //     }

            $("#searchInput").keyup((e)=>{
                if(e.keyCode=="13"){                    
                    let searchInput = $("#searchInput").val();
                    sessionStorage.setItem("searchInput",searchInput);
                    window.location.href=window.location.href+"search?data="+searchInput;
                }
            })
        })
        
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
            <div class="search-location">定位中</div>

        </div>
        <div class="banner-swiper-box mySwiper">
            <div class="banner-swiper swiper-wrapper">
                <div class="banner-image swiper-slide">
                    <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/banner/firstbanner.png"/>
                </div>
                <div class="banner-image swiper-slide">
                    <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/banner/微信图片_20210628113403.png"/>
                </div>
                <div class="banner-image swiper-slide">
                    <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/banner/微信图片_20210628113347.png"/>
                </div>
                <div class="banner-image swiper-slide">
                    <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/banner/PNG-red.png"/>
                </div>
            </div>
        </div>

        <div class="type-list">
            <div class="item">
                <div class="item-icon-box" onclick="goTo('search','data','早教亲子')">
                    <div class="item-icon"
                        style='background-image: url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/shouye_zaojiaoz_icon%402x.png"); background-position: 0% 0%; background-size: 100% 100%;'>
                    </div>
                </div>
                <div class="item-name">早教亲子</div>

            </div>
            <div class="item">
                <div class="item-icon-box">
                    <div class="item-icon"
                        style='background-image: url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/shouye_zaojiaoz_icon%402x.png"); background-position: 0% 0%; background-size: 100% 100%;'>
                    </div>
                </div>
                <div class="item-name">早教亲子</div>

            </div>
            <div class="item">
                <div class="item-icon-box">
                    <div class="item-icon"
                        style='background-image: url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/shouye_zaojiaoz_icon%402x.png"); background-position: 0% 0%; background-size: 100% 100%;'>
                    </div>
                </div>
                <div class="item-name">早教亲子</div>

            </div>

            <div class="item">
                <div class="item-icon-box">
                    <div class="item-icon"
                        style='background-image: url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/shouye_zaojiaoz_icon%402x.png"); background-position: 0% 0%; background-size: 100% 100%;'>
                    </div>
                </div>
                <div class="item-name">早教亲子</div>

            </div>

            <div class="item">
                <div class="item-icon-box">
                    <div class="item-icon"
                        style='background-image: url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/shouye_zaojiaoz_icon%402x.png"); background-position: 0% 0%; background-size: 100% 100%;'>
                    </div>
                </div>
                <div class="item-name">早教亲子</div>

            </div>

            <div class="item">
                <div class="item-icon-box">
                    <div class="item-icon"
                        style='background-image: url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/shouye_zaojiaoz_icon%402x.png"); background-position: 0% 0%; background-size: 100% 100%;'>
                    </div>
                </div>
                <div class="item-name">早教亲子</div>

            </div>

        </div>

        <div class="purchase">
            <div class="icon" style='background-image: url("{{asset('../image/shouye_laba_icon.png')}}");
                background-position: center center; background-size: cover;'>
            </div>
            <div class="names-box">
                <div class="names">
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                    <div class="name">用户郑甲会，刚刚购买了【舞蹈训练】课包，支付订金420元</div>
                </div>
            </div>
        </div>



        <div class="brands">
            <div class="title">
                <div class="left">品牌专区
                </div>

            </div>

            <div class="items">
                <!-- <div v-for="item in brands" :key="item.id" class="item" @click="goTo('search',item.name)"> -->
                <div class="item">
                    <div class="logo"
                        style='background-image:url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/brands/jswudao.jpg");'>
                    </div>
                    <div class="name">JS舞蹈</div>
                    <div class="desc"></div>
                </div>

                <div class="item">
                    <div class="logo"
                        style='background-image:url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/brands/jswudao.jpg")'>
                    </div>
                    <div class="name">JS舞蹈</div>
                    <div class="desc"></div>
                </div>

                <div class="item">
                    <div class="logo"
                        style='background-image:url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/brands/jswudao.jpg")'>
                    </div>
                    <div class="name">JS舞蹈</div>
                    <div class="desc"></div>
                </div>

                <div class="item">
                    <div class="logo"
                        style='background-image:url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/brands/jswudao.jpg")'>
                    </div>
                    <div class="name">JS舞蹈</div>
                    <div class="desc"></div>
                </div>

                <div class="item">
                    <div class="logo"
                        style='background-image:url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/brands/jswudao.jpg")'>
                    </div>
                    <div class="name">JS舞蹈</div>
                    <div class="desc"></div>
                </div>

                <div class="item">
                    <div class="logo"
                        style='background-image:url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/brands/jswudao.jpg")'>
                    </div>
                    <div class="name">JS舞蹈</div>
                    <div class="desc"></div>
                </div>


            </div>
        </div>

        <div class="hot-packages">
            <div class="title">
                <div class="left">推荐课包</div>
            </div>
            <div class="select-nav">
                <div class="select-nav-items">
                    
                </div>

            </div>
            <div class="items">
                <div class="items-left">
                    <div class="items-left-infos">
                        <div class="item">
                            <div class="thumbnail" style="background-image: url('https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/transfer_info/tmp_e6e5ebc46269e177e52c8f052eff529b.png'); background-position: center center; background-size: cover;"></div>
                            <div class="position-box">
                                <div class="icon" style='background-image: url("image/dingwei_icon.png"); background-position: center center; background-size: cover;''></div>
                                <div class="address">浙江省杭州市上城区</div>
                                <div class="distance"></div>
                            </div>
                            <div class="infos">
                                <div class="line1">
                                    <div class="tag">卖家自转</div>
                                    <div class="name">【年卡 |教练班】舞蹈学校教练班转让</div>
                                </div>
                                <div class="line2">
                                    <div class="price"> ¥10000</div>
                                    <div class="want">0人想要</div>
                                    <div class="discount">5.3<span class="fonts">折</span></div>
                                    
                                </div>
                                <div class="line3">
                                    <div class="t">戴斯尔舞蹈学院</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="tabbar">
        <div class="tabbar-item" id="tabbar1">
            <div class="tabbar-item-pic pre" style='background-image: url("{{asset('../image/tabbar/shouye_shouye_pre_icon.png')}}");'></div>
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
            <div class="tabbar-item-pic nor" style='background-image: url("{{asset('../image/tabbar/shouye_wode_nor_icon.png')}}");'></div>
            <div class="tabbar-item-name">我的</div>
        </div>
    </div>


</body>

</html>