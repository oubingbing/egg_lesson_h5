$(document).ready(()=>{
    $("#tabbar1").click(()=>{
        window.href=window.document.location.pathname;
    });
    $("#tabbar4").click(()=>{
        window.href=window.document.location.pathname+`/my`;
    });
})