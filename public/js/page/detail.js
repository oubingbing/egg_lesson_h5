var state = {
    goods: [],
    goods_divs: {},
    goods_params: {
        page_number: 1,
        page_size: 6
    },
    current_goods_detail: null,
    current_goods_id: null
}

//获取url传参
// let url_params_text = window.location.href.split("?")[1];
// url_params_text = url_params_text.split("&");
// let url_params = {};
// for (let i in url_params_text) {
//     let item = url_params_text[i];
//     url_params[item.split('=')[0]] = item.split('=')[1];
// }
// console.log(url_params);
// if (!!url_params.id) {
//     state.current_goods_id = url_params.id;
// }

let isEnd = false;

function getGoodsDetail(current_goods_id = state.current_goods_id) {
    state.current_goods_id = current_goods_id;
    Get(mRoute.goods_detail(current_goods_id), void(0), res => {

        if (res && res.data) {
            if (!res.data.campus) {
                res.data.campus = { campus: {} };
            }
            if (!res.data.campus.campus) {
                res.data.campus.campus = {};
            }
            res.data.reset_title =
                `【${res.data.contact.lesson_type === 1 ? res.data.contact.surplus_lesson_time + "节" : ''}
                        ${['', '', '年卡'][res.data.contact.lesson_type]} |${res.data.campus.sub_course_type}】${res.data.transfer_info.title}`;

            state.current_goods_detail = res.data;
            try{
                setApi(res.data.transfer_info.title, '我在旦旦发现宝贝了！', res.data.transfer_info.attachments[0], window.location.href);
            }catch(e){
                
            }
            
            console.log(state.current_goods_detail);
            if (state.current_goods_detail.collection !== 1) {
                document.getElementById("do_collection").className = "item show";
                document.getElementById("do_uncollection").className = "item hide";
            } else {
                document.getElementById("do_collection").className = "item hide";
                document.getElementById("do_uncollection").className = "item show";
            }
            initMap();

        }
    })
}
let isLoading =false;
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
                                <div class="name"><a class="title-link" title="${item.reset_title}" href="${window.location.protocol}//${window.location.hostname}/detail/${item.goods_id}.html">${item.reset_title}</a></div>
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

function showUpdating() {
    document.getElementsByClassName("updating-view")[0].className = "updating-view show";
}

function showService() {
    showUpdating();
}

function doCollection() {
    showUpdating();
}

function handleValueChange(t, e) {
    console.log(t, e);
    showUpdating();
}

function createPoster() {
    showUpdating();
}

function createOrder() {
    showUpdating();
}

function showMap() {
    let item = state.current_goods_detail;
    window.location.href = `https://apis.map.qq.com/tools/poimarker?type=0&marker=coord:${item.campus.campus.latitude},${item.campus.campus.longitude};title:${item.campus.campus.name};addr:${item.campus.campus.address}&key=75ABZ-MJ76R-AZ7WK-W6ZLZ-45TBK-W7FJV&referer=dandanzkw`
}

function initMap() {
    if (!state.current_goods_detail)
        return;

    //定义地图中心点坐标
    var center = new TMap.LatLng(state.current_goods_detail.campus.campus.latitude, state.current_goods_detail.campus.campus.longitude)
        //定义map变量，调用 TMap.Map() 构造函数创建地图
    var map = new TMap.Map(document.getElementById('map_container'), {
        center: center, //设置地图中心点坐标
        zoom: 17.2, //设置地图缩放级别
        pitch: 43.5, //设置俯仰角
        rotation: 45 //设置地图旋转角度
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
    // getGoodsDetail();
    getGoods();

    scrollToBottom('product-detail', null, () => {
        state.goods_params.page_number++;
        showLoading();
        getGoods();
    })

    var swiper = new Swiper(".mySwiper", {
        loop: true,
        autoplay: true
    });
})