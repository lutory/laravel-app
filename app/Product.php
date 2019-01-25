<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'body',
        'price',
        'old_price',
        'photo_id',
        'status',
        'quantity',
        'published_on'
    ];

    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')->latest();
    }

//    public function getPriceAttribute($price)
//    {
//        return $price.' лв.';
//    }

//    public function getOldPriceAttribute($price)
//    {
//        if($price){
//            return $price.' лв.';
//        }
//        return ' - ';
//    }
}
