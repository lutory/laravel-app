<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::get('/admin', function(){
    return view('admin.index');
})->middleware('auth');

Route::group(['middleware'=>'admin'], function(){
    Route::resource('/admin/users','AdminUsersController');

    Route::resource('/admin/post-categories','AdminPostsCategoriesController');
    Route::post('/admin/post-categories/search','AdminPostsCategoriesController@search');
    Route::resource('/admin/tags','AdminTagsController');
    Route::post('/admin/tags/search','AdminTagsController@search');
    Route::resource('/admin/pages','AdminPagesController');
    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
    Route::get('/admin/media',function(){
        return view('admin.media');
    })->middleware('auth');
    Route::post('/admin/comments/change-status','AdminCommentsController@changeStatus');
    Route::post('/admin/comment/delete','AdminCommentsController@destroy');

    Route::get('/admin/products/categories','AdminCategoriesController@index')->name('products.categories');
    Route::get('/admin/products/categories/{category}/edit','AdminCategoriesController@edit')->name('products.categories.edit');
    Route::patch('/admin/products/categories/{category}','AdminCategoriesController@update')->name('products.categories.update');
    Route::post('/admin/products/categories','AdminCategoriesController@store')->name('products.categories.store');
    Route::post('/admin/categories/reorder','AdminCategoriesController@reorder');

    Route::get('/admin/posts/categories','AdminCategoriesController@index')->name('posts.categories');
    Route::get('/admin/posts/categories/{category}/edit','AdminCategoriesController@edit')->name('posts.categories.edit');
    Route::patch('/admin/posts/categories/{category}','AdminCategoriesController@update')->name('posts.categories.update');
    Route::post('/admin/posts/categories','AdminCategoriesController@store')->name('posts.categories.store');

    Route::resource('/admin/products','AdminProductsController');
    Route::resource('/admin/posts','AdminPostsController');
});

//Route::get('/', 'FrontPagesController@home');
