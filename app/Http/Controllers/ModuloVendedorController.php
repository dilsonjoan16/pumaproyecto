<?php

namespace App\Http\Controllers;

use App\Models\Acumulado;
use App\Models\Premios;
use App\Models\Promotor;
use App\Models\Sorteos;
use App\Models\User;
use App\Models\Vendedor;
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
        $vendedores = User::with('tieneUsuarios')->find($usuario->id);

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
        $ventas3 = Ventas::select('Loteria')->where('user_id', $usuario->id)->get();
        
        $ventas2 = Ventas::where('user_id', $usuario->id)->get();
        
        foreach ($ventas3 as $v3) {
        }
        //dd($v3->Loteria);
        $loterias = Sorteos::where('id', $v3->Loteria)->get(); //LOTERIAS AFILIADAS
        foreach ($loterias as $lt) {
        }
        //dd($lt->Loteria);
        
        foreach($ventas2 as $v) //ESTO SE REAIZA PARA PODER COLOCARLE EL NOMBRE A LA LOTERIA EN LUGAR DEL ID SIN MODIFICAR LA BD SOLO EL OBJETO
        {
            $v->Fecha = $v->Fecha;
            $v->Numero = $v->Numero;
            $v->Valorapuesta =  $v->Valorapuesta;
            $v->Loteria = $lt->Loteria;
            $v->Tipo = $v->Tipo;
            $v->Estado = $v->Estado;
            $v->Referencia = $v->Referencia;
            $v->Sumatotalventas = $v->Sumatotalventas;
            $v->Puntoventas = $v->Puntoventas;
            $v->Puntoentregaventas = $v->Puntoentregaventas;
            //dd($ventas2);
        }
        $ventasVendedor = User::with('tieneUsuarios')->where('user_id', $usuario->id)->with('Ventas')->get();
        //dd($ventasVendedor);
        /*foreach($ventasVendedor as $vv){
            foreach($vv->Ventas as $v2){
            }
        }
        //dd($v2->Loteria);
        $loterias2 = Sorteos::where('id', $v2->Loteria)->get(); //LOTERIAS AFILIADAS
        foreach($loterias2 as $lt2){}
        //dd($lt2->Loteria);
        $array = [];
        /*
        $venta = User::with('tieneUsuarios')->get();
        return $venta;*/
        /*foreach ($ventasVendedor as $vvv) {
            if($vvv->tieneUsuarios) {
                dd($vvv->tieneUsuarios);
            }else {
                dd($vvv);
            }
            foreach ($vvv->Ventas as $v22) {
                $array[] = [
                "Fecha" => $v22->Fecha,
                "Numero" => $v22->Numero,
                "Valoapuesta" =>  $v22->Valorapuesta,
                "Loteria" => $lt2->Loteria,
                "Tipo" => $v22->Tipo,
                "Estado" => $v22->Estado,
                "Referencia" => $v22->Referencia,
                "Sumatotalventas" => $v22->Sumatotalventas,
                "Puntoventas" => $v22->Puntoventas,
                "Puntoentregaventas" => $v22->Puntoentregaventas,
            ];
                //dd($vvv->Ventas);
            }
        }*/
        //dd($array);
        //RESUMEN DE VENTAS DEL PROMOTOR
        $ventatotal = Ventas::with('user')->where('user_id', '=', $usuario->id)->count();
        $ventadiaria = Ventas::with('user')->where('user_id', '=', $usuario->id)->whereDay('created_at', $day)->count();
        $ventasemanal = Ventas::with('user')->where('user_id', '=', $usuario->id)->where("created_at", "<", $afterWeek)->where("created_at", ">", $lastWeek)->count();
        $ventamensual = Ventas::with('user')->where('user_id', '=', $usuario->id)->whereMonth('created_at', $month)->count();
        $ventaanual = Ventas::with('user')->where('user_id', '=', $usuario->id)->whereYear('created_at', $year)->count();
        $acumulados = Acumulado::where('Estado', '=', 1)->get();
        $premios = Premios::where('Estado', '=', 1)->get();
        //$acumulado = Ventas::sum('Valorapuesta'); ACUMULADO SON PREMIOS CHICOS
        //FALTA "PREMIOS" SON PREMIOS GRANDES O FINALES DE LA RIFA
        $respuesta =  [

            "Ventas totales" => $ventatotal,
            "Ventas del dia" => $ventadiaria,
            "Ventas de la semana" => $ventasemanal,
            "Ventas del mes" => $ventamensual,
            "Ventas del año" => $ventaanual,
            // "Acumulado de apuestas" => $acumulado,
            //"Acumulados" => $acumulados,
            //"Premios" => $premios,
            "VENTAS PRUEBA" => $ventas2,
            //"VENTAS PRUEBA2" => $array,
            "Datos y ventas del promotor" => $ventas,
            "Datos de los vendedores" => $ventasVendedor
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
        $ventadiaria = Ventas::with('user')->where('user_id', '=', $usuario->id)->whereDay('Fecha', $day)->count('id');
        $ventasemanal = Ventas::with('user')->where('user_id', '=', $usuario->id)->where("Fecha", "<", $afterWeek)->where("Fecha", ">", $lastWeek)->count();
        $ventamensual = Ventas::with('user')->where('user_id', '=', $usuario->id)->whereMonth('Fecha', $month)->count();
        $ventaanual = Ventas::with('user')->where('user_id', '=', $usuario->id)->whereYear('Fecha', $year)->count();
        //$acumulado = Ventas::sum('Valorapuesta'); ACUMULADO SON PREMIOS CHICOS
        //FALTA "PREMIOS" SON PREMIOS GRANDES O FINALES DE LA RIFA
        $respuesta =  [

            "Ventas totales del usuario" => $ventatotal,
            "Ventas del dia del usuario" => $ventadiaria,
            "Ventas de la semana del usuario" => $ventasemanal,
            "Ventas del mes del usuario" => $ventamensual,
            "Ventas del año del usuario" => $ventaanual,
            // "Acumulado de apuestas" => $acumulado,
            "Datos del modelo asociado al vendedor" => $ventas

        ];
        return response()->json($respuesta, 200);
    }
}
