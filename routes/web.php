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

$router->group(['middleware' => 'json_response','prefix' => 'api'], function () use ($router) {
    /** 课程列表 **/
    $router->get("/goods/page","GoodsController@page");
    /** 课程详情 **/
    $router->get("/goods/{id}","GoodsController@detail");
});

$router->group([], function () use ($router) {
    /** 课程列表 **/
    $router->get("/","GoodsController@index");
    /** 课程列表 **/
    $router->get("/index","GoodsController@index");
    /** 课程详情 **/
    $router->get("/detail","GoodsController@detailView");
});
