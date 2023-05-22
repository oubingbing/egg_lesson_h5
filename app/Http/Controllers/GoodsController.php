<?php


namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ContractTransferInfos;
use App\Models\Goods;
use App\Models\LessonCategory;
use App\Service\BannerService;
use App\Service\BrandService;
use App\Service\GoodsService;
use App\Service\LessonCategoryService;
use App\Service\PurchaseLogService;
use Carbon\Carbon;
use Exception;
use GeoIp2\Database\Reader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use EasyWeChat\Factory;

class GoodsController extends Controller
{
    private $goodsService;

    public function __construct(GoodsService $goodsService)
    {
        $this->goodsService = $goodsService;
    }

    public function index(Request $request)
    {
        $config = [
            "debug"=>"",
            "beta"=>"",
            "appId"=>"",
            "nonceStr"=>"",
            "timestamp"=>"",
            "url"=>"",
            "jsApiList"=>"",
            "signature"=>"",
        ];
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

        $options = [
            'app_id'    => env("WECHAT_APPID"),
            'secret'    => env("WECHAT_SECRET"),
            'token'     => 'easywechat',
        ];

        try{
            $app = Factory::officialAccount($options);
            $config = $app->jssdk->buildConfig(['updateAppMessageShareData','updateTimelineShareData','onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareQZone'], $debug = false, $beta = false, $json = true,[]);
        }catch(Exception $e){}

        if(!is_array($config)){
            $config = json_decode($config,true);
        }

        $view = "index";
        if(!isMobile()){
            $view = "pc";
        }

        request()->offsetSet('page_size', 36);
        request()->offsetSet('page_number', 1);
        request()->offsetSet('order_by', "id");
        request()->offsetSet('sort_by', "desc");

        $goodsList = $this->page(request());

        $sort = $request->input("sort","desc");
        $list = app(LessonCategoryService::class)->getAll($sort);

        return view($view,["category_list"=>collect($list)->toArray(),"goods_list"=>collect($goodsList["page_data"])->toArray(),"goods"=>"iphone 6","debug"=>$config["debug"],"beta"=>$config["beta"],"appId"=>$config["appId"],"nonceStr"=>$config["nonceStr"],"timestamp"=>$config["timestamp"],"url"=>$config["url"],"jsApiList"=>json_encode(['updateAppMessageShareData','updateTimelineShareData']),"signature"=>$config["signature"]]);
    }

    public function pc(Request $request)
    {
        $config = [
            "debug"=>"",
            "beta"=>"",
            "appId"=>"",
            "nonceStr"=>"",
            "timestamp"=>"",
            "url"=>"",
            "jsApiList"=>"",
            "signature"=>"",
        ];
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

        $options = [
            'app_id'    => env("WECHAT_APPID"),
            'secret'    => env("WECHAT_SECRET"),
            'token'     => 'easywechat',
        ];

        try{
            $app = Factory::officialAccount($options);
            $config = $app->jssdk->buildConfig(['updateAppMessageShareData','updateTimelineShareData','onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareQZone'], $debug = false, $beta = false, $json = true,[]);
        }catch(Exception $e){}

        if(!is_array($config)){
            $config = json_decode($config,true);
        }

        request()->offsetSet('page_size', 36);
        request()->offsetSet('page_number', 1);
        request()->offsetSet('order_by', "id");
        request()->offsetSet('sort_by', "desc");

        $goodsList = $this->page(request());

        $sort = $request->input("sort","desc");
        $list = app(LessonCategoryService::class)->getAll($sort);

        return view('pc',["category_list"=>collect($list)->toArray(),"goods_list"=>collect($goodsList["page_data"])->toArray(),"goods"=>"iphone 6","debug"=>$config["debug"],"beta"=>$config["beta"],"appId"=>$config["appId"],"nonceStr"=>$config["nonceStr"],"timestamp"=>$config["timestamp"],"url"=>$config["url"],"jsApiList"=>json_encode(['updateAppMessageShareData','updateTimelineShareData']),"signature"=>$config["signature"]]);
    }

