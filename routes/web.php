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
Route::get('/tag/adicionar', ['as' => 'admin.tag.adicionar', 'uses' => 'Admin\TagController@adicionar']);
Route::post('/tag/salvar', ['as' => 'admin.tag.salvar', 'uses' => 'Admin\TagController@salvar']);
Route::post('/tag/atualizar', ['as' => 'admin.tag.atualizar', 'uses' => 'Admin\TagController@atualizar']);
Route::get('/tag/editar/{tag}', ['as' => 'admin.tag.editar', 'uses' => 'Admin\TagController@editar']);
Route::get('/tag/consultar', ['as' => 'admin.tag.consultar', 'uses' => 'Admin\TagController@consultar']);
Route::delete('/tag/{tag}', ['as' => 'admin.tag.delete', 'uses' => 'Admin\TagController@delete']);
Route::post('/teste', ['as' => 'teste', 'uses' => 'HomeController@teste']);
//-----------------------------------------------FIM TAG----------------------------------------------------//

//-----------------------------------------------INICIO CATEGORIA-------------------------------------------------//
Route::get('/categorias', ['as' => 'admin.categorias', 'uses' => 'Admin\CategoriaController@index']);
Route::get('/categoria/adicionar', ['as' => 'admin.categoria.adicionar', 'uses' => 'Admin\CategoriaController@adicionar']);
Route::post('/categoria/salvar', ['as' => 'admin.categoria.salvar', 'uses' => 'Admin\CategoriaController@salvar']);
Route::post('/categoria/atualizar', ['as' => 'admin.categoria.atualizar', 'uses' => 'Admin\CategoriaController@atualizar']);
Route::get('/categoria/editar/{categoria}', ['as' => 'admin.categoria.editar', 'uses' => 'Admin\CategoriaController@editar']);
Route::get('/categoria/consultar', ['as' => 'admin.categoria.consultar', 'uses' => 'Admin\CategoriaController@consultar']);
Route::delete('/categoria/{categoria}', ['as' => 'admin.categoria.delete', 'uses' => 'Admin\CategoriaController@delete']);
//-----------------------------------------------FIM CATEGORIA----------------------------------------------------//

//-----------------------------------------------INICIO AUTOR-------------------------------------------------//
Route::get('/autores', ['as' => 'admin.autores', 'uses' => 'Admin\AutorController@index']);
Route::get('/autor/adicionar', ['as' => 'admin.autor.adicionar', 'uses' => 'Admin\AutorController@adicionar']);
Route::post('/autor/salvar', ['as' => 'admin.autor.salvar', 'uses' => 'Admin\AutorController@salvar']);
Route::post('/autor/atualizar', ['as' => 'admin.autor.atualizar', 'uses' => 'Admin\AutorController@atualizar']);
Route::get('/autor/editar/{autor}', ['as' => 'admin.autor.editar', 'uses' => 'Admin\AutorController@editar']);
Route::get('/autor/consultar', ['as' => 'admin.autor.consultar', 'uses' => 'Admin\AutorController@consultar']);
Route::delete('/autor/{autor}', ['as' => 'admin.autor.delete', 'uses' => 'Admin\AutorController@delete']);
//-----------------------------------------------FIM AUTOR----------------------------------------------------//