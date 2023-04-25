<?php


namespace App\Http\Controllers;

class ArticleController extends Controller
{
    private $service;

    public function __construct()
    {
    }

    public function indexView()
    {
        return view('article.list',[]);
    }

    public function detailView()
    {
        return view('article.detail',[]);
    }

    public function indexPcView()
    {
        return view('article.pcList',[]);
    }

    public function detailPcView()
    {
        return view('article.pcDetail',[]);
    }
}
