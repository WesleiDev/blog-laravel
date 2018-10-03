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

Route::get('/',['as' => 'admin.home', 'uses'=> function () {
    return view('admin.home');
}]);

//-----------------------------------------------INICIO TAG-------------------------------------------------//
Route::get('/tags', ['as' => 'admin.tags', 'uses' => 'Admin\TagController@index']);
Route::get('/tag/add', ['as' => 'admin.tag.add', 'uses' => 'Admin\TagController@add']);
Route::post('/tag/save', ['as' => 'admin.tag.save', 'uses' => 'Admin\TagController@save']);
Route::post('/tag/update', ['as' => 'admin.tag.update', 'uses' => 'Admin\TagController@update']);
Route::get('/tag/edit/{tag}', ['as' => 'admin.tag.edit', 'uses' => 'Admin\TagController@edit']);
Route::get('/tag/search', ['as' => 'admin.tag.search', 'uses' => 'Admin\TagController@search']);
Route::delete('/tag/{tag}', ['as' => 'admin.tag.delete', 'uses' => 'Admin\TagController@delete']);
Route::post('/teste', ['as' => 'teste', 'uses' => 'HomeController@teste']);
//-----------------------------------------------FIM TAG----------------------------------------------------//

//-----------------------------------------------INICIO CATEGORIA-------------------------------------------------//
Route::get('/categories', ['as' => 'admin.categories', 'uses' => 'Admin\CategoryController@index']);
Route::get('/category/add', ['as' => 'admin.category.add', 'uses' => 'Admin\CategoryController@add']);
Route::post('/category/salve', ['as' => 'admin.category.save', 'uses' => 'Admin\CategoryController@save']);
Route::post('/category/update', ['as' => 'admin.category.update', 'uses' => 'Admin\CategoryController@update']);
Route::get('/category/edit/{category}', ['as' => 'admin.category.edit', 'uses' => 'Admin\CategoryController@edit']);
Route::get('/category/search', ['as' => 'admin.category.search', 'uses' => 'Admin\CategoryController@search']);
Route::delete('/category/{category}', ['as' => 'admin.category.delete', 'uses' => 'Admin\CategoryController@delete']);
//-----------------------------------------------FIM CATEGORIA----------------------------------------------------//

//-----------------------------------------------INICIO AUTOR-------------------------------------------------//
Route::get('/authors', ['as' => 'admin.authors', 'uses' => 'Admin\AuthorController@index']);
Route::get('/author/add', ['as' => 'admin.author.add', 'uses' => 'Admin\AuthorController@add']);
Route::post('/author/save', ['as' => 'admin.author.save', 'uses' => 'Admin\AuthorController@save']);
Route::post('/author/update', ['as' => 'admin.author.update', 'uses' => 'Admin\AuthorController@update']);
Route::get('/author/edit/{author}', ['as' => 'admin.author.edit', 'uses' => 'Admin\AuthorController@edit']);
Route::get('/author/search', ['as' => 'admin.author.search', 'uses' => 'Admin\AuthorController@search']);
Route::delete('/author/{author}', ['as' => 'admin.author.delete', 'uses' => 'Admin\AuthorController@delete']);
//-----------------------------------------------FIM AUTOR----------------------------------------------------//

//-----------------------------------------------INICIO POST-------------------------------------------------//
Route::get('/posts', ['as' => 'admin.posts', 'uses' => 'Admin\PostController@index']);
Route::get('/post/add', ['as' => 'admin.post.add', 'uses' => 'Admin\PostController@add']);
Route::post('/post/save', ['as' => 'admin.post.save', 'uses' => 'Admin\PostController@save']);
Route::post('/post/update', ['as' => 'admin.post.update', 'uses' => 'Admin\PostController@update']);
Route::get('/post/edit/{post}', ['as' => 'admin.post.edit', 'uses' => 'Admin\PostController@edit']);
Route::get('/post/search', ['as' => 'admin.post.search', 'uses' => 'Admin\PostController@search']);
Route::delete('/post/{post}', ['as' => 'admin.post.delete', 'uses' => 'Admin\PostController@delete']);
//-----------------------------------------------FIM AUTOR----------------------------------------------------//