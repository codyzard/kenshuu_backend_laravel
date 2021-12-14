<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['src', 'article_id'];
    /**
     * image belongs to article
     *
     * @return belongsTo #associate
     */
    public function article()
    {
        return $this->belongsTo('App\Article');
    }
}
