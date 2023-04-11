
var loading = null;
var isLoading = false;
$(document).ready(()=>{
    createLoading();
})
function createLoading(){
    loading = document.createElement('div');
    loading.className = 'loading-box hide';
    let loadingCover = document.createElement('div');
    loadingCover.className = "cover";
    let loadingImg=[];
    loading.appendChild(loadingCover);
    for(let i=0;i<5;i++){
        loadingImg[i] = document.createElement('div');
        loadingImg[i].className = `loading-img ${i>0?'lm'+i:''}`;
        loading.appendChild(loadingImg[i]);
    }
    document.body.appendChild(loading);

}
function showLoading(time){
    isLoading = true;
    if(!loading){
        createLoading();
    }else{
        loading.className = 'loading-box show';
    }
}

function hideLoading(){
    isLoading = false;
    if(!!loading){
        loading.className = 'loading-box hide';
    }
}

function goTo(address,t,v){
    window.location.href=`${window.location.protocol}//${window.location.hostname}/${address}?${t}=${v}`;
}


function scrollToBottom(div_class,div_id,callback){
    let div = document.getElementById(div_id);
    if(!div){
        div = document.getElementsByClassName(div_class)[0];
    }
    div.addEventListener('scroll',()=>{
        let scrollHeight =div.scrollHeight;
        let windowTop = document.body.clientHeight;
        let scrollTop = div.scrollTop;
        if(windowTop+scrollTop+100>scrollHeight && !isLoading ){
          callback();
        }
    },true);
}

function toMoney(num) {
    if (num) {
        if (isNaN(num)) {
            alert('金额中含有不能识别的字符');
            return;
        }
        num = typeof num == 'string' ? parseFloat(num) : num // 判断是否是字符串如果是字符串转成数字
        num = num.toFixed(2); // 保留两位
        console.log(num)
        num = parseFloat(num); // 转成数字
        num = num.toLocaleString(); // 转成金额显示模式
        // 判断是否有小数
        if (num.indexOf('.') === -1) {
            num = '￥' + num + '.00';
        } else {
            console.log(num.split('.')[1].length)
            // num = num.split('.')[1].length < 2 ? '￥' + num + '0' : '￥' + num;
        }
        return num; // 返回的是字符串23,245.12保留2位小数
    } else {
        return num = null;
    }
}

function showGoodDetail(goods_id) {
    goTo('detail','id',goods_id);
}


function letsScrollTo(name,father='window'){
    console.log(name);
    let item;
    if(name.indexOf(".")>=0){
        item = document.getElementsByClassName(name.split(".")[1])[0];
    }else{
        item = document.getElementById(name.split("#")[1]);
    }
    console.log(item);
    console.log("scroll",item.offsetTop);
    let father_div;
    if(father=="window"){
        window.scroll({top:item.offsetTop,left:0,behavior:'smooth'});
    }else if(father.indexOf(".")>=0){
        father_div = document.getElementsByClassName(father.split(".")[1])[0];
    }else{
        father_div = document.getElementById(father.split("#")[1]);
    }
    father_div.scroll({top:item.offsetTop-49,left:0,behavior:'smooth'});
}