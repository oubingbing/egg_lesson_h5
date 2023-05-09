<?php


namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Service\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    private $service;

    public function __construct(ArticleService $service)
    {
        $this->service = $service;
    }

    //文章首页
    public function indexView()
    {
        $result = $this->service->GetCategoryTopArticle();
        return view('article.index',["article_category"=>$result]);
    }

    //文章列表页
    public function listView($id)
    {
        $data = explode(".",$id);
        $id = $data[0];

        request()->offsetSet('page_size', 10);
        request()->offsetSet('page_number', 1);
        request()->offsetSet('category_id', $id);

        $data = $this->page(request());
        $result = collect($data["page_data"])->toArray();
        $categoryList = $this->service->categories();
        foreach($result as &$item){
            $item["category_seo_title"] = "";
            $item["category_seo_key_word"] = "";
            $item["category_seo_describe"] = "";
            foreach($categoryList as $c){
                if($c->id == $item[Article::FIELD_ID_CATEGORY]){
                    $item["category_seo_title"] = $c->{ArticleCategory::FIELD_SEO_TITLE};
                    $item["category_seo_key_word"] = $c->{ArticleCategory::FIELD_SEO_KEY_WROD};
                    $item["category_seo_describe"] = $c->{ArticleCategory::FIELD_SEO_DESCRIBE};
                    break;
                }
            }
        }

        return view('article.list',["article_list"=>$result]);
    }

    //文章详情页
    public function detailView($id)
    {
        $data = explode(".",$id);
        $id = $data[0];
        $result = $this->service->detail($id);

        $result["content"] = preg_replace("/\n/","</br>",$result["content"]);
        $result["seo_describe"] = json_encode($result["seo_describe"])==true?$result["seo_describe"]:"";

        $previous = ["title"=>"","id"=>0];
        $next = ["title"=>"","id"=>0];

        $previousArticle = $this->service->detail($id-1);
        if($previousArticle){
            $previous = ["title"=>$previousArticle["title"],"id"=>$previousArticle["id"]];
        }

        $nextArticle = $this->service->detail($id+1);
        if($nextArticle){
            $next = ["title"=>$nextArticle["title"],"id"=>$nextArticle["id"]];
        }

        $result["pre"] = $previous;
        $result["next"]= $next;

        $this->service->updateBroweNum($id,$result[Article::FIELD_BROWSE_NUM]+1);

        $categoryList = $this->service->categories();
        $sameList = collect(ARticle::where('category_father_id',$result["category_father_id"])->where("attachments","!=","")->orderBy(DB::raw('RAND()'))->take(5)->get(["id","title","attachments","category_id"]))->toArray();
        foreach($sameList as &$s){
            $s["category_name"] = "";
            foreach($categoryList as $c){
                if($c->id == $s["category_id"]){
                    $s["category_name"] = $c->{ArticleCategory::FIELD_NAME};
                    break;
                }
            }
        }

        $moreList = collect(ARticle::query()->where("attachments","!=","")->orderBy("id","desc")->take(5)->get(["id","title","attachments","category_id"]))->toArray();
        foreach($moreList as &$s){
            $s["category_name"] = "";
            foreach($categoryList as $c){
                if($c->id == $s["category_id"]){
                    $s["category_name"] = $c->{ArticleCategory::FIELD_NAME};
                    break;
                }
            }
        }

        $result["same_list"] = $sameList;
        $result["more_list"] = $moreList;

        return view('article.detail',["article"=>$result]);
    }

    //PC文章首页
    public function indexPcView()
    {
        $result = $this->service->GetCategoryTopArticle();
        return view('article.pcIndex',["article_category"=>$result]);
    }

    //PC文章列表页
    public function listPcView($id)
    {
        $data = explode(".",$id);
        $id = $data[0];

        request()->offsetSet('page_size', 10);
        request()->offsetSet('page_number', 1);
        request()->offsetSet('category_id', $id);

        $data = $this->page(request());
        $result = collect($data["page_data"])->toArray();

        $categoryList = $this->service->categories();
        foreach($result as &$item){
            $item["category_seo_title"] = "";
            $item["category_seo_key_word"] = "";
            $item["category_seo_describe"] = "";
            foreach($categoryList as $c){
                if($c->id == $item[Article::FIELD_ID_CATEGORY]){
                    $item["category_seo_title"] = $c->{ArticleCategory::FIELD_SEO_TITLE};
                    $item["category_seo_key_word"] = $c->{ArticleCategory::FIELD_SEO_KEY_WROD};
                    $item["category_seo_describe"] = $c->{ArticleCategory::FIELD_SEO_DESCRIBE};
                    break;
                }
            }
        }

        return view('article.pcList',["article_list"=>$result]);
    }

    //pc文章详情页
    public function detailPcView($id)
    {
        $data = explode(".",$id);
        $id = $data[0];
        $result = $this->service->detail($id);
        $result["content"] = preg_replace("/\n/","</br>",$result["content"]);
        $result["seo_describe"] = json_encode($result["seo_describe"])==true?$result["seo_describe"]:"";

        $previous = ["title"=>"","id"=>0];
        $next = ["title"=>"","id"=>0];

        $previousArticle = $this->service->detail($id-1);
        if($previousArticle){
            $previous = ["title"=>$previousArticle["title"],"id"=>$previousArticle["id"]];
        }

        $nextArticle = $this->service->detail($id+1);
        if($nextArticle){
            $next = ["title"=>$nextArticle["title"],"id"=>$nextArticle["id"]];
        }

        $result["pre"] = $previous;
        $result["next"]= $next;

        $this->service->updateBroweNum($id,$result[Article::FIELD_BROWSE_NUM]+1);

        $categoryList = $this->service->categories();
        $sameList = collect(ARticle::where('category_father_id',$result["category_father_id"])->where("attachments","!=","")->orderBy(DB::raw('RAND()'))->take(5)->get(["id","title","attachments","category_id"]))->toArray();
        foreach($sameList as &$s){
            $s["category_name"] = "";
            foreach($categoryList as $c){
                if($c->id == $s["category_id"]){
                    $s["category_name"] = $c->{ArticleCategory::FIELD_NAME};
                    break;
                }
            }
        }

        $moreList = collect(ARticle::query()->where("attachments","!=","")->orderBy("id","desc")->take(5)->get(["id","title","attachments","category_id"]))->toArray();
        foreach($moreList as &$s){
            $s["category_name"] = "";
            foreach($categoryList as $c){
                if($c->id == $s["category_id"]){
                    $s["category_name"] = $c->{ArticleCategory::FIELD_NAME};
                    break;
                }
            }
        }

        $result["same_list"] = $sameList;
        $result["more_list"] = $moreList;

        return view('article.pcDetail',["article"=>$result]);
    }

    public function getCategory()
    {
        $result = $this->service->GetCategoryTopArticle();
        return $result;
    }

    public function detail($id)
    {
        $result = $this->service->detail($id);
        $result["content"] = preg_replace("/\n/","</br>",$result["content"]);
        $result["seo_describe"] = json_encode($result["seo_describe"])==true?$result["seo_describe"]:"";

        $previous = ["title"=>"","id"=>0];
        $next = ["title"=>"","id"=>0];

        $previousArticle = $this->service->detail($id-1);
        if($previousArticle){
            $previous = ["title"=>$previousArticle["title"],"id"=>$previousArticle["id"]];
        }

        $nextArticle = $this->service->detail($id+1);
        if($nextArticle){
            $next = ["title"=>$nextArticle["title"],"id"=>$nextArticle["id"]];
        }

        $result["pre"] = $previous;
        $result["next"]= $next;

        $sameList = collect(ARticle::where('category_father_id',$result["category_father_id"])->where("attachments","!=","")->where("attachments","!=","")->orderBy(DB::raw('RAND()'))->take(5)->get(["id","title","attachments"]))->toArray();
        $moreList = collect(ARticle::query()->where("attachments","!=","")->where("attachments","!=","")->orderBy("id","desc")->take(5)->get(["id","title","attachments"]))->toArray();
        $result["same_list"] = $sameList;
        $result["more_list"] = $moreList;

        return $result;
    }

    public function page(Request $request)
    {
        $pageSize           = $request->input('page_size', 10);
        $pageNumber         = $request->input('page_num', 1);
        $categoryId         = $request->input("category_id");
        $filter             = $request->input("filter");

        $queryBuilder = $this->service->GetArticleByCategory($categoryId,$filter);
        $fields = [
            Article::FIELD_ID,
            Article::FIELD_TITLE,
            Article::FIELD_SEO_TITLE,
            Article::FIELD_SEO_KEY_WROD,
            Article::FIELD_SEO_DESCRIBE,
            Article::FIELD_CREATED_AT,
            Article::FIELD_ATTACHMENTS,
            Article::FIELD_BROWSE_NUM,
            Article::FIELD_ID_CATEGORY
        ];

        $pageParams = ['page_size' => $pageSize, 'page_number' => $pageNumber];
        $list = paginate($queryBuilder, $pageParams, $fields, function ($item)  {
            $item["seo_describe"] = json_encode($item["seo_describe"])==true?$item["seo_describe"]:"";
            return $item;
        });

        return $list;
    }
}
