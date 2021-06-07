<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Reporte;
use App\Models\Ventas;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $resumenventas = Ventas::all();
        return response()->json($resumenventas, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Reporte $reporte)
    {
        $request->validate([
            "Monto" => "required|integer",
            "Tipo" => "required", //Esto es Gasto, Pago, Premio
            "Salida" => "required", // Esto es Acumulado o Caja
            "Descripcion" => "required|string|max:255",
            
        ]);

        $reporte = Reporte::create([
            "Monto" => $request->get("Monto"),
            "Tipo" => $request->get("Tipo"),
            "Salida" => $request->get("Salida"),
            "Descripcion" => $request->get("Descripcion"),
            
        ]);

        return response()->json($reporte, 201);
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
