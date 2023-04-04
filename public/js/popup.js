$(document).ready(()=>{
    let show_updating_popup=document.createElement("div");
    show_updating_popup.className="updating-view hide";
    show_updating_popup.innerHTML=`<div class="cover"></div>`;
    show_updating_popup.innerHTML+=`<img class="popup" src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/banner/updating.png"/>`;
    document.body.appendChild(show_updating_popup);
    setTimeout(()=>{
        show_updating_popup.className="updating-view show";
        $(show_updating_popup).click(()=>{
            show_updating_popup.className="updating-view hide";
        })
    },2000);
})