<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Article extends Model
{
    /**
     * article belongs to author
     *
     * @return belongsTo #1-1 associate
     */
    public function author()
    {
        return $this->belongsTo('App\Author', 'author_id');
    }

    /**
     * articles has many images
     *
     * @return hasMany #1-n associate
     */
    public function images()
    {
        return $this->hasMany('App\Image');
    }

    /**
     * article belongs to & has many categories
     *
     * @return belongsToMany #1-n associate
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category', 'article_categories', 'article_id', 'category_id');
    }

    /**
     * get_all_articles
     *
     * @return array
     */
    public function get_all_articles()
    {
        return Article::select(
            'articles.id',
            'title',
            'thumbnail_id',
            'articles.created_at',
            'src',
            'authors.fullname'
        )->leftJoin('images', 'images.id', '=', 'articles.thumbnail_id')->join('authors', 'authors.id', '=', 'articles.author_id')->orderBy('created_at', Config::get("gVar.sort_desc"))->get();
    }

    public function get_article_by_id($id)
    {
        $article = Article::find($id)->load('author:id,fullname')->load('images');
        $article->page_view += 1;
        if ($article->save()) {
            return $article;
        }
        return false;
    }
}