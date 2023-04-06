function mHttp(method, url, params, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(params);
    xhr.onreadystatechange = () => {
        let data = null;
        if (xhr.readyState === 4 ){
            if(xhr.status === 200) {
         
                if (!!xhr.responseText) { data = JSON.parse(xhr.responseText); }
                
            }else{
                data = xhr;
            }
            callback(data);
        }
    }
}

function Get(url, params, callback) {
    return mHttp('get', url, params, callback);
}
function Post(url, params, callback) {
    return mHttp('get', url, params, callback);
}
function Del(url, params, callback) {
    return mHttp('delete', url, params, callback);
}

const httpHeader = `${window.location.protocol}//${window.location.hostname}/api`;

const mRoute = {
    goods_page:`${httpHeader}/goods/page`
}