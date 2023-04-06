
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