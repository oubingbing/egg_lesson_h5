<?php


namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Models\Goods;
use App\Service\BannerService;
use App\Service\BrandService;
use App\Service\GoodsService;
use App\Service\LessonCategoryService;
use App\Service\PurchaseLogService;
use Exception;
use GeoIp2\Database\Reader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class GoodsController extends Controller
{
    private $goodsService;

    public function __construct(GoodsService $goodsService)
    {
        $this->goodsService = $goodsService;
    }

    public function index(Request $request)
    {
        $ip = getIP();
        session(['language' => "CN"]);
        $cityDbReader = new Reader(storage_path("GeoIP2-City.mmdb"));
        try{
            $record = $cityDbReader->city($ip);
            if($record){
                if($record->country->isoCode != "CN"){
                    session(['language' => "EN"]);
                }
            }
        }catch(Exception $e){}

        return view('index',["goods"=>"iphone 6"]);
    }

    public function detailView($id)
    {
        $ip = getIP();
        session(['language' => "CN"]);
        $cityDbReader = new Reader(storage_path("GeoIP2-City.mmdb"));
        try{
            $record = $cityDbReader->city($ip);
            if($record){
                if($record->country->isoCode != "CN"){
                    session(['language' => "EN"]);
                }
            }
        }catch(Exception $e){}

        return view('detail',["id"=>$id]);
    }

    public function searchView(Request $request)
    {
        $data = $request->input("data");

        $ip = getIP();
        session(['language' => "CN"]);
        $cityDbReader = new Reader(storage_path("GeoIP2-City.mmdb"));
        try{
            $record = $cityDbReader->city($ip);
            if($record){
                if($record->country->isoCode != "CN"){
                    session(['language' => "EN"]);
                }
            }
        }catch(Exception $e){}

        return view('searchlist',["data"=>$data]);
    }

    public function page(Request $request)
    {
        $pageSize           = $request->input('page_size', 10);
        $pageNumber         = $request->input('page_number', 1);
        $orderBy            = $request->input('order_by', 'created_at');
        $sortBy             = $request->input('sort_by', 'desc');
        $type               = $request->input("type"); //查询的类型，1=根据品牌查询，2=根据上架时间查询（最新上架）,3=热门课包
        $brands             = $request->input("brands");
        $lessonCategoryIds  = $request->input("lesson_category_ids");
        $city               = $request->input("city");
        $minPrice           = $request->input("min_price");
        $maxPrice           = $request->input("max_price");
        $collection         = $request->input("collection"); //是否查询收藏的商品
        $longitude          = $request->input("longitude");
        $latitude           = $request->input("latitude");

        $user = null;

        if ($lessonCategoryIds) {
            if (!is_array($lessonCategoryIds)) {
                $lessonCategoryIds = json_decode($lessonCategoryIds,true);
            }
        }

        Log::info("商品查询输入：".json_encode($request->all()));

        $ids = [];
        $locations = null;
        $pageNumberNew = $pageNumber;
        if ($type==4){
            $lessonLocation = "lesson_location";
            $locations = Redis::georadius($lessonLocation,$longitude,$latitude,50, 'km', ['withdist' => true, 'sort' => 'asc']);
            if (!empty($locations)){
                $locations = collect(collect($locations)->groupBy(0))->toArray();
                foreach ($locations as $l){
                    array_push($ids,$l[0][0]);
                }

                $goodsIds = $this->goodsService->queryLocation($user,$type,$brands,$lessonCategoryIds,$minPrice,$maxPrice,$collection,$city,$longitude,$latitude,$ids);
                $newIds = [];
                foreach ($ids as $id){
                    if (in_array($id,$goodsIds)){
                        array_push($newIds,$id);
                    }
                }
                $ids = $newIds;
                $pageIds = [];
                for ($i=$pageSize*($pageNumber-1);$i <= $pageSize*$pageNumber-1;$i++){
                    if (!isset($ids[$i])){
                        break;
                    }
                    array_push($pageIds,$ids[$i]);
                }
                $pageNumber = 1;

                $ids = $pageIds;
            }
        }

        $queryBuilder = $this->goodsService->query($user,$type,$brands,$lessonCategoryIds,$minPrice,$maxPrice,$collection,$city,$longitude,$latitude,$ids)->sort($orderBy,$sortBy,$ids)->done();
        $fields = [
            Goods::FIELD_ID,
            Goods::FIELD_ID_BRAND,
            Goods::FIELD_ID_CAMPUS,
            Goods::FIELD_ID_CATEGORY_LESSON,
            Goods::FIELD_SUB_COURSE_TYPE,
            Goods::FIELD_PRICE,
            Goods::FIELD_DISCOUNT,
            Goods::FIELD_DEPOSIT,
            Goods::FIELD_STATUS,
            Goods::FIELD_SALES_STATUS,
            Goods::FIELD_CREATED_AT,
            Goods::FIELD_VIEW_NUM
        ];
        $pageParams = ['page_size' => $pageSize, 'page_number' => $pageNumber];
        $domain = config("app.tc_cos_domain");
        $list = paginate($queryBuilder, $pageParams, $fields, function ($item) use($domain,$locations,$longitude,$latitude,$type) {
            return $this->goodsService->formatPage($item,$domain,$locations,$longitude,$latitude,$type);
        });

        $list["page"]["number"] = $pageNumberNew;

        if (!empty($ids)){
            $list["page_data"] = collect($list["page_data"])->sortBy("distance")->values()->all();
        }

        return $list;
    }

    public function detail($id)
    {
        $user = null;
        $goods = $this->goodsService->detail($user,$id);
        if(!$goods){
            throw new ApiException("数据不存在");
        }

        $result = $this->goodsService->formatSingle($goods);
        return $result;
    }

    /**
     * 获取所有的品牌数据
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getBrands(Request $request)
    {
        $sort = $request->input("sort","desc");
        $type = $request->input("type");
        $list = app(BrandService::class)->getAll($sort,$type);
        return $list;
    }

        /**
     * 获取所有的课程类型
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCategory(Request $request)
    {
        $sort = $request->input("sort","desc");
        $list = app(LessonCategoryService::class)->getAll($sort);
        return $list;
    }

    public function bannerList(Request $request)
    {
        $list = app(BannerService::class)->allUp();
        $domain = config("app.tc_cos_domain");
        foreach ($list as $key => $item){
            $list[$key] = app(BannerService::class)->format($item,$domain);
        }

        return $list;
    }

        /**
     * 获取购买记录
     *
     * @return mixed
     */
    public function purchaseLog()
    {
        return app(PurchaseLogService::class)->getAll();
    }
}
