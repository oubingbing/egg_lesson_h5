var state = {
    data: [],
    params: {
        page_num: 1,
        page_size: 10
    }
}

function doAjax(params = state.params) {
    showLoading();
    console.log(window.location.href);
    if (!state.params.category_id) {
        state.params.category_id = (window.location.href.split("/list/"))[1].split(".html")[0];
    }
    console.log(state.params.category_id);
    Get(mRoute.article_list, params, res => {
        if(state.params.page_num===1){
            state.data = [];
        }
        state.page = res.data.page;
        state.data = state.data.concat(res.data.page_data);
        console.log(state.data);
        hideLoading();
        for (let i in state.data) {
            let item = document.createElement("div");
            item.className = "item";
            item.innerHTML = `<p class="t1">${state.data[i].created_at}</p>
    <p class="t2">${state.data[i].title}</p>`;
            let showDetailBtn = document.createElement("p");
            showDetailBtn.className = `t3`;
            showDetailBtn.innerText=`查看更多`;
            item.onclick = goTo.bind(this, "article_detail", `id`, state.data[i].id);
            item.appendChild(showDetailBtn);
            document.getElementById("articleList").appendChild(item);
        }
    }, err => {

    });

}

$(document).ready(() => {
    this.doAjax();

    setTimeout(()=>{
        $(".search-bar").removeClass("noshow")
    },1200);
    setTimeout(()=>{
        $(".search-tips").removeClass("noshow")
    },1400);
    document.getElementById("searchInput").addEventListener("keyup", (e) => {

        if (parseInt(e.keyCode) === 13) {
            document.getElementById("articleList").innerHTML = '';
            state.params.page_num = 1;
            this.doAjax();
        } else {
            console.log(document.getElementById("searchInput").value);
            state.params.filter = document.getElementById("searchInput").value;
            console.log(state);
        }
    })

    scrollToBottom('article-list-container', null, () => {
        state.params.page_num++;
        showLoading();

        doAjax();
    })
})