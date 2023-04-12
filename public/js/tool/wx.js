// wx.config({
//     debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
//     appId: 'wxe42e6f2271d39485', // 必填，公众号的唯一标识
//     timestamp: , // 必填，生成签名的时间戳
//     nonceStr: '', // 必填，生成签名的随机串
//     signature: '',// 必填，签名
//     jsApiList: [] // 必填，需要使用的JS接口列表
//   });
function getSignature(res){
wx.config({
    debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: 'wxe42e6f2271d39485', // 必填，公众号的唯一标识
    timestamp: res.timestamp , // 必填，生成签名的时间戳
    nonceStr: res.nonceStr, // 必填，生成签名的随机串
    signature: res.signature,// 必填，签名
    jsApiList: ['updateAppMessageShareData','updateTimelineShareData'] // 必填，需要使用的JS接口列表
  });


}

function setApi(){
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.updateAppMessageShareData({ 
          title: 'TEST1', // 分享标题
          desc: 'TEST2', // 分享描述
          link: '', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
          imgUrl: 'https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/banner/微信图片_20210628113403.png', // 分享图标
          success: function () {
            console.log("wx updateAppMessageShareData success")
          }
        })
        wx.updateTimelineShareData({ 
            title: 'TEST11', // 分享标题
            link: 'TEST22', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: 'https://dandan-1304667790.cos.ap-shenzhen-fsi.myqcloud.com/banner/微信图片_20210628113403.png', // 分享图标
            success: function () {
              console.log("wx updateTimelineShareData success")
            }
          })
      });
}
getSignature();