//逻辑代码
let test_fenlei = [{ id: 1, name: "早教亲子" }, { id: 2, name: "英语培训" }, { id: 3, name: "日语培训" }];
test_fenlei = [{ id: 0, name: "全部" }].concat(test_fenlei);
let swiper_new_goods;
let state = {
    current_location: null,
    brands: [],
    purchase_logs: [
        "平台已完成认证技术和运营流程升级，卖家无需上传身份证即可发布订单",
        "卖家订单免费发布，不成功不收费",
        "平台网页版已上线，各平台流量互通，更快对接买卖双方"
    ],
    lesson_category: [],
    banners: [],
    goods: [],
    goods_params: {
        page_size: 6,
        page_number: 1,
    },
    goods_divs: {

    }
}

function clickSelectNavItem(item) {
    console.log(item);
    let list = document.getElementsByClassName("select-nav-item");
    for (let i in list) {
        if (list[i].id == `selectNavItem${item.id}`) {
            if (list[i].className.indexOf("hover") >= 0) {
                return;
                // list[i].className = `select-nav-item`;
                // delete state.goods_params.lesson_category_ids;
            } else {
                if (item.id === 0) {
                    delete state.goods_params.lesson_category_ids;
                } else {
                    state.goods_params.lesson_category_ids = item.id;
                }

                list[i].className = `select-nav-item hover`;
            }
            isEnd = false;
            state.goods_params.page_number = 1;
            console.log(state.goods_params);
            showLoading();
            getGoods();

        } else {
            list[i].className = `select-nav-item`;
        }
    }

}

function getLessonCategories() {
    Get(mRoute.lesson_category, null, (res) => {
        if (res.data) {
            state.lesson_category = res.data
        } else {
            console.log("lesson_category get error");
        }
        console.log('state.lesson_category', state.lesson_category);

        document.getElementById("lesson_categorys").innerHTML = '';
        let select_nav_item_all = document.createElement("div");
        select_nav_item_all.innerHTML = `全部`;
        select_nav_item_all.className = "select-nav-item hover";
        select_nav_item_all.id = `selectNavItem0`;
        select_nav_item_all.onclick = clickSelectNavItem.bind(this, { id: 0, name: "全部" });
        document.getElementsByClassName("select-nav-items")[0].appendChild(select_nav_item_all);
        for (let i in state.lesson_category) {
            let lesson_category = document.createElement("div");
            lesson_category.innerText = state.lesson_category[i];
            lesson_category.onclick = goTo.bind(null, 'search', 'category_id', state.lesson_category[i].id)
            lesson_category.className = "item";
            lesson_category.innerHTML = `
             <div class="item-icon-box">
                 <div class="item-icon"
                     style='background-image: url("${state.lesson_category[i].attachments[0]}"); background-position: 0% 0%; background-size: 100% 100%;'>
                 </div>
             </div>
             <div class="item-name">${state.lesson_category[i].name}</div>`;
            document.getElementById("lesson_categorys").appendChild(lesson_category);

            let select_nav_item = document.createElement("div");
            select_nav_item.innerHTML = state.lesson_category[i].name;
            select_nav_item.className = "select-nav-item";
            select_nav_item.id = `selectNavItem${state.lesson_category[i].id}`;
            select_nav_item.onclick = clickSelectNavItem.bind(this, state.lesson_category[i]);
            // select_nav_item.id = `selectNavItem_${test_fenlei[i].id}`;
            document.getElementsByClassName("select-nav-items")[0].appendChild(select_nav_item);

        }

    })
}
getLessonCategories();

function getPurChaseLogs() {
    // Get(mRoute.purchase_logs, null, (res) => {
    //     if (res.data) {
    //         state.purchase_logs = res.data
    //     } else {
    //         console.log("purchase_logs get error");
    //     }
    //     console.log('state.purchase_logs', state.purchase_logs);

    document.getElementById("purchase_logs").innerHTML = '';
    for (let i in state.purchase_logs) {
        let purchase_log = document.createElement("div");
        purchase_log.innerText = state.purchase_logs[i];
        purchase_log.className = "name";
        document.getElementById("purchase_logs").appendChild(purchase_log);
    }

    // })
}
// getPurChaseLogs();

function getBanners() {
    Get(mRoute.banners, null, (res) => {
        if (res.data) {
            state.banners = res.data
        } else {
            console.log("banners get error");
        }
        console.log('state.banners', state.banners);

        document.getElementById("banners").innerHTML = '';
        for (let i in state.banners) {
            let banner = document.createElement("div");
            banner.className = `banner-image swiper-slide`;
            banner.innerHTML = `<img src="${state.banners[i].attachments[0]}"/>`;
            document.getElementById("banners").appendChild(banner);


        }
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            autoplay: true
        });
    })
}
getBanners();


