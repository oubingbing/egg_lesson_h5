$(document).ready(()=>{
    $("#tabbar1").click(()=>{
        window.location.href=`${window.location.protocol}//${window.location.hostname}`;
    });
    $("#tabbar4").click(()=>{
        console.log(window.location);
        window.location.href=`${window.location.protocol}//${window.location.hostname}/my`;
    });
    $("#tabbar2").click(()=>{
        document.getElementsByClassName("updating-view")[0].className="updating-view show";
    });
    $("#tabbar3").click(()=>{
        document.getElementsByClassName("updating-view")[0].className="updating-view show";
    });
})

function goToEditor(){
    window.location.href= "/article.html";
}