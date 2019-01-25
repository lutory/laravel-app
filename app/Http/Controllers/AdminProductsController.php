<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminProductsRequest;
use Illuminate\Http\Request;
use App\Photo;
use App\Product;
use App\Tag;
use App\Image;
use Illuminate\Support\Facades\Session;

class AdminProductsController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->get('search');
        //$category = $request->get('category') != '' ? $request->get('category') : "";
        $field = $request->get('field') != '' ? $request->get('field') : 'created_at';
        $sort = $request->get('sort') != '' ? $request->get('sort') : 'desc';
        $status = $request->get('status') != '' ? $request->get('status') : 'all';

        $products = new Product();
//        if($category){
//            $products = $products->with('category')->whereHas('category', function ($q) use ($category) {
//                $q->where('name', 'LIKE', "%$category%");
//            });
//        }
        if($status != 'all'){
            $products = $products->where('status', '=', $status );
        }

        $products = $products
            ->where('title', 'like', '%' . $search . '%')
            ->orderBy($field, $sort)
            ->paginate(5)
            ->withPath('?search=' . $search .'&status=' . $status  . '&field=' . $field . '&sort=' . $sort);
//            ->withPath('?search=' . $search . '&category=' . $category .'&status=' . $status  . '&field=' . $field . '&sort=' . $sort);

        //$categories = PostsCategory::pluck('name','name')->all();
        
        return view('admin.products.index', compact(['products']));
    }
    
    public function create()
    {
        //$categories = PostsCategory::pluck('name','id')->all();
        $tags = Tag::orderBy('name','asc')->pluck('name','id')->all();
        return view('admin.products.create',compact('tags'));
    }

    public function store(AdminProductsRequest $request)
    {
        //dd($request->all());exit;

        $product = new Product();
        $product->title = $request->input('title');
        $product->body = $request->input('body');
        $product->status = $request->input('status');
        $product->price = $request->input('price');
        $product->old_price = $request->input('old_price');
        $product->quantity = $request->input('quantity');
        $product->published_on = $request->input('published_on') ? $request->input('published_on' ) : date('Y-m-d H:i:s');


        if( $file = $request->file('photo_id') ){
            $name = time().$file->getClientOriginalName();
            $file->move('images/products',$name);
            $photo = Photo::create(['file'=>$name]);
            $product->photo_id = $photo->id;
        }

        $product->save();

        if($request->input('tags')){
            $tagsIds = $request->input('tags');
            $integerIDs = array_map('intval', explode(',',$tagsIds[0]));
            $product->tags()->attach($integerIDs);
        }

        if($request->input('gallery')){
            $imagesPaths = explode(',',$request->input('gallery')[0]);

            foreach ($imagesPaths as $path){
                $image = new Image(['path'=>$path]);
                $product->images()->save($image);
            }

        }

        return redirect('/admin/products');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        //$categories = PostsCategory::pluck('name','id')->all();
        $tags = Tag::all()->except($product->tags()->pluck('id')->toArray());
        $comments = $product->comments()->paginate(5);

        //dd($product);exit;

        return view('/admin/products/edit', compact('product','tags','comments'));
    }
    
    public function update(AdminProductsRequest $request, $id)
    {
        //dd($request->all());exit;
        $product = Product::findOrFail($id);
        $product->title = $request->input('title');
        $product->body = $request->input('body');
        $product->status = $request->input('status');
        $product->price = $request->input('price');
        $product->old_price = $request->input('old_price');
        $product->quantity = $request->input('quantity');
        $product->published_on = $request->input('published_on') ? $request->input('published_on' ) : date('Y-m-d H:i:s');
        //$product->category_id = $request->input('category_id');

        if( $file = $request->file('photo_id') ){
            $name = time().$file->getClientOriginalName();
            $file->move('images/products',$name);
            if($product->photo){
                $photo = Photo::findOrFail($product->photo_id);
                $photo->file = $name;
                $photo->save();
                unlink(public_path().$product->photo->getProductImagePath($product->photo->file));
            }
            else{
                $photo = Photo::create(['file'=>$name]);
                $product->photo_id = $photo->id;
            }
        }
        if($request->input('tags')){
            $tagsIds = $request->input('tags');
            $integerIDs = array_map('intval', explode(',',$tagsIds[0]));

            $product->tags()->sync($integerIDs);

        }
        if($request->input('gallery')){

            $product->images()->delete();

            $imagesPaths = explode(',',$request->input('gallery')[0]);

            foreach ($imagesPaths as $path){
                $image = new Image(['path'=>$path]);
                $product->images()->save($image);
            }

        }
        Session::flash('edited_product',$product->title. ' has been edited');
        $product->save();

        return redirect('/admin/products');
    }

    public function destroy($id)
    {
        $product = Product::findOrfail($id);
        if($product->photo){
            unlink(public_path().$product->photo->getProductImagePath($product->photo->file));
        }
        $product->delete();


        Session::flash('deleted_product','The product has been deleted');
        return redirect ('/admin/products');
    }
}
