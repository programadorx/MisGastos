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
    return view('/home'); // lo obligo a loguearse ni bien entra
});


Route::get('/inicio', function () { //acomodar lo de inicio dsp
  //  return view('welcome');

	return view('layout2');	
});



Auth::routes();

Route::get('/home', 'CategoriaController@index');//el / me tira al home y de aca lo tiro a cate


Route::resource('/categoria','CategoriaController');
Route::resource('/item','ItemController');

Route::resource('/clasificacion','ClasificacionController');

Route::get('/clasificacion/{id}/destroy',
	['uses'=>'ClasificacionController@destroy','as'=>'clasificacion.destroy']);

//Agrego una ruta nueva, que soporta el get, para poder enviar el id
//de eliminacion a traves de un href y no un formulario.




// Para agregar un metodo al resource  como por ejemplo estadisticas
//debe realizarse antes del resource, sino no funciona.

Route::get('/ingreso/estadisticas','IngresoController@estadisticas'); 
Route::get('/ingreso/estadisticas/diario/{desde}/{hasta}','IngresoController@getPorDia');
Route::get('/ingreso/estadisticas/mensual/{aniodesde}/{aniohasta}','IngresoController@getMensual');
Route::get('/ingreso/estadisticas/poranio/{anio}','IngresoController@getPorAnio');
Route::get('/ingreso/estadisticas/pormes/{mes}','IngresoController@getPorMes');
Route::get('/ingreso/estadisticas/porcategoria/{idCategoria}','IngresoController@getPorCategoria');
Route::get('/ingreso/estadisticas/porproducto/{id}/{tipo}','IngresoController@getPorProducto');
Route::resource('/ingreso','IngresoController');


Route::get('/egreso/estadisticas','EgresoController@estadisticas'); 
Route::get('/egreso/estadisticas/diario/{desde}/{hasta}','EgresoController@getPorDia');
Route::get('/egreso/estadisticas/mensual/{aniodesde}/{aniohasta}','EgresoController@getMensual');
Route::get('/egreso/estadisticas/poranio/{anio}','EgresoController@getPorAnio');
Route::get('/egreso/estadisticas/pormes/{mes}','EgresoController@getPorMes');
Route::get('/egreso/estadisticas/porcategoria/{idCategoria}','EgresoController@getPorCategoria');
Route::get('/egreso/estadisticas/porproducto/{id}/{tipo}','EgresoController@getPorProducto');
Route::resource('/egreso','EgresoController');



Route::get('/balance','BalanceController@index');

Route::get('/balance/filtrado','BalanceController@filtrado'); // para q reciba la ptecion ajax
Route::get('/balance/filtrado/poranio/{anio}','BalanceController@getPorAnio');
Route::get('/balance/filtrado/pormes/{mes}','BalanceController@getPorMes');
Route::get('/balance/filtrado/diario/{desde}/{hasta}','BalanceController@getPorDia');
Route::get('/balance/filtrado/mensual/{aniodesde}/{aniohasta}','BalanceController@getMensual');
