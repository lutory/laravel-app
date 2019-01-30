<?php

namespace App\Http\Controllers;

use App\Category;
use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $categoryType = '';

    public function __construct()
    {
        $route = \Request::route()->getName();
        $this->categoryType = explode('.',$route)[0];
    }

    public function index()
    {
        $type = $this->categoryType;
        $categoriesArr = Category::with('photo')->with($type)->whereType($this->categoryType)->orderBy('order', 'asc')->get()->toArray();
        $categories = $this->_buildTree($categoriesArr);
        $mainCategories = $this->_mainCategories($categoriesArr);

        //dd($categoriesArr);
        return view('admin.categories.index', compact(['categories','mainCategories','type']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:categories',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->body = $request->body ? $request->body : '';
        $category->parent_id = $request->parent_id ? $request->parent_id : 0;
        $category->status = $request->status;
        $category->type = $this->categoryType;

        if( $file = $request->file('photo_id') ){
            $name = time().$file->getClientOriginalName();
            $file->move('images/categories',$name);
            $photo = Photo::create(['file'=>$name]);
            $category->photo_id = $photo->id;
        }

        $category->save();

        return redirect('/admin/'.$this->categoryType.'/categories');
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
        $category = Category::findOrFail($id);
        $type = $this->categoryType;
        $mainCategories = Category::whereParentId(0)->whereType($this->categoryType)->where('id','!=',$id)->pluck("name", "id")->toArray();
        $children = Category::whereParentId($id)->count();
        return view('/admin/categories/edit', compact('category','type', 'mainCategories','children'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::findOrFail($id);
        $oldParentIdCategory = $category->parent_id;
        $category->name = $request->name;
        $category->body = $request->body;
        $category->status = $request->status;
        $category->parent_id = ( isset($request->parent_id) ) ? $request->parent_id : $oldParentIdCategory;

        //dd($request->all());exit;


        if( $file = $request->file('photo_id') ){
            $name = time().$file->getClientOriginalName();
            $file->move('images/categories',$name);
            if($category->photo){
                $photo = Photo::findOrFail($category->photo_id);
                $photo->file = $name;
                $photo->save();
                unlink(public_path().$category->photo->getCategoryImagePath($category->photo->file));
            }
            else{
                $photo = Photo::create(['file'=>$name]);
                $category->photo_id = $photo->id;
            }
        }

        $category->save();

        Session::flash('edited_cat','The category has been edited');

        return redirect('/admin/'.$this->categoryType.'/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function reorder(Request $request)
    {
        $categories =  json_decode($request->list);

        foreach ($categories as $category){
            $cat = Category::findOrFail($category->id);
            $cat->order = $category->order;
            $cat->save();

            if( count($category->children)>0 ){
                foreach($category->children as $child){
                    $innerCat = Category::findOrFail($child->id);
                    $innerCat->order = $child->order;
                    $innerCat->save();
                }
            }
        }

        return response()->json(array('status'=> 'success'), 200);
    }

    private function _buildTree($items){
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

    private function _mainCategories($items){
        $categories = [];
        foreach ($items as $item){
            if( $item['parent_id'] == 0 ){
                $categories[ $item['id']] = $item['name'];
            }
        }
        return $categories;

    }
}
