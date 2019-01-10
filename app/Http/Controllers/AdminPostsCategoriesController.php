<?php

namespace App\Http\Controllers;

use App\PostsCategory;
use Illuminate\Http\Request;

class AdminPostsCategoriesController extends Controller
{
    public function index(){

        $categories = PostsCategory::all();
        return view('admin.post_categories.index', compact('categories'));
    }

    public function edit( Request $request ){

        $id = $request->id;
        $name = $request->name;
        $postCategory = PostsCategory::findOrFail($id);
        $postCategory->name = $name;
        $postCategory->save();

        return response()->json(array('category'=> $postCategory), 200);
    }

    public function create( Request $request ){

        $name = $request->name;
        $postCategory = new PostsCategory();
        $postCategory->name = $name;
        $postCategory->save();

        return response()->json(array('category'=> $postCategory), 200);
    }
}
