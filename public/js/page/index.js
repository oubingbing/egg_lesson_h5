//逻辑代码
let test_fenlei = [{ id: 1, name: "早教亲子" }, { id: 2, name: "英语培训" }, { id: 3, name: "日语培训" }];
test_fenlei = [{ id: 0, name: "全部" }].concat(test_fenlei);

let state = {
    brands: [],
    purchase_logs: [],
    lesson_category: [],
    banners: [],
    packages: [],
    package_params: {
        page_size: 4,
        page_number: 1,
    },
    goods_divs: {

    }
}

Get(mRoute.lesson_category, null, (res) => {
    if (res.data) {
        state.lesson_category = res.data
    } else {
        console.log("lesson_category get error");
    }
    console.log('state.lesson_category', state.lesson_category);

    document.getElementById("lesson_categorys").innerHTML = '';
    for (let i in state.lesson_category) {
        let lesson_category = document.createElement("div");
        lesson_category.innerText = state.lesson_category[i];
        lesson_category.onclick = goTo.bind(null, 'search', 'data', state.lesson_category[i].name)
        lesson_category.className = "item";
        lesson_category.innerHTML = `
         <div class="item-icon-box">
             <div class="item-icon"
                 style='background-image: url("${state.lesson_category[i].attachments[0]}"); background-position: 0% 0%; background-size: 100% 100%;'>
             </div>
         </div>
         <div class="item-name">${state.lesson_category[i].name}</div>`;
        document.getElementById("lesson_categorys").appendChild(lesson_category);
    }

})
Get(mRoute.purchase_logs, null, (res) => {
    if (res.data) {
        state.purchase_logs = res.data
    } else {
        console.log("purchase_logs get error");
    }
    console.log('state.purchase_logs', state.purchase_logs);

    document.getElementById("purchase_logs").innerHTML = '';
    for (let i in state.purchase_logs) {
        let purchase_log = document.createElement("div");
        purchase_log.innerText = state.purchase_logs[i];
        purchase_log.className = "name";
        document.getElementById("purchase_logs").appendChild(purchase_log);
    }

})
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

        var swiper = new Swiper(".mySwiper", {
            loop: true,
            autoplay: true
        });
    }
})


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

function drawGood(goods_id) {
    let left = document.getElementById("goods_left");
    let right = document.getElementById("goods_right");
    if (left.offsetHeight >= right.offsetHeight) {
        right.appendChild(state.goods_divs[goods_id]);
    } else {
        left.appendChild(state.goods_divs[goods_id]);
    }
}
let isEnd = false;
function getGoods(params = state.package_params) {
    isLoading=true;
    if(isEnd){
        hideLoading();
        return;
    }
    Get(mRoute.goods_page, params, res => {
        if (res.data) {
            isLoading=false;
            hideLoading();
            if(!res.data.page_data.length){
                isEnd = true;
            }
            for (let i in res.data.page_data) {
                res.data.page_data[i].reset_title =
                    `【${res.data.page_data[i].contact.lesson_type === 1 ? res.data.page_data[i].contact.surplus_lesson_time + "节" : ''}
                        ${['', '', '年卡'][res.data.page_data[i].contact.lesson_type]} |${res.data.page_data[i].campus.sub_course_type}】${res.data.page_data[i].transfer_info.title}`;
            }

            state.packages = state.packages.concat(res.data.page_data);

            let left_height = document.getElementById("goods_left").offsetHeight;
            let right_height = document.getElementById("goods_right").offsetHeight;
            for (let i in res.data.page_data) {
                let item = res.data.page_data[i];

                let item_div = document.createElement('div');
                item_div.className = 'item uncount';
                item_div.id = `goods_id_${item.goods_id}`;
                item_div.innerHTML = `
                        <img class="thumbnail" onload="drawGood(${item.goods_id})"
                            src="${item.transfer_info.attachments[0]}">
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
            console.log("packages get error");
        }
        console.log('state.packages', state.packages);



    })
}


$(document).ready(() => {


    getGoods();


    for (let i in test_fenlei) {
        console.log(i, i == 0);
        let select_nav_item = document.createElement("div");
        select_nav_item.innerHTML = test_fenlei[i].name;
        select_nav_item.className = "select-nav-item";
        select_nav_item.id = `selectNavItem_${test_fenlei[i].id}`;
        if (i == 0) {
            select_nav_item.className = "select-nav-item hover";

        }
        $(".select-nav-items").append(select_nav_item);
    }

    $("#searchInput").keyup((e) => {
        if (e.keyCode == "13") {
            let searchInput = $("#searchInput").val();
            sessionStorage.setItem("searchInput", searchInput);
            window.location.href = window.location.href + "search?data=" + searchInput;
        }
    })

    scrollToBottom('page-index', null, () => {
        state.package_params.page_number++;
        showLoading();
        getGoods();
    })
})