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
use App\Http\Controllers\Auth\PasswordResetController;
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


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Ruta para el Recovery (Recuperacion de Clave) -> ACTUALMENTE NO FUNCIONA (ESTA ERA LA OPCION 2) FUNCIONA CON
//NOTIFICATION -> FALTA CONFIGURARA QUE AL DARLE CLICK AL BOTON EN EL MAIL REDIRIJA AL FRONT CON LA URL DEL SERVIDOR
Route::group([
    'namespace' => 'Auth',
    //'middleware' => 'api',
    'prefix' => 'password'
], function () {
//    Route::post('create', 'PasswordResetController@create');
  //  Route::get('find/{token}', 'PasswordResetController@find');
    //Route::post('reset', 'PasswordResetController@reset');

    Route::post('create', [PasswordResetController::class, 'create']);
    Route::get('find/{token}', [PasswordResetController::class, 'find']);
    Route::post('reset', [PasswordResetController::class, 'reset']);
});
// FIN DE LA RUTA DE RECOVERY #2
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//RUTA PARA HABILITAR EL CORS
Route::group(['middleware' => 'cors', 'prefix' => 'api'], function () { //RUTA PARA HABILITAR EL CORS EN EL SERVIDOR

    //Ruta del JWT
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'authenticate']);

    //RUTA DEL HOME LIBRE -> Donde se encuentran las imagenes del home y pagina principal
    Route::get('HomeCustomize', [CustomizeController::class, 'index']);


