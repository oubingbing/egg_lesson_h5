var state = {
    goods: [],
    goods_divs: {},
    goods_params: {
        page_number: 1,
        page_size: 4
    },
    current_goods_detail: null,
    current_goods_id: null
}

//获取url传参
let url_params_text = window.location.href.split("?")[1];
url_params_text = url_params_text.split("&");
let url_params = {};
for (let i in url_params_text) {
    let item = url_params_text[i];
    url_params[item.split('=')[0]] = item.split('=')[1];
}
console.log(url_params);
if (!!url_params.id) {
    state.current_goods_id = url_params.id;
}

let isEnd = false;

function getGoodsDetail() {
    showLoading();
    Get(mRoute.goods_detail(state.current_goods_id), void(0), res => {

        if (res && res.data) {
            res.data.reset_title =
                `【${res.data.contact.lesson_type === 1 ? res.data.contact.surplus_lesson_time + "节" : ''}
                        ${['', '', '年卡'][res.data.contact.lesson_type]} |${res.data.campus.sub_course_type}】${res.data.transfer_info.title}`;

            state.current_goods_detail = res.data;
            console.log(state.current_goods_detail);
            if(state.current_goods_detail.collection!==1){
                document.getElementById("do_collection").className="item show";
                document.getElementById("do_uncollection").className="item hide";
            }else{
                document.getElementById("do_collection").className="item hide";
                document.getElementById("do_uncollection").className="item show";
            }

            for (let i in state.current_goods_detail.transfer_info.attachments) {
                let item = state.current_goods_detail.transfer_info.attachments[i];
                let banner = document.createElement("div");
                banner.className = `banner-image swiper-slide`;
                banner.innerHTML = `<div style="background-image: url('${item}');background-size:cover;background-position:center;width:100%;height:100%"/>`;
                document.getElementById("banners").appendChild(banner);
            }
            var swiper = new Swiper(".mySwiper", {
                loop: true,
                autoplay: true
            });

            document.getElementById("part1").innerHTML = `<div class="line1">

            ${state.current_goods_detail.reset_title}
         
        </div>
        <div class="line15">
            <div class="item"></div>
            <div class="item grey">
              
                发布于：${state.current_goods_detail.created_at}
            </div>
        </div>

        <div class="line2">
            <div class="item">
                <div class="t1">转让价格：</div>
             
                <div class="t2">¥${state.current_goods_detail.transfer_info.price}</div>
            </div>
            <div class="item">
                <div class="t1">订金：</div>
               
                <div class="t2">¥${state.current_goods_detail.transfer_info.deposit?state.current_goods_detail.transfer_info.deposit:'---'}</div>
            </div>
            <div class="item grey">
             
                ${state.current_goods_detail.view_num}人查看
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
        </div>`;

            document.getElementById("part2").innerHTML = `<div class="line">
        <div class="item">
            <div class="name">品牌</div>
            <div class="content">${state.current_goods_detail.campus.brand.name}</div>
        </div>

    </div>

    <div class="line">
        <div class="item">
            <div class="name">校区名称</div>
            <div class="content">${state.current_goods_detail.campus.campus.name}</div>
        </div>

    </div>
    <div class="line">
        <div class="item">
            <div class="name">课程类型</div>
            <div class="content">
                ${state.current_goods_detail.campus.lesson_category.name}
            </div>
        </div>
        <div class="item">
            <div class="name">课程类别</div>
            <div class="content">${state.current_goods_detail.campus.sub_course_type}</div>
        </div>
    </div>
    <div class="line">
        <div class="item">
            <div class="name">课卡类型</div>
            <div class="content">
                ${['','次卡','年卡'][state.current_goods_detail.contact.lesson_type]}
            </div>
        </div>
        <div class="item">
        <div class="name">剩余课时</div>
        <div class="content" id="surplusLessonTime">--</div>
        </div>
    </div>
    <div class="line">
        <div class="item">
            <div class="name">适课年龄</div>
            <div class="content">
            ${state.current_goods_detail?state.current_goods_detail.contact.min_year:'---'}-${state.current_goods_detail?state.current_goods_detail.contact.max_year:'---'}岁
            </div>
        </div>
        <div class="item">
            <div class="name">适课性别</div>
            <div class="content">${['','男宝宝','女宝宝','不限'][state.current_goods_detail.contact.lesson_gender]}</div>
        </div>
    </div>


    <div class="line">
        <div class="item">
            <div class="name">合同原价</div>
            <div class="content1">¥${state.current_goods_detail.contact.surplus_amount}</div>
            <div class="content2">${state.current_goods_detail.transfer_info.discount}折</div>
        </div>

    </div>

    <div class="line">
        <div class="item">
            <div class="name">合同有效期</div>
            <div class="content">${state.current_goods_detail.contact.contract_expired}</div>
        </div>
    </div>

    <div class="line">
        <div class="item">
            <div class="name">转让介绍</div>
            <div class="content">${state.current_goods_detail.transfer_info.introduce}</div>
        </div>

    </div>`;

            document.getElementById("part3").innerHTML = ` <div class="map-container" id="map_container"></div><div class="location-text">
    ${state.current_goods_detail.campus.campus.address}
</div>
<div class="btn-come" onclick="showMap()">到这里去</div>
<div class="line"></div>`;

            document.getElementById("sellerInfo").innerHTML = `<div class="left">
<img class="icon" src="${state.current_goods_detail.seller.avatar}" />
<div class="infos">
    <div class="name">${state.current_goods_detail.seller.nickname}</div>
     <div class="phone">${state.current_goods_detail.seller.phone.substring(0,3)}****${state.current_goods_detail.seller.phone.substring(7,11)}</div>
</div>
</div>
<div class="right">
已入驻旦旦${state.current_goods_detail.seller.settle_in}天
</div>`;


            if (state.current_goods_detail.contact.lesson_type != 2) {
                document.getElementById("surplusLessonTime").innerText = state.current_goods_detail.contact.surplus_lesson_time;

            }

            initMap();

        }
        hideLoading();
    })
}

