<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    /**
     * author has many articles
     *
     * @return hasMany #1-n associate
     */
    public function articles()
    {
        return $this->hasMany('App\Article');
    }
}
