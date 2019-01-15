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
});

Route::group(['middleware'=>'admin'], function(){
    Route::resource('/admin/users','AdminUsersController');
    Route::resource('/admin/posts','AdminPostsController');
    Route::get('/admin/post-categories','AdminPostsCategoriesController@index')->name('posts.categories');
    Route::post('/admin/post-categories/edit','AdminPostsCategoriesController@edit');
    Route::post('/admin/post-categories/create','AdminPostsCategoriesController@create');

    Route::get('/admin/tags','AdminTagsController@index')->name('tags');
    Route::post('/admin/tags','AdminTagsController@index');
    Route::post('/admin/tags/edit','AdminTagsController@edit');
    Route::post('/admin/tags/create','AdminTagsController@create');

});

