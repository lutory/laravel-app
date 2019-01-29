<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function posts()
    {
        return $this->morphedByMany('App\Post', 'categoryable');
    }
    public function products()
    {
        return $this->morphedByMany('App\Product', 'categoryable');
    }
    public function photo(){
        return $this->belongsTo('App\Photo');
    }
}
