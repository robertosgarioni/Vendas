<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/categorias', 'ControladorCategoria@indexJson');
Route::get('/usuario', 'ControladorUsuario@indexJson');
Route::resource('/produtos', 'ControladorProduto');
Route::resource('/usuario', 'ControladorUsuario');
Route::resource('/receber', 'ControladorReceber');
Route::resource('/pedido', 'ControladorPedido');
Route::resource('/pedido/itens', 'ControladorPedidoItens');
Route::post('/produto/estoque/{id}/{qte}', 'ControladorPedidoItens@baixar');
Route::resource('/pedido/novo', 'ControladorPedido');
Route::post('/receber/baixar/{id}', 'ControladorReceber@baixar');