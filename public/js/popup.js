let urlparse = document.scripts[document.scripts.length - 1].src.split("\?");
console.log(urlparse);
let values = {};
if(urlparse.length>1){
    let parms = urlparse[1].split("&");
    for(let i in parms){
        let parm = parms[i].split("=");
        values[parm[0]] = parm[1];
    }
}

$(document).ready(()=>{
    let show_updating_popup=document.createElement("div");
    show_updating_popup.className="updating-view hide";
    show_updating_popup.innerHTML=`<div class="cover"></div>`;
    show_updating_popup.innerHTML+=`<img class="popup" src="https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/banner/updating.png"/>`;
    document.body.appendChild(show_updating_popup);
    $(show_updating_popup).click(()=>{
        show_updating_popup.className="updating-view hide";
    })
    if(values['show']==0)return;
    setTimeout(()=>{
        show_updating_popup.className="updating-view show";
       
    },2000);
})