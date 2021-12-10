<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;

class HomeController extends Controller
{
    private $articleModel;
    public function __construct()
    {
        $this->articleModel = new Article();
    }
    public function home()
    {
        $categories = Category::all();
        $articles = $this->articleModel->get_all_articles();
        return view('homes.home', [
            'categories' => $categories,
            'articles' => $articles,
        ]);
    }
}