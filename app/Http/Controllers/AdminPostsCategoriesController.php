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

    public function edit( $id ){

        $category = PostsCategory::findOrFail($id);
        return view('/admin/post_categories/edit', compact('category'));
    }

    public function update( $id,Request $request ){

        $request->validate([
            'name' => 'required|unique:posts_categories',
        ]);

        $category = PostsCategory::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return redirect('/admin/post-categories');
    }

    public function store( Request $request ){

        $request->validate([
            'name' => 'required|unique:posts_categories',
        ]);

        $category = new PostsCategory();
        $category->name = $request->name;
        $category->save();

        return redirect('/admin/post-categories');
    }

    public function search( Request $request ){

        $categories = PostsCategory::where('name', 'LIKE', '%'.$request->search.'%')->get();

        return response()->json(array('categories'=> $categories), 200);
    }
}
