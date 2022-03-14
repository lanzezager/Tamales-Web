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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
    return view('home/index');
});

Route::get('/menu', function () {
    return view('home/menu');
});

Route::get('/contact', function () {
    return view('home/contact');
});

Route::get('/page', function () {
    return view('home/regular-page');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');


//PANEL DE USUARIO
Route::get('/panel_usuario','Panel_usuario_controller@index');
Route::get('/panel_usuario/datos','Panel_usuario_controller@datos');
//Route::get('/pdv','Panel_usuario_controller@pdv');
Route::get('/panel_usuario/pedidos','Panel_usuario_controller@pedidos');
Route::resource('/panel_usuario/productos','ProductosController');
Route::resource('/panel_usuario/usuarios','UsuariosController');
Route::resource('/panel_usuario/market/sucursales','SucursalesController');
Route::resource('/panel_usuario/market/e_inventario','EntregaInventarioController');
Route::resource('/panel_usuario/market/r_inventario','RecibeInventarioController');
Route::post('/panel_usuario/market/r_inventario/detalles_entrega','RecibeInventarioController@Busca_Detalle_Entrega');

Route::get('/panel_usuario/estadisticas','Panel_usuario_controller@estadisticas');
Route::get('/panel_usuario/ajustes','Panel_usuario_controller@ajustes');

Route::get('/panel_usuario/market/e_inventario/{id_e_inv}/report','EntregaInventarioController@reportes');

Route::get('/panel_usuario/market/r_inventario/{id_r_inv}/report','RecibeInventarioController@reportes');
//PUNTO DE VENTA
Route::get('/pdv','PuntodeVentaController@puntodeventa');
Route::post('/pdv/pagar','PuntodeVentaController@pagar');

//Route::get('/panel_usuario/productos','Panel_usuario_controller@productos');
//Route::get('/panel_usuario/productos/nuevo','Panel_usuario_controller@add_productos');
//Route::post('/panel_usuario/productos/nuevo','Panel_usuario_controller@save_productos');
//Route::get('/panel_usuario/productos/editar/{produ}','Panel_usuario_controller@edit_productos');
//Route::post('/panel_usuario/productos/actualizar/{produ}','Panel_usuario_controller@edit_productos_update');
//Route::get('/panel_usuario/productos/borrar/{produ}','Panel_usuario_controller@borra_productos');
//Route::get('/panel_usuario/productos/mostrar/{produ}','Panel_usuario_controller@show_productos');
//Route::get('/panel_usuario/usuarios','Panel_usuario_controller@usuarios');
//Route::get('/panel_usuario/usuarios/{userio?}','Panel_usuario_controller@datos');
//Route::get('/panel_usuario/usuarios/editar/{userio?}','Panel_usuario_controller@edita_usuarios');
//Route::post('/panel_usuario/usuarios/editar/{usur?}','Panel_usuario_controller@edita_usuarios_update');
//Route::get('/panel_usuario/usuarios/borrar/{usur?}','Panel_usuario_controller@borra_users');
