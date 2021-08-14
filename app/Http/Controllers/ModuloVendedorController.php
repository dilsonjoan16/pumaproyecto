<?php

namespace App\Http\Controllers;

use App\Models\Acumulado;
use App\Models\Premios;
use App\Models\Promotor;
use App\Models\Sorteos;
use App\Models\User;
use App\Models\Vendedor;
use App\Models\Reporte;
use App\Models\Ventas;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ModuloVendedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = auth()->user();
        $usuario->id;

        //VENDEDORES AFILIADOS AL PROMOTOR
        $vendedores = User::with('tieneUsuarios')->where('tipo', 1)->find($usuario->id);

        return response()->json($vendedores, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendedor = User::find($id);
        $respuesta =  [
            "Objeto encontrado con exito!" => $vendedor
        ];
        return response()->json($respuesta, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //$nuevo_id = $request->get('nuevo_id');
        $user = User::find($id);
        if ($imagenes = $request->file('foto')) {
            $file = $imagenes->getClientOriginalName();
            $imagenes->move('images', $file);
            $user['foto'] = $file;
        }
        if ($imagenes === null) {
            $user->update($request->all());
            //$user->rol_id = 3;
            //$user->user_id = $nuevo_id;
            $user->save();
            /*if ($user->hasRole('Administrador')) {
                    $user->removeRole('Administrador');
                }
                if ($user->hasRole('Promotor')) {
                    $user->removeRole('Promotor');
                }
                $user->assignRole('Vendedor');*/
            $respuesta =  [
                "El objeto fue actualizado con exito!" => $user,
            ];
            return response()->json($respuesta, 200);
        }
        if ($imagenes !== null) {
            $user->update([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'dni' => $request->get('dni'),
                'ganancia' => $request->get('ganancia'),
                'porcentaje' => $request->get('porcentaje'),
                'foto' => $file,
                'direccion' => $request->get('direccion'),
                'telefono' => $request->get('telefono'),
                'codigo' => $request->get('codigo'),
                //'rol_id' => 3
            ]);
            /*if ($user->hasRole('Administrador')) {
                    $user->removeRole('Administrador');
                }
                if ($user->hasRole('Promotor')) {
                    $user->removeRole('Promotor');
                }
                $user->assignRole('Vendedor');*/
            //$user->user_id = $nuevo_id;
            //$user->save();
            $respuesta =  [
                "El objeto fue actualizado con exito!" => $user,
            ];

            return response()->json($respuesta, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendedor = User::find($id);
        $vendedor->tipo = 0;
        $vendedor->email = "Eliminado/".$vendedor->email;
        $vendedor->save();

        $respuesta =  [
            "Objeto eliminado con exito!" => $vendedor
        ];

        return response()->json($respuesta, 200);
    }

    public function busqueda(Request $request)
    {
        $request->validate([
            "busqueda" => "string|max:255"
        ]);

        $busqueda = $request->get('busqueda');

        $vendedor = User::where('name', 'LIKE', '%' . $busqueda . '%')->orWhere('email', 'LIKE', '%' . $busqueda . '%')->get();

        return response()->json($vendedor, 200);
    }

    public function analisisPromotor()
    {
        $usuario = auth()->user();
        $usuario->id;

        $fechaActual = Carbon::now();
        //$week = Carbon::now()->week(); SEMANA ACTUAL CON CARBON


        $month = $fechaActual->format('m');
        $day = $fechaActual->format('d');
        $year = $fechaActual->format('Y');
        $fechaActual = $fechaActual->format('d-m-Y');
        $lastWeek = Carbon::now()->subWeek();
        $afterWeek = Carbon::now()->addWeek();
        $actualweek = Ventas::where("created_at", "<", $afterWeek)->where("created_at", ">", $lastWeek)->count("Numero");

        /*
        $today = Carbon::now();
         = //whatever carbon or something else has to retrieve today's day
        $ventasemanal = Ventas::where
       ->where('startdate', '<', $today->format('Y-m-d'))
       ->where('endate', '>', $today->format('Y-m-d'))
       //or where ('weekday') = $weekday?
       ->get();


         */
        //$fechaActual = $fechaActual->format('Y-m-d');

        $ventas = User::with('Ventas')->find($usuario->id); //VENTAS DEL PROMOTOR
        $ventasVendedor = User::with('tieneUsuarios')->where('user_id', $usuario->id)->with('Ventas')->get();
        //RESUMEN DE VENTAS DEL PROMOTOR
        $ventatotal = Ventas::with('user')->where('user_id', '=', $usuario->id)->count();
        $ventadiaria = Ventas::with('user')->where('user_id', '=', $usuario->id)->whereDay('created_at', $day)->sum('Valorapuesta');
        $ventasemanal = Ventas::with('user')->where('user_id', '=', $usuario->id)->where("created_at", "<", $afterWeek)->where("created_at", ">", $lastWeek)->sum('Valorapuesta');
        $ventamensual = Ventas::with('user')->where('user_id', '=', $usuario->id)->whereMonth('created_at', $month)->sum('Valorapuesta');
        $ventaanual = Ventas::with('user')->where('user_id', '=', $usuario->id)->whereYear('created_at', $year)->sum('Valorapuesta');
        $acumulados = Acumulado::where('Estado', '=', 1)->get();
        $premios = Premios::where('Estado', '=', 1)->get();
        $acumulado = $usuario->balance;
        $gastos = Reporte::where('Tipo', 'Gasto')->sum('Monto');
        $premios = Reporte::where('Tipo', 'Premio')->sum('Monto');
        //FALTA "PREMIOS" SON PREMIOS GRANDES O FINALES DE LA RIFA
        $respuesta =  [

            "Ventas totales" => $acumulado,
            "Ventas del dia" => $ventadiaria,
            "Ventas de la semana" => $ventasemanal,
            "Ventas del mes" => $ventamensual,
            "Ventas del año" => $ventaanual,
            // "Acumulado de apuestas" => $acumulado,
            //"Acumulados" => $acumulados,
            //"Premios" => $premios,
            //"VENTAS PRUEBA2" => $array,
            "Datos y ventas del promotor" => $ventas,
            "Datos de los vendedores" => $ventasVendedor,
            //"acumulado" => $acumulado,
            "gastos" => $gastos,
            "premios" => $premios
        ];
        return response()->json($respuesta, 200);
    }

    public function analisisVendedor()
    {
        $usuario = auth()->user();
        $usuario->id;

        $fechaActual = Carbon::now();
        //$week = Carbon::now()->week(); SEMANA ACTUAL CON CARBON


        $month = $fechaActual->format('m');
        $day = $fechaActual->format('d');
        $year = $fechaActual->format('Y');
        $fechaActual = $fechaActual->format('d-m-Y');
        $lastWeek = Carbon::now()->subWeek();
        $afterWeek = Carbon::now()->addWeek();
        //dd($day);
        //EJEMPLO BASE -> $actualweek = Ventas::where("created_at", "<", $afterWeek)->where("created_at", ">", $lastWeek)->count("Numero");

        /*
        $today = Carbon::now();
         = //whatever carbon or something else has to retrieve today's day
        $ventasemanal = Ventas::where
       ->where('startdate', '<', $today->format('Y-m-d'))
       ->where('endate', '>', $today->format('Y-m-d'))
       //or where ('weekday') = $weekday?
       ->get();


         */


        //$fechaActual = $fechaActual->format('Y-m-d');

        $ventas = User::with('Ventas')->find($usuario->id);
        //$ventas = Ventas::with('user')->where('user_id', '=', $usuario->id)->get();
        //SOLICITUDES APARTE
        $ventatotal = Ventas::with('user')->where('user_id', '=', $usuario->id)->count();
        $ventadiaria = Ventas::with('user')->where('user_id', '=', $usuario->id)->whereDay('Fecha', $day)->sum('Valorapuesta');
        $ventasemanal = Ventas::with('user')->where('user_id', '=', $usuario->id)->where("Fecha", "<", $afterWeek)->where("Fecha", ">", $lastWeek)->sum('Valorapuesta');
        $ventamensual = Ventas::with('user')->where('user_id', '=', $usuario->id)->whereMonth('Fecha', $month)->sum('Valorapuesta');
        $ventaanual = Ventas::with('user')->where('user_id', '=', $usuario->id)->whereYear('Fecha', $year)->sum('Valorapuesta');
        $acumulado = $usuario->balance;
        //$acumulado = Ventas::sum('Valorapuesta'); ACUMULADO SON PREMIOS CHICOS
        //FALTA "PREMIOS" SON PREMIOS GRANDES O FINALES DE LA RIFA
        $respuesta =  [

            "Ventas totales del usuario" => $ventatotal,
            "Ventas del dia del usuario" => $ventadiaria,
            "Ventas de la semana del usuario" => $ventasemanal,
            "Ventas del mes del usuario" => $ventamensual,
            "Ventas del año del usuario" => $ventaanual,
            // "Acumulado de apuestas" => $acumulado,
            "Datos del modelo asociado al vendedor" => $ventas,
            "acumulado" => $acumulado

        ];
        return response()->json($respuesta, 200);
    }
}
