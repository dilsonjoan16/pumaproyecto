<?php

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

//Ruta del JWT
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'authenticate']);
Route::post('logout', [UserController::class, 'logout']);

//Ruta del Middleware
Route::group(['middleware' => ['jwt.verify']], function () {
    //Debo colocar las rutas protegias por el middleware
});

//Ruta de customize 
Route::apiResource('customize',CustomizeController::class);


//Ruta de practica del envio de correos
//Route::post('getmail',[MailController::class,'getMail']);

Route::get('contactanos', [MailController::class, 'index'])->name('contactanos.index');
Route::post('contactanos', [MailController::class, 'store'])->name(('contactanos.store'));