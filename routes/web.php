<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'json_response','prefix' => 'api'], function () {
    /** 课程列表 **/
    Route::get("/goods/page","GoodsController@page");
    /** 课程详情 **/
    Route::get("/goods/{id}","GoodsController@detail");

    /** 获取邮箱验证码 **/
    Route::get("/email/send_code","UserController@getEmailCode");
    /** 箱验证码登录 **/
    Route::post("/login","UserController@login");
    /** 用户信息 **/
    Route::get("/user","UserController@user");
    /** 语言 **/
    Route::get("/language","UserController@language");

    /** 获取品牌数据 **/
    Route::get("/brands","GoodsController@getBrands");
    /** 获取课程类型数据 **/
    Route::get("/lesson_category","GoodsController@getCategory");
    /** banner **/
    Route::get("/banners","GoodsController@bannerList");
    /** 购买记录 **/
    Route::get("/purchase_logs","GoodsController@purchaseLog");

    /** 文章-列表页面 **/
    Route::get("/article/category","ArticleController@getCategory");
    /** 文章-列表页面 **/
    Route::get("/article/{id}","ArticleController@detail");
    /** 文章-详情页面 **/
    Route::get("/article/list/page","ArticleController@page");
});

Route::group([], function () use ($router) {
    /** 课程列表 **/
    Route::get("/","GoodsController@index");
    /** 课程列表 **/
    Route::get("/index","GoodsController@index");

    /** 课程列表 **/
    Route::get("/pc","GoodsController@pc");

    /** 课程列表 **/
    Route::get("/pc/detail/{id}","GoodsController@pcDetailView");
    /** 搜索页 **/
    Route::get("/pc/search/{id}","GoodsController@pcSearchView");

    /** 课程详情 **/
    Route::get("/detail/{id}","GoodsController@detailView");
    /** 搜索页 **/
    Route::get("/search/{id}","GoodsController@searchView");
    /** 搜索页 **/
    Route::get("/my","UserController@myView");

    /** sitemap **/
    Route::get("/sitemap","GoodsController@sitemap");

    /** 文章-首面 **/
    Route::get("/article.html","ArticleController@indexView");
    /** 文章-列表页面 **/
    Route::get("/article/list/{id}","ArticleController@listView");
    /** 文章-详情页面 **/
    Route::get("/article/{id}","ArticleController@detailView");

    /** 文章-列表页面 **/
    Route::get("/pc/article.html","ArticleController@indexPcView");
    /** 文章-列表页面 **/
    Route::get("/pc/article/list/{id}","ArticleController@listPcView");
    /** 文章-详情页面 **/
    Route::get("/pc/article/{id}","ArticleController@detailPcView");
});
