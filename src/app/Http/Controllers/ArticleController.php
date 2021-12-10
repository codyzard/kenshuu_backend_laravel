<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    private $articleModel, $categoryModel;
    public function __construct()
    {
        $this->articleModel = new Article();
        $this->categoryModel = new Category();
    }
    public function show($id)
    {
        $article = $this->articleModel->get_article_by_id($id);
        if ($article) {
            return view('articles.show', [
                'article' => $article,
            ]);
        }
        return redirect('/');
    }

    public function new()
    {
        $categories = $this->categoryModel->get_all_categories();
        return view('articles.new', [
            'categories' => $categories,
        ]);
    }
}
