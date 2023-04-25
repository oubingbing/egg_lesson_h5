<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>旦旦转课网_全网首个课程转让交易平台</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{asset('css/global_pc.css')}}" rel="stylesheet">
        <link href="{{asset('css/page/pc/searchlist_pc.css')}}" rel="stylesheet">

        <!-- Styles -->
        <link rel="shortcut icon" href="{{asset('image/logo.png')}}" type="image/x-icon">
        <script src="{{asset('js/jquery.js')}}"></script>
        <script src="{{asset('js/pc/tool/tool.js')}}"></script>
        <script src="{{asset('js/tool/http.js')}}"></script>
        <script src="{{asset('js/pc/page/searchlist.js')}}"></script>
        <script src="https://mapapi.qq.com/web/mapComponents/geoLocation/v/geolocation.min.js"></script>
        <script src="http://res2.wx.qq.com/open/js/jweixin-1.6.0.js"></script>
    </head>
    <body>
        <div class="container pc"  id="pc">
        <!-- <div class="goback" style="background-image:url('{{asset('image/back_btn.png')}}')" onclick="goTo('index',null,null)"></div> -->
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
                <div class="goods_list" id="goods_list">
                <div class="hot-goods">
                    <div class="items">
                        <div class="items-0">
                            <div class="items-0-infos" id="goods_0">
        
                            </div>
                        </div>
                        <div class="items-1">
                            <div class="items-1-infos" id="goods_1">
        
                            </div>
                        </div>
                        <div class="items-2">
                            <div class="items-2-infos" id="goods_2">
        
                            </div>
                        </div>
                        <div class="items-3">
                            <div class="items-3-infos" id="goods_3">
        
                            </div>
                        </div>
                        <div class="items-4">
                            <div class="items-4-infos" id="goods_4">
        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="modal-select-list">
                    <div class="cover" onclick="handleValueChange('show_select_modal',-1)"></div>
                    <div class="modal-select-list-2-content">
                        <div class="sub-list">
                            <div class="name">价格区间</div>
                            </div>
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

        <div class="footer">
            <p>
                <a href="https://pc.dandanzkw.com/">首页</a> |
                <a href="https://pc.dandanzkw.com/search?category_id=3" >舞蹈培训</a> |
                <a href=" https://pc.dandanzkw.com/search?category_id=7">瑜伽健身</a> |
                 <a href="https://pc.dandanzkw.com/search?category_id=1">早教亲子</a> |
                 <a href="https://pc.dandanzkw.com/search?category_id=2">英语培训</a>|
                 <a href="https://pc.dandanzkw.com/search?category_id=4">器乐文艺</a> |
                 <a href="https://pc.dandanzkw.com/search?category_id=5">语种培训</a> |
                 <a href="https://pc.dandanzkw.com/search?category_id=6">体育竞技</a> |
                 <a href="https://pc.dandanzkw.com/search?category_id=8">Steam</a> |
                 <a href="https://pc.dandanzkw.com/search?category_id=10">职业教育</a> |
                 <a href="https://www.dandanzkw.com/aboutus/">关于我们</a> |
                 <a href="https://www.dandanzkw.com/yinsi/">注册条例</a> |
                 <a href="https://www.dandanzkw.com/kechengleibie/">课程类别说明 </a>|
                 <a href="https://www.dandanzkw.com/kechengfabu/">课程发布条例</a>|
                 <a href="https://www.dandanzkw.com/cooperate/">联系我们</a> |
                 <a href="https://m.dandanzkw.com/sitemap.txt">网站地图 </a>
                 </p>
            <div class="authentication">
                <div style="width:300px;margin:0px auto;padding: 2px;">
                    <a target="_blank" href="https://beian.miit.gov.cn" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;"><img src="{{asset('image/www_beian_gov_cn.png')}}" style="float:left; width: 20px; height: 20px;"><p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;">粤ICP备2021068181号-1</p></a>
                </div>
            </div>
            <div style="width:500px; margin:0px auto;" class="f_copyright">
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
    <script type="text/javascript">
        var data = "{{$data}}";
        var categoryId = "{{$category_id}}";

        </script>
</html>
