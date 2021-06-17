<?php

namespace App\Http\Controllers;
use App\Models\Sorteos;
use Illuminate\Http\Request;

class SorteosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sorteos = Sorteos::where("Estado", '=', 1)->get();
        $respuesta =  [
            "Sorteos Activos" => $sorteos
        ]; 
        return response()->json($respuesta, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Sorteos $sorteos)
    {
        $request->validate([
            "NombreSorteo" => "required|string|max:255",
            "Tipo" => "required|integer|max:10",
            "FechaCulminacion" => "required|date",
            "Numeros" => "required|integer|max:1000",
            
            //"Lugarpodio",
            //"NombreGanador",
            //"Vendedor"
        ]);

        $sorteos = Sorteos::create([
            "NombreSorteo" => $request->get("NombreSorteo"),
            "Tipo" => $request->get("Tipo"),
            "FechaCulminacion" => $request->get("FechaCulminacion"),
            "Numeros" => $request->get("Numeros"),
            
        ]);

        $respuesta =  [
            "Sorteo Creado con exito!" => $sorteos
        ];

        return response()->json($respuesta, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sorteos = Sorteos::find($id);
        $respuesta =  [
            "Objeto encontrado con exito!" => $sorteos
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
        $sorteos = Sorteos::find($id);
        $sorteos->update($request->all());
        $respuesta =  [
            "Objeto Modificado con exito!" => $sorteos
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
        $sorteos = Sorteos::find($id);
        $sorteos->Estado = 0;
        $sorteos->save();

        $respuesta =  [
            "Objeto eliminado con exito!" => $sorteos
        ];

        return response()->json($respuesta, 200);
    }
}
