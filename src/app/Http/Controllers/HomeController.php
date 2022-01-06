<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;

class HomeController extends Controller
{
    private $articleModel;
    public function __construct(Article $article)
    {
        $this->articleModel = $article;
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