    public function detailView($id)
    {
        $options = [
            'app_id'    => env("WECHAT_APPID"),
            'secret'    => env("WECHAT_SECRET"),
            'token'     => 'easywechat',
        ];

        $data = explode(".",$id);
        $id = $data[0];

        $cityDbReader = new Reader(storage_path("GeoIP2-City.mmdb"));
        $ip = getIP();
        if($ip == "127.0.0.1"){
            $ip = "180.149.130.16";
        }
        $record = $cityDbReader->city($ip);
        $lat = $record->location->latitude;
        $long = $record->location->longitude;

        $config = [
            "debug"=>"",
            "beta"=>"",
            "appId"=>"",
            "nonceStr"=>"",
            "timestamp"=>"",
            "url"=>"",
            "jsApiList"=>"",
            "signature"=>"",
        ];

        try{
            $app = Factory::officialAccount($options);
            $config = $app->jssdk->buildConfig(['updateAppMessageShareData','updateTimelineShareData','onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareQZone'], $debug = false, $beta = false, $json = true,[]);
        }catch(Exception $e){}

        $ip = getIP();
        session(['language' => "CN"]);
        try{
            $record = $cityDbReader->city($ip);
            if($record){
                if($record->country->isoCode != "CN"){
                    session(['language' => "EN"]);
                }
            }
        }catch(Exception $e){}

        $user = null;
        $goods = $this->goodsService->detail($user,$id);
        if(!$goods){
            throw new ApiException("数据不存在");
        }


        $result = $this->goodsService->formatSingle($goods);
        if(!is_array($config)){
            $config = json_decode($config,true);
        }

        $hiddenPhone = "***********";
        $phone = $result["seller"]["phone"];
        $result["seller"]["phone"]= "";
        if(strlen($phone)>= 10){
            $hiddenPhone = substr_replace($phone,'****',3,4);
            $result["seller"]["phone"]= $hiddenPhone;
        }

        $resetTitle = $result["contact"]["lesson_type"] == 1 ?"【".$result["contact"]["surplus_lesson_time"]."节 | ".$result["sub_course_type"]."】".$result["transfer_info"]["title"]:"【年卡 | ".$result["sub_course_type"]."】".$result["transfer_info"]["title"];
        $result = array_merge($result,["reset_title"=>$resetTitle,"hidden_phone"=>$hiddenPhone]);

        request()->offsetSet('page_size', 10);
        request()->offsetSet('page_number', 1);
        request()->offsetSet('type', 4);
        request()->offsetSet('sort_by', "asc");
        //附近的
        request()->offsetSet('latitude', $lat);
        request()->offsetSet('longitude', $long);
        $close = $this->page(request());

        $recommend = ["nearby"=>[],"close"=>[],"close_city"=>[]];
        if(is_array($close["page_data"])){
            $nearby = [];
            foreach($close["page_data"] as $item){
                $title = $this->goodsService->getTitle($item);
                array_push($nearby,["title"=>$title,"id"=>$item["goods_id"]]);
            }
            $recommend["nearby"] = $nearby;
        }

        //同类型的
        request()->offsetSet('latitude', "");
        request()->offsetSet('longitude', "");
        request()->offsetSet('lesson_category_ids', [$result["campus"]["lesson_category"]["id"]]);
        $sameClass = $this->page(request());
        if(is_array($sameClass["page_data"])){
            $close = [];
            foreach($sameClass["page_data"] as $item){
                $title = $this->goodsService->getTitle($item);
                array_push($close,["title"=>$title,"id"=>$item["goods_id"]]);
            }
            $recommend["close"] = $close;
        }

        //附近城市
        request()->offsetSet('lesson_category_ids', "");
        request()->offsetSet('km', 1000);
        request()->offsetSet('sort_by', "desc");
        $city = $this->page(request());
        if(is_array($city["page_data"])){
            $closeCity = [];
            foreach($city["page_data"] as $item){
                $title = $this->goodsService->getTitle($item);
                array_push($closeCity,["title"=>$title,"id"=>$item["goods_id"]]);
            }
            $recommend["close_city"] = $closeCity;
        }

        $previous = ["id"=>$id-1,"title"=>""];
        $next = ["id"=>$id+1,"title"=>""];
        $previousGoods = $this->goodsService->detail($user,$id-1);
        if($previousGoods){
            $previousInfo = $this->goodsService->formatSingle($previousGoods);
            $previous["title"] = $previousInfo["contact"]["lesson_type"] == 1 ?"【".$previousInfo["contact"]["surplus_lesson_time"]."节 | ".$previousInfo["sub_course_type"]."】".$previousInfo["transfer_info"]["title"]:"【年卡 | ".$previousInfo["sub_course_type"]."】".$previousInfo["transfer_info"]["title"];
        }

        $nextGoods = $this->goodsService->detail($user,$id+1);
        if($nextGoods){
            $nextInfo = $this->goodsService->formatSingle($nextGoods);
            $next["title"] = $nextInfo["contact"]["lesson_type"] == 1 ?"【".$nextInfo["contact"]["surplus_lesson_time"]."节 | ".$nextInfo["sub_course_type"]."】".$nextInfo["transfer_info"]["title"]:"【年卡 | ".$nextInfo["sub_course_type"]."】".$nextInfo["transfer_info"]["title"];
        }

        return view('detail',["previous"=>$previous,"next"=>$next,"recommend_list"=>$recommend,"goods_detail"=>$result,"goods_id"=>$id,"id"=>$id,"debug"=>$config["debug"],"beta"=>$config["beta"],"appId"=>$config["appId"],"nonceStr"=>$config["nonceStr"],"timestamp"=>$config["timestamp"],"url"=>$config["url"],"jsApiList"=>json_encode(['updateAppMessageShareData','updateTimelineShareData']),"signature"=>$config["signature"]]);
    }

