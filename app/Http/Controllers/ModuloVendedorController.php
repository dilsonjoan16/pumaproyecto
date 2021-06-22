<?php

namespace App\Http\Controllers;
use App\Models\Acumulado;
use App\Models\Premios;
use App\Models\Promotor;
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
        //VENDEDORES AFILIADOS AL PROMOTOR
        $vendedorPromotor = Vendedor::all();
        $vendedorPromotor->promotor()->where('tipo','=', 1)->get();
        //$vendedor = User::where('tipo', '=', 1)->get();
        return response()->json($vendedorPromotor, 200);
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
        $vendedor = User::find($id);
        $vendedor->update($request->all());
        $respuesta =  [
            "Objeto modificado con exito!" =>$vendedor
        ];
        return response()->json($respuesta, 200);
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
            "Objeto eliminado con exito!" =>$vendedor
        ];

        return response()->json($respuesta, 200);
    }

    public function busqueda(Request $request)
    {
        $request->validate([
            "busqueda" => "string|max:255"
        ]);

        $busqueda = $request->get('busqueda');

        $vendedor = Vendedor::where('name', 'LIKE', '%' . $busqueda . '%')->get();

        return response()->json($vendedor, 200);

    }

    public function analisisPromotor()
    {

        
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
        //OJO RELACIONAR CON LOS VENDEDORES DE CADA PROMOTOR
        $ventas = Promotor::all();
        //SOLICITUDES APARTE
        $ventatotal = Ventas::count("Numero");
        $ventadiaria = Ventas::whereDay('created_at', $day)->count('Numero');
        $ventasemanal = $actualweek;
        $ventamensual = Ventas::whereMonth('created_at', $month)->count('Numero');
        $ventaanual = Ventas::whereYear('created_at', $year)->count('Numero');
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
            "Acumulados" => $acumulados,
            "Premios" => $premios,
            "Datos del modelo" => $ventas->ventaVendedor

        ];
        return response()->json($respuesta, 200);
    }

    public function analisisVendedor()
    {


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
        //OJO RELACIONAR CON LOS POMOTORES DE CADA VENDEDOR!!!!
        $ventas = Ventas::all();
        //SOLICITUDES APARTE
        $ventatotal = Ventas::count("Numero");
        $ventadiaria = Ventas::whereDay('created_at', $day)->count('Numero');
        $ventasemanal = $actualweek;
        $ventamensual = Ventas::whereMonth('created_at', $month)->count('Numero');
        $ventaanual = Ventas::whereYear('created_at', $year)->count('Numero');
        //$acumulado = Ventas::sum('Valorapuesta'); ACUMULADO SON PREMIOS CHICOS
        //FALTA "PREMIOS" SON PREMIOS GRANDES O FINALES DE LA RIFA
        $respuesta =  [

            "Ventas totales" => $ventatotal,
            "Ventas del dia" => $ventadiaria,
            "Ventas de la semana" => $ventasemanal,
            "Ventas del mes" => $ventamensual,
            "Ventas del año" => $ventaanual,
            // "Acumulado de apuestas" => $acumulado,
            "Datos del modelo asociado al vendedor" => $ventas->vendedores

        ];
        return response()->json($respuesta, 200);
    }
}
