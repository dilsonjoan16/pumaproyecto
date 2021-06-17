<?php

namespace App\Http\Controllers;

use App\Models\Ventas;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Premios;
use App\Models\Acumulado;
use App\Models\Reporte;

class EstadoVentasController extends Controller
{
    public function index()
    {
        $ventas = Ventas::where("Estado", "=", 1)->get();
        $estadodecuenta = Reportes::all();
        
        return response()->json($ventas, 200);
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
        $montoPremio = Premios::where('Estado', '=', 1)->sum('MontoReferencia');
        $montoAcumulado = Acumulado::where('Estado', '=', 1)->sum('MontoReferencia');
        $gastos = Reporte::where('Tipo', '=', 'Gasto')->sum('Monto');
        //FIN DE CONSULTAS
        $State =  [
            "Acumulado de ventas del dia" => $ventaDiaria,
            "Conteo de ventas del dia" => $cuentaVentaDiaria,
            "Acumulado de ventas del mes" => $ventaMensual,
            "Conteo de ventas del mes" => $cuentaVentaMensual,
            "Acumulado del Monto de Premios" => $montoPremio,
            "Acumulado del Monto de Acumulados" => $montoAcumulado,
            "Acumulado del Monto de Gastos" => $gastos,
            "fecha Actual" =>$fechaActual,
        ];

        return response()->json($State, 200);
    }
    
}
