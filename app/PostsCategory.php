<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostsCategory extends Model
{
    protected $fillable = ['name'];
    protected $table = 'posts_categories';

    public function posts(){
        return $this->hasMany('App\Post','category_id');
    }
}
