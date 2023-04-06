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
    }

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