function getGoods(params = state.goods_params) {
    isLoading = true;
    if (isEnd) {
        hideLoading();
        return;
    }
    Get(mRoute.goods_page, params, res => {
        if (res.data) {
            isLoading = false;
            hideLoading();
            if (!res.data.page_data.length) {
                isEnd = true;
            }
            for (let i in res.data.page_data) {
                res.data.page_data[i].reset_title =
                    `【${res.data.page_data[i].contact.lesson_type === 1 ? res.data.page_data[i].contact.surplus_lesson_time + "节" : ''}
                        ${['', '', '年卡'][res.data.page_data[i].contact.lesson_type]} |${res.data.page_data[i].campus.sub_course_type}】${res.data.page_data[i].transfer_info.title}`;
            }

            state.goods = state.goods.concat(res.data.page_data);

            for (let i in res.data.page_data) {
                let item = res.data.page_data[i];

                let item_div = document.createElement('div');
                item_div.className = 'item';
                item_div.id = `goods_id_${item.goods_id}`;
                item_div.onclick = showGoodDetail.bind(null, item.goods_id);
                item_div.innerHTML = `
                        <img class="thumbnail" onload="drawGood(${item.goods_id})"
                            src="${item.transfer_info.attachments&&item.transfer_info.attachments[0]?item.transfer_info.attachments[0]:'https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/banner/微信图片_20210628113403.png'}">
                        </div>
                        <div class="position-box">
                            <div class="icon"
                                style='background-image: url("image/dingwei_icon.png"); background-position: center center; background-size: cover;'>
                            </div>
                            <div class="address">${item.campus && item.campus.campus ? item.campus.campus.address : ''}</div>
                            <div class="distance">${item.distance ? item.distance + "km" : ''}</div>
                        </div>
                        <div class="infos">
                            <div class="line1">
                                <div class="tag">卖家自转</div>
                                <div class="name">${item.reset_title}</div>
                            </div>
                            <div class="line2">
                                <div class="price"> ¥${item.transfer_info.price > 10000 ? parseInt(item.transfer_info.price / 1000) / 10 + "万" : item.transfer_info.price}</div>
                                <div class="want">${item.collection}人想要</div>
                                <div class="discount">${item.transfer_info.discount ? item.transfer_info.discount : '10'}<span class="fonts">折</span></div>
   
                            </div>
                            <div class="line3">
                                <div class="t">${item.campus.brand.name}</div>
                            </div>
   
                            <img class="discount-icon"
                                src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/remen_icon%402x.png" />
                        </div>
                    `;
                state.goods_divs[item.goods_id] = item_div;

            }

        } else {
            console.log("goods get error");
        }
        console.log('state.goods', state.goods);



    })
}

function drawGood(goods_id) {
    let left = document.getElementById("goods_left");
    let right = document.getElementById("goods_right");
    if (left.offsetHeight >= right.offsetHeight) {
        right.appendChild(state.goods_divs[goods_id]);

    } else {
        left.appendChild(state.goods_divs[goods_id]);
    }
    setTimeout(() => {
        state.goods_divs[goods_id].className = "item show";
    }, 100);

}

function showUpdating(){
    window.location.href="weixin://dl/business/?t=Zb60DIUIuui";
}

function showService(){
    showUpdating();
}
function doCollection(){
    showUpdating();
}
function handleValueChange(t,e){
    console.log(t,e);
    showUpdating();
}
function createPoster(){
    showUpdating();
}
function createOrder(){
    showUpdating();
}

function showMap(){
    let item = state.current_goods_detail;
    window.location.href = `https://apis.map.qq.com/tools/poimarker?type=0&marker=coord:${item.campus.campus.latitude},${item.campus.campus.longitude};title:${item.campus.brand.name};addr:${item.campus.campus.address}&key=75ABZ-MJ76R-AZ7WK-W6ZLZ-45TBK-W7FJV&referer=dandanzkw`
}

function initMap() {
    if(!state.current_goods_detail)
    return;

    //定义地图中心点坐标
    var center = new TMap.LatLng(state.current_goods_detail.campus.campus.latitude,state.current_goods_detail.campus.campus.longitude)
    //定义map变量，调用 TMap.Map() 构造函数创建地图
    var map = new TMap.Map(document.getElementById('map_container'), {
        center: center,//设置地图中心点坐标
        zoom: 17.2,   //设置地图缩放级别
        pitch: 43.5,  //设置俯仰角
        rotation: 45    //设置地图旋转角度
    });
    var marker = new TMap.MultiMarker({
        map: map,
        styles: {
          // 点标记样式
          marker: new TMap.MarkerStyle({
            width: 20, // 样式宽
            height: 30, // 样式高
            anchor: { x: 10, y: 30 }, // 描点位置
          }),
        },
        geometries: [
          // 点标记数据数组
          {
            // 标记位置(纬度，经度，高度)
            position: center,
            id: 'marker',
          },
        ],
      });
}

$(document).ready(() => {
    getGoodsDetail();
    getGoods();
   
    scrollToBottom('product-detail', null, () => {
        state.goods_params.page_number++;
        showLoading();
        getGoods();
    })
})