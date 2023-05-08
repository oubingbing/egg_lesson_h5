var loading = null;
var isLoading = false;
$(document).ready(() => {
    createLoading();
})

function createLoading() {
    loading = document.createElement('div');
    loading.className = 'loading-box hide';
    let loadingCover = document.createElement('div');
    loadingCover.className = "cover";
    let loadingImg = [];
    loading.appendChild(loadingCover);
    for (let i = 0; i < 5; i++) {
        loadingImg[i] = document.createElement('div');
        loadingImg[i].className = `loading-img ${i>0?'lm'+i:''}`;
        loading.appendChild(loadingImg[i]);
    }
    document.body.appendChild(loading);

}

function showLoading(time) {
    isLoading = true;
    if (!loading) {
        createLoading();
    } else {
        loading.className = 'loading-box show';
    }
}

function hideLoading() {
    isLoading = false;
    if (!!loading) {
        loading.className = 'loading-box hide';
    }
}

function goTo(address, t, v) {
    let params = '';
    if (!!t && !!v) {
        params = `?${t}=${v}`;
    }
    if (address === "detail") {
        address = `detail/${v}.html`;
        params = ``;
    }
    if(address=== "search"){
        address = `search/${v}.html`;
        params= ``;
    }
    let href = `${window.location.protocol}//${window.location.hostname}${address=='index'?'':'/pc/'+address}${params}`;
    console.log(href);
    window.open(href);
}


function scrollToBottom(div_class, div_id, callback) {
    let div = document.getElementById(div_id);
    if (!div) {
        div = document.getElementsByClassName(div_class)[0];
    }
    console.log("div", div);
    div.addEventListener('scroll', () => {

        let scrollHeight = div.scrollHeight;
        let windowTop = document.body.clientHeight;
        let scrollTop = div.scrollTop;

        if (windowTop + scrollTop + 100 > scrollHeight && !isLoading) {
            callback();
        }
    }, true);
}

function scrollToBottomPc(div_class, div_id, callback) {
    let div = document.getElementById(div_id);
    if (!div) {
        div = document.getElementsByClassName(div_class)[0];
    }
    console.log("div", div);
    div.addEventListener('scroll', () => {

        let scrollHeight = div.scrollHeight;
        let windowTop = document.body.clientHeight;
        let scrollTop = div.scrollTop;
        if (windowTop + scrollTop + 300 > scrollHeight && !isLoading) {
            callback();
        }
    }, true);
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
    goTo('detail', 'id', goods_id);
}


function letsScrollTo(name, father = 'window') {
    console.log(name);
    let item;
    if (name.indexOf(".") >= 0) {
        item = document.getElementsByClassName(name.split(".")[1])[0];
    } else {
        item = document.getElementById(name.split("#")[1]);
    }
    console.log(item);
    console.log("scroll", item.offsetTop);
    let father_div;
    if (father == "window") {
        window.scroll({ top: item.offsetTop, left: 0, behavior: 'smooth' });
    } else if (father.indexOf(".") >= 0) {
        father_div = document.getElementsByClassName(father.split(".")[1])[0];
    } else {
        father_div = document.getElementById(father.split("#")[1]);
    }
    father_div.scroll({ top: item.offsetTop - 49, left: 0, behavior: 'smooth' });
}


function createTitleNav() {
    let pc = document.getElementById("pc");
    let titleNav = document.createElement("div");
    titleNav.className = "title-nav";
    titleNav.innerHTML = `<div class="box">
        <div class="button">发布课程</div>
        <div class="button">查看消息</div>
        <div class="button red">请登录</div>
        <!-- <img class="location-logo" src="{{asset('image/dingwei_icon.png')}}"/> -->
        <div class="search-location" id="currentLocation">
            定位中</div>
            </div>`;
    pc.insertBefore(titleNav, pc.children[0]);
}

