<?php

namespace App\Http\Controllers;

use App\Category;
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
        $categories = Category::getCategoryTreeByType('products');

        $search = $request->get('search');
        $category = $request->get('category') != '' ? $request->get('category') : "";
        $field = $request->get('field') != '' ? $request->get('field') : 'created_at';
        $sort = $request->get('sort') != '' ? $request->get('sort') : 'desc';
        $status = $request->get('status') != '' ? $request->get('status') : 'all';

        $products = new Product();
        if($category){

            $products = $products->with('categories')->whereHas('categories', function ($q) use ($category) {
                $q->where('id', $category);
            });

        }
        if($status != 'all'){
            $products = $products->where('status', '=', $status );
        }

        $products = $products
            ->where('title', 'like', '%' . $search . '%')
            ->orderBy($field, $sort)
            ->paginate(5)
            ->withPath('?search=' . $search . '&category=' . $category .'&status=' . $status  . '&field=' . $field . '&sort=' . $sort);

        //$categories = PostsCategory::pluck('name','name')->all();

        return view('admin.products.index', compact(['products','categories']));
    }
    
    public function create()
    {
        $categories = Category::getCategoryTreeByType('products');
        //print_r($categories);exit;
        $tags = Tag::orderBy('name','asc')->pluck('name','id')->all();
        return view('admin.products.create',compact('tags','categories'));
    }

    public function show()
    {

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

        if($request->input('tags')[0]  ){
            $tagsIds = $request->input('tags');
            $integerIDs = array_map('intval', explode(',',$tagsIds[0]));
            $product->tags()->attach($integerIDs);
        }

        if($request->input('gallery')[0]){
            $imagesPaths = explode(',',$request->input('gallery')[0]);

            foreach ($imagesPaths as $path){
                $image = new Image(['path'=>$path]);
                $product->images()->save($image);
            }

        }

        if($request->input('categories')[0]){
            $catsIds = $request->input('categories');
            $integerIDs = array_map('intval', explode(',',$catsIds[0]));
            //dd($integerIDs);exit;
            $product->categories()->attach($integerIDs);
        }

        return redirect('/admin/products');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::getCategoryTreeByType('products');
        $tags = Tag::all()->except($product->tags()->pluck('id')->toArray());
        $comments = $product->comments()->paginate(5);

        //dd($product);exit;

        return view('/admin/products/edit', compact('product','tags','comments','categories'));
    }
    
    public function update(AdminProductsRequest $request, $id)
    {
       // dd($request->all());exit;
        $product = Product::findOrFail($id);
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



        $tagsIds = $request->input('tags');
        if($tagsIds[0]){
            $integerIDs = array_map('intval', explode(',',$tagsIds[0]));
            $product->tags()->sync($integerIDs);
        }
        else{
            $product->tags()->detach();
        }


        $product->images()->delete();
        if($request->input('gallery')[0]){
            $imagesPaths = explode(',',$request->input('gallery')[0]);
            foreach ($imagesPaths as $path){
                $image = new Image(['path'=>$path]);
                $product->images()->save($image);
            }
        }


        $catsIds = $request->input('categories');
        if($catsIds[0]){
            $integerIDs = array_map('intval', explode(',',$catsIds[0]));
            $product->categories()->sync($integerIDs);
        }
        else{
            $product->categories()->detach();
        }



        Session::flash('edited_product',$product->title. ' has been edited');
        $product->save();

        return redirect('/admin/products');
    }

    public function destroy($id)
    {
        $product = Product::findOrfail($id);
        $product->tags()->detach();
        $product->categories()->detach();
        $product->comments()->delete();
        if($product->photo){
            unlink(public_path().$product->photo->getProductImagePath($product->photo->file));
        }
        $product->delete();


        Session::flash('deleted_product','The product has been deleted');
        return redirect ('/admin/products');
    }
}
