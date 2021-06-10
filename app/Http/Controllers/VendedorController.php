<?php

namespace App\Http\Controllers;

use App\Models\Ventas;
use Illuminate\Http\Request;

class VendedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /*
        SELECT id,id_usuarios,Count(id_usuarios) 
        FROM tbl_statsingreso 
        GROUP BY id_usuarios 
        HAVING Count(id_usuarios) 
        ORDER BY Count(id_usuarios) 
        DESC
         */
        //$ventas = Ventas::select("Numero")->get()->toArray();
        //$ventas2 = Ventas::count("Numero");

        /*$nombre2 = array_unique($ventas);
        $v_comunes1 = array_diff_assoc($ventas, $nombre2);
        $v_comunes2 = array_unique($v_comunes1);   // Eliminamos los elementos repetidos
        sort($v_comunes2);    // Orden ascendente en array 
        $repetidos = implode(', ', $v_comunes2);    // Creamos cadena a partir del array
    */

        /*$ventas3 = SELECT("Numero",SUM("contador"))
        ->FROM("Ventas")
        ->groupBy("Numero");
        return $ventas3;*/

        /*$ventas3 = [];
        foreach($ventas as $ventas2){
            $ventas3 [] = $ventas2->repeticion;
            
        }/*
        /*
            Consulta SQL propia, regresa cual es el mas repetido en orden

        $ventas4 = Ventas::raw(' SELECT `Numero`, 
        COUNT(`Numero`) FROM `Ventas` GROUP BY `Numero`
         ORDER BY COUNT(`Numero`) DESC');
         */

        //dd($ventas3);
        $ventas = Ventas::groupBy('Numero')->select('Numero', Ventas::raw('count(*) as repeticion'))->orderBy('repeticion', 'DESC')->get();
        $ventas2 = Ventas::all();
        $ventas3 = Ventas::Where('Estado', '=', 0)->get();
        $respuesta =  [
            "Numeros de loteria mas repetidos" => $ventas,
            "Numeros de loteria bloqueados" => $ventas3,
            "Data completa del Modelo" => $ventas2
        ];
        return response()->json($respuesta);
        //SELECT cliente, SUM(precio)
        //FROM pedidos
        //GROUP BY cliente

        
        
        //$masvendido = Ventas::where("Numero",">","$conteo")->get();
        /*$respuesta =  [
            
            "Los numeros mas vendidos son" =>$repetidos
        ];
        $retorno = Ventas::all();
        return response()->json([$respuesta,$retorno]);*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Ventas $ventas)
    {
        $request->validate([
            "Fecha" => "required|date",
            "Numero" => "required|integer",
            "Valorapuesta" => "required|integer",
            "Loteria" => "required|string",
            "Tipo" => "required|string",
            //Menu lateral en las vistas
            "Sumatotalventas" => "required|integer",
            "Puntoventas" => "required|string",
            "Nombrepromotor" => "required|string",
            "Puntoentregaventas" => "required|string"
        ]);

        /* 
            Logica para lograr captar la sumatoria
        */
            //$valor = $valor + $request->get("Sumatotalventas");
        /*
            Fin de la logica para lograr captar la sumatoria
        */
            
        $ventas = Ventas::create([
            "Fecha" => $request->get("Fecha"),
            "Numero" => $request->get("Numero"),
            "Valorapuesta" => $request->get("Valorapuesta"),
            "Loteria" => $request->get("Loteria"),
            "Tipo" => $request->get("Tipo"),
            "Sumatotalventas" => $request->get("Sumatotalventas"),
            "Puntoventas" => $request->get("Puntoventas"),
            "Nombrepromotor" => $request->get("Nombrepromotor"),
            "Puntoentregaventas" => $request->get("Puntoentregaventas"),
            "Sumatoria Final" => $request->get("Sumatotalventas")+$ventas->Sumatotalventas
        ]);
//Revisar la logica para Obtener la sumatoria correcta!
        /*$acumulador = Ventas::where("Sumatotalventas",">","0")->get();
        $ventas->Sumatotalventas + $acumulador;*/
        return response()->json($ventas, 201); //$acumulador);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ventas = Ventas::find($id);
        $respuesta =  [
            "Objeto encontrado con exito!" => $ventas
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
        $ventas = Ventas::find($id);
        $ventas->update($request->all());

        $respuesta =  [
            "El registro fue actualizado con exito!" => $ventas
        ];
        return response()->json($respuesta,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ventas = Ventas::find($id);
        $ventas->Estado = "0";
        $ventas->save();

        $respuesta =  [
            "El objeto fue eliminado con exito!" =>$ventas
        ];

        return response()->json($respuesta, 200);
    }
}
