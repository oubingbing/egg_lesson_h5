const RECOMMEND_CATEGORY_ID = 10;
var state = {
    page:{

    },
    recommend_category:{},
    params:{
        category_id:5,
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
        state.category = res.data;
        for(let i in res.data){
            if(res.data[i].id===RECOMMEND_CATEGORY_ID){
                state.recommend_category = res.data[i];
                this.buildRecommend();
            }
        }
    },err=>{

    });
}
function buildRecommend(){
    console.log(state.recommend_category);
}

$(document).ready(()=>{
    getArticleList();
    getArticleCategory();
})