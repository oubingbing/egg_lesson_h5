var state = {
    show_search_menu: false,
    now_select_type_index: 4,
    genders: [{
        id: 1,
        name: "男"
    }, {
        id: 2,
        name: "女"
    }],
    brands: [],
    course_types: [],
    prices: [{
        id: 0,
        name: "0-1,999",
        min_price: 0,
        max_price: 1999
    }, {
        id: 2000,
        name: "2,000-4,999",
        min_price: 2000,
        max_price: 4999
    }, {
        id: 5000,
        name: "5,000-9,999",
        min_price: 5000,
        max_price: 9999
    }, {
        id: 10000,
        name: "10,000-14,999",
        min_price: 10000,
        max_price: 14999
    }, {
        id: 15000,
        name: "15,000-19,999",
        min_price: 15000,
        max_price: 19999
    }, {
        id: 20000,
        name: "20,000-24,999",
        min_price: 20000,
        max_price: 24999
    }, {
        id: 25000,
        name: "25,000以上",
        min_price: 25000,
        max_price: -1
    }],
    ages: [{
        id: 1,
        name: "1-2岁"
    }, {
        id: 2,
        name: "2-3岁"
    }, {
        id: 3,
        name: "3-4岁"
    }, {
        id: 4,
        name: "4-5岁"
    }, {
        id: 5,
        name: "5-6岁"
    }, {
        id: 6,
        name: "6-7岁"
    }],
    areas: [{
        value: 1,
        label: "全国"
    }, {
        value: 2,
        label: "深圳"
    }, {
        value: 3,
        label: "上海"
    }],
    select_type_list: [{
            value: 1,
            label: "附近",
            sort: "desc"
        },
        {
            value: 2,
            label: "价格",
            sort: "desc"
        },
        // {
        // 	value: 3,
        // 	label: "区域筛选",
        // 	sort: "desc"
        // }, 
        {
            value: 4,
            label: "课类筛选",
            sort: "desc"
        }
    ],
    goods: [],
    goods_params: {
        page_size: 20,
        page_number: 1
    },
};

//获取url传参
let url_params_text = window.location.href.split('search/')[1];
url_params_text = url_params_text.split('.html')[0];
if(!!url_params_text && parseInt(url_params_text)!==0){
    state.goods_params.lesson_category_ids = url_params_text;
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
            if (!res.data.page_data.length) {
                isEnd = true;
            }
            for (let i in res.data.page_data) {
                res.data.page_data[i].reset_title =
                    `【${res.data.page_data[i].contact.lesson_type === 1 ? res.data.page_data[i].contact.surplus_lesson_time + "节" : ''}
                        ${['', '', '年卡'][res.data.page_data[i].contact.lesson_type]} |${res.data.page_data[i].campus.sub_course_type}】${res.data.page_data[i].transfer_info.title}`;
                res.data.page_data[i].transfer_info.price_text = toMoney(res.data.page_data[i].transfer_info
                    .price);
            }

            state.goods = state.goods.concat(res.data.page_data);

            for (let i in res.data.page_data) {
                let item = res.data.page_data[i];
                drawPackagesItem(item);
            }

        } else {
            console.log("goods get error");
        }
        console.log('state.goods', state.goods);



    })
}

function drawPrices() {
    for (let i in state.prices) {
        let item = state.prices[i];
        let item_div = document.createElement('div');
        item_div.innerText = item.name;
        item_div.className = `item`;
        item_div.onclick = updateParams.bind(null, 'prices', item.min_price, item.max_price);
        document.getElementById("prices").appendChild(item_div);
    }
}

function drawLessonCategories() {

    Get(mRoute.lesson_category, null, (res) => {
        if (res.data) {
            state.lesson_category = res.data
        } else {
            console.log("lesson_category get error");
        }
        console.log('state.lesson_category', state.lesson_category);



        for (let i in state.lesson_category) {
            let item = state.lesson_category[i];
            let item_div = document.createElement('div');
            item_div.innerText = item.name;
            item_div.className = `item`;
            item_div.id = `lessonCategory${item.id}`;
            item_div.onclick = updateParams.bind(null, 'lesson_category_ids', item.id);
            document.getElementById("lessonCategories").appendChild(item_div);
        }

        //获取之后检测是否有已选中的项   
        if (!!state.goods_params.lesson_category_ids) {
            updateUI('lessonCategories', state.goods_params.lesson_category_ids);
        }
    });

}

function drawSearchNav() {
    for (let i in state['select_type_list']) {
        let item = state['select_type_list'][i];
        let select_type = document.createElement('div');
        select_type.onclick = doSelectSort.bind(this, item.value);
        select_type.className = `item`;
        select_type.innerText = item.label;
        select_type.id = `select_type_list_${item.value}`;
        document.getElementById("searchNav").appendChild(select_type);
    }
}

$(document).ready(() => {
    try {
        document.getElementById("searchInput").value = state.goods_params.brands ? state.goods_params.brands : '';
    } catch (e) {
        console.log(e)
    }

    $("#searchInput").keyup((e) => {
        if (e.keyCode == "13") {
            getSearchInput();
        }
    })

    drawPrices(); //构建价格列表
    drawLessonCategories(); //构建课程类别列表
    drawSearchNav(); //构建筛选菜单总列表

    // container.on('submit', '#searchInput', function(event){
    //     event.preventDefault();
    // })

    scrollToBottom(null, 'goods', () => {
        if (isEnd) {
            return;
        }
        showLoading();
        state.goods_params.page_number++;
        getGoods();
    })
    showLoading();
    getGoods();
    
});



