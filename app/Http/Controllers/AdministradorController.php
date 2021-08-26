<?php

namespace App\Http\Controllers;

use App\Models\Acumulado;
use App\Models\Administrador;
use App\Models\Reporte;
use App\Models\Ventas;
use Illuminate\Http\Request;
use App\Models\User;

class AdministradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $resumenventasProm = User::with('Ventas')->where('rol_id', '=', 2)->get();
        $resumenventasVend = User::with('Ventas')->where('rol_id', '=', 3)->get();

        return response()->json(compact('resumenventasProm','resumenventasVend'), 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $usuario = auth()->user();
        $tipo = $request->get('Tipo');
        //dd($tipo);

        $request->validate([
            "Monto" => "required|integer",
            "user_pago" => "integer",
            //"Tipo" => "required", //Esto es Gasto, Pago, Premio
            "Descripcion" => "string|max:255",
            "Salida" => "required", // Esto es Acumulado o Caja


            //"Referencia" => "required|string|max:255",
            //"Transaccion" => "require|string|max:255"

        ]);



        if($tipo == 1)
        {
            $reporte = new Reporte;
            $reporte->Tipo = "Gasto";
            $reporte->Monto = $request->get("Monto");
            $reporte->Descripcion = $request->get("Descripcion");
            $reporte->Salida = $request->get("Salida");
            $reporte->user_id = $usuario->id;
            $reporte->save();

            //$acumulado2 = Acumulado::sum('Monto');
            //dd($acumulado2);
            //$acumulacion = ($acumulado2 - $reporte->Monto);
            //dd($acumulacion);
            //dd($reporte->Monto);
            //$acumulado = new Acumulado();
            //$acumulado->Monto = $acumulacion;
            //$acumulado->save();
            

            $usuario->reporte_id = $reporte->id;
            $usuario->save();

            $creador = User::with('reportes')->where('reporte_id', $reporte->id)->get();

            return response()->json(compact('reporte','creador'), 201);

        }
        if($tipo == 2)
        {
            $reporte = new Reporte;
            $reporte->Tipo = "Pago";
            $reporte->user_pago = $request->get("user_pago");
            $reporte->Monto = $request->get("Monto");
            $reporte->Salida = $request->get("Salida");
            $reporte->user_id = $usuario->id;
            $reporte->save();
            $usuario->reporte_id = $reporte->id;
            $usuario->save();

            $pagado = User::select('id')->where('id', $reporte->user_pago)->first();
            $creador = User::with('reportes')->where('reporte_id', $reporte->id)->get();

            $userpago = User::find($pagado);
            //dd($userpago);
            foreach($userpago as $p){}

            if($reporte->Monto > $p->balance)
            {
                return response()->json("No puedes cancelar mas de la cuenta", 400);
            }
            else
            {
                if($reporte->Monto <= $p->balance)
                {
                    $p->balance = $p->balance - $reporte->Monto;
                    $p->update();
                }
            }

            //dd($userpago);
            return response()->json(compact('reporte','creador','userpago'), 201);

        }
        if($tipo == 3)
        {
            $reporte = new Reporte;
            $reporte->Tipo = "Premio";
            $reporte->Monto = $request->get("Monto");
            $reporte->Descripcion = $request->get("Descripcion");
            $reporte->Salida = $request->get("Salida");
            $reporte->user_id = $usuario->id;
            $reporte->save();
            $usuario->reporte_id = $reporte->id;
            $usuario->save();

            $creador = User::with('reportes')->where('reporte_id', $reporte->id)->get();

            return response()->json(compact('reporte','creador'), 201);

        }

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
