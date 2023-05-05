var state = {
    swiper:null,
    connect_articles: [
        { title: "如何成为一名王者大神", seo_describe: "如何如何如何如何所以所以这般这般" },
        { title: "如何成为一名王者中神", seo_describe: "如何如何如何如何所以所以这般这般" },
        { title: "如何成为一名王者小神", seo_describe: "如何如何如何如何所以所以这般这般" },
        { title: "如何成为一名王者巨神", seo_describe: "如何如何如何如何所以所以这般这般" }
    ]
};

function setConnectArticles() {
 state.swiper = new Swiper('.swiper-container', {
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
$(document).ready(() => {
    this.setConnectArticles();
})