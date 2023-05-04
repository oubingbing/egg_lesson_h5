<?php


namespace App\Service;

use App\Exceptions\ApiException;
use App\Models\Article;
use App\Models\ArticleCategory;
use Carbon\Carbon;

class ArticleService
{
    private $articleBuilder;

    public function categories(){
        $list = ArticleCategory::query()
        ->where(ArticleCategory::FIELD_STATUS,ArticleCategory::ENUM_STATUS_UP)
        ->orderBy("sort","desc")
        ->get([
            ArticleCategory::FIELD_ID,
            ArticleCategory::FIELD_NAME,
            ArticleCategory::FIELD_ID_FATHER
        ]);
        return $list;
    }

    public function GetArticleTop()
    {
        $result = Article::query()
        ->where(Article::FIELD_STATUS,Article::ENUM_STATUS_UP)
        ->where(Article::FIELD_TOP,Article::ENUM_TOP_YES)
        ->orderBy("sort","desc")
        ->get([
            Article::FIELD_ID,
            Article::FIELD_TITLE,
            Article::FIELD_SEO_TITLE,
            Article::FIELD_SEO_KEY_WROD,
            Article::FIELD_SEO_DESCRIBE,
            Article::FIELD_CREATED_AT,
            Article::FIELD_ID_CATEGORY,
            Article::FIELD_ID_CATEGORY_FATHER,
            Article::FIELD_ATTACHMENTS
        ]);
        return $result;
    }

    //获取栏目页面数据
    public function GetCategoryTopArticle()
    {
        $result = [];
        $categoryList = $this->categories();
        if(!$categoryList){
            return $result;
        }

        $articleList = $this->GetArticleTop();

        foreach($categoryList as $c){
            if($c->{ArticleCategory::FIELD_ID_FATHER} == 0){
                $category = [
                    "id"=>$c->id,
                    "name"=>$c->{ArticleCategory::FIELD_NAME},
                    "sub_category"=>[],
                    "top_article"=>[]
                ];
                $category = [
                    "id"=>$c->id,
                    "name"=>$c->{ArticleCategory::FIELD_NAME},
                    "sub_category"=>[],
                    "top_article"=>[]
                ];

                $subCategory = [];
                foreach($categoryList as $sc){
                    if($sc->{ArticleCategory::FIELD_ID_FATHER} == $c->id){
                        $subCategoryItem = [
                            "id"=>$sc->id,
                            "name"=>$sc->{ArticleCategory::FIELD_NAME},
                            "top_article"=>[]
                        ];
                        array_push($subCategory,$subCategoryItem);
                    }
                }

                foreach($articleList as $a){
                    if($a->{Article::FIELD_ID_CATEGORY_FATHER} == $c->id){
                        array_push($category["top_article"],collect($a)->toArray());
                    }
                }

                foreach($subCategory as $index => $sc){
                    foreach($articleList as $a){
                        if($a->{Article::FIELD_ID_CATEGORY} == $sc["id"]){
                            array_push($subCategory[$index]["top_article"],collect($a)->toArray());
                        }
                    }
                }

                $category["sub_category"] = $subCategory;
                array_push($result,$category);
            }
        }

        return $result;
    }

    public function GetArticleByCategory($categoryId)
    {
        $category = ArticleCategory::find($categoryId);
        if(!$category){
            throw new ApiException("栏目不存在");
        }

        $this->articleBuilder = Article::query()
        ->where(Article::FIELD_STATUS,Article::ENUM_STATUS_UP)
        ->orderBy("sort","desc");

        if($category->{ArticleCategory::FIELD_ID_FATHER} == 0){
            $this->articleBuilder->where(Article::FIELD_ID_CATEGORY_FATHER,$categoryId);
        }else{
            $this->articleBuilder->where(Article::FIELD_ID_CATEGORY,$categoryId);
        }

        return $this->articleBuilder;
    }

    public function detail($id)
    {
        $article = Article::query()->where(Article::FIELD_STATUS,Article::ENUM_STATUS_UP)->where(Article::FIELD_ID,$id)->first();
        if(!$article){
            return $article;
        }

        $result = [
            Article::FIELD_ID=>$article->{Article::FIELD_ID},
            Article::FIELD_ID_CATEGORY=>$article->{Article::FIELD_ID_CATEGORY},
            Article::FIELD_ID_CATEGORY_FATHER=>$article->{Article::FIELD_ID_CATEGORY_FATHER},
            Article::FIELD_TITLE=>$article->{Article::FIELD_TITLE},
            Article::FIELD_SEO_DESCRIBE=>$article->{Article::FIELD_SEO_DESCRIBE},
            Article::FIELD_CONTENT=>$article->{Article::FIELD_CONTENT},
            Article::FIELD_SEO_TITLE=>$article->{Article::FIELD_SEO_TITLE},
            Article::FIELD_SEO_KEY_WROD=>$article->{Article::FIELD_SEO_KEY_WROD},
            Article::FIELD_CREATED_AT=>Carbon::parse($article->{Article::FIELD_CREATED_AT})->toDateTimeString(),
            Article::FIELD_ATTACHMENTS=>$article->{Article::FIELD_ATTACHMENTS},
            "category_name"=>"",
            "category_father_name"=>""
        ];

        $category = ArticleCategory::find($article->{Article::FIELD_ID_CATEGORY});
        if($category){
            $result["category_name"] = $category->{ArticleCategory::FIELD_NAME};
        }

        $categoryFather = ArticleCategory::find($article->{Article::FIELD_ID_CATEGORY_FATHER});
        if($categoryFather){
            $result["category_father_name"] = $categoryFather->{ArticleCategory::FIELD_NAME};
        }

        return $result;
    }

}
