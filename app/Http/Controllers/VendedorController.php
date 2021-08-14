<?php

namespace App\Http\Controllers;

use App\Mail\VentaMaxMail;
use App\Models\Promotor;
use App\Models\Vendedor;
use App\Models\User;
use App\Models\Ventas;
use App\Models\Sorteos;
use App\Models\Solicitudes;
use Illuminate\Http\Request;
use Mail;

class VendedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $ventas2 = Ventas::with('user')->where('Estado',1)->get(); //OBTENGO VENTAS Y LOS USUARIOS ASIGNADOS A ESAS VENTAS
        //dd($ventas2);
        $ventas = Ventas::groupBy('Numero')->select('Numero', Ventas::raw('count(*) as repeticion'))->orderBy('repeticion', 'DESC')->get();
        $ventas4 = Ventas::Where('Estado', 0)->get();
        $respuesta =  [
            "Numeros de loteria mas repetidos" => $ventas,
            "Numeros de loteria bloqueados" => $ventas4,
            "Data completa del Modelo" => $ventas2
        ];


        return response()->json($respuesta);
    }

    public function estadoDeCuenta()
    {
        $usuario = auth()->user();
        $ventas2 = User::with('Ventas')->find($usuario->id);
        return response()->json($ventas2,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ventas = Ventas::find($id);
        $respuesta =  [
            "Objeto encontrado con exito!" => $ventas
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
        $ventas = Ventas::find($id);
        $ventas->update($request->all());

        $respuesta =  [
            "El registro fue actualizado con exito!" => $ventas
        ];
        return response()->json($respuesta,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        //EIMINADO ESPECIFICO//
        $ventas = Ventas::find($id);
        $ventas->Estado = 0;
        $ventas->update();

        $respuesta = [
            "El objeto fue eliminado con exito!" => $ventas
        ];

       /* $ventas = Ventas::find($id);              /////ELIMINADO GENERAL//////
        $ventas->Numero;
        if ($ventas = Ventas::select('*')->where('Numero', '=', $ventas->Numero)->get()) {
            foreach ($ventas as $venta) {
                $venta->Estado = "0";
                $venta->save();
            }
            $respuesta =  [
                "El objeto fue eliminado con exito!" => $ventas
            ];
        }*/
        //dd($ventas);

        return response()->json($respuesta, 200);
    }

    public function desbloqueo($id)
    {
        $ventas = Ventas::find($id);
        $ventas->Numero;
        if ($ventas = Ventas::select('*')->where('Numero', '=', $ventas->Numero)->get()) {
            foreach ($ventas as $venta) {
                $venta->Estado = "1";
                $venta->save();
            }
            $respuesta =  [
                "El objeto fue eliminado con exito!" => $ventas
            ];
        }
        //dd($ventas);

        return response()->json($respuesta, 200);
    }

    public function guardarVenta(Request $request)
    {
        $usuario = auth()->user();
        $usuario->id;
        /*$ventas->Loteria = $request->get('id_loteria');*/
        //dd($usuario->rol_id);
        //dd($usuario->id);

        $request->validate([
            "Fecha" => "required|date",
            "Numero" => "required|integer",
            "Valorapuesta" => "required|integer",
            "Loteria" => "required|integer", //id de la loteria
            "Tipo" => "required|string",
            //AGREGADO DE REFERENCIA -> DESCRIPCION
            "Referencia" => "required|string",
            //Menu lateral en las vistas
            //"Sumatotalventas" => "required|integer",
            "Puntoventas" => "required|string",
            //"Nombrepromotor" => "required|string",
            "Puntoentregaventas" => "required|string"
        ]);

        //validacion si esta bloqueado 1 numero en 1 loteria

        $verdadero = Ventas::where('Estado', 0)->get();
        foreach($verdadero as $v){
            if($v->Numero == $request->get("Numero") && $v->sorteo_id == $request->get("Loteria")){
                return response()->json("Numero bloqueado", 400);
            }
        }
        $ventas = Ventas::create([
            "Fecha" => $request->get("Fecha"),
            "Numero" => $request->get("Numero"),
            "Valorapuesta" => $request->get("Valorapuesta"),
            //"Loteria" => $request->get('Loteria'),
            //"Loteria" => $loteria,
            "Tipo" => $request->get("Tipo"),
            //AGREGADO DE REFERENCIA
            "Referencia" => $request->get("Referencia"),
            //REVISAR APARTADO DE SUMATOTALVENTAS! HACER UN ACUMULADOR DESDE LA BASE DE DATOS -> ORDERBY U SUM POSIBLEMENTE
            //"Sumatotalventas" => $request->get("Sumatotalventas"),
            "Puntoventas" => $request->get("Puntoventas"),
            //"Nombrepromotor" => $request->get("Nombrepromotor"),
            "Puntoentregaventas" => $request->get("Puntoentregaventas"),
            //"Sumatoria Final" => $request->get("Sumatotalventas")+$ventas->Sumatotalventas
        ]);

        $ventas->user_id = $usuario->id;
        $ventas->sorteo_id = $request->get('Loteria');
        $ventas->save();
        $usuario->venta_id = $ventas->id;
        $usuario->save();
        $busqueda = Sorteos::where('id', $ventas->sorteo_id)->get();
        foreach($busqueda as $b){
            $b->venta_id = $ventas->id;
            $b->save();
        }
        //dd($b->Loteria);
        $ventas->Loteria = $b->Loteria;
        $ventas->update();
        //dd($ventas->Loteria);

        ///////////// LOGICA DEL ADICIONAL /////////////

        $consulta2 = Sorteos::where('id', $ventas->sorteo_id)->get();
        foreach ($consulta2 as $c2)
        {}
        //dd($c2->Max);
        //dd($ventas->Numero);
        $consulta1 = Ventas::where('Numero', $ventas->Numero)->where('Loteria', $ventas->Loteria)->sum('Valorapuesta');
        //dd($consulta1);
        $consulta3 = Sorteos::where('id',$ventas->sorteo_id)->get();
        foreach($consulta3 as $c3)
        {}
        //dd($c3->Loteria);
        if($consulta1 >= $c2->Max)
        {

            $ventas->Estado = "0";
            $ventas->save();

            $userEmail = User::where('rol_id', '>', 1)->get();
            //dd($userEmail);
            foreach ($userEmail as $um) {
                $contacto = new VentaMaxMail([$ventas->Numero, $c3->Loteria, $um->name]);
                Mail::to($um->email)->send($contacto);
            };
        }
        //dd($ventas->Estado);

        ///////////////// LOGICA DEL ADICIONAL ////////////////

        $Vendedor = User::where('id', '=', $ventas->user_id)->first();
        $sumatotalventa = Ventas::count("Numero"); //Suma de las ventas realizadas
        $sumatotalventa2 = Ventas::where('user_id', $usuario->id)->sum('Valorapuesta'); //Suma de valor de venta realizada
        $usuario->ganancia = $sumatotalventa2;
        $usuario->balance = ($usuario->ganancia * $usuario->porcentaje)/100;
        $usuario->update();
        //dd($usuario->balance);
        $respuesta =  [
            "Suma de todas las ventas que se realizaron" => $sumatotalventa,
            "Suma total del valor de todas las ventas" => $sumatotalventa2,
            "Vendedor/Promotor afiliado a la venta" => $Vendedor,

        ];
        return response()->json(compact('ventas','sumatotalventa','sumatotalventa2','Vendedor'), 201);
    }

    public function adicionales()
    {
        $usuario = auth()->user();
        $usuario->id;
        $ventatotal = Ventas::with('user')->where('user_id', '=', $usuario->id)->count();
        $sumatotal = Ventas::with('user')->where('user_id', '=', $usuario->id)->sum('Valorapuesta');
        $promotor = User::where('id', '=', $usuario->user_id)->get();

        /*$respuesta =  [
            "Numero de ventas" => $ventatotal,
            "Suma del valor de las ventas" => $sumatotal,

        ];*/

        return response()->json(compact('ventatotal','sumatotal','promotor'), 200);
    }

    public function perfil()
    {
        $usuario = auth()->user();
        $usuario->id;

        $ventas = User::with('Ventas')->where('venta_id', '=', $usuario->venta_id)->get();
        $solicitudes = User::with('solicitudes')->where('solicitud_id', '=', $usuario->solicitud_id)->get();
        $pertenece = User::where('id', '=', $usuario->user_id)->get();
        $tiene = User::where('user_id', '=', $usuario->id)->get();
        $sorteos = User::with('sorteos')->where('sorteo_id', '=', $usuario->sorteo_id)->get();
        $credito = Solicitudes::where('Categoria', 'Prestamo/Credito')->where('user_id', '=', $usuario->id)->where('Tipo', '=', 2)->sum('CantidadSolicitada');

        $respuesta =  [
            "Datos del usuario" => $usuario,
            //"Rol aparte" => $usuario->roles,
            "Ventas del usuario" => $ventas,
            "Solicitudes del usuario" => $solicitudes,
            "Pertenece a este usuario" => $pertenece,
            "Tiene a estos usuarios" => $tiene,
            "Sorteos creados" => $sorteos,
            "Credito" => $credito
        ];

        return response()->json($respuesta,200);

    }
}
