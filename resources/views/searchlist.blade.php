<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="divport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>热门课包</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{asset('css/global.css')}}" rel="stylesheet">
        <link href="{{asset('css/page/searchlist.css')}}" rel="stylesheet">

        <!-- Styles -->
        <script src="{{asset('js/jquery.js')}}"></script>
        <script src="{{asset('js/page/searchlist.js')}}"></script>
        <style>

        </style>
    </head>
    <body>
        <div class="container">
            <div class="search-nav-box">
                <div class="search-nav">
                    <img src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/sousuo_icon%402x.png" class="search-icon"/>
                    <input class="search-input" @focus="handleValueChange('show_search_menu',true)"
    placeholder-class="search-input-placeholder" placeholder="搜索课程，品牌" @confirm="newSearch()"
                        v-model="params.brands" confirm-type="search" type="text"/>
    
                </div>
            </div>
    <!-- show_search_menu -->
                <div class="history-search show">
                    <div class="line1">
                        <div class="t1">历史搜索</div>
                        <img class="btn-clean" @click="cleanHistory()"
                            src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/laji_icon%402x.png"/>
                    </div>
    
                    <div v-for="item in history_list" :key="item" class="item" @click="quickSearch(item)">
                        {{item}}
                    </div>
                </div>
                <div class="hot-search">
                    <div class="t1">热门搜索</div>
                    <div v-for="item in hot_list" :key="item.id" class="item" @click="quickSearch(item.name)">
                        {{item.name}}
                    </div>
                </div>
                <div class="btn-hide-search" @click="handleValueChange('show_search_menu',false)">取消</div>


            <!-- <block v-else> -->
                <div class="select-nav">
                    <div @click="doSelectSort($event,4)" :class="['item',now_select_type_index===4?'hover color-blue':'']">
                        附近
                    </div>
                    <div v-for="(item,index) in select_type_list" :key="item.value" @click="doSelectSort($event,index)"
                        :class="['item',now_select_type_index===index?'hover':'']">
                        {{item.label}}
                    </div>
    
    
    
                </div>
    
                <div  class="packages">
                    <div class="item showGoodDetail" params="item.goods_id">
                        <div class="part1">
                            <img class="thumbnail" mode="aspectFill" src="item.transfer_info.attachments[0]"/>
                            <div class="infos">
                                <div class="t1">
                                    【年卡|舞蹈舞蹈】舞蹈舞蹈
                                </div>
                                <div class="t2">有效期：2023-12-13</div>
    
                                <div class="t3">
                                    <div>课程类型：舞蹈舞蹈</div>
                                    <div>
                                        课卡类型：年卡&nbsp;&nbsp;剩余课时：3节
                                    </div>
                                    <div>
                                        适课年龄：0-5岁&nbsp;&nbsp;
                                        适课性别：不限
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="part2">
                            这就是抬头！
                        </div>
                        <div class="part3">
                            <div class="price">125.55</div>
                            <div class="discount">3.4折</div>
                            <div class='distance'>3km</div>
                        </div>
    
    
    
    
                    </div>
                </div>
                <div class="modal-select-list">
                    <div class="cover funC_handleValueChange" params="show_select_modal=-1"></div>
                    <div class="modal-select-list-2-content">
                        <div class="input-box">
                            <input type="text" class="input-min" placeholder-class="input-min-placeholder"
                                v-model="params.min_price" placeholder="最低价格" />
                            <div class="to"></div>
                            <input type="text" class="input-max" placeholder-class="input-max-placeholder"
                                v-model="params.max_price" placeholder="最高价格" />
                        </div>
    
                        <div class="prices">
                            <div class="item"  key="item.id"
                                @click="updateParams('prices',item.min_price,item.max_price)">item.name</div>
                        </div>
    
                        <div class="btns">
                            <div class="btn-cancel" @click="resetParams()">重&nbsp;置</div>
                            <div class="btn-ok" @click="submit()">确&nbsp;认</div>
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
                                key="item.value" @click="updateParams('now_location',item.id)">item.name</div>
                        </div>
                    </div>
    
                    <div class="modal-select-list-4-content">
                        <div class="select-list">
    
    
                            <div class="sub-list">
                                <div class="name">课程类型</div>
                                <div class="items">
                                    <!-- <div v-for="item in course_types" :key="item.id"
                                        :class="['item',params.lesson_category_ids===item.id?'hover':'']"
                                        @click="updateParams('lesson_category_ids',item.id)">{{item.name}}</div> -->

                                        <div class="item hover">类型1</div>
                                        <div class="item">类型2</div>
                                </div>
                            </div>
    
    
    
    
    
    
                        </div>
                        <div class="btns">
                            <div class="btn-cancel" @click="resetParams()">重&nbsp;置</div>
                            <div class="btn-ok" @click="submit()">确&nbsp;认</div>
                        </div>
                    </div>
                </div>
    
    
    
    
        </div>
    </body>
    <script type="text/javascript">
        var data = "{{$data}}";
        console.log("data=" + data)
        </script>
</html>