    public function pcDetailView($id)
    {
        $options = [
            'app_id'    => env("WECHAT_APPID"),
            'secret'    => env("WECHAT_SECRET"),
            'token'     => 'easywechat',
        ];

        $cityDbReader = new Reader(storage_path("GeoIP2-City.mmdb"));
        $ip = getIP();
        if($ip == "127.0.0.1"){
            $ip = "180.149.130.16";
        }
        $record = $cityDbReader->city($ip);
        $lat = $record->location->latitude;
        $long = $record->location->longitude;

        $data = explode(".",$id);
        $id = $data[0];

        $config = [
            "debug"=>"",
            "beta"=>"",
            "appId"=>"",
            "nonceStr"=>"",
            "timestamp"=>"",
            "url"=>"",
            "jsApiList"=>"",
            "signature"=>"",
        ];

        try{
            $app = Factory::officialAccount($options);
            $config = $app->jssdk->buildConfig(['updateAppMessageShareData','updateTimelineShareData','onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareQZone'], $debug = false, $beta = false, $json = true,[]);
        }catch(Exception $e){}

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

        $user = null;
        $goods = $this->goodsService->detail($user,$id);
        if(!$goods){
            throw new ApiException("数据不存在");
        }


        $result = $this->goodsService->formatSingle($goods);
        if(!is_array($config)){
            $config = json_decode($config,true);
        }

        $hiddenPhone = "***********";
        $phone = $result["seller"]["phone"];
        $result["seller"]["phone"]= "";
        if(strlen($phone)>= 10){
            $hiddenPhone = substr_replace($phone,'****',3,4);
            $result["seller"]["phone"]= $hiddenPhone;
        }

        $resetTitle = $result["contact"]["lesson_type"] == 1 ?"【".$result["contact"]["surplus_lesson_time"]."节 | ".$result["sub_course_type"]."】".$result["transfer_info"]["title"]:"【年卡 | ".$result["sub_course_type"]."】".$result["transfer_info"]["title"];
        $result = array_merge($result,["reset_title"=>$resetTitle,"hidden_phone"=>$hiddenPhone]);

        request()->offsetSet('page_size', 10);
        request()->offsetSet('page_number', 1);
        request()->offsetSet('type', 4);
        request()->offsetSet('sort_by', "asc");
        //附近的
        request()->offsetSet('latitude', $lat);
        request()->offsetSet('longitude', $long);
        $close = $this->page(request());

        $recommend = ["nearby"=>[],"close"=>[],"close_city"=>[]];
        if(is_array($close["page_data"])){
            $nearby = [];
            foreach($close["page_data"] as $item){
                $title = $this->goodsService->getTitle($item);
                array_push($nearby,["title"=>$title,"id"=>$item["goods_id"]]);
            }
            $recommend["nearby"] = $nearby;
        }

        //同类型的
        request()->offsetSet('latitude', "");
        request()->offsetSet('longitude', "");
        request()->offsetSet('lesson_category_ids', [$result["campus"]["lesson_category"]["id"]]);
        $sameClass = $this->page(request());
        if(is_array($sameClass["page_data"])){
            $close = [];
            foreach($sameClass["page_data"] as $item){
                $title = $this->goodsService->getTitle($item);
                array_push($close,["title"=>$title,"id"=>$item["goods_id"]]);
            }
            $recommend["close"] = $close;
        }

        //附近城市
        request()->offsetSet('lesson_category_ids', "");
        request()->offsetSet('km', 1000);
        request()->offsetSet('sort_by', "desc");
        $city = $this->page(request());
        if(is_array($city["page_data"])){
            $closeCity = [];
            foreach($city["page_data"] as $item){
                $title = $this->goodsService->getTitle($item);
                array_push($closeCity,["title"=>$title,"id"=>$item["goods_id"]]);
            }
            $recommend["close_city"] = $closeCity;
        }

        $previous = ["id"=>$id-1,"title"=>""];
        $next = ["id"=>$id+1,"title"=>""];
        $previousGoods = $this->goodsService->detail($user,$id-1);
        if($previousGoods){
            $previousInfo = $this->goodsService->formatSingle($previousGoods);
            $previous["title"] = $previousInfo["contact"]["lesson_type"] == 1 ?"【".$previousInfo["contact"]["surplus_lesson_time"]."节 | ".$previousInfo["sub_course_type"]."】".$previousInfo["transfer_info"]["title"]:"【年卡 | ".$previousInfo["sub_course_type"]."】".$previousInfo["transfer_info"]["title"];
        }

        $nextGoods = $this->goodsService->detail($user,$id+1);
        if($nextGoods){
            $nextInfo = $this->goodsService->formatSingle($nextGoods);;
            $next["title"] = $nextInfo["contact"]["lesson_type"] == 1 ?"【".$nextInfo["contact"]["surplus_lesson_time"]."节 | ".$nextInfo["sub_course_type"]."】".$nextInfo["transfer_info"]["title"]:"【年卡 | ".$nextInfo["sub_course_type"]."】".$nextInfo["transfer_info"]["title"];
        }

        return view('pc_detail',["previous"=>$previous,"next"=>$next,"recommend_list"=>$recommend,"goods_detail"=>$result,"id"=>$id,"debug"=>$config["debug"],"beta"=>$config["beta"],"appId"=>$config["appId"],"nonceStr"=>$config["nonceStr"],"timestamp"=>$config["timestamp"],"url"=>$config["url"],"jsApiList"=>json_encode(['updateAppMessageShareData','updateTimelineShareData']),"signature"=>$config["signature"]]);
    }