function setFooter(id,classname){
    let parent = null;
    if(!!id){
        parent = document.getElementById(id);
    }
    else if(!!classname){
        parent = document.getElementsByClassName(classname)[0];
    }
    if(!parent){
        console.log("nothing append footer");
        return;
    }
    let footer = document.createElement("div");
    footer.innerHTML = `<div class="footer">
    <p>
        <a href="https://pc.dandanzkw.com/">首页</a> |
        <a href="https://pc.dandanzkw.com/search?category_id=3" >舞蹈培训</a> |
        <a href=" https://pc.dandanzkw.com/search?category_id=7">瑜伽健身</a> |
         <a href="https://pc.dandanzkw.com/search?category_id=1">早教亲子</a> |
         <a href="https://pc.dandanzkw.com/search?category_id=2">英语培训</a>|
         <a href="https://pc.dandanzkw.com/search?category_id=4">器乐文艺</a> |
         <a href="https://pc.dandanzkw.com/search?category_id=5">语种培训</a> |
         <a href="https://pc.dandanzkw.com/search?category_id=6">体育竞技</a> |
         <a href="https://pc.dandanzkw.com/search?category_id=8">Steam</a> |
         <a href="https://pc.dandanzkw.com/search?category_id=10">职业教育</a> |
         <a href="https://www.dandanzkw.com/aboutus/">关于我们</a> |
         <a href="https://www.dandanzkw.com/yinsi/">注册条例</a> |
         <a href="https://www.dandanzkw.com/kechengleibie/">课程类别说明 </a>|
         <a href="https://www.dandanzkw.com/kechengfabu/">课程发布条例</a>|
         <a href="https://www.dandanzkw.com/cooperate/">联系我们 </a>
         </p>
    <div class="authentication">
        <div style="width:300px;margin:0px auto;padding: 2px;">
            <a target="_blank" href="https://beian.miit.gov.cn" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;"><img src="{{asset('image/www_beian_gov_cn.png')}}" style="float:left; width: 20px; height: 20px;"><p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;">粤ICP备2021068181号-1</p></a>
        </div>
    </div>
    <div style="width:500px; margin:0px auto;" class="f_copyright">
        <span>深圳市吉飞旦达科技有限公司 版权所有<a href="https://beian.miit.gov.cn/" target="_blank"></a><br>Copyright(C)2020-2023 dandanzkw.com All Rights Reserved.</span>
    </div>

    <p class="copyright-box">
        
        <a class="copyright copyright-3" href="http://www.cyberpolice.cn" target="_blank" rel="noopener noreferrer">
          网络警察提醒你
        </a>
        
        <a class="copyright copyright-5" href="http://www.12377.cn/" target="_blank" rel="noopener noreferrer">
          中国互联网举报中心
        </a>
        
        <a class="copyright copyright-7" href="http://www.shdf.gov.cn/shdf/channels/740.html" target="_blank" rel="noopener noreferrer">
          扫黄打非网举报专区
        </a>
        
        <a class="copyright copyright-9" href="http://ggfw.cnipa.gov.cn:8010/PatentCMS_Center?fromsite=www.jd.com" target="_blank" rel="noopener noreferrer">
          国家知识产权公共服务网
        </a>
      </p>
</div>`;
parent.appendChild(footer);
}

function getLocationByApi(params={},callback=()=>{}) {

    var geolocation = new qq.maps.Geolocation("75ABZ-MJ76R-AZ7WK-W6ZLZ-45TBK-W7FJV", "dandanzkw");
    geolocation.getLocation((res) => {
        console.log(res);
        params.latitude = res.lat;
        params.longitude = res.lng;
        // state.goods_params.order_by = 'location';
        params.sort_by = 'asc';
        document.getElementById("currentLocation").innerText = res.city;
        sessionStorage.setItem('location', JSON.stringify(res));
        callback(params);
    }, (err) => {
        console.log(err);
        callback(params);
    }, { timeout: 2000 });
}