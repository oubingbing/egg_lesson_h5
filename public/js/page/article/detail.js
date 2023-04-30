var state = {
    connect_articles: [
        { title: "如何成为一名王者大神", seo_describe: "如何如何如何如何所以所以这般这般" },
        { title: "如何成为一名王者中神", seo_describe: "如何如何如何如何所以所以这般这般" },
        { title: "如何成为一名王者小神", seo_describe: "如何如何如何如何所以所以这般这般" },
        { title: "如何成为一名王者巨神", seo_describe: "如何如何如何如何所以所以这般这般" }
    ]
};

function setConnectArticles() {
    let items = state.connect_articles;
    if (items.length) {
        for (let j in items) {
            let item = document.createElement("div");
            item.className = "item";
            item.innerHTML = `<div class="bg"></div>
                            <div class="name">${items[j].title}</div>
                            <div class="description">${items[j].seo_describe}</div>`;
            document.getElementById(`list_1_items`).appendChild(item);
        }
    }
}
$(document).ready(() => {
    this.setConnectArticles();
})