function getBrandList() {
    return; //暂不获取品牌列表信息
    Get(mRoute.brands, null, (res) => {
        if (res.data) {
            state.brands = res.data
        } else {
            console.log("brands get error");
        }
        console.log('state.brands', state.brands);

        document.getElementById("brands").innerHTML = '';


        for (let i in state.brands) {
            let brand = document.createElement("div");
            brand.className = `item`;
            brand.onclick = goTo.bind(null, 'search', 'data', state.brands[i].name)
            brand.innerHTML = `<div class="logo" style='background-image:url("${state.brands[i].attachments[0]}");'>
                 </div>`;
            brand.innerHTML += `<div class="name">${state.brands[i].name}</div>`;
            brand.innerHTML += `<div class="desc"></div>`;
            document.getElementById("brands").appendChild(brand);

        }
    })
}
getBrandList();


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
let isEnd = false;

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
            if (state.goods_params.page_number === 1) {
                document.getElementById("goods_left").innerHTML = '';
                document.getElementById("goods_right").innerHTML = '';
            }

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
                if (item && item.campus && item.campus.campus) {
                    //处理省市区 保留关键数据
                    item.reset_address = JSON.parse(JSON.stringify(item.campus.campus
                        .address));
                    console.log("---item.reset_address", item.reset_address);
                    if (item.reset_address.indexOf("省") > 0) {
                        item.reset_address = item.reset_address.split("省")[1];
                    }
                    if (item.reset_address.indexOf("镇") > 0) {
                        item.reset_address = item.reset_address.split("镇")[0] + "镇";
                    }
                    if (item.reset_address.indexOf("县") > 0) {
                        item.reset_address = item.reset_address.split("县")[0] + "县";
                    }
                    if (item.reset_address.indexOf("区") > 0) {
                        item.reset_address = item.reset_address.split("区")[0] + "区";
                    }

                    let subSHI0 = item.reset_address.substring(0, item.reset_address.indexOf("市") + 1);
                    let subSHI = item.reset_address.substring(item.reset_address.indexOf("市") + 1, item.reset_address.length);
                    if (subSHI.indexOf("市") >= 0) {
                        let subsub = subSHI;
                        subSHI = subsub.substring(subsub.indexOf("市") + 1, subsub.length);
                        subSHI0 = subsub.substring(0, subsub.indexOf("市") + 1);
                    }
                    item.reset_address = subSHI.length > 5 ? subSHI0 : subSHI;
                } else {
                    item.reset_address = '';
                }


                let item_div = document.createElement('div');
                item_div.className = 'item';
                item_div.id = `goods_id_${item.goods_id}`;
                item_div.onclick = showGoodDetail.bind(null, item.goods_id);
                item_div.innerHTML = `
                        <img class="thumbnail" onload="drawGood(${item.goods_id})"
                            src="${item.transfer_info.attachments && item.transfer_info.attachments[0] ? item.transfer_info.attachments[0] : 'https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/banner/微信图片_20210628113403.png'}">
                        </div>
                        <div class="position-box">
                            <div class="icon"
                                style='background-image: url("https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/images/dingwei_icon.png"); background-position: center center; background-size: cover;'>
                            </div>
                            <div class="address">${item.reset_address}</div>
                        </div>
                        <div class="infos">
                            <div class="line1">
                                <div class="tag">卖家自转</div>
                                <div class="name">${item.reset_title}</div>
                            </div>
                            <div class="line2">
                                <div class="price"> ¥${item.transfer_info.price > 10000 ? parseInt(item.transfer_info.price / 1000) / 10 + "万" : item.transfer_info.price}</div>
                                <div class="want">${item.view_num}人查看</div>
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
function getLocationByApi() {
    var geolocation = new qq.maps.Geolocation("75ABZ-MJ76R-AZ7WK-W6ZLZ-45TBK-W7FJV", "dandanzkw");
    geolocation.getLocation((res) => {
        console.log('-------', res);
        state.current_location = res;
        state.goods_params.latitude = res.lat;
        state.goods_params.longitude = res.lng;
        state.goods_params.type = 4;
        state.goods_params.sort_by = "asc";
        document.getElementById("currentLocation").innerText = res.city;
        sessionStorage.setItem('location', JSON.stringify(res));
        getGoods();
    }, (err) => {
        document.getElementById("custom_popup_btn_ok").className = "btn-cancel btn-only";
        document.getElementById("custom_popup_btn_cancel").style = "display:none";
        customPopup.className = 'custom-popup show';
        console.log('------------', err);
        document.getElementById("currentLocation").innerText = "定位失败";
        getGoods();
    }, { timeout: 4000 });
}

function setIndexNum() {
    let random = [11, 13, 10, 12, 14, 8, 9][moment().day()];
    let random2 = [7, 6, 8, 7, 6, 8, 9][moment().day()];
    random += moment().date() % 2;
    console.log(random);
    let defaultNum = 4284 + parseInt(((new Date().getTime() - new Date("2023-04-01").getTime()) / 1000 / 60 / 60 / 24) * 39.5);
    let todayDefaultNum = parseInt((new Date().getTime() - new Date(moment().format("YYYY-MM-DD 10:00:00")).getTime()) / 1000);
    todayDefaultNum = Math.max(0, todayDefaultNum);
    todayDefaultNum = Math.min(28800, todayDefaultNum);
    document.getElementById("indexNum1").innerText = parseInt(todayDefaultNum / (60 * random + 11));
    document.getElementById("indexNum2").innerText = defaultNum + parseInt(todayDefaultNum / (60 * random + 11));
    document.getElementById("indexNum3").innerText = Math.min(parseInt(todayDefaultNum / (60 * random + 11) / 3), parseInt(todayDefaultNum / (60 * random + 11) / 5 + random2));
    setTimeout(() => {
        setIndexNum();
    }, 100000);

}

$(document).ready(() => {
    setIndexNum();
    getPurChaseLogs();
    getGoods();

    $("#searchInput").keyup((e) => {
        // if (e.keyCode == "13") {
        //     let searchInput = $("#searchInput").val();
        //     sessionStorage.setItem("searchInput", searchInput);
        goTo('search', 'category', 0);
        // }
    })

    scrollToBottom('page-index', null, () => {
        state.goods_params.page_number++;
        showLoading();
        getGoods();
    })

    swiper_new_goods = new Swiper('.swiper-new-goods', {
        slidesPerView: 3,
        spaceBetween: 10,
        centeredSlides: true,
        autoplay: true,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
})