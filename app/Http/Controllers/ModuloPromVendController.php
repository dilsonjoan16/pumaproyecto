<?php

namespace App\Http\Controllers;

use App\Models\Promotor;
use App\Models\User;
use App\Models\Vendedor;
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
        $administradores = User::where('rol_id','=',1)->get();
        $promotores = User::where('rol_id','=',2)->get();
        $vendedores = User::where('rol_id','=',3)->get();
        

        return response()->json([$vendedores, $promotores, $administradores], 200);
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
        $nuevoId = User::where('rol_id', '=', 2)->get();
        $respuesta = [
            "Objeto encontrado con exito!" => $user,
            "Promotores disponibles" => $nuevoId
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
        $usuario = auth()->user();
        $usuario->rol_id;
        $rolSelector = $request->get('rol');
        //dd($rolSelector); 
        //dd($usuario->rol_id);
        if($usuario->rol_id == 1)
        {
//////////////////////////////////////////////////////////////////////////////////////////////
            if($rolSelector == 1)
            {
                $user = User::find($id);
                if ($imagenes = $request->file('foto')) {
                    $file = $imagenes->getClientOriginalName();
                    $imagenes->move('images', $file);
                    $user['foto'] = $file;
                }
                if ($imagenes === null) {
                    $user->update($request->all());
                    $user->rol_id = 1;
                    $user->save();
                    if ($user->hasRole('Promotor')) {
                        $user->removeRole('Promotor');
                    }
                    if ($user->hasRole('Vendedor')) {
                        $user->removeRole('Vendedor');
                    }
                    $user->assignRole('Administrador');
                    $respuesta =  [
                        "El objeto fue actualizado con exito!" => $user,
                    ];
                    return response()->json($respuesta, 200);
                }
                if ($imagenes !== null) {
                    $user->update([
                        'name' => $request->get('name'),
                        'email' => $request->get('email'),
                        'dni' => $request->get('dni'),
                        'ganancia' => $request->get('ganancia'),
                        'porcentaje' => $request->get('porcentaje'),
                        'foto' => $file,
                        'direccion' => $request->get('direccion'),
                        'telefono' => $request->get('telefono'),
                        'codigo' => $request->get('codigo'),
                        'rol_id' => 1
                    ]);
                    if ($user->hasRole('Promotor')) {
                        $user->removeRole('Promotor');
                    }
                    if ($user->hasRole('Vendedor')) {
                        $user->removeRole('Vendedor');
                    }
                    $user->assignRole('Administrador');
                    $respuesta =  [
                        "El objeto fue actualizado con exito!" => $user,
                    ];

                    return response()->json($respuesta, 200);
                }
                
            }
//////////////////////////////////////////////////////////////////////////////////////////////
            if($rolSelector == 2)
            {
                $user = User::find($id);
                if ($imagenes = $request->file('foto')) {
                    $file = $imagenes->getClientOriginalName();
                    $imagenes->move('images', $file);
                    $user['foto'] = $file;
                }
                if ($imagenes === null) {
                    $user->update($request->all());
                    $user->rol_id = 2;
                    $user->save();
                    if ($user->hasRole('Administrador')) {
                        $user->removeRole('Administrador');
                    }
                    if ($user->hasRole('Vendedor')) {
                        $user->removeRole('Vendedor');
                    }
                    $user->assignRole('Promotor');
                    $respuesta =  [
                        "El objeto fue actualizado con exito!" => $user,
                    ];
                    return response()->json($respuesta, 200);
                }
                if ($imagenes !== null) {
                    $user->update([
                        'name' => $request->get('name'),
                        'email' => $request->get('email'),
                        'dni' => $request->get('dni'),
                        'ganancia' => $request->get('ganancia'),
                        'porcentaje' => $request->get('porcentaje'),
                        'foto' => $file,
                        'direccion' => $request->get('direccion'),
                        'telefono' => $request->get('telefono'),
                        'codigo' => $request->get('codigo'),
                        'rol_id' => 2
                    ]);
                    if ($user->hasRole('Administrador')) {
                        $user->removeRole('Administrador');
                    }
                    if ($user->hasRole('Vendedor')) {
                        $user->removeRole('Vendedor');
                    }
                    $user->assignRole('Promotor');
                    $respuesta =  [
                        "El objeto fue actualizado con exito!" => $user,
                    ];

                    return response()->json($respuesta, 200);
            }
        }
//////////////////////////////////////////////////////////////////////////////////////////////
        if($rolSelector == 3)
        {
            $nuevo_id = $request->get('nuevo_id');
                $user = User::find($id);
                if ($imagenes = $request->file('foto')) {
                    $file = $imagenes->getClientOriginalName();
                    $imagenes->move('images', $file);
                    $user['foto'] = $file;
                }
                if ($imagenes === null) {
                    $user->update($request->all());
                    $user->rol_id = 3;
                    $user->user_id = $nuevo_id;
                    $user->save();
                    if ($user->hasRole('Administrador')) {
                        $user->removeRole('Administrador');
                    }
                    if ($user->hasRole('Promotor')) {
                        $user->removeRole('Promotor');
                    }
                    $user->assignRole('Vendedor');
                    $respuesta =  [
                        "El objeto fue actualizado con exito!" => $user,
                    ];
                    return response()->json($respuesta, 200);
                }
                if ($imagenes !== null) {
                    $user->update([
                        'name' => $request->get('name'),
                        'email' => $request->get('email'),
                        'dni' => $request->get('dni'),
                        'ganancia' => $request->get('ganancia'),
                        'porcentaje' => $request->get('porcentaje'),
                        'foto' => $file,
                        'direccion' => $request->get('direccion'),
                        'telefono' => $request->get('telefono'),
                        'codigo' => $request->get('codigo'),
                        'rol_id' => 3
                    ]);
                    if ($user->hasRole('Administrador')) {
                        $user->removeRole('Administrador');
                    }
                    if ($user->hasRole('Promotor')) {
                        $user->removeRole('Promotor');
                    }
                    $user->assignRole('Vendedor');
                    $user->user_id = $nuevo_id;
                    $user->save();
                    $respuesta =  [
                        "El objeto fue actualizado con exito!" => $user,
                    ];

                    return response()->json($respuesta, 200);
                }
        }
//////////////////////////////////////////////////////////////////////////////////////////////
        if($rolSelector == null)
        {
            $user = User::find($id);
                if ($imagenes = $request->file('foto')) {
                    $file = $imagenes->getClientOriginalName();
                    $imagenes->move('images', $file);
                    $user['foto'] = $file;
                }
                if ($imagenes === null) {
                    $user->update($request->all());
                    //$user->rol_id = 3;
                    //$user->user_id = $nuevo_id;
                    $user->save();
                    /*if ($user->hasRole('Administrador')) {
                        $user->removeRole('Administrador');
                    }
                    if ($user->hasRole('Promotor')) {
                        $user->removeRole('Promotor');
                    }
                    $user->assignRole('Vendedor');*/
                    $respuesta =  [
                        "El objeto fue actualizado con exito!" => $user,
                    ];
                    return response()->json($respuesta, 200);
                }
                if ($imagenes !== null) {
                    $user->update([
                        'name' => $request->get('name'),
                        'email' => $request->get('email'),
                        'dni' => $request->get('dni'),
                        'ganancia' => $request->get('ganancia'),
                        'porcentaje' => $request->get('porcentaje'),
                        'foto' => $file,
                        'direccion' => $request->get('direccion'),
                        'telefono' => $request->get('telefono'),
                        'codigo' => $request->get('codigo'),
                        //'rol_id' => 3
                    ]);
                    /*if ($user->hasRole('Administrador')) {
                        $user->removeRole('Administrador');
                    }
                    if ($user->hasRole('Promotor')) {
                        $user->removeRole('Promotor');
                    }
                    $user->assignRole('Vendedor');*/
                    //$user->user_id = $nuevo_id;
                    //$user->save();
                    $respuesta =  [
                        "El objeto fue actualizado con exito!" => $user,
                    ];

                    return response()->json($respuesta, 200);
        }
    }
//////////////////////////////////////////////////////////////////////////////////////////////
    if ($usuario->rol_id == 2)
    {
            //$nuevo_id = $request->get('nuevo_id');
            $user = User::find($id);
            if ($imagenes = $request->file('foto')) {
                $file = $imagenes->getClientOriginalName();
                $imagenes->move('images', $file);
                $user['foto'] = $file;
            }
            if ($imagenes === null) {
                $user->update($request->all());
                $user->rol_id = 3;
                //$user->user_id = $nuevo_id;
                $user->save();
                if ($user->hasRole('Administrador')) {
                    $user->removeRole('Administrador');
                }
                if ($user->hasRole('Promotor')) {
                    $user->removeRole('Promotor');
                }
                $user->assignRole('Vendedor');
                $respuesta =  [
                    "El objeto fue actualizado con exito!" => $user,
                ];
                return response()->json($respuesta, 200);
            }
            if ($imagenes !== null) {
                $user->update([
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'dni' => $request->get('dni'),
                    'ganancia' => $request->get('ganancia'),
                    'porcentaje' => $request->get('porcentaje'),
                    'foto' => $file,
                    'direccion' => $request->get('direccion'),
                    'telefono' => $request->get('telefono'),
                    'codigo' => $request->get('codigo'),
                    'rol_id' => 3
                ]);
                if ($user->hasRole('Administrador')) {
                    $user->removeRole('Administrador');
                }
                if ($user->hasRole('Promotor')) {
                    $user->removeRole('Promotor');
                }
                $user->assignRole('Vendedor');
                //$user->user_id = $nuevo_id;
                //$user->save();
                $respuesta =  [
                    "El objeto fue actualizado con exito!" => $user,
                ];

                return response()->json($respuesta, 200);
            }
        }
    }
}

    public function updateVendedor(Request $request, $id)
    {
        $promotor = Promotor::all()->select('id')->orderBy('nombre', 'desc')->get();

        $nuevoId = $request->get($promotor->id);

        $vendedor = Vendedor::find($id);
        $vendedor->promotor = $nuevoId;
        $vendedor->update($request->all());

        //dd($vendedor); 

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
        $user->email = "";
        $user->save();

        $respuesta = [
            "El objeto fue eliminado con exito" => $user
        ];

        return response()->json($respuesta, 200);
    }

}
