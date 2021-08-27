<?php

namespace App\Http\Controllers;

use App\Models\Ventas;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Premios;
use App\Models\Acumulado;
use App\Models\Reporte;
use App\Models\User;

class EstadoVentasController extends Controller
{
    public function index()
    {

        $estadodecuenta = Reporte::with('user')->get();

        $ventas = Ventas::selectRaw('sum(Valorapuesta) as venta, user_id, Fecha')->groupBy('user_id', 'Fecha')->with('user', function($q){
            $q->select('name', 'id')->get();
        })->get();
        
        $respuesta =  [
            //"Modelo Ventas" => $ventas,
            "Modelo Reporte" => $estadodecuenta,
            "ventaDiaria" => $ventas
            /*"Ventas de promotores" => ->where('Estado','=', 1)->get(),
            "Ventas de vendedores" => $ventas->vendedores()->where('Estado','=',1)->get()*/
        ];
        return response()->json($respuesta, 200);
    }

    public function finanzas()
    {
        $fechaActual = Carbon::now(); //OBTENGO LA FECHA ACTUAL
        $month = $fechaActual->format('m');
        $day = $fechaActual->format('d');
        $year = $fechaActual->format('Y');
        $fechaActual = $fechaActual->format('d-m-Y');
        //CONSULTAS
        $ventaDiaria = Ventas::whereDay('created_at', $day)->sum('Valorapuesta'); //SUMA DEL ACUMULADO DE VENTAS DIARIO
        $cuentaVentaDiaria = Ventas::whereDay('created_at', $day)->count('Numero'); //CONTEO DE VENTAS DIARIO
        $ventaMensual = Ventas::whereMonth('created_at', $month)->sum('Valorapuesta'); //SUMA DEL ACUMULADO DE VENTAS MENSUALES
        $cuentaVentaMensual = Ventas::whereMonth('created_at', $month)->count('Numero'); //CONTEO DE VENTAS EN EL MES
        //$montoPremio = Premios::where('Estado', '=', 1)->sum('MontoReferencia');
        //$montoAcumulado = Acumulado::where('Estado', '=', 1)->sum('MontoReferencia');
        $gastos = Reporte::where('Tipo', 'Gasto')->sum('Monto');
        //$acumulado = User::where('tipo', 1)->sum('balance');
        $acumulado3 = Acumulado::sum('Monto');
        $acumulado2 = Reporte::where('Salida', 'Acumulado')->sum('Monto');
        $acumulado = $acumulado3 - $acumulado2;
        $premios = Reporte::where('Tipo','Premio')->sum('Monto');
        //FIN DE CONSULTAS
        $State =  [
            "AcumuladoDeVentasDelDia" => $ventaDiaria,
            "ConteoDeVentasDelDia" => $cuentaVentaDiaria,
            "AcumuladoDeVentasDelMes" => $ventaMensual,
            "ConteoDeVentasDelMes" => $cuentaVentaMensual,
            "AcumuladoDelMontoDePremios" => $premios,
            "AcumuladoDelMontoDeAcumulado" => $acumulado,
            "AcumuladoDelMontoDeGastos" => $gastos,
            "fecha Actual" =>$fechaActual,
        ];

        return response()->json($State, 200);
    }

}
