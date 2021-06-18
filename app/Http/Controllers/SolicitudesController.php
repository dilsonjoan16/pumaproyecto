<?php

namespace App\Http\Controllers;

use App\Models\Solicitudes;
use Illuminate\Http\Request;

class SolicitudesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $solicitudes = Solicitudes::where('tipo', '=', '1')->get();

        return response()->json($solicitudes, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Solicitudes $solicitudes)
    {
        /*$solicitudes = Solicitudes::create($request->all());
        return $solicitudes;*/
        $request->validate([
            "Nombre" => "required|string",
            "CantidadSolicitada" => "required|integer",
            "Cuotas" => "required|integer",
            "MobiliarioSolicitado" => "required|string",
            "Ubicacion" => "required|string",
            "Solicitud" => "required|string",

        ]);

        $solicitudes = Solicitudes::create([
            "Nombre" => $request->get("Nombre"),
            "CantidadSolicitada" => $request->get("CantidadSolicitada"),
            "Cuotas" => $request->get("Cuotas"),
            "MobiliarioSolicitado" => $request->get("MobiliarioSolicitado"),
            "Ubicacion" => $request->get("Ubicacion"),
            "Solicitud" => $request->get("Solicitud")

        ]);

        $respuesta =  [
            "La solicitud ha sido creada y enviada con exito!" => $solicitudes
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
        $solicitudes = Solicitudes::find($id);
        $respuesta =  [
            "Objeto encontrado con exito!" => $solicitudes
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
        $solicitudes = Solicitudes::find($id);
        $solicitudes->Tipo = "2";
        $solicitudes->save();
        $respuesta =  [
            "El objeto fue validado con exito!" => $solicitudes
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
        $solicitudes = Solicitudes::find($id);
        $solicitudes->Tipo = "0";
        $solicitudes->save();

        /*
            Otra logica posible: 
            MyModel::where('confirmed', '=', 0)->update(['confirmed' => 1])
        */

        $respuesta =  [
            "El objeto fue eliminado con exito!" => $solicitudes
        ];

        return response()->json($respuesta, 200);
    }

    public function SolicitudesRechazadas()
    {
        $solicitudes = Solicitudes::where('Tipo','=',0)->get();
        $respuesta =  [
            "Solicitudes Rechazadas" => $solicitudes
        ];
        return response()->json($respuesta, 200);
    }

    public function SolicitudesAceptadas()
    {
        $solicitudes = Solicitudes::where('Tipo', '=', 2)->get();
        $respuesta =  [
            "Solicitudes Aceptadas" => $solicitudes
        ];
        return response()->json($respuesta, 200);
    }
}
