<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
