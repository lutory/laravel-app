<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['title','photo_id','body','slug'];

    public function photo(){
        return $this->belongsTo('App\Photo');
    }
}
