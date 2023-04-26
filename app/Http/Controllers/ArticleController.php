<?php


namespace App\Http\Controllers;

use App\Models\Article;
use App\Service\ArticleService;
use Illuminate\Http\Request;

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

        return view('article.index',["article"=>$result]);
    }

    //文章列表页
    public function listView()
    {
        $result = $this->service->GetCategoryTopArticle();

        return view('article.list',["article"=>$result]);
    }

    //文章详情页
    public function detailView()
    {
        $result = $this->service->detail(14);
        return view('article.detail',["article"=>$result]);
    }

    //PC文章首页
    public function indexPcView()
    {
        return view('article.pcIndex',[]);
    }

    //PC文章列表页
    public function listPcView()
    {
        return view('article.pcList',[]);
    }

    //pc文章详情页
    public function detailPcView()
    {
        $result = $this->service->detail(14);
        return view('article.pcDetail',["article"=>$result]);
    }

    public function page(Request $request)
    {
        $pageSize           = $request->input('page_size', 10);
        $pageNumber         = $request->input('page_number', 1);
        $categoryId               = $request->input("category_id");

        $queryBuilder = $this->service->GetArticleByCategory($categoryId)->done();
        $fields = [
            Article::FIELD_ID,
            Article::FIELD_TITLE,
            Article::FIELD_SEO_TITLE,
            Article::FIELD_SEO_KEY_WROD,
            Article::FIELD_SEO_DESCRIBE,
            Article::FIELD_CREATED_AT,
        ];
        $pageParams = ['page_size' => $pageSize, 'page_number' => $pageNumber];
        $list = paginate($queryBuilder, $pageParams, $fields, function ($item)  {
            return $item;
        });

        return $list;
    }
}
