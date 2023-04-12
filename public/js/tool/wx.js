// wx.config({
//     debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
//     appId: 'wxe42e6f2271d39485', // 必填，公众号的唯一标识
//     timestamp: , // 必填，生成签名的时间戳
//     nonceStr: '', // 必填，生成签名的随机串
//     signature: '',// 必填，签名
//     jsApiList: [] // 必填，需要使用的JS接口列表
//   });
let link;
function getSignature(res){
  console.log(res.url);
  res.jsApiList=['updateAppMessageShareData','updateTimelineShareData'];
  link = res.url;
  console.log(res);
wx.config(res);
wx.error(res=>{
  console.log("error",res);
})
}

function setApi(title,desc,imgUrl){
  wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
  wx.checkJsApi({
    jsApiList: ['updateAppMessageShareData','updateTimelineShareData'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
    success: function(res) {
    // 以键值对的形式返回，可用的api值true，不可用为false
    console.log("====res",res);
    // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
      // if(res.checkResult.updateAppMessageShareData){
        wx.updateAppMessageShareData({ 
          title, // 分享标题
          desc, // 分享描述
          link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
          imgUrl, // 分享图标
          success: function () {
            console.log("wx updateAppMessageShareData success")
          }
        })
      // }
      
      // if(res.checkResult.updateAppMessageShareData){
      wx.updateAppMessageShareData({ 
          title, // 分享标题
          link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
          imgUrl, // 分享图标
          success: function () {
            console.log("wx updateTimelineShareData success")
          }
        })
      // }
    
  
    }
  });
});
}