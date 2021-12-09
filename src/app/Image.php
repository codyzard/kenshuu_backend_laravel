<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
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
