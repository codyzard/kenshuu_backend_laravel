<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\Helper\Helper;
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

    public function create(Request $request)
    {
        $validatedData = $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'categories' => 'required',
        ], [
            'title.required' => 'タイトルが空自にすることはできません！',
            'content.required' => 'コンテンツが空自にすることはできません！',
            'categories.required' => 'カテゴライズを最少1つ選んでください！'
        ]);
        if ($validatedData) {
            $title = $request->title;
            $images = null;
            $thumbnail = null;
            $content = $request->content;
            $categories_id = $request->categories;
            $author_id = 1; // しばらくアサインメント
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                $thumbnail = $request->thumbnail;
            }
            $is_success = $this->articleModel->store_new_article($title, $images, $thumbnail, $content, $categories_id, $author_id);
            if ($is_success) {
                return redirect()->back()->with('message', '記事投稿が成功でした！');
            }
            return redirect('/');
        }
    }
}
