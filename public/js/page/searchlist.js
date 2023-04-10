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
    select_type_list: [
        	{
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
    packages: [],
    package_params: {
        page_size: 5,
        page_number: 1
    },
};

let isEnd = false;
function getGoods(params = state.package_params) {
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

            state.packages = state.packages.concat(res.data.page_data);

            for (let i in res.data.page_data) {
                let item = res.data.page_data[i];
                drawPackagesItem(item);
            }

        } else {
            console.log("packages get error");
        }
        console.log('state.packages', state.packages);



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
    });

}

function drawSearchNav(){
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
    drawPrices();//构建价格列表
    drawLessonCategories();//构建课程类别列表
    drawSearchNav();//构建筛选菜单总列表

    scrollToBottom(null, 'packages', () => {
        if (isEnd) {
            return;
        }
        showLoading();
        state.package_params.page_number++;
        getGoods();
    })
    showLoading();
    getGoods();
});



function getSearchInput(e) {
    console.log(e);
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
function showGoodDetail(e, e2) {
    console.log(e, e2)
}

function resetParams() {
    delete state.package_params.min_price;
    delete state.package_params.lesson_category_ids;
    delete state.package_params.max_price;
    updateUI('lessonCategories', -1);
    document.getElementById("min_price").value = null;
    document.getElementById("max_price").value = null;
}

function submit() {
    isEnd = false;
    doSelectSort(-1);
    state.package_params.page_number = 1;
    document.getElementById("packages").innerHTML = '';
    showLoading();
    getGoods();
}

function updateParams(t, e, e2) {

    switch (t) {
        case 'min_price':
        case 'max_price':
            e = document.getElementById(t).value;
            state.package_params[t] = e;
            break;
        case 'prices':
            state.package_params['min_price'] = e;
            document.getElementById("min_price").value = e;
            if (parseInt(e2) !== -1) {
                state.package_params['max_price'] = e2;
                document.getElementById("max_price").value = e2;
            } else {
                delete (state.package_params['max_price']);
                document.getElementById("max_price").value = null;
            }
            break;
        case 'lesson_category_ids':
            state.package_params[t] = e;
            updateUI('lessonCategories', e);
            break;
        default:
            state.package_params[t] = e;
            break;
    }


    console.log(state.package_params);
}

function updateUI(t, e) {
    switch (t) {
        case "lessonCategories":
            let list = document.getElementById(t).children;
            for (let i in list) {
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
    for(let i in searchNavs){
        let item = searchNavs[i];
        if(item.id===`select_type_list_${index}`){
            item.className = `item hover color-blue`;
        }else{
            item.className = `item`;
        }
    }

    if (index === 1) {
        showLoading();
        isEnd = false;
        state.params = {
            page_number: 1,
            page_size: 5,
            // lantitude:1,
            // longtitude:1
        }
        document.getElementById("packages").innerHTML = '';
        getGoods();
    } else {
        delete state.package_params.lantitude;
        delete state.package_params.longtitude;
    }
}

function drawPackagesItem(item) {
    let item_div = document.createElement("div");
    item_div.id = `packageItem_${item.id}`;
    item_div.className = "item";
    item_div.onclick = showGoodDetail.bind(this, item.id);
    item_div.innerHTML = `<div class="part1">
        <img class="thumbnail" src="${item.transfer_info.attachments && item.transfer_info.attachments[0] ? item.transfer_info.attachments[0] : 'https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/banner/微信图片_20210628113403.png'}"/>
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
    document.getElementById("packages").appendChild(item_div);
}