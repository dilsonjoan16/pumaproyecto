<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdministradorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomizeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ModuloPromVendController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\ListagaleriasController;
use App\Http\Controllers\SolicitudesController;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

//Ruta api
//Route::apiResource('puma', PumaController::class);
Route::group(['middleware' => 'cors', 'prefix' => 'api'], function () {
    
});
//Ruta del JWT
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'authenticate']);
//Aqui va la ruta del recovery

//Ruta del Middleware
Route::group(['middleware' => ['jwt.verify']], function () {
    //Debo colocar las rutas protegias por el middleware
    Route::post('logout', [UserController::class, 'logout']);
});
//REVISAR!!!! RUTA PARA CAMBIAR EL TIPO DE MUESTRA DE LAS GALERIAS
Route::put('listagalerias', [ListagaleriasController::class, 'update']);

//Ruta del envio de correos
Route::get('contactanos', [MailController::class, 'index'])->name('contactanos.index');
Route::post('contactanos', [MailController::class, 'store'])->name(('contactanos.store'));
//Route::post('getmail',[MailController::class,'getMail']);

//Rutas para el Rol de administrados
//Ruta para el CRUD de vendedores
Route::apiResource('admin', AdminController::class)->names('admin.vendedores');

//Grupo de rutas de administrador
Route::prefix('administrador')->group(function () {
    Route::get('resumenventas', [AdministradorController::class,'index']); //Resumen de ventas
    Route::post('reportes',[AdministradorController::class,'store']); //generacion de reportes
    Route::apiResource('modulopromotorvendedor',ModuloPromVendController::class);
    //Ruta de customize (Api home, Crear galerias, Modificar galerias, Eliminar galerias)
    Route::apiResource('customize', CustomizeController::class);
    
//Route::get();
//Route::get();
//Route::get();
//Route::get();
});

//Grupo de rutas de Promotor
Route::prefix('promotor')->group(function () {
    //rutas del promotor
//Route::get();
//Route::get();
//Route::get();
//Route::get();
});

//Grupo de rutas del vendedor
Route::prefix('vendedor')->group(function () {
Route::post('reportarventa',[VendedorController::class,'store']);
Route::apiResource('solicitudes', SolicitudesController::class);
//Route::get();
//Route::get();
//Route::get();
//Route::get();
});


//Ruta que permita traer datos del user
Route::get('users', [UserController::class, 'GetUsers']);
