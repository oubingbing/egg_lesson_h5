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
function valueChange(e,t,v){
    console.log(e,t,v);
    values[t] = v;
    switch(t){
        case "show_smallapp":
            sessionStorage.setItem("SHOW_SMALLAPP",v);
            break;
    }
}
$(document).ready(()=>{
    values['show_smallapp']=sessionStorage.getItem("SHOW_SMALLAPP");
    let show_updating_popup=document.createElement("div");
    show_updating_popup.className="updating-view hide";
    let cover = document.createElement("div");
    cover.className = "cover";
    cover.onclick = ()=>{
        show_updating_popup.className="updating-view hide";
    }
    show_updating_popup.appendChild(cover);
    let popup = document.createElement('img');
    popup.className = "popup";
    popup.src = "https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/banner/updating.png";
    show_updating_popup.appendChild(popup)

    // let close_btn = document.createElement("div");
    // close_btn.style = "position:absolute;z-index:2;width:100%;height:20vw;bottom:50%;margin-bottom:-43vw;left:0;";
    // close_btn.onclick=(e)=>{
    //     e.stopPropagation();
    //     show_updating_popup.className="updating-view hide";
    // }
    // show_updating_popup.appendChild(close_btn);
    document.body.appendChild(show_updating_popup);

    popup.onclick =(e)=>{
        e.stopPropagation();
        // window.location.href="weixin://dl/business/?t=Zb60DIUIuui";
    };
})