<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $categories = Category::all();
        $articles = Article::get_all_articles();
        return view('homes.home', [
            'categories' => $categories,
            'articles' => $articles,
        ]);
    }
}
