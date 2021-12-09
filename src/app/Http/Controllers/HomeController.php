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
        $articles = Article::all();
        return view('homes.home',[
            'categories' => $categories,
            'articles' => $articles,
        ]);
    }
}