//AUXILIAR PARA CREAR EL PRIMER USUARIO SIN NECECIDAD DE CREDENCIALES (sin necesidad de loguearse
Route::post('auxiliar', [UserController::class, 'emergencia']); //CREACION DE ADMINISTRADORES -> USUARIO 0

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
            Route::get('perfil', [VendedorController::class, 'perfil']); //PERFIL DEL USUARIO
            Route::apiResource('modulopromotorvendedor', ModuloPromVendController::class); //Read-Delete DE PROMOTORES Y VENDEDORES
            Route::get('vendedores/general', [ModuloPromVendController::class, 'condensacion']); //VER TODOS LOS USUARIOS CON ROL MAYOR A 1
            Route::post('moduloPromotorVendedorUpdate/{id}', [ModuloPromVendController::class, 'update']);//UPDATE DE ADMINISTRADORES-PROMOTORES-VENDEDORES
            Route::get('SolicitudesAdministrador', [SolicitudesController::class, 'SolicitudesAdministrador']); //MOSTRAR TODAS LAS SOLICITUDES
            Route::delete('eliminarsolicitud/{id}', [SolicitudesController::class, 'destroy']); //ELIMINAR UNA SOLICITUD MEDIANTE ID
            Route::put('modificarsolicitud/{id}', [SolicitudesController::class, 'update']); //ACEPTAR UNA SOLICITUD MEDIANTE ID
            Route::get('encontrarsolicitudes/{id}', [SolicitudesController::class, 'show']); //ENCONTRAR SOLICITUD POR ID
            Route::get('solicitudesAceptadas', [SolicitudesController::class, 'SolicitudesAceptadas']); //MOSTRAR SOLICITUDES APROBADAS
            Route::get('solicitudesRechazadas', [SolicitudesController::class, 'SolicitudesRechazadas']); //MOSTRAR SOLICITUDES RECHAZADAS
            //  Ruta de customize (Api home, Crear galerias, Modificar galerias, Eliminar galerias)
            Route::apiResource('customize', CustomizeController::class); //CONTIENE TODO DEL HOME (GALERIAS,TITULOS,DESCRIPCIONES,ETC)
            Route::get('customizeGeneral', [CustomizeController::class, 'general']); //CONTIENE TODAS LAS GALERIAS SOLO MUESTRA
            Route::post('customizeUpdate/{id}', [CustomizeController::class,'update']); //MODIFICACION DEL CUSTOMIZE (GALERIAS)
            Route::get('UpdateEstado/{id}', [CustomizeController::class, 'UpdateEstado']); //UPDATE DE ESTADO 0 A 1 (INACTIVO -> ACTIVO)
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
            Route::get('mostrarSorteo', [SorteosController::class, 'index']); //MUESTRA TODO SOBRE SORTEOS
            Route::get('mostrarSorteo/{id}', [SorteosController::class, 'show']); //MUESTRA UN REGISTRO MEDIANTE ID SOBRE SORTEOS
           // RUTA DEFECTUOSA // Route::post('crearSorteos', [SorteosController::class, 'store']); //CREA UN SORTEO
            Route::post('generarSorteo', [SorteosController::class, 'generar']);
            Route::put('modificarSorteo/{id}', [SorteosController::class, 'update']); //MODIFICA UN SORTEO MEDIANTE ID
            Route::delete('eliminarSorteo/{id}', [SorteosController::class, 'destroy']); //ELIMINA UN SORTEO MEDIANTE ID
            Route::put('habilitarSorteo/{id}', [SorteosController::class, 'habilitar']);
            //Ruta para la creacion de Premios
            /*Route::get('mostrarPremios', [PremiosController::class, 'index']); //MUESTRA TODO SOBRE PREMIOS
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
            */

        });
    });

    Route::group(['middleware' => ['role:Promotor']], function () {
        //Grupo de rutas de Promotor
        Route::prefix('promotor')->group(function () {
            Route::post('reportarVentaPromotor', [VendedorController::class, 'guardarVenta']); //REPORTE DE VENTAS DEL PROMOTOR
            Route::post('crearvendedor', [UserController::class, 'register']); //CREA UN VENDEDOR AFILIADO AL PROMOTOR
            Route::get('mostrarvendedor', [ModuloVendedorController::class, 'index']); //MUESTRA TODOS LOS VENDEDORES AFILIADOS AL PROMOTOR
            Route::get('encontrarvendedor/{id}', [ModuloVendedorController::class, 'show']); //MUESTRA UN VENDEDOR MEDIANTE ID AFILIADO AL PROMOTOR
            Route::post('modificarvendedor/{id}', [ModuloVendedorController::class, 'update']); //MODIFICA UN VENDEDOR MEDIANTE ID AFILIADO AL PROMOTOR
            Route::delete('eliminarvendedor/{id}', [ModuloVendedorController::class, 'destroy']); //ELIMINAR UN VENDEDOR MEDIANTE ID AFILIADO AL PROMOTOR
            Route::post('busquedavendedor', [ModuloVendedorController::class, 'busqueda']); //BARRA DE BUSQUEDA MEDIANTE EL NOMBRE
            Route::get('mostrarsolicitud', [SolicitudesController::class, 'verSolicitudPromotor']); //MOSTRAR TODAS LAS SOLICITUDES
            Route::post('crearsolicitud', [SolicitudesController::class, 'store']); //CREAR SOlICITUDES
            Route::get('encontrarsolicitud/{id}', [SolicitudesController::class, 'show']); //ENCONTRAR SOLICITUD POR ID
            Route::delete('eliminarsolicitud/{id}', [SolicitudesController::class, 'destroy']); //ELIMINAR UNA SOLICITUD MEDIANTE ID
            Route::get('resumenDeVentas', [ModuloVendedorController::class, 'analisisPromotor']); //VENTAS TOTALES DEL DIA,MES, PREMIOS, ACUMUALDOS
            Route::get('adicionalesVendedor', [VendedorController::class, 'adicionales']); //DATOS ADICIONALES QUE APARECEN EN REPORTE DE VENTAS -> PROMOTOR, ETC
            Route::get('perfil', [VendedorController::class, 'perfil']); //PERFIL DEL USUARIO
            Route::get('sorteoGeneral', [SorteosController::class, 'sorteoGeneral']); //CONTIENE LOS DATOS COMPLETOS DEL MODELO SORTEOS
            Route::get('sorteos/general', [SorteosController::class, 'sorteoAll']); //TIENE TODOS LOS SORTEOS PARA EL MODULO DE VENTAS (VENTAS MAX Y SE BLOQUEA EL NUMERO)
            Route::post('reportes', [AdministradorController::class, 'store']); //GENERACION DE REPORTES
            Route::get('vendedores/promotor', [ModuloPromVendController::class, 'sublimacion']); //VER TODOS LOS USUARIOS CON ROL MAYOR A 1


        });
    });

    Route::group(['middleware' => ['role:Vendedor']], function () {
        //Grupo de rutas del vendedor
        Route::prefix('vendedor')->group(function () {
            // RUTA INFRUCTUOSA //Route::post('reportarventa', [VendedorController::class, 'store']); //CREAR VENTA //RUTA INFRUCTUOSA
            Route::post('venta', [VendedorController::class, 'guardarVenta']);//RUTA PARA CREAR VENTA-VENDEDOR
            Route::get('mostrarventa',   [VendedorController::class, 'estadoDeCuenta']); //MUESTRA TODAS LAS VENTAS AFILIADAS AL VENDEDOR
            Route::get('encontrarventa/{id}', [VendedorController::class, 'show']); //MUESTRA UNA VENTA MEDIANTE ID
            Route::put('modificarventa/{id}', [VendedorController::class, 'update']); //MODIFICA UNA VENTA MEDIANTE ID
            Route::delete('eliminarventa/{id}', [VendedorController::class, 'destroy']); //ELIMINA UNA VENTA MEDIANTE ID
            Route::post('crearsolicitud', [SolicitudesController::class, "store"]); //CREAR SOLICITUDES
            Route::get('mostrarsolicitud', [SolicitudesController::class, 'solicitudVendedor']); //MOSTRAR TODAS LAS SOLICITUDES
            Route::get('encontrarsolicitud/{id}', [SolicitudesController::class, 'show']); //MOSTRAR UN REGISTRO DE SOLICITUDES MEDIANTE ID
            Route::delete('eliminarsolicitud/{id}', [SolicitudesController::class, 'destroy']); //ELIMINAR SOLICITUD MEDIANTE ID
            Route::get('estadodecuenta', [ModuloVendedorController::class, 'analisisVendedor']); //VENTAS TOTALES DEL DIA,SEMANA,MES PREMIOS, ETC
            Route::get('solicitudesPropias', [SolicitudesController::class, 'index']); //TODOS LOS DATOS AFILIADOS AL USUARIO
            Route::get('adicionalesVendedor', [VendedorController::class,'adicionales']); //DATOS ADICIONALES QUE APARECEN EN REPORTE DE VENTAS -> PROMOTOR, ETC
            Route::get('perfil', [VendedorController::class, 'perfil']); //PERFIL DEL USUARIO
            Route::get('sorteoGeneral', [SorteosController::class, 'sorteoGeneral']);
            Route::get('sorteos/general', [SorteosController::class, 'sorteoAll']);
            //Route::put('modificarsolicitud/{id}', [SolicitudesController::class,'update']); EN CASO DE NECESITARSE RUTA PARA MODIFICAR

        });
    });
});

//Ruta del envio de correos
Route::get('contactanos', [MailController::class, 'index'])->name('contactanos.index');
Route::post('contactanos', [MailController::class, 'store'])->name(('contactanos.store')); //ENVIO DE CORREOS
Route::post('mailRecovery', [MailController::class, 'MailRecovery']); //Envio de emails para recovery password (recovery key)
    //Route::post('getmail',[MailController::class,'getMail']);
});













