var state = {
    data: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
    params: {
        page_number: 1,
        page_size: 10
    }
}

function doAjax() {

    setTimeout(() => {
        hideLoading();
        for (let i in state.data) {
            let item = document.createElement("div");
            item.className = "item";
            item.innerHTML = `<p class="t1">2023-04-04</p>
            <p class="t2">这就是严正声明</p>
            <p class="t3">更多→</p>`;
            document.getElementById("articleList").appendChild(item);
        }
    }, 2000);


}
$(document).ready(() => {
    this.doAjax();

    scrollToBottom('items', null, () => {
        state.params.page_number++;
        showLoading();

        doAjax();
    })
})