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
    public static function  getCategoryTreeByType($type){

        $categoriesArr = Category::with('photo')->whereType($type)->orderBy('order', 'asc')->get()->toArray();
        $categories = self::_buildTree($categoriesArr);
        return $categories;
    }
    private static function _buildTree($items){
        $childs = array();

        foreach($items as &$item) {
            $childs[$item['parent_id']][] = &$item;
        }
        unset($item);

        foreach($items as &$item){
            if (isset($childs[$item['id']])){
                $item['childs'] = $childs[$item['id']];
            }
        }

        return $childs[0];

    }
}
