<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    private $articleModel, $categoryModel;
    public function __construct()
    {
        $this->articleModel = new Article();
        $this->categoryModel = new Category();
    }
    /**
     * Showing article with $id
     *
     * @param  mixed $id
     * @return view
     */
    public function show($id)
    {
        $article = $this->articleModel->get_article_by_id($id);
        if ($article) {
            return view('articles.show', [
                'article' => $article,
            ]);
        }
        return redirect()->route('notfounds.not_found');
    }

    /**
     * Showing new article form
     *
     * @return view
     */
    public function new()
    {
        if (Auth::check()) {
            $categories = $this->categoryModel->get_all_categories();
            return view('articles.new', [
                'categories' => $categories,
            ]);
        }
        return redirect()->route('authors.login')->withErrors('ログインが必要です！');
    }

    /**
     * Creating new article
     *
     * @param  mixed $request(title, content, categories, images(or not), thumbnail(or not))
     * @return void
     */
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
        if ($validatedData && Auth::check()) {
            $title = $request->title;
            $images = null;
            $thumbnail = null;
            $content = $request->content;
            $categories_id = $request->categories;
            $author_id = Auth::user()->id; // しばらくアサインメント
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

    /**
     * Showing edit article form with $id
     *
     * @param  mixed $id
     * @return view
     */
    public function edit($id)
    {
        $article_edit = $this->articleModel->get_article_for_edit($id);
        if ($article_edit && Auth::check() && Auth::user()->id === $article_edit->author_id) {
            return view('articles.edit', [
                'article_edit' => $article_edit,
            ]);
        }
        return redirect()->route('notfounds.not_found');
    }

    /**
     * Updating article with title & content
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $validatedData = $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
        ], [
            'title.required' => 'タイトルが空自にすることはできません！',
            'content.required' => 'コンテンツが空自にすることはできません！',
        ]);
        if ($validatedData) {
            $title = $request->title;
            $content = $request->content;
            $is_success = $this->articleModel->update_article($id, $title, $content);
            if ($is_success) {
                return redirect()->route('articles.show', $id)->with('message', '記事編集が成功でした！');
            }
            return redirect()->route('articles.edit', $id)->withErrors('更新が失敗しました！');
        }
    }

    /**
     * Deleting article by $id
     *
     * @param  int $id
     * @return void
     */
    public function delete($id)
    {
        if (Auth::check() && Auth::user()->articles->find($id)) {
            $is_success = $this->articleModel->delete_article($id);
            if ($is_success) {
                return redirect()->route('homes.home')->with('message', '削除が成功しました！');
            }
            return redirect()->route('articles.show', $id)->withErrors('削除が失敗しました！');
        }
        return redirect()->route('notfounds.not_found');
    }
}
