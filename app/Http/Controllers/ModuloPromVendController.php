<?php

namespace App\Http\Controllers;

use App\Models\Promotor;
use App\Models\User;
use Illuminate\Http\Request;

class ModuloPromVendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $administradores = User::all();
        $administradores->promotors->where('tipo', '=', '1')->get();

        $promotores = Promotor::all();
        $promotores->vendedors()->where('tipo', '=', '1')->get();

        return response()->json([$user, $promotores], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $respuesta = [
            "Objeto encontrado con exito!" => $user
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
        //Debo permitir hacer los cambios necesarios
        $user = User::find($id);

        $user->update($request->all());

        $respuesta = [
            "El objeto fue actualizado con exito" => $user
        ];

        return response()->json($respuesta);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Debo permitir que se haga un SET al estado y cambie el estado a 0 solamente, NO DESTRUIR de BD

        //$user = User::where('id', $id)->set('tipo',0);

        $user = User::find($id);
        $user->tipo = "0";
        $user->save();

        $respuesta = [
            "El objeto fue eliminado con exito" => $user
        ];

        return response()->json($respuesta, 200);
    }
}
