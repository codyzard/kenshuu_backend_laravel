<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    private $articleModel, $categoryModel;
    public function __construct(Article $article, Category $category)
    {
        //Init model
        $this->articleModel = $article;
        $this->categoryModel = $category;
        $this->middleware('author_authenticate')->except('show');
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
        return abort(404);
    }

    /**
     * Showing new article form
     *
     * @return view
     */
    public function new()
    {
        $categories = $this->categoryModel->get_all_categories();
        return view('articles.new', [
            'categories' => $categories,
        ]);
    }

    /**
     * Creating new article
     *
     * @param  mixed $request(title, content, categories, images(or not), thumbnail(or not))
     * @return redirect
     */
    public function create(StoreArticleRequest $request)
    {
        // Check policy before create
        $this->authorize('create', $this->articleModel);

        // Assgin request input to new Article object
        $this->articleModel->title = $request->title;
        $this->articleModel->content = $request->content;
        $this->articleModel->author_id = Auth::user()->id;
        $categories_id = $request->categories;
        $images = null;
        $thumbnail = null;

        // Process article add images if images exist
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $thumbnail = $request->thumbnail;
        }

        // Create new article
        $is_success = $this->articleModel->store_new_article($images, $thumbnail, $categories_id);
        if ($is_success) {
            return redirect()->back()->with('message', '記事投稿が成功でした！');
        }

        return redirect()->route('homes.home')->withErrors('予期しないエラー!');
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
        if ($article_edit) {
            $this->authorize('update', $article_edit);
            return view('articles.edit', [
                'article_edit' => $article_edit,
            ]);
        }
        return abort(403);
    }

    /**
     * Updating article with title & content
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return redirect
     */
    public function update(UpdateArticleRequest $request, $id)
    {
        // Find article base on $id if exists
        $this->articleModel = Article::findOrFail($id);
        // Check policy before update
        $this->authorize('update',  $this->articleModel);
        // Assgin request input to existed article base on $id
        $this->articleModel->title = $request->title;
        $this->articleModel->content = $request->content;

        // Update article
        if ($this->articleModel->save()) {
            return redirect()->route('articles.show', $id)->with('message', '記事編集が成功でした！');
        }
        return redirect()->route('articles.edit', $id)->withErrors('更新が失敗しました！');
    }

    /**
     * Deleting article by $id
     *
     * @param  int $id
     * @return redirect|view
     */
    public function delete($id)
    {
        // Find author's article base on $id if exists
        $article_delete = Auth::user()->articles()->findOrFail($id);

        // Check policy before delete
        if ($article_delete && ($this->authorize('delete', $article_delete))) {
            // Delete article
            $is_success = $this->articleModel->delete_article($id);
            if ($is_success) {
                return redirect()->route('homes.home')->with('message', '削除が成功しました！');
            }
            return redirect()->route('articles.show', $id)->withErrors('削除が失敗しました！');
        }

        return abort(403);
    }
}
