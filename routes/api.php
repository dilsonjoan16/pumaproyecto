<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomizeController;
use App\Http\Controllers\MailController;

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

//Ruta de customize (Api home)
Route::apiResource('customize', CustomizeController::class);

//Ruta del envio de correos
Route::get('contactanos', [MailController::class, 'index'])->name('contactanos.index');
Route::post('contactanos', [MailController::class, 'store'])->name(('contactanos.store'));
//Route::post('getmail',[MailController::class,'getMail']);

//Rutas para el Rol de administrados
//Ruta para el CRUD de vendedores
Route::apiResource('admin', AdminController::class)->names('admin.vendedores');

//Ruta que permita traer datos del user
Route::get('users', [UserController::class, 'GetUsers']);
