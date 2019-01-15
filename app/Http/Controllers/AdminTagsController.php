<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class AdminTagsController extends Controller
{
    public function index(Request $request){


        if($request->search){
            $tags = Tag::where('name','like','%'.$request->search.'%');
        }
        else{
            $tags = Tag::all();
        }

        return view('admin.tags.index', compact('tags'));
    }
    public function edit( Request $request ){

        $id = $request->id;
        $name = $request->name;
        $tag = Tag::findOrFail($id);
        $tag->name = $name;
        $tag->save();

        return response()->json(array('tag'=> $tag), 200);
    }

    public function create( Request $request ){

        $name = $request->name;
        $tag = new Tag();
        $tag->name = $name;
        $tag->save();

        return response()->json(array('tag'=> $tag), 200);
    }


}
