<?php

namespace App\Http\Controllers;

use App\Models\Acumulado;
use App\Models\Premios;
use App\Models\Sorteos;
use App\Models\User;
use Carbon\Carbon;
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
        $sorteos->Codigo = "Eliminado/$id/".$sorteos->Codigo;
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
            "Codigo" => "required|string", //fragmento eliminado |unique:sorteos,Codigo
            "Max" => "integer",
            "porc_4cifras" => "integer",
            "porc_triple" => "integer",
            "porc_combn3" => "integer",
            "porc_combn4" => "integer",
            "porc_terminal" => "integer",
        ]);
       
        $sorteos = new Sorteos;
        $sorteos->Fecha = $request->get('Fecha'); //YY-MM-DD HH:MM:SS
        $sorteos->Loteria = $request->get('Loteria');
        $sorteos->Codigo = $request->get('Codigo');
        $sorteos->Max = $request->get('Max');
        $sorteos->porc_4cifras = $request->get('porc_4cifras');
        $sorteos->porc_triple = $request->get('porc_triple');
        $sorteos->porc_combn3 = $request->get('porc_combn3');
        $sorteos->porc_combn4 = $request->get('porc_combn4');
        $sorteos->porc_terminal = $request->get('porc_terminal');
        $sorteos->Estado = 1;
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
        $now = Carbon::now();
        $nowAfter = Carbon::now(); //Tiempo Actual del sistema
        $after = $nowAfter->addHour();
        $nowBefore = Carbon::now();
        $before = $nowBefore->subHour(); //-1 Hora del tiempo actual del sistema
        //echo $before;
        //echo $after;

        $sorteo = Sorteos::where('Estado', 1)->where('Fecha', '>', $before )->where('Fecha', '<', $after)->get();
        foreach($sorteo as $s){
            $s->Estado = 0;       //Se hace una busqueda de los sorteos que estan a punto de jugar
            $s->update();         //Una hora antes del juego el sorteo pasa a estado 0 y no se muestra para reportes
        }
        //dd($s);

        $sorteo2 = Sorteos::where('Estado', 1)->where('Fecha', '>', $now)->get();
        //dd($sorteo2);         //Sorteos validos para jugar, respetando la logica de las fechas

        return response()->json($sorteo2, 200);
    }
}
