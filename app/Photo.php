<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['file'];
    protected $uploadFolder = '/images/';
    protected $uploadPostsFolder = '/images/posts/';
    protected $uploadUsersFolder = '/images/profile/';
    protected $uploadPagesFolder = '/images/pages/';
    protected $uploadProductsFolder = '/images/products/';
    protected $uploadCategoryFolder = '/images/categories/';
    protected $defaultPhoto = 'default.jpg';

//    public function getFileAttribute($photo){
//        if($photo){
//            return $this->uploadFolder.$photo;
//        }
//        return $this->uploadFolder.$this->defaultPhoto;
//    }
    public function getPostImagePath($photo){
        if($photo){
            return $this->uploadPostsFolder.$photo;
        }

    }
    public function getUserImagePath($photo){
        if($photo){
            return $this->uploadUsersFolder.$photo;
        }
    }
    public function getPageImagePath($photo){
        if($photo){
            return $this->uploadPagesFolder.$photo;
        }
    }
    public function getProductImagePath($photo){
        if($photo){
            return $this->uploadProductsFolder.$photo;
        }
    }
    public function getCategoryImagePath($photo){
        if($photo){
            return $this->uploadCategoryFolder.$photo;
        }
    }


}
