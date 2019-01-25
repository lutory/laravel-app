<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function posts()
    {
        return $this->morphedByMany('App\Post', 'taggable');
    }
    public function products()
    {
        return $this->morphedByMany('App\Product', 'taggable');
    }
}
