<?php

namespace App\Http\Controllers;

use App\Models\Acumulado;
use App\Models\Premios;
use App\Models\Sorteos;
use App\Models\User;
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
        $sorteos = Sorteos::where("Estado", '=', 1)->with('user')->get();
        $respuesta =  [
            "Sorteos Activos" => $sorteos
        ];
        return response()->json($respuesta, 200);
    }

    public function sorteoGeneral()
    {
        $sorteos = Sorteos::all();
        return response()->json($sorteos, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sorteos = Sorteos::with('user')->find($id);
        $respuesta =  [
            "Objeto encontrado con exito!" => $sorteos,
            /*"Premios ligados" => $sorteos->premios,
            "Acumulados ligados" => $sorteos->acumulado*/
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

    public function generar(Request $request)
    {
        $usuario = auth()->user();

        $request->validate([
            "Fecha" => "required|date",
            "Loteria" => "required|string",
            "Codigo" => "required|string|unique:sorteos,Codigo",
            //"Max" => "integer"
        ]);

        $sorteos = new Sorteos;
        $sorteos->Fecha = $request->get('Fecha');
        $sorteos->Loteria = $request->get('Loteria');
        $sorteos->Codigo = $request->get('Codigo');
        //$sorteos->Max = $request->get('Max');
        $sorteos->user_id = $usuario->id;
        $sorteos->save();
        $usuario->sorteo_id = $sorteos->id;
        $usuario->update();

        $creador = User::where('id', $sorteos->user_id)->first();

        return response()->json(compact('sorteos','creador'), 201);
    }

    public function habilitar($id)
    {
        $sorteos = Sorteos::find($id);
        $sorteos->Estado = 1;
        $sorteos->save();

        $respuesta =  [
            "Objeto habilitado con exito!" => $sorteos
        ];

        return response()->json($respuesta, 200);
    }

    public function sorteoAll()
    {
        $sorteo = Sorteos::where('Estado', 1)->get();
        return response()->json($sorteo, 200);
    }
}
