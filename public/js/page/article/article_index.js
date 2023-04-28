var state = {
    page:{

    },
    params:{
        category_id:1,
        page_num:1,
        page_size:10
    }
}
function getArticleList(params = state.params){
    Get(mRoute.article_list,params,res=>{
        console.log('----article list',res);
    },err=>{

    });
}
function getArticleCategory(){
    Get(mRoute.article_category,void(0),res=>{
        console.log('----category',res);
    },err=>{

    });
}
$(document).ready(()=>{
    getArticleList();
    getArticleCategory();
})