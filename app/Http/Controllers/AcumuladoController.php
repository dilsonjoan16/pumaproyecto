<?php

namespace App\Http\Controllers;
use App\Models\Acumulado;
use Illuminate\Http\Request;

class AcumuladoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $acumulado = Acumulado::where('Estado', '=', 1)->get();

        return response()->json($acumulado, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Acumulado $acumulado)
    {
        $request->validate([
            "Nombre" => "required|string|max:255",
            "MontoReferencia" => "required|integer"
        ]);
        
        $acumulado = Acumulado::create([
            "Nombre" => $request->get("Nombre"),
            "MontoReferencia" => "required|integer"
        ]);

        $respuesta =  [
            "Objeto creado con exito!" => $acumulado
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
        $acumulado = Acumulado::find($id);
        $prueba =  [
            "Objeto encontrado con exito!" => $acumulado
        ];

        return response()->json($prueba, 200);
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
        $acumulado = Acumulado::find($id);
        $acumulado->update($request->all());
        $respuesta =  [
            "Objeto modificado con exito!" =>$acumulado
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
        $acumulado = Acumulado::find($id);
        $acumulado->Estado = 0;
        $acumulado->save();

        $respuesta =  [
            "Objeto eliminado con exito!" => $acumulado
        ];

        return response()->json($respuesta, 200);
    }
}
