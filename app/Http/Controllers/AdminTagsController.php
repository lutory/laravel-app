<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use Illuminate\Support\Facades\Session;

class AdminTagsController extends Controller
{
    public function index(){

        $tags = Tag::all();
        return view('admin.tags.index', compact('tags'));
    }

    public function edit( $id ){

        $tag = Tag::findOrFail($id);
        return view('/admin/tags/edit', compact('tag'));
    }

    public function update( $id,Request $request ){

        $request->validate([
            'name' => 'required|unique:tags',
        ]);

        $tag = Tag::findOrFail($id);
        $tag->name = $request->name;
        $tag->save();

        Session::flash('edited_tag','The tag has been edited');

        return redirect('/admin/tags');
    }

    public function store( Request $request ){

        $request->validate([
            'name' => 'required|unique:tags',
        ]);

        $tag = new Tag();
        $tag->name = $request->name;
        $tag->save();

        return redirect('/admin/tags');
    }

    public function destroy($id)
    {
        $tag = Tag::findOrfail($id);
        if($tag->posts){
            $tag->posts()->detach();
        }
        $tag->delete();


        Session::flash('deleted_tag','The tag has been deleted');
        return redirect ('/admin/tags');
    }

    public function search( Request $request ){

        $tags = Tag::where('name', 'LIKE', '%'.$request->search.'%')->get();

        return response()->json(array('tags'=> $tags), 200);
    }


}
