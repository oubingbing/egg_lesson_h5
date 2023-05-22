const RECOMMEND_CATEGORY_ID = 5;

var swiper, swiper2,swiper3;

var state = {
    now_category_id: RECOMMEND_CATEGORY_ID,
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
        this.resetRecommendCategory(this.buildRecommend.bind(this))
    }, err => {

    });
}
function buildTitleNav(hover = null) {
    let record = JSON.parse(JSON.stringify(state.category));
    console.log(record);
    let rec = [];
    for (let i in record) {
        if (record[i].id === RECOMMEND_CATEGORY_ID) {
            rec = [record[i]];
            record.splice(i, 1);
            record = rec.concat(record);
            state.category = record;
            console.log(record);
            break;
        }
    }
    for (let i in record) {
        let classname = 'menu-btn';
        if (!hover && parseInt(i) === 0) {
            classname += ' hover';
        }
        let div = document.createElement("div");
        div.className = classname;
        div.id = `category_id_${record[i].id}`;
        div.innerText = record[i].name;
        div.onclick = this.selectTitleNav.bind(this, `category_id_${record[i].id}`);
        document.getElementById("menu_nav").appendChild(div);
    }
}
function selectTitleNav(hover = null) {
    if (!hover) { return; }
    let divs = document.getElementsByClassName("menu-btn");
    for (let i = 0; i < divs.length; i++) {
        if (divs[i].id.toString() === hover.toString()) {
            divs[i].className = "menu-btn hover";
            state.now_category_id = divs[i].id.split("category_id_")[1];
            this.resetRecommendCategory(this.buildStyleLists.bind(this))
        } else {
            divs[i].className = "menu-btn";
        }
    }
}
function buildStyleLists() {
    console.log("STATE", state);
    let record = state.recommend_category.sub_category;
    for (let i = 0; i < 4; i++) {
        document.getElementById(`list_${i + 1}_items`).innerHTML = '';
    }
    for (let i = 0; i < 4; i++) {
        if (!!record[i]) {
            let items = record[i].top_article;
            document.getElementById(`list_${i + 1}_title`).innerText = record[i].name;
            document.getElementById(`list_${i + 1}_showmore`).onclick = goTo.bind(this, "article_list", "id", record[i].id);
            if (items.length) {
                for (let j in items) {
                    let attachments = items[j].attachments&&items[j].attachments[0] ? items[j].attachments[0] : '';
                    let item = document.createElement("div");
                    item.onclick = goTo.bind(this, 'article_detail', 'id', items[j].id);

                    let seo_item = document.createElement("a");
                    seo_item.href = `https://m.dandanzkw.com/article/${items[j].id}.html`;
                    seo_item.innerText = `${items[j].title}-${items[j].seo_describe}-${items[j].created_at}`;
                    document.getElementById("default_article_list").appendChild(seo_item);

                    switch (i) {
                        case 0:
                            item.className = "item swiper-slide";
                            item.innerHTML = `<div class="bg" style="background-image:url('${attachments}')"></div>
                            <div class="name">${items[j].title}</div>
                            <div class="description">${items[j].seo_describe}</div>`;
                            document.getElementById(`list_${i + 1}_items`).appendChild(item);
                            break;
                        case 1:
                        case 2:
                            item.className = "item swiper-slide";
                            item.innerHTML = `<div class="name">${items[j].title}</div>`;
                            item.style.backgroundImage = `url(${attachments})`;
                            document.getElementById(`list_${i + 1}_items`).appendChild(item);
                            break;
                        case 3:
                            item.className = "item";
                            item.innerHTML = `<div class="thumbnail" style="background-image:url('${attachments}')"></div>
                            <div class="info">
                            <div class="name">
                            ${items[j].title}
                            </div>
                            <div class="category">${items[j].category_name}</div>
                            <div class="created-at">${moment(items[j].created_at).format("YYYY-MM-DD")}</div></div>`;
                            document.getElementById(`list_${i + 1}_items`).appendChild(item);
                            break;
                        default:
                            break;
                    }

                }

            }
            if(i===0){
                swiper3 = new Swiper('.swiper-container', {
                    slidesPerView: 3,
                    spaceBetween: 10,
                    centeredSlides: true,
                    autoplay:true,
                    loop: true,
                    pagination: {
                      el: '.swiper-pagination',
                      clickable: true,
                    },
                  });
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
function handleValueChange(t, e) {
    console.log(t, e);
}
function resetRecommendCategory(callback = () => { }) {

    for (let i in state.category) {
        console.log(state.category[i].id, state.now_category_id);
        if (state.category[i].id.toString() === state.now_category_id.toString()) {
            state.recommend_category = state.category[i];
            callback();
        }
    }
}
function buildRecommend() {

    console.log(state.recommend_category);
    let record = state.recommend_category;
    // for (let i in record.top_article) {
    //     let div = document.createElement("div");
    //     div.className = "banner  swiper-slide";
    //     try {
    //         div.style = `background-image:url('${record.top_article[i].attachments[0]}')`;
    //         div.onclick = goTo.bind(this, 'article_detail', 'id', record.top_article[i].id);
    //     } catch (e) {
    //         console.log(e);
    //     }

    //     document.getElementById("head_banner_box").appendChild(div);
    // }
    this.buildStyleLists();

    // swiper = new Swiper(".mySwiper", {
    //     loop: true,
    //     autoplay: true
    // });
}

$(document).ready(() => {

    setTimeout(()=>{
        $(".search-bar").removeClass("noshow")
    },1200);
    setTimeout(()=>{
        $(".search-tips").removeClass("noshow")
    },1400);
    getArticleList();
    getArticleCategory();
})