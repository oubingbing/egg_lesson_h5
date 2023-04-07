var state = {
    packages: [1, 2, 3, 4, 5, 6, 7, 8],
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
    ]
};
$(document).ready(() => {
    for (let i in state['select_type_list']) {
        let select_type = document.createElement('div');
        select_type.onclick = doSelectSort.bind(this, state['select_type_list'][i].value);
        select_type.className = 'item hover';
        select_type.innerText = state['select_type_list'][i].label;
        select_type.id = `select_type_list_${i}`;
        document.getElementById("searchNav").appendChild(select_type);

        document.getElementById("packages").addEventListener('scroll',packagesScroll,true);
    }

    drawPackagesItem();

});

function packagesScroll(e){
    let scrollHeight = document.getElementById('packages').scrollHeight;
    let windowTop = document.body.clientHeight;
    let scrollTop = document.getElementById('packages').scrollTop;
    if(windowTop+scrollTop+100>scrollHeight && !isLoading ){
        showLoading();
        setTimeout(()=>{
            hideLoading();
            drawPackagesItem();
        },2000);
    }

}


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
function getGoods() {

}

function doSelectSort(index) {
    console.log("index", index);

    //显示菜单浮窗
    for (let i in state.select_type_list) {
        console.log($(`.modal-select-list-${state.select_type_list[i].value}-content`));
        $(`.modal-select-list-${state.select_type_list[i].value}-content`).removeClass("show");
    }
    console.log(index !== -1);
    if (index !== -1) {
        $(".modal-select-list").addClass("show");
        $(`.modal-select-list-${index}-content`).addClass("show");
    } else {
        $(".modal-select-list").removeClass("show");
    }

    if (index === state.now_select_type_index && index !== -1) {
        state.now_select_type_index = null;
        state.params = {
            page_number: 1,
            page_size: 5
        }
        getGoods();
        return;
    }


    state.now_select_type_index = index;


    if (index === 4) {
        getGoods();
        return;
    }
    if (index !== -1) {
        let now_select_type = state.select_type_list[index];
        state.show_select_modal = now_select_type.value;
        console.log(state);
    }

}

function drawPackagesItem() {
    for (let i in state.packages) {
        let item = document.createElement("div");
        item.id = `packageItem_${i}`;
        item.className="item";
        item.onclick = showGoodDetail.bind(i);
        item.innerHTML = `<div class="part1">
        <img class="thumbnail" src="item.transfer_info.attachments[0]"/>
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
    </div>`;
    console.log(item);
        document.getElementById("packages").appendChild(item);
    }


}