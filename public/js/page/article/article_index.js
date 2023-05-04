const RECOMMEND_CATEGORY_ID = 5;

var swiper, swiper2;

var state = {
    now_category_id:RECOMMEND_CATEGORY_ID,
    page: {

    },
    recommend_category: {},
    params: {
        category_id: 5,
        page_num: 1,
        page_size: 10
    }
}
function getArticleList(params = state.params) {
    Get(mRoute.article_list, params, res => {
        console.log('----article list', res);
    }, err => {

    });
}
function getArticleCategory() {
    Get(mRoute.article_category, void (0), res => {
        console.log('----category', res);
        state.category = res.data;
        this.buildTitleNav();
        for (let i in res.data) {
            if (res.data[i].id === state.now_category_id) {
                state.recommend_category = res.data[i];
                this.buildRecommend();
            }
        }
    }, err => {

    });
}
function buildTitleNav(hover = null) {
    let record = state.category;
    console.log(record);
    for (let i in record) {
        let classname = 'menu-btn';
        if (!hover && parseInt(i) === 0) {
            classname += ' hover';
        }
        let div = document.createElement("div");
        div.className = classname;
        div.id = record[i].id;
        div.innerText = record[i].name;
        div.onclick = this.selectTitleNav.bind(this, record[i].id);
        document.getElementById("menu_nav").appendChild(div);
    }
}
function selectTitleNav(hover = null) {
    if (!hover) { return; }
    let divs = document.getElementsByClassName("menu-btn");
    for (let i = 0; i < divs.length; i++) {
        if (divs[i].id.toString() === hover.toString()) {
            divs[i].className = "menu-btn hover";
        } else {
            divs[i].className = "menu-btn";
        }
    }
}
function buildStyleLists() {
    let record = state.recommend_category.sub_category;
    for (let i = 0; i < 4; i++) {
        if (!!record[i]) {
            let items = record[i].top_article;
            document.getElementById(`list_${i + 1}_title`).innerText = record[i].name;
            if (items.length) {
                for (let j in items) {
                    let item = document.createElement("div");
                    switch (i) {
                        case 0:
                            item.className = "item";
                            item.innerHTML = `<div class="bg" style="background-image:url('${items[j].attachments[0]}')"></div>
                            <div class="name">${items[j].title}</div>
                            <div class="description">${items[j].seo_describe}</div>`;
                            document.getElementById(`list_${i + 1}_items`).appendChild(item);
                            break;
                        case 1:
                        case 2:
                            item.className = "item swiper-slide";
                            item.innerHTML = `<div class="name">${items[j].title}</div>`;
                            item.style.backgroundImage = `url(${items[j].attachments[0]})`;
                            document.getElementById(`list_${i + 1}_items`).appendChild(item);
                            break;
                        case 3:
                            item.className = "item";
                            item.innerHTML = `<div class="thumbnail" style="background-image:url('${items[j].attachments[0]}')"></div>
                            <div class="info">
                            <div class="name">
                            ${items[j].title}
                            </div>
                            <div class="created-at">${moment(items[j].created_at).format("YYYY-MM-DD")}</div></div>`;
                            document.getElementById(`list_${i + 1}_items`).appendChild(item);
                            break;
                        default:
                            break;
                    }

                }

            }
            if (i === 2) {
                // setTimeout(()=>{
                swiper2 = new Swiper(".mySwiper2", {
                    loop: true,
                    autoplay: true
                });
                // },2000);

            }

        }
    }
}
function buildRecommend() {
    console.log(state.recommend_category);
    let record = state.recommend_category;
    for (let i in record.top_article) {
        let div = document.createElement("div");
        div.className = "banner  swiper-slide";
        try {
            div.style = `background-image:url('${record.top_article[i].attachments[0]}')`;
        } catch (e) {
            console.log(e);
        }

        document.getElementById("head_banner_box").appendChild(div);
    }
    this.buildStyleLists();

    swiper = new Swiper(".mySwiper", {
        loop: true,
        autoplay: true
    });
}

$(document).ready(() => {
    getArticleList();
    getArticleCategory();
})