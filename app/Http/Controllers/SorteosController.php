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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*public function crear(Request $request)
    {
        $usuario = auth()->user();

        $request->validate([
            
            "Fecha" => "required|date",
            "Loteria" => "required|string",
            "Codigo" => "required|string|unique:sorteos,Codigo",
            //insercion de datos del modelo Premios
            //"NombrePremio" => "required|string|max:255",
            //"MontoReferenciaPremio" => "required|integer",
            //insercion de datos del modelo Acumulados
            //"NombreDeAcumulado" => "required|string|max:255",
            //"MontoReferenciaAcumulado" => "required|integer"
            
            //"Lugarpodio",
            //"NombreGanador",
            //"Vendedor"
        ]);

        $sorteos = Sorteos::create([
            
            "Fecha" => $request->get("Fecha"),
            "Loteria" => $request->get("Loteria"),
            "Codigo" => $request->get("Codigo")
            
        ]);

        $sorteos->user_id = $usuario->id;
        $sorteos->save();

        $usuario->sorteo_id = $sorteos->id;
        $usuario->save();

        $creador = User::where('id', '=', $sorteo->user_id)->first();
        /*$premios = Premios::create([
            "Nombre" => $request->get('NombrePremio'),
            "MontoReferencia" => $request->get('MontoReferenciaPremio')
        ]);

        $acumulado = Acumulado::create([
            "Nombre" => $request->get('NombreDeAcumulado'),
            "MontoReferencia" => $request->get('MontoReferenciaAcumulado')
        ]);*/
        /*
        $respuesta =  [
            "Sorteo Creado con exito!" => $sorteos,
            "Creador del sorteo" => $creador
            /*"Premios creados para el sorteo" => $sorteos->premios()->where('Estado', '=', 1)->get(),
            "Acumulados creados para el sorteo" => $sorteos->acumulado()->where('Estado', '=', 1)->get(),
            "Premios recien creados" => $premios,
            "Acumulado recien creados" => $acumulado*/
        /*];

        return response()->json($respuesta, 201);
    }*/

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
        /////////SUJETO A REVISION//////////////

        $sorteos = Sorteos::find($id);
        //$premios = $sorteos->premios;
        //$acumulados = $sorteos->acumulado;
        //$acumulados->update($request->all());
        //$premios->update($request->all());
        $sorteos->update($request->all());

        /////////SUJETO A REVISION//////////////
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
            "Codigo" => "required|string|unique:sorteos,Codigo"
        ]);

        $sorteos = new Sorteos;
        $sorteos->Fecha = $request->get('Fecha');
        $sorteos->Loteria = $request->get('Loteria');
        $sorteos->Codigo = $request->get('Codigo');
        $sorteos->user_id = $usuario->id;
        $sorteos->save();
        $usuario->sorteo_id = $sorteos->id;
        $usuario->save();

        $creador = User::where('id', '=', $sorteos->user_id)->first();

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
}
