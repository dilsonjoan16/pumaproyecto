<?php

namespace App\Http\Controllers;

use App\Models\Promotor;
use App\Models\Vendedor;
use App\Models\User;
use App\Models\Ventas;
use App\Models\Solicitudes;
use Illuminate\Http\Request;

class VendedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /*
        SELECT id,id_usuarios,Count(id_usuarios) 
        FROM tbl_statsingreso 
        GROUP BY id_usuarios 
        HAVING Count(id_usuarios) 
        ORDER BY Count(id_usuarios) 
        DESC
         */
        //$ventas = Ventas::select("Numero")->get()->toArray();
        //$ventas2 = Ventas::count("Numero");

        /*$nombre2 = array_unique($ventas);
        $v_comunes1 = array_diff_assoc($ventas, $nombre2);
        $v_comunes2 = array_unique($v_comunes1);   // Eliminamos los elementos repetidos
        sort($v_comunes2);    // Orden ascendente en array 
        $repetidos = implode(', ', $v_comunes2);    // Creamos cadena a partir del array
    */

        /*$ventas3 = SELECT("Numero",SUM("contador"))
        ->FROM("Ventas")
        ->groupBy("Numero");
        return $ventas3;*/

        /*$ventas3 = [];
        foreach($ventas as $ventas2){
            $ventas3 [] = $ventas2->repeticion;
            
        }/*
        /*
            Consulta SQL propia, regresa cual es el mas repetido en orden

        $ventas4 = Ventas::raw(' SELECT `Numero`, 
        COUNT(`Numero`) FROM `Ventas` GROUP BY `Numero`
         ORDER BY COUNT(`Numero`) DESC');
         */

        //dd($ventas3);

        //DATOS PARA METRICAS
        //$ventas2 = User::select('*')->ventaVendedor; //Primera logica
        //$ventas2 = User::with('ventaVendedor')->get();


    
        $ventas2 = Ventas::with('user')->get(); //OBTENGO VENTAS Y LOS USUARIOS ASIGNADOS A ESAS VENTAS
        //$ventas2 = User::with('Ventas')->get(); //OBTENGO LOS USUARIOS
        //dd($ventas2);

        $ventas = Ventas::groupBy('Numero')->select('Numero', Ventas::raw('count(*) as repeticion'))->orderBy('repeticion', 'DESC')->get();
        $ventas3 = Ventas::Where('Estado', '=', 0)->get();
        $respuesta =  [
            "Numeros de loteria mas repetidos" => $ventas,
            "Numeros de loteria bloqueados" => $ventas3,
            "Data completa del Modelo" => $ventas2
        ];
        return response()->json($respuesta);
        //SELECT cliente, SUM(precio)
        //FROM pedidos
        //GROUP BY cliente

        
        
        //$masvendido = Ventas::where("Numero",">","$conteo")->get();
        /*$respuesta =  [
            
            "Los numeros mas vendidos son" =>$repetidos
        ];
        $retorno = Ventas::all();
        return response()->json([$respuesta,$retorno]);*/
    }

    public function estadoDeCuenta()
    {
        $usuario = auth()->user();
        $ventas2 = User::with('Ventas')->find($usuario->id);
        return response()->json($ventas2,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*public function store(Request $request, Ventas $ventas)
    {

        $usuario = auth()->user();
        $usuario->id;
        //dd($usuario->rol_id);
        //dd($usuario->id);

        $request->validate([
            "Fecha" => "required|date",
            "Numero" => "required|integer",
            "Valorapuesta" => "required|integer",
            "Loteria" => "required|string",
            "Tipo" => "required|string",
            //AGREGADO DE REFERENCIA -> DESCRIPCION
            "Referencia" => "required|string",
            //Menu lateral en las vistas
            //"Sumatotalventas" => "required|integer",
            "Puntoventas" => "required|string",
            //"Nombrepromotor" => "required|string",
            "Puntoentregaventas" => "required|string"
        ]);

        /* 
            Logica para lograr captar la sumatoria
        */
            //$valor = $valor + $request->get("Sumatotalventas");
        /*
            Fin de la logica para lograr captar la sumatoria
        */
        

        /*$ventas = Ventas::create([
            "Fecha" => $request->get("Fecha"),
            "Numero" => $request->get("Numero"),
            "Valorapuesta" => $request->get("Valorapuesta"),
            "Loteria" => $request->get("Loteria"),
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
        $ventas->save();
        $usuario->venta_id = $ventas->id;
        $usuario->save();
        $Vendedor = User::where('id', '=', $ventas->user_id)->first();
        $sumatotalventa = Ventas::count("Numero"); //Suma de las ventas realizadas
        $sumatotalventa2 = Ventas::sum('Valorapuesta'); //Suma de valor de venta realizada
        $respuesta =  [
            "Suma de todas las ventas que se realizaron" => $sumatotalventa,
            "Suma total del valor de todas las ventas" => $sumatotalventa2,
            "Vendedor/Promotor afiliado a la venta" =>$Vendedor,
        ];
        return response()->json([$ventas, $respuesta], 201);

    }*/

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
        $ventas = Ventas::find($id);
        $ventas->Numero;
        if ($ventas = Ventas::select('*')->where('Numero', '=', $ventas->Numero)->get()) {
            foreach ($ventas as $venta) {
                $venta->Estado = "0";
                $venta->save();
            }
            $respuesta =  [
                "El objeto fue eliminado con exito!" => $ventas
            ];
        }
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
        //dd($usuario->rol_id);
        //dd($usuario->id);
        
        $request->validate([
            "Fecha" => "required|date",
            "Numero" => "required|integer",
            "Valorapuesta" => "required|integer",
            "Loteria" => "required|string",
            "Tipo" => "required|string",
            //AGREGADO DE REFERENCIA -> DESCRIPCION
            "Referencia" => "required|string",
            //Menu lateral en las vistas
            //"Sumatotalventas" => "required|integer",
            "Puntoventas" => "required|string",
            //"Nombrepromotor" => "required|string",
            "Puntoentregaventas" => "required|string"
        ]);

        /* 
            Logica para lograr captar la sumatoria
        */
        //$valor = $valor + $request->get("Sumatotalventas");
        /*
            Fin de la logica para lograr captar la sumatoria
        */


        $ventas = Ventas::create([
            "Fecha" => $request->get("Fecha"),
            "Numero" => $request->get("Numero"),
            "Valorapuesta" => $request->get("Valorapuesta"),
            "Loteria" => $request->get("Loteria"),
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
        $ventas->save();
        $usuario->venta_id = $ventas->id;
        $usuario->save();
        $Vendedor = User::where('id', '=', $ventas->user_id)->first();
        $sumatotalventa = Ventas::count("Numero"); //Suma de las ventas realizadas
        $sumatotalventa2 = Ventas::sum('Valorapuesta'); //Suma de valor de venta realizada
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
        $credito = Solicitudes::where('Categoria', 'Prestamo/Credito')->where('user_id', '=', $usuario->id)->sum('CantidadSolicitada');

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