function saveLocation(p){
    console.log("----p",p);
    state.location = {
        latitude:p.latitude,
        longitude:p.longitude
    }
    console.log(state);
    getGoods();
}




function getSearchInput() {
    state.goods_params.brands = document.getElementById("searchInput").value;
    state.goods_params.page_number = 1;
    document.getElementById("goods").innerHTML = '';
    console.log(state.goods_params);
    isEnd = false;
    showLoading();
    getGoods();
    return false;
}

function handleValueChange(t, v) {
    state[t] = v;
    switch (t) {
        case "show_select_modal":
            doSelectSort(v);
            break;
        default:
            break;
    }
}

function quickSearch(e) {
    console.log("e", e);
}

function resetParams() {
    delete state.goods_params.min_price;
    delete state.goods_params.lesson_category_ids;
    delete state.goods_params.max_price;
    delete state.goods_params.latitude;
    delete state.goods_params.longitude;
    updateUI('lessonCategories', -1);
    document.getElementById("min_price").value = null;
    document.getElementById("max_price").value = null;
}

function submit() {
    isEnd = false;
    doSelectSort(-1);
    state.goods_params.page_number = 1;
    document.getElementById("goods").innerHTML = '';
    showLoading();
    getGoods();
}

function updateParams(t, e, e2) {
    console.log(t, e, e2)
    switch (t) {
        case 'min_price':
        case 'max_price':
            e = document.getElementById(t).value;
            state.goods_params[t] = e;
            break;
        case 'prices':
            state.goods_params['min_price'] = e;
            document.getElementById("min_price").value = e;
            if (parseInt(e2) !== -1) {
                state.goods_params['max_price'] = e2;
                document.getElementById("max_price").value = e2;
            } else {
                delete(state.goods_params['max_price']);
                document.getElementById("max_price").value = null;
            }
            break;
        case 'lesson_category_ids':
            state.goods_params[t] = e;
            updateUI('lessonCategories', e);
            break;
        default:
            state.goods_params[t] = e;
            break;
    }


    console.log(state.goods_params);
}

function updateUI(t, e) {
    console.log('tag 305', t, e)
    switch (t) {
        case "lessonCategories":
            let list = document.getElementById(t).children;
            for (let i in list) {
                console.log(list[i].id, `lessonCategory${e}`, list[i].id === `lessonCategory${e}`)
                if (list[i].id === `lessonCategory${e}`) {
                    list[i].className = `item hover`;
                } else {
                    list[i].className = `item`;
                }
            }
            break;
    }
}

function doSelectSort(index) {
    index = parseInt(index);

    //显示菜单浮窗
    for (let i in state.select_type_list) {
        $(`.modal-select-list-${state.select_type_list[i].value}-content`).removeClass("show");
    }
    if (index !== -1 && index !== 1) {
        $(".modal-select-list").addClass("show");
        $(`.modal-select-list-${index}-content`).addClass("show");
    } else {
        $(".modal-select-list").removeClass("show");
    }

    state.now_select_type_index = index;
    let searchNavs = document.getElementById("searchNav").children;
    for (let i in searchNavs) {
        let item = searchNavs[i];
        if (item.id === `select_type_list_${index}`) {
            item.className = `item hover color-blue`;
        } else {
            item.className = `item`;
        }
    }

    if (index === 1) {
        showLoading();
        isEnd = false;
        state.goods_params.page_number=1;
        if(state.location.latitude){
            state.goods_params.latitude = state.location.latitude;
            state.goods_params.longitude = state.location.longitude;
            state.goods_params.sort_by = 'asc';
            state.goods_params.type = 4;//附近课程筛选
            document.getElementById("goods").innerHTML = '';
        getGoods();
        }else{
            getLocationByApi(JSON.parse(JSON.stringify(state.goods_params)),saveLocation);
        }
        
    } else {
        delete state.goods_params.lantitude;
        delete state.goods_params.longtitude;
    }
}

function drawPackagesItem(item) {
    let item_div = document.createElement("div");
    item_div.id = `packageItem_${item.goods_id}`;
    item_div.className = "item";
    item_div.onclick = showGoodDetail.bind(null, item.goods_id);
    item_div.innerHTML = `<div class="part1">
        <div class="thumbnail" style="background-image:url(${item.transfer_info.attachments && item.transfer_info.attachments[0] ? item.transfer_info.attachments[0] : 'https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/banner/微信图片_20210628113403.png'});"></div>
        <div class="infos">
            <div class="t1">
                ${item.reset_title}
            </div>
            <div class="t2">有效期：${item.contact.contract_expired}</div>

            <div class="t3">
                <div>课程类型：${item.campus.lesson_category.name}</div>
                <div>
                    课卡类型：${['', '次卡', '年卡'][item.contact.lesson_type]}&nbsp;&nbsp;剩余课时：${item.contact.surplus_lesson_time}节
                </div>
                <div>
                    适课年龄：${item.contact.min_year}-${item.contact.max_year}岁&nbsp;&nbsp;
                    适课性别：${['', '男', '女', '不限'][item.contact.lesson_gender]}
                </div>
            </div>
        </div>
    </div>

    <div class="part2">
        ${item.transfer_info.title}
    </div>
    <div class="part3">
        <div class="price">${item.transfer_info.price_text}</div>
        <div class="discount">${item.transfer_info.discount}折</div>
        <div class='distance'>${item.distance ? item.distance + "km" : ''}</div>
    </div>`;
    document.getElementById("goods").appendChild(item_div);
}