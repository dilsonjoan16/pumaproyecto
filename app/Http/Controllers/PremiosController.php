<?php

namespace App\Http\Controllers;

use App\Models\Premios;
use Illuminate\Http\Request;

class PremiosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $premios = Premios::where('Estado', '=', 1)->get();

        return response()->json($premios, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Premios $premios)
    {
        $request->validate([
            "Nombre" => "required|string|max:255",
            "MontoReferencia" => "required|integer"
        ]);

        $premios = Premios::create([
            "Nombre" => $request->get("Nombre"),
            "MontoReferencia" => $request->get("MontoReferencia"),
        ]);

        $respuesta =  [
            "Objeto creado con exito!" => $premios
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
        $premios = Premios::find($id);
        $respuesta =  [
            "Objeto encontrado con exito!" => $premios
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
        $premios = Premios::find($id);
        $premios->update($request->all());
        $respuesta =  [
            "Objeto modificado con exito!" => $premios
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
        $premios = Premios::find($id);
        $premios->Estado = 0;
        $premios->save();

        $respuesta = [
            "Objeto eliminado con exito!" => $premios
        ];

        return response()->json($respuesta, 200);
    }
}
