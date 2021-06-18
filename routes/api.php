<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdministradorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomizeController;
use App\Http\Controllers\EstadoVentasController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ModuloPromVendController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\ListagaleriasController;
use App\Http\Controllers\ModuloVendedorController;
use App\Http\Controllers\SolicitudesController;
use App\Http\Controllers\SorteosController;
use App\Http\Controllers\AcumuladoController;
use App\Http\Controllers\CrearRoles;
use App\Http\Controllers\PremiosController;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

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
    //Grupo de rutas que habilita permisos CORS
});
//Ruta del JWT
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'authenticate']);
////////////////////////////////////////////////////////////////
//Ruta para el Recovery (Recuperacion de Clave)
//Aqui deber la ruta

//RUTA DEL HOME LIBRE
Route::get('HomeCustomize', [CustomizeController::class, 'index']);
//////////////////////////////////////////DEVOLVER A LOS MIDDLEWARE POSTERIORMENTE
Route::post('crearpromotorvendedor', [UserController::class, 'register']); //CREACION DE PROMOTORES Y VENDEDORES
Route::apiResource('modulopromotorvendedor', ModuloPromVendController::class); //ReadUpdateDelete DE PROMOTORES Y VENDEDORES

//Ruta del Middleware
Route::group(['middleware' => ['jwt.verify']], function () {
    //RUTA PARA EL LOGOUT DEL SISTEMA
    Route::post('logout', [UserController::class, 'logout']);
    //
    Route::group(['middleware' => ['role:Administrador']], function () {
        //Grupo de rutas de administrador
        Route::prefix('administrador')->group(function () {
            Route::get('resumenventas', [AdministradorController::class, 'index']); //RESUMEN DE VENTAS
            Route::post('reportes', [AdministradorController::class, 'store']); //GENERACION DE REPORTES


            Route::get('SolicitudesAdministrador', [SolicitudesController::class, 'index']); //MOSTRAR TODAS LAS SOLICITUDES
            Route::delete('eliminarsolicitud/{id}', [SolicitudesController::class, 'destroy']); //ELIMINAR UNA SOLICITUD MEDIANTE ID
            Route::put('modificarsolicitud/{id}', [SolicitudesController::class, 'update']); //ACEPTAR UNA SOLICITUD MEDIANTE ID
            Route::get('encontrarsolicitudes/{id}', [SolicitudesController::class, 'show']); //ENCONTRAR SOLICITUD POR ID
            Route::get('solicitudesAceptadas', [SolicitudesController::class, 'SolicitudesAceptadas']); //MOSTRAR SOLICITUDES APROBADAS
            Route::get('solicitudesRechazadas', [SolicitudesController::class, 'SolicitudesRechazadas']); //MOSTRAR SOLICITUDES RECHAZADAS
            //  Ruta de customize (Api home, Crear galerias, Modificar galerias, Eliminar galerias)
            Route::apiResource('customize', CustomizeController::class); //CONTIENE TODO DEL HOME (GALERIAS,TITULOS,DESCRIPCIONES,ETC)
            // RUTA PARA CAMBIAR EL TIPO DE MUESTRA DE LAS GALERIAS
            Route::put('galeriasResultados/{id}', [ListagaleriasController::class, 'updateResultados']); //CAMBIA EL TIPO PARA MOSTRAR EN RESULTADOS
            Route::put('galeriasSorteos/{id}', [ListagaleriasController::class, 'updateSorteos']); //CAMBIA EL TIPO PARA MOSTRAR EN SORTEOS
            Route::put('galeriasUbicanos/{id}', [ListagaleriasController::class, 'updateUbicanos']); //CAMBIA EL TIPO PARA MOSTRAR EN UBICANOS
            Route::put('galeriasTestimonios/{id}', [ListagaleriasController::class, 'updateTestimonios']); //CAMBIA EL TIPO PARA MOSTRAR EN TESTIMONIOS
            Route::get('estadoDeCuenta', [EstadoVentasController::class, 'index']); //ESTADO DE CUENTA
            Route::get('finanzas', [EstadoVentasController::class, 'finanzas']); //TABLA LATERAL DONDE SE ENCUENTRAN LOS ACUMUALDOS DEL DIA, MES, GASTOS, PREMIOS, ACUMULADOS
            Route::get('metricas', [VendedorController::class, 'index']); //VER METRICAS
            Route::delete('bloquearNumero/{id}', [VendedorController::class, 'destroy']); //BLOQUEA UN NUMERO MEDIANTE ID
            Route::put('desbloquearNumero/{id}', [VendedorController::class, 'desbloqueo']); //DESBLOQUEA UN NUMERO MEDIANTE ID
            //Ruta para la creacion de Sorteos
            Route::get('mostrarSorteos', [SorteosController::class, 'index']); //MUESTRA TODO SOBRE SORTEOS
            Route::get('encontrarSorteos/{id}', [SorteosController::class, 'show']); //MUESTRA UN REGISTRO MEDIANTE ID SOBRE SORTEOS
            Route::post('crearSorteos', [SorteosController::class, 'create']); //CREA UN SORTEO 
            Route::put('modificarSorteos/{id}', [SorteosController::class, 'update']); //MODIFICA UN SORTEO MEDIANTE ID
            Route::delete('eliminarSorteos/{id}', [SorteosController::class, 'destroy']); //ELIMINA UN SORTEO MEDIANTE ID
            //Ruta para la creacion de Premios
            Route::get('mostrarPremios', [PremiosController::class, 'index']); //MUESTRA TODO SOBRE PREMIOS
            Route::get('encontrarPremios/{id}', [PremiosController::class, 'show']); //MUESTRA UN REGISTRO MEDIANTE ID SOBRE PREMIOS
            Route::post('crearPremios', [PremiosController::class, 'store']); //CREA UN PREMIO
            Route::put('modificarPremios/{id}', [PremiosController::class, 'update']); //MODIFICA UN PREMIO MEDIANTE ID
            Route::delete('eliminarPremios/{id}', [PremiosController::class, 'destroy']); //ELIMINA UN PREMIO MEDIANTE ID
            //Ruta para la creacion de Acumulados
            Route::get('mostrarAcumulado', [AcumuladoController::class, 'index']); //MUESTRA TODO SOBRE ACUMULADO
            Route::get('encontrarAcumulado/{id}', [AcumuladoController::class, 'show']); //MUESTRA UN REGISTRO MEDIANTE ID SOBRE ACUMULADO
            Route::post('crearAcumulado', [AcumuladoController::class, 'store']); //CREA UN ACUMULADO
            Route::put('modificarAcumulado/{id}', [AcumuladoController::class, 'update']); //MODIFICA UN ACUMULADO MEDIANTE ID
            Route::delete('eliminarAcumulado/{id}', [AcumuladoController::class, 'destroy']); //ELIMINA UN ACUMULADO MEDIANTE ID
            //Rutas para crear Roles => Administrador -> Promotor -> Vendedor
            Route::get('CrearAdministrador', [CrearRoles::class, 'CrearAdministrador']); //CREA EL ROL AL ULTIMO ID REGISTRADO
            Route::get('CrearPromotor', [CrearRoles::class, 'CrearPromotor']); //CREA EL ROL AL ULTIMO ID REGISTRADO
            Route::get('CrearVendedor', [CrearRoles::class, 'CrearVendedor']); //CREA EL ROL AL ULTIMO ID REGISTRADO
            //Rutas para eliminar Roles => Administrador -> Promotor -> Vendedor
            Route::get('EliminarAdministrador/{id}', [CrearRoles::class, 'EliminarAdministrador']); //ELIMINA EL ROL AL ID SUMINISTRADO
            Route::get('EliminarPromotor/{id}', [CrearRoles::class, 'EliminarPromotor']); //ELIMINA EL ROL AL ID SUMINISTRADO
            Route::get('EliminarVendedor/{id}', [CrearRoles::class, 'EliminarVendedor']); //ELIMINA EL ROL AL ID SUMINISTRADO
            //Rutas para modificar Roles => Administrador -> Promotor -> Vendedor
            Route::get('ModificarAdministrador/{id}', [CrearRoles::class, 'ModificarAdministrador']); //CREA EL ROL AL ID SUMINISTRADO
            Route::get('ModificarPromotor/{id}', [CrearRoles::class, 'ModificarPromotor']); //ELIMINA EL ROL ACTUAL Y AGREGA ROL PROMOTOR
            Route::get('ModificarVendedor/{id}', [CrearRoles::class, 'ModificarVendedor']); //ELIMINA EL ROL VENDEDOR Y AGREGA ROL PROMOTOR

        });
    });

    Route::group(['middleware' => ['role:Promotor']], function () {
        //Grupo de rutas de Promotor
        Route::prefix('promotor')->group(function () {
            Route::post('crearvendedor', [UserController::class, 'register']); //CREA UN VENDEDOR AFILIADO AL PROMOTOR
            Route::get('mostrarvendedor', [ModuloVendedorController::class, 'index']); //MUESTRA TODOS LOS VENDEDORES AFILIADOS AL PROMOTOR
            Route::get('encontrarvendedor/{id}', [ModuloVendedorController::class, 'show']); //MUESTRA UN VENDEDOR MEDIANTE ID AFILIADO AL PROMOTOR
            Route::put('modificarvendedor/{id}', [ModuloVendedorController::class, 'update']); //MODIFICA UN VENDEDOR MEDIANTE ID AFILIADO AL PROMOTOR
            Route::delete('eliminarvendedor/{id}', [ModuloVendedorController::class, 'destroy']); //ELIMINAR UN VENDEDOR MEDIANTE ID AFILIADO AL PROMOTOR
            Route::post('busquedavendedor', [ModuloVendedorController::class, 'busqueda']); //BARRA DE BUSQUEDA MEDIANTE EL NOMBRE
            Route::get('mostrarsolicitudes', [SolicitudesController::class, 'index']); //MOSTRAR TODAS LAS SOLICITUDES 
            Route::post('crearsolicitudes', [SolicitudesController::class, 'store']); //CREAR SOlICITUDES
            Route::get(
                'encontrarsolicitudes/{id}',
                [SolicitudesController::class, 'show'] //ENCONTRAR SOLICITUD POR ID
            ); //MUESTRA SOLO UN REGISTRO DE SOLICITUDES MEDIANTE ID
            Route::delete('eliminarsolicitud/{id}', [SolicitudesController::class, 'destroy']); //ELIMINAR UNA SOLICITUD MEDIANTE ID
            Route::get('estadodecuenta', [ModuloVendedorController::class, 'analisisPromotor']); //VENTAS TOTALES DEL DIA,MES, PREMIOS, ACUMUALDOS 
        });
    });

    Route::group(['middleware' => ['role:Vendedor']], function () {
        //Grupo de rutas del vendedor
        Route::prefix('vendedor')->group(function () {
            Route::post('reportarventa', [VendedorController::class, 'store']); //CREAR VENTA
            Route::get('mostrarventa',   [VendedorController::class, 'index']); //MUESTRA TODAS LAS VENTAS
            Route::get('encontrarventa/{id}', [VendedorController::class, 'show']); //MUESTRA UNA VENTA MEDIANTE ID
            Route::put('modificarventa/{id}', [VendedorController::class, 'update']); //MODIFICA UNA VENTA MEDIANTE ID
            Route::delete('eliminarventa/{id}', [VendedorController::class, 'destroy']); //ELIMINA UNA VENTA MEDIANTE ID
            Route::post('crearsolicitud', [SolicitudesController::class, "store"]); //CREAR SOLICITUDES
            Route::get('mostrarsolicitud', [SolicitudesController::class, 'index']); //MOSTRAR TODAS LAS SOLICITUDES
            Route::get('encontrarsolicitud/{id}', [SolicitudesController::class, 'show']); //MOSTRAR UN REGISTRO DE SOLICITUDES MEDIANTE ID
            Route::delete('eliminarsolicitud/{id}', [SolicitudesController::class, 'destroy']); //ELIMINAR SOLICITUD MEDIANTE ID
            Route::get('estadodecuenta', [ModuloVendedorController::class, 'analisisVendedor']); //VENTAS TOTALES DEL DIA,SEMANA,MES PREMIOS, ETC
            //Route::put('modificarsolicitud/{id}', [SolicitudesController::class,'update']); EN CASO DE NECESITARSE RUTA PARA MODIFICAR

        });
    });
});



