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
    return view('admin.home');
});

//-----------------------------------------------INICIO TAG-------------------------------------------------//
Route::get('/tags', ['as' => 'admin.tags', 'uses' => 'Admin\TagController@index']);
Route::get('/tag/adicionar', ['as' => 'admin.tag.adicionar', 'uses' => 'Admin\TagController@adicionar']);
Route::post('/tag/salvar', ['as' => 'admin.tag.salvar', 'uses' => 'Admin\TagController@salvar']);
Route::post('/tag/atualizar', ['as' => 'admin.tag.atualizar', 'uses' => 'Admin\TagController@atualizar']);
Route::get('/tag/editar/{tag}', ['as' => 'admin.tag.editar', 'uses' => 'Admin\TagController@editar']);
Route::get('/tag/consultar', ['as' => 'admin.tag.consultar', 'uses' => 'Admin\TagController@consultar']);
Route::post('/teste', ['as' => 'teste', 'uses' => 'HomeController@teste']);
//-----------------------------------------------FIM TAG----------------------------------------------------//