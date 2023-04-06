function mHttp(method,url,params,callback){
    var xhr = new XMLHttpRequest();
    xhr.open(method,url,true);
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xhr.send(params);
    xhr.onreadystatechange = ()=>{
        if(xhr.readyState === 4 && xhr.status === 200){
            console.log(xhr.responseText);
        }
        let data = JSON.parse(xhr.responseText);
        callback(data);
    }
}

function Get(url,params,callback){
    return mHttp('get',url,params,callback);
}
function Post(url,params,callback){
    return mHttp('get',url,params,callback);
}
function Del(url,params,callback){
    return mHttp('delete',url,params,callback);
}