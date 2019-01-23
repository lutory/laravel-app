<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminPagesRequest;
use App\Photo;
use Illuminate\Http\Request;
use App\Page;
use Illuminate\Support\Facades\Session;

class AdminPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pages = Page::orderBy('title', 'asc')->get();
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminPagesRequest $request)
    {
        $page = new Page();
        $page->title = $request->input('title');
        $page->slug = $request->input('slug');
        $page->body = $request->input('body');


        if( $file = $request->file('photo_id') ){
            $name = time().$file->getClientOriginalName();
            $file->move('images/pages',$name);
            $photo = Photo::create(['file'=>$name]);
            $page->photo_id = $photo->id;
        }


        $page->save();

        return redirect('/admin/pages');
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
        $page = Page::findOrFail($id);

        return view('/admin/pages/edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminPagesRequest $request, $id)
    {
        $page = Page::findOrFail($id);
        $page->title = $request->input('title');
        $page->body = $request->input('body');
        $page->slug = $request->input('slug');

        if( $file = $request->file('photo_id') ){
            $name = time().$file->getClientOriginalName();
            $file->move('images/pages',$name);
            if($page->photo){
                $photo = Photo::findOrFail($page->photo_id);
                $photo->file = $name;
                $photo->save();
                unlink(public_path().$page->photo->getPostImagePath($page->photo->file));
            }
            else{
                $photo = Photo::create(['file'=>$name]);
                $page->photo_id = $photo->id;
            }
        }

        Session::flash('edited_page',$page->title. ' has been edited');
        $page->save();

        return redirect('/admin/pages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::findOrfail($id);
        if($page->photo){
            unlink(public_path().$page->photo->getPageImagePath($page->photo->file));
        }
        $page->delete();


        Session::flash('deleted_page','The page has been deleted');
        return redirect ('/admin/pages');
    }
}