    public function pcSearchView($id)
    {
        $data = explode(".",$id);
        $categoryId = $data[0];

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

        request()->offsetSet('page_size', 30);
        request()->offsetSet('page_number', 1);
        request()->offsetSet('order_by', "id");
        request()->offsetSet('sort_by', "desc");
        request()->offsetSet('lesson_category_ids', [$categoryId]);

        $goodsList = $this->page(request());

        $categoryName = "";
        $category = app(LessonCategoryService::class)->findById($categoryId);
        if($category){
            $categoryName = $category->{LessonCategory::FIELD_NAME};
        }

        return view('pc_searchlist',["goods_list"=>collect($goodsList["page_data"])->toArray(),"data"=>"","category_id"=>$categoryId,"category_name"=>$categoryName]);
    }

    public function searchView($id)
    {
        $data = explode(".",$id);
        $categoryId = $data[0];

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

        request()->offsetSet('page_size', 36);
        request()->offsetSet('page_number', 1);
        request()->offsetSet('order_by', "id");
        request()->offsetSet('sort_by', "desc");
        request()->offsetSet('lesson_category_ids', [$categoryId]);

        $goodsList = $this->page(request());

        $categoryName = "";
        $category = app(LessonCategoryService::class)->findById($categoryId);
        if($category){
            $categoryName = $category->{LessonCategory::FIELD_NAME};
        }

        return view('searchlist',["data"=>"","goods_list"=>collect($goodsList["page_data"])->toArray(),"category_id"=>$categoryId,"category_name"=>$categoryName]);
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
        $km                 = $request->input("km",500000);

        $user = null;

        if ($lessonCategoryIds) {
            if (!is_array($lessonCategoryIds)) {
                $lessonCategoryIds = json_decode($lessonCategoryIds,true);
            }
        }

        $ids = [];
        $locations = null;
        $pageNumberNew = $pageNumber;
        if ($type==4){
            $lessonLocation = "lesson_location";

            $locations = Redis::georadius($lessonLocation,floatval($longitude),floatval($latitude),(float)$km, 'km', ['withdist' => true, 'sort' => $sortBy]);
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

    public function sitemap(Request $request)
    {

        // 设置网站根目录
        $base_url = 'https://www.dandanzkw.com';

        // 创建sitemap.xml文件
        $now = Carbon::now()->toDateString();
        $file = fopen(public_path("sitemap.xml"), "w");
        fwrite($file, '<?xml version="1.0" encoding="UTF-8"?>'."\n");
        fwrite($file, '<?xml-stylesheet type="text/xsl" href="sitemap.xsl"?>'."\n");
        fwrite($file, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n");

        // 添加主页链接
        fwrite($file, '<url>'."\n");
        fwrite($file, '<loc>'.$base_url.'</loc>'."\n");
        fwrite($file, '<priority>1.0</priority>'."\n");
        fwrite($file, '<mobile:mobile type="mobile"/>'."\n");
        fwrite($file, '<lastmod>'.$now.'</lastmod>'."\n");
        fwrite($file, '<changefreq>Always</changefreq>'."\n");
        fwrite($file, '</url>'."\n");

        $data = Goods::query()
            ->whereIn(Goods::FIELD_STATUS,[
                Goods::ENUM_STATUS_VERIFY_SUCCESS,
                Goods::ENUM_STATUS_TRANSFER_FAIL,
            ])
            ->where(Goods::FIELD_SALES_STATUS,Goods::ENUM_SALES_STATUS_UP)
            ->with(array_merge(["transfer_info"=>function($query){
            $query->select([
                ContractTransferInfos::FIELD_ID,
                ContractTransferInfos::FIELD_ID_GOODS,
                ContractTransferInfos::FIELD_TITLE,
            ]);
        }]))->select(["id","price"])->get();
        $list = collect($data)->toArray();
        $result = [];

        foreach($list as $item){
            fwrite($file, '<url>'."\n");
            fwrite($file, '<loc>'."https://m.dandanzkw.com/detail/".$item['id'].".html".'</loc>'."\n");
            fwrite($file, '<priority>0.6</priority>'."\n");
            fwrite($file, '<mobile:mobile type="mobile"/>'."\n");
            fwrite($file, '<lastmod>'.$now.'</lastmod>'."\n");
            fwrite($file, '<changefreq>Always</changefreq>'."\n");
            fwrite($file, '</url>'."\n");
        }

        $sort = $request->input("sort","desc");
        $lessonCategoryList = app(LessonCategoryService::class)->getAll($sort);
        foreach($lessonCategoryList as $lc){
            fwrite($file, '<url>'."\n");
            fwrite($file, '<loc>'."https://m.dandanzkw.com/search/".$lc['id'].".html".'</loc>'."\n");
            fwrite($file, '<priority>0.8</priority>'."\n");
            fwrite($file, '<mobile:mobile type="mobile"/>'."\n");
            fwrite($file, '<lastmod>'.$now.'</lastmod>'."\n");
            fwrite($file, '<changefreq>Always</changefreq>'."\n");
            fwrite($file, '</url>'."\n");
        }

        $articleList = Article::get(["id","title"]);
        foreach($articleList as $a){
            fwrite($file, '<url>'."\n");
            fwrite($file, '<loc>'."https://m.dandanzkw.com/article/".$a['id'].".html".'</loc>'."\n");
            fwrite($file, '<priority>0.6</priority>'."\n");
            fwrite($file, '<mobile:mobile type="mobile"/>'."\n");
            fwrite($file, '<lastmod>'.$now.'</lastmod>'."\n");
            fwrite($file, '<changefreq>Always</changefreq>'."\n");
            fwrite($file, '</url>'."\n");
        }

        $categoryList = ArticleCategory::all();
        foreach($categoryList as $ca){
            fwrite($file, '<url>'."\n");
            fwrite($file, '<loc>'."https://m.dandanzkw.com/article/list/".$ca['id'].".html".'</loc>'."\n");
            fwrite($file, '<priority>0.8</priority>'."\n");
            fwrite($file, '<mobile:mobile type="mobile"/>'."\n");
            fwrite($file, '<lastmod>'.$now.'</lastmod>'."\n");
            fwrite($file, '<changefreq>Always</changefreq>'."\n");
            fwrite($file, '</url>'."\n");
        }

        fwrite($file, '</urlset>'."\n");

        $this->sitemapPc($request);

        return view('sitemap',["data"=>$result]);
    }

    public function sitemapPc(Request $request)
    {

        // 设置网站根目录
        $base_url = 'https://pc.dandanzkw.com';

        // 创建sitemap.xml文件
        $now = Carbon::now()->toDateString();
        $file = fopen(public_path("sitemapPc.xml"), "w");
        fwrite($file, '<?xml version="1.0" encoding="UTF-8"?>'."\n");
        fwrite($file, '<?xml-stylesheet type="text/xsl" href="sitemap.xsl"?>'."\n");
        fwrite($file, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n");

        // 添加主页链接
        fwrite($file, '<url>'."\n");
        fwrite($file, '<loc>'.$base_url.'</loc>'."\n");
        fwrite($file, '<priority>1.0</priority>'."\n");
        //fwrite($file, '<mobile:mobile type="pc,mobile"/>'."\n");
        fwrite($file, '<lastmod>'.$now.'</lastmod>'."\n");
        fwrite($file, '<changefreq>Always</changefreq>'."\n");
        fwrite($file, '</url>'."\n");

        $data = Goods::query()
            ->whereIn(Goods::FIELD_STATUS,[
                Goods::ENUM_STATUS_VERIFY_SUCCESS,
                Goods::ENUM_STATUS_TRANSFER_FAIL,
            ])
            ->where(Goods::FIELD_SALES_STATUS,Goods::ENUM_SALES_STATUS_UP)
            ->with(array_merge(["transfer_info"=>function($query){
            $query->select([
                ContractTransferInfos::FIELD_ID,
                ContractTransferInfos::FIELD_ID_GOODS,
                ContractTransferInfos::FIELD_TITLE,
            ]);
        }]))->select(["id","price"])->get();
        $list = collect($data)->toArray();
        $result = [];

        foreach($list as $item){
            fwrite($file, '<url>'."\n");
            fwrite($file, '<loc>'."https://pc.dandanzkw.com/pc/detail/".$item['id'].".html".'</loc>'."\n");
            fwrite($file, '<priority>0.6</priority>'."\n");
            //fwrite($file, '<mobile:mobile type="pc,mobile"/>'."\n");
            fwrite($file, '<lastmod>'.$now.'</lastmod>'."\n");
            fwrite($file, '<changefreq>Always</changefreq>'."\n");
            fwrite($file, '</url>'."\n");
        }

        $sort = $request->input("sort","desc");
        $lessonCategoryList = app(LessonCategoryService::class)->getAll($sort);
        foreach($lessonCategoryList as $lc){
            fwrite($file, '<url>'."\n");
            fwrite($file, '<loc>'."https://pc.dandanzkw.com/pc/search/".$lc['id'].".html".'</loc>'."\n");
            fwrite($file, '<priority>0.8</priority>'."\n");
            //fwrite($file, '<mobile:mobile type="pc,mobile"/>'."\n");
            fwrite($file, '<lastmod>'.$now.'</lastmod>'."\n");
            fwrite($file, '<changefreq>Always</changefreq>'."\n");
            fwrite($file, '</url>'."\n");
        }

        fwrite($file, '</urlset>'."\n");

        return view('sitemap',["data"=>$result]);
    }

    public function reportBaidu($goodsId)
    {
        $urls = array(
            'https://m.dandanzkw.com/detail/'.$goodsId.'.html'
        );
        $api = 'http://data.zz.baidu.com/urls?site=m.dandanzkw.com&token=xRZLHk7QAXOcTv37';
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        Log::info("百度推送结果=".json_encode($result).",推送数据=".json_encode($urls));
    }
}

