<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['file'];
    protected $uploadFolder = '/images/profile/';
    protected $defaultPhoto = 'default.jpg';

    public function getFileAttribute($photo){
        if($photo){
            return $this->uploadFolder.$photo;
        }
        return $this->uploadFolder.$this->defaultPhoto;
    }

}