//Ruta del envio de correos
Route::get('contactanos', [MailController::class, 'index'])->name('contactanos.index');
Route::post('contactanos', [MailController::class, 'store'])->name(('contactanos.store')); //ENVIO DE CORREOS
//Route::post('getmail',[MailController::class,'getMail']);

//Rutas para el Rol de administrador




/////////////////// RUTAS DE PUERBAS ////////////////////

//Ruta para el CRUD de vendedores
Route::apiResource('admin', AdminController::class)->names('admin.vendedores');

//Ruta que permita traer datos del user
Route::get('users', [UserController::class, 'GetUsers']);

//Rutas para crear Roles
Route::get('verAdministrador', function () {
    //dd(Role::all(), Permission::all());
    User::first()->assignRole('General');
    dd(User::first()->can('crearVendedor'));
});
Route::get('crearAdministrador', function () {
    //Role::create(['name' => 'General']);
    //Permission::create(['name' => 'crearVendedor']);
    //dd(User::latest('id')->first()->hasRole('Administrador'));
    //$usuarios = User::with('rol')->whereRolId(1)->findOrFail(auth()->id());
    //dd($usuarios);
    if (User::all()->hasRole('Administrador')->findOrFail(auth()->id())) {
        return response()->json(["Rol" => "Administrador"], 200);
    } else {
        return response()->json(["No es administrador"], 200);
    }
});
