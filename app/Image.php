<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['name', 'path','order'];
    public $timestamps = false;

    public function imageable(){
        return $this->morphTo();
    }
}
