<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminPostsRequest;
use App\Photo;
use App\Post;
use App\PostsCategory;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = PostsCategory::pluck('name','id')->all();
        $tags = Tag::orderBy('name','asc')->pluck('name','id')->all();
        return view('admin.posts.create',compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminPostsRequest $request)
    {
        $post = new Post();
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->status = $request->input('status');
        $post->category_id = $request->input('category_id');
        $post->user_id = auth()->user()->id;

        if( $file = $request->file('photo_id') ){
            $name = time().$file->getClientOriginalName();
            $file->move('images/posts',$name);
            $photo = Photo::create(['file'=>$name]);
            $post->photo_id = $photo->id;

        }


        $post->save();

        if($request->input('tags')){
            $tagsIds = $request->input('tags');
            $integerIDs = array_map('intval', explode(',',$tagsIds[0]));

            $post->tags()->attach($integerIDs);

        }



        return redirect('/admin/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = PostsCategory::pluck('name','id')->all();
        $tags = Tag::all()->except($post->tags()->pluck('id')->toArray());

        return view('/admin/posts/edit', compact('post','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminPostsRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->status = $request->input('status');
        $post->category_id = $request->input('category_id');

        if( $file = $request->file('photo_id') ){
            $name = time().$file->getClientOriginalName();
            $file->move('images/posts',$name);
            if($post->photo){
                $photo = Photo::findOrFail($post->photo_id);
                $photo->file = $name;
                $photo->save();
                unlink(public_path().$post->photo->getPostImagePath($post->photo->file));
            }
            else{
                $photo = Photo::create(['file'=>$name]);
                $post->photo_id = $photo->id;
            }
        }
        if($request->input('tags')){
            $tagsIds = $request->input('tags');
            $integerIDs = array_map('intval', explode(',',$tagsIds[0]));

            $post->tags()->sync($integerIDs);

        }
        Session::flash('edited_post',$post->title. ' has been edited');
        $post->save();

        return redirect('/admin/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrfail($id);
        if($post->photo){
            unlink(public_path().$post->photo->getPostImagePath($post->photo->file));
        }
        $post->delete();


        Session::flash('deleted_post','The post has been deleted');
        return redirect ('/admin/posts');
    }
}
