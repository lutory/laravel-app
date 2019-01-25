<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminPostsRequest;
use App\Photo;
use App\Post;
use App\PostsCategory;
use App\Tag;
use App\User;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category') != '' ? $request->get('category') : "";
        $field = $request->get('field') != '' ? $request->get('field') : 'created_at';
        $sort = $request->get('sort') != '' ? $request->get('sort') : 'desc';
        $status = $request->get('status') != '' ? $request->get('status') : 'all';

        $posts = new Post();
        if($category){
            $posts = $posts->with('category')->whereHas('category', function ($q) use ($category) {
                $q->where('name', 'LIKE', "%$category%");
            });
        }
        if($status != 'all'){
            $posts = $posts->where('status', '=', $status );
        }

        $posts = $posts
            ->where('title', 'like', '%' . $search . '%')
            ->orderBy($field, $sort)
            ->paginate(5)
            ->withPath('?search=' . $search . '&category=' . $category .'&status=' . $status  . '&field=' . $field . '&sort=' . $sort);

        $categories = PostsCategory::pluck('name','name')->all();
        $users = User::pluck('name','id')->all();
        return view('admin.posts.index', compact(['posts','users','categories']));
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
        //dd($request->all());exit;

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

        if($request->input('gallery')){
            $imagesPaths = explode(',',$request->input('gallery')[0]);

            foreach ($imagesPaths as $path){
                $image = new Image(['path'=>$path]);
                $post->images()->save($image);
            }

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
        $comments = $post->comments()->paginate(5);

        //dd($comments);exit;

        return view('/admin/posts/edit', compact('post','categories','tags','comments'));
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
        //dd($request->all());exit;
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
        if($request->input('gallery')){

            $post->images()->delete();

            $imagesPaths = explode(',',$request->input('gallery')[0]);

            foreach ($imagesPaths as $path){
                $image = new Image(['path'=>$path]);
                $post->images()->save($image);
            }

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
