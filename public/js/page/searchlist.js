var state = {
    show_search_menu: false,
    now_select_type_index: 4,
    select_type_list: [
        // 	{
        // 	value: 1,
        // 	label: "附近",
        // 	sort: "desc"
        // }, 
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
        page_size: 4,
        page_number: 1
    }
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



$(document).ready(() => {
    for (let i in state['select_type_list']) {
        let select_type = document.createElement('div');
        select_type.onclick = doSelectSort.bind(this, state['select_type_list'][i].value);
        select_type.className = 'item hover';
        select_type.innerText = state['select_type_list'][i].label;
        select_type.id = `select_type_list_${i}`;
        document.getElementById("searchNav").appendChild(select_type);


    }

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

}

function submit() {

}

function updateParams() {

}

function doSelectSort(index) {
    index = parseInt(index);
   
    //显示菜单浮窗
    for (let i in state.select_type_list) {
        $(`.modal-select-list-${state.select_type_list[i].value}-content`).removeClass("show");
    }
    if (index !== -1) {
        $(".modal-select-list").addClass("show");
        $(`.modal-select-list-${index}-content`).addClass("show");
    } else {
        $(".modal-select-list").removeClass("show");
    }

    if (index == state.now_select_type_index && index != -1) {
        state.now_select_type_index = null;
        state.params = {
            page_number: 1,
            page_size: 5
        }
        document.getElementById("packages").innerHTML = '';
        getGoods();
        return;
    }


    state.now_select_type_index = index;

    if(index===1){
        state.package_params.lantitude =1;
        state.package_params.longtitude = 1;
    }else{
        delete state.package_params.lantitude;
        delete state.package_params.longtitude;
    }


    if (index === 4) {
        getGoods();
        return;
    }
}

function drawPackagesItem(item) {
    let item_div = document.createElement("div");
    item_div.id = `packageItem_${item.id}`;
    item_div.className = "item";
    item_div.onclick = showGoodDetail.bind(this,item.id);
    item_div.innerHTML = `<div class="part1">
        <img class="thumbnail" src="${item.transfer_info.attachments&&item.transfer_info.attachments[0]?item.transfer_info.attachments[0]:'https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/banner/微信图片_20210628113403.png'}"/>
        <div class="infos">
            <div class="t1">
                ${item.reset_title}
            </div>
            <div class="t2">有效期：${item.contact.contract_expired}</div>

            <div class="t3">
                <div>课程类型：${item.campus.lesson_category.name}</div>
                <div>
                    课卡类型：${['','次卡','年卡'][item.contact.lesson_type]}&nbsp;&nbsp;剩余课时：${item.contact.surplus_lesson_time}节
                </div>
                <div>
                    适课年龄：${item.contact.min_year}-${item.contact.max_year}岁&nbsp;&nbsp;
                    适课性别：${['','男','女','不限'][item.contact.lesson_gender]}
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
        <div class='distance'>${item.distance?item.distance+"km":''}</div>
    </div>`;
    document.getElementById("packages").appendChild(item_div);
}