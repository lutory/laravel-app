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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::get('/admin', function(){
    return view('admin.index');
})->middleware('auth');

Route::group(['middleware'=>'admin'], function(){
    Route::resource('/admin/users','AdminUsersController');
    Route::resource('/admin/posts','AdminPostsController');
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
});

Route::get('/', 'FrontPagesController@home');
