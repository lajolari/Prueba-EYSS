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

/* Rutas de las Categorias */

Route::get('/', "CategoriasController@index");
Route::put('editar_categoria', "CategoriasController@update");
Route::delete('eliminar_categoria', "CategoriasController@destroy");

/* Rutas de los Productos */

Route::post('producto_nuevo', "ProductosController@store");
Route::get('productos/{id}', "ProductosController@show");
Route::get('editar_producto', "ProductosController@update");
Route::delete('eliminar_producto', "ProdcutosController@destroy");

