function mHttp(method, url, params, callback) {
    var xhr = new XMLHttpRequest();

    let params_txt = ``;
    if (!!params) {
        for (let i in params) {
            params_txt += `${i}=${params[i]}&`
        }
    }
    if (params_txt.length > 0) {
        params_txt = params_txt.substring(0, params_txt.length - 1);
    }
    console.log(params_txt);


    switch (method) {
        case "get":
            url += `?${params_txt}`;
            params = null;
            break;
        case "post":
            params = params_txt;
            break;
    }
    xhr.open(method, url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(params);
    xhr.onreadystatechange = () => {
        let data = null;
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {

                if (!!xhr.responseText) { data = JSON.parse(xhr.responseText); }

            } else {
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
    return mHttp('post', url, params, callback);
}

function Del(url, params, callback) {
    return mHttp('delete', url, params, callback);
}

// const httpHeader = `${window.location.protocol}//${window.location.hostname}/api`;
const httpHeader = `//m.dandanzkw.com/api`;

const mRoute = {
    goods_page: `${httpHeader}/goods/page`,
    banners: `${httpHeader}/banners`,
    purchase_logs: `${httpHeader}/purchase_logs`,
    lesson_category: `${httpHeader}/lesson_category`,
    brands: `${httpHeader}/brands`,
    goods_detail: id => `${httpHeader}/goods/${id}`,
    article_category:`${httpHeader}/article/category`,
    article_list:`${httpHeader}/article/list/page`,
    article_detail:id=>`${httpHeader}/article/${id}`,
}