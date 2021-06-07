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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
