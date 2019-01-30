<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'user_id',
        'photo_id',
        'status',
    ];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function photo(){
        return $this->belongsTo('App\Photo');
    }
    public function tags(){
        return $this->morphToMany('App\Tag', 'taggable');
    }
    public function images(){
        return $this->morphMany('App\Image', 'imageable');
    }
    public function comments(){
        return $this->morphMany('App\Comment', 'commentable')->latest();
    }
    public function categories()
    {
        return $this->morphToMany('App\Category', 'categoryable');
    }
}
