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
});

Route::group([], function () use ($router) {
    /** 课程列表 **/
    Route::get("/","GoodsController@index");
    /** 课程列表 **/
    Route::get("/index","GoodsController@index");
    /** 课程详情 **/
    Route::get("/detail/{id}","GoodsController@detailView");
});
