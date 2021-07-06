<?php

namespace App\Http\Controllers;

use App\Models\Promotor;
use App\Models\RolesUser;
use App\Models\User;
use App\Models\Vendedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Contracts\Validation\Rule;


class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        //Consulta que me trae el rol logueado
        //$usuarios = User::with('rol')->whereRolId(1)->findOrFail(auth()->id());


        $usuario = auth()->user();
        $usuario->roles; //ESTO ME TRAE EL USUARIO LOGUEADO CON TODA SU INFORMACION PERSONAL Y DEL ROL


        //Fin de consulta que me trae el rol logueado
        return response()->json(compact('token', 'usuario'));
    }
    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }

    public function register(Request $request) 
    {

        $usuario = auth()->user();
        $usuario->rol_id;
        //dd($usuario->rol_id);
        //$usuario->roles; //ESTO ME TRAE EL USUARIO LOGUEADO CON TODA SU INFORMACION PERSONAL Y DEL ROL
        $rolSelector = $request->get('rol');
    if($usuario->rol_id == 1){            
        if($rolSelector == 1) {//REGISTRO DE ADMINISTRADOR
                $validator = Validator::make($request->all(), [
                    'name' => 'required|string',
                    'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                    'password' => 'required|string|min:6|max:12',
                    'dni' => 'required|integer',
                    //'ganancia' => 'required|integer',
                    //'porcentaje' => 'required|integer|max:50',
                    'foto' => 'required|image|max:2048', //la validacion siempre debe ir acompañada por "|image|max:2048" para poder validar existencia de imagen
                    'direccion' => 'required|string|max:255',
                    'telefono' => 'required|integer',
                    'codigo' => 'required|unique:users,codigo',

                ]);
                //dd($validator);
                if ($validator->fails()) {
                    return response()->json($validator->errors()->toJson(), 400);
                }

                $userFoto = $request->all();
                if ($imagen = $request->file('foto')) {
                    $file = $imagen->getClientOriginalName();
                    $imagen->move('images', $file);
                    $userFoto['foto'] = $file;
                }
                //dd($userFoto);

                //$rol = RolesUser::select('id')->where('nombre','=','Administrador')->get();
                //php artisan db:seed --class=BookSeeder CORRER UN SEEDER INDIVIDUAL        
                //dd($rol);

                $user = User::create([
                        'name' => $request->get('name'),
                        'email' => $request->get('email'),
                        'password' => Hash::make($request->get('password')),
                        'dni' => $request->get('dni'),
                        //'ganancia' => $request->get('ganancia'),
                        //'porcentaje' => $request->get('porcentaje'),
                        //'balance' => (($request->get('ganancia')) * ($request->get('porcentaje')) / 100),
                        'foto' => $userFoto['foto'],
                        'direccion' => $request->get('direccion'),
                        'telefono' => $request->get('telefono'),
                        'codigo' => $request->get('codigo'),
                        'rol_id' => 1,
                        //con esto se genera un codigo con la PRIMERA LETRA DEL NOMBRE Y SU DNI
                        //'codigo' => substr($request->get('name'), 0, 1) . $request->get('dni'),

                    ]);
                $user = User::latest('id')->first();
                $user->user_id = $user->id;
                $user->save();
                $user->assignRole('Administrador');

                $token = JWTAuth::fromUser($user);

                return response()->json(compact('user', 'token'), 201);
        }
        if($rolSelector == 2){ ////CREACION DE PROMOTOR
                $validator = Validator::make($request->all(), [
                    'name' => 'required|string',
                    'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                    'password' => 'required|string|min:6|max:12',
                    'dni' => 'required|integer',
                    'ganancia' => 'required|integer',
                    'porcentaje' => 'required|integer|max:50',
                    'foto' => 'required|image|max:2048', //la validacion siempre debe ir acompañada por "|image" para poder validar existencia de imagen
                    'direccion' => 'required|string|max:255',
                    'telefono' => 'required|integer',
                    'codigo' => 'required|unique:users,codigo',

                ]);
                //dd($validator);
                if ($validator->fails()) {
                    return response()->json($validator->errors()->toJson(), 400);
                }

                $userFoto = $request->all();
                if ($imagen = $request->file('foto')) {
                    $file = $imagen->getClientOriginalName();
                    $imagen->move('images', $file);
                    $userFoto['foto'] = $file;
                }

                //$rol = RolesUser::select('id')->where('nombre','=','Administrador')->get();
                //php artisan db:seed --class=BookSeeder CORRER UN SEEDER INDIVIDUAL        
                //dd($rol);

                $user = User::create([
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => Hash::make($request->get('password')),
                    'dni' => $request->get('dni'),
                    'ganancia' => $request->get('ganancia'),
                    'porcentaje' => $request->get('porcentaje'),
                    'balance' => (($request->get('ganancia')) * ($request->get('porcentaje')) / 100),
                    'foto' => $userFoto['foto'],
                    'direccion' => $request->get('direccion'),
                    'telefono' => $request->get('telefono'),
                    'codigo' => $request->get('codigo'),
                    'rol_id' => 2,
                    //con esto se genera un codigo con la PRIMERA LETRA DEL NOMBRE Y SU DNI
                    //'codigo' => substr($request->get('name'), 0, 1) . $request->get('dni'),

                ]);

                $user = User::latest('id')->first();
                $user->user_id = $usuario->id;
                $user->save();
                $user->assignRole('Promotor');

                $token = JWTAuth::fromUser($user);

                return response()->json(compact('user', 'token'), 201);
        }
        if($rolSelector == 3){ /////CREACION DE VENDEDOR
                $validator = Validator::make($request->all(), [
                    'name' => 'required|string',
                    'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                    'password' => 'required|string|min:6|max:12',
                    'dni' => 'required|integer',
                    'ganancia' => 'required|integer',
                    'porcentaje' => 'required|integer|max:50',
                    'foto' => 'required|image|max:2048', //la validacion siempre debe ir acompañada por "|image" para poder validar existencia de imagen
                    'direccion' => 'required|string|max:255',
                    'telefono' => 'required|integer',
                    'codigo' => 'required|unique:users,codigo',

                ]);
                //dd($validator);
                if ($validator->fails()) {
                    return response()->json($validator->errors()->toJson(), 400);
                }

                $userFoto = $request->all();
                if ($imagen = $request->file('foto')) {
                    $file = $imagen->getClientOriginalName();
                    $imagen->move('images', $file);
                    $userFoto['foto'] = $file;
                }

                //$rol = RolesUser::select('id')->where('nombre','=','Administrador')->get();
                //php artisan db:seed --class=BookSeeder CORRER UN SEEDER INDIVIDUAL        
                //dd($rol);

                $user = User::create([
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => Hash::make($request->get('password')),
                    'dni' => $request->get('dni'),
                    'ganancia' => $request->get('ganancia'),
                    'porcentaje' => $request->get('porcentaje'),
                    'balance' => (($request->get('ganancia')) * ($request->get('porcentaje')) / 100),
                    'foto' => $userFoto['foto'],
                    'direccion' => $request->get('direccion'),
                    'telefono' => $request->get('telefono'),
                    'codigo' => $request->get('codigo'),
                    'rol_id' => 3,
                    //con esto se genera un codigo con la PRIMERA LETRA DEL NOMBRE Y SU DNI
                    //'codigo' => substr($request->get('name'), 0, 1) . $request->get('dni'),

                ]);

                $user = User::latest('id')->first();
                $user->user_id = $usuario->id;
                $user->save();
                $user->assignRole('Vendedor');

                $token = JWTAuth::fromUser($user);

                return response()->json(compact('user', 'token'), 201);
        }
        if($rolSelector !== 1 && $rolSelector !== 2 && $rolSelector !== 3 ){
            return response()->json("Error -> esa opcion no existe o no eligio alguna de las planteadas", 400);
        }
    }
    if($usuario->rol_id == 2){
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'password' => 'required|string|min:6|max:12',
                'dni' => 'required|integer',
                'ganancia' => 'required|integer',
                'porcentaje' => 'required|integer|max:50',
                'foto' => 'required|image|max:2048', //la validacion siempre debe ir acompañada por "|image" para poder validar existencia de imagen
                'direccion' => 'required|string|max:255',
                'telefono' => 'required|integer',
                'codigo' => 'required|unique:users,codigo',

            ]);
            //dd($validator);
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }

            $userFoto = $request->all();
            if ($imagen = $request->file('foto')) {
                $file = $imagen->getClientOriginalName();
                $imagen->move('images', $file);
                $userFoto['foto'] = $file;
            }

            //$rol = RolesUser::select('id')->where('nombre','=','Administrador')->get();
            //php artisan db:seed --class=BookSeeder CORRER UN SEEDER INDIVIDUAL        
            //dd($rol);

            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'dni' => $request->get('dni'),
                'ganancia' => $request->get('ganancia'),
                'porcentaje' => $request->get('porcentaje'),
                'balance' => (($request->get('ganancia')) * ($request->get('porcentaje')) / 100),
                'foto' => $userFoto['foto'],
                'direccion' => $request->get('direccion'),
                'telefono' => $request->get('telefono'),
                'codigo' => $request->get('codigo'),
                'rol_id' => 3,
                //con esto se genera un codigo con la PRIMERA LETRA DEL NOMBRE Y SU DNI
                //'codigo' => substr($request->get('name'), 0, 1) . $request->get('dni'),

            ]);

            $user = User::latest('id')->first();
            $user->user_id = $usuario->id;
            $user->save();
            $user->assignRole('Vendedor');

            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user', 'token'), 201);
    }
    if($usuario->rol_id == 3){ //ROL VENDEDOR, NO PUEDE CREAR USUARIOS
        return response()->json("Por la naturaleza de su Rol no tiene autorizacion", 403);
    }

}

    /*public function registerVendedor(Request $request)
    {

        $usuario = auth()->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            
            'password' => 'required|string|min:6|max:12',
            'dni' => 'required|integer',
            'ganancia' => 'required|integer',
            'porcentaje' => 'required|integer|max:50',
            'foto' => 'required|image|max:2048',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|integer',
            'codigo' => ' required|unique:users,codigo',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $vendedorFoto = $request->all();
        if ($imagen = $request->file('foto')) {
            $file = $imagen->getClientOriginalName();
            $imagen->move('images', $file);
            $vendedorFoto['foto'] = $file;
        }

        //$rol = RolesUser::where('nombre', 'Vendedor');

        $vendedor = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'dni' => $request->get('dni'),
            'ganancia' => $request->get('ganancia'),
            'porcentaje' => $request->get('porcentaje'),
            'balance' => (($request->get('ganancia')) * ($request->get('porcentaje')) / 100),
            'foto' => $vendedorFoto,
            'direccion' => $request->get('direccion'),
            'telefono' => $request->get('telefono'),
            'codigo' => $request->get('codigo'),
            'user_id' => $usuario->id,
            'rol_id' => 2,
            //con esto se genera un codigo con la PRIMERA LETRA DEL NOMBRE Y SU DNI
            //'codigo' => substr($request->get('name'), 0, 1) . $request->get('dni'),
        ]);

        $vendedor = User::latest('id')->first();
        $vendedor->assignRole('Vendedor');

        $padreVendedor = User::latest('id')->first();
        $padreVendedor->user_id();
        $datoPadreVendedor = User::where('user_id', $padreVendedor)->get();
        //$vendedorPromotor = Vendedor::all();
        //$vendedorPromotor->promotor;
        //////////////////////////////////////////////////////////////////////////  
        //          Posible segunda logica                                      //
        //                                                                      //
        //          $vendedorPromotor2 = Vendedor::with('Promotor')->get();     //
        //////////////////////////////////////////////////////////////////////////  
        $token = JWTAuth::fromUser($vendedor);

        return response()->json([$vendedor, $padreVendedor, $datoPadreVendedor, $token], 201);
    }

    public function registerPromotor(Request $request)
    {

        $usuario = auth()->user();
        $usuario->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => ['required', 'email', 'max:255', 'unique:users,email'], 
            'password' => 'required|string|min:6|max:12',
            'dni' => 'required|integer',
            'ganancia' => 'required|integer',
            'porcentaje' => 'required|integer|max:50',
            'foto' => 'required',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|integer',
            'codigo' => 'required|unique:users,codigo'

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $promotorFoto = $request->all();

        if ($imagen = $request->file('foto')) {
            $file = $imagen->getClientOriginalName();
            $imagen->move('images', $file);
            $promotorFoto['foto'] = $file;
        }

        //$rol = RolesUser::where('nombre', 'Promotor')->first();

        $promotor = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'dni' => $request->get('dni'),
            'ganancia' => $request->get('ganancia'),
            'porcentaje' => $request->get('porcentaje'),
            'balance' => (($request->get('ganancia')) * ($request->get('porcentaje')) / 100),
            'foto' => $promotorFoto,
            'direccion' => $request->get('direccion'),
            'telefono' => $request->get('telefono'),
            'codigo' => $request->get('codigo'),
            'user_id' => $usuario->user,
            'rol_id' => 2,
            //con esto se genera un codigo con la PRIMERA LETRA DEL NOMBRE Y SU DNI
            //'codigo' => substr($request->get('name'), 0, 1) . $request->get('dni'),
        ]);*/

        /*$promotor = new User;
        $promotor->name = $request->get('name');
        $promotor->email = $request->get('email');
        $promotor->password = Hash::make($request->get('password'));
        $promotor->dni = $request->get('dni');
        $promotor->ganancia = $request->get('ganancia');
        $promotor->porcentaje = $request->get('porcentaje');
        $promotor->balance = (($request->get('ganancia')) * ($request->get('porcentaje')) / 100);
        $promotor->foto = $promotorFoto;
        $promotor->direccion = $request->get('direccion');
        $promotor->telefono = $request->get('telefono');
        $promotor->codigo = $request->get('codigo');
        $promotor->user_id = $usuario;
        $promotor->rol_id = 2;
        $promotor->save();
        
        
        //$padrePromotor = User::latest('id')->first();
        //$padrePromotor->user_id;
        //$datoPadrePromotor = User::where('user_id', $padrePromotor)->get();
        $datoPadre = User::with("perteneceUsuarios")->get();

        $promotor = User::latest('id')->first();
        $promotor->assignRole('Promotor');

        //$promotorAdministrador = Promotor::all();
        //$promotorAdministrador->administrador;

        //////////////////////////////////////////////////////////////////////////  
        //          Posible segunda logica                                      //
        //                                                                      //
        //          $promotorAdministrador2 = Promotor::with(Users')->get();     //
        //////////////////////////////////////////////////////////////////////////

        $token = JWTAuth::fromUser($promotor);
        return response()->json(compact('promotor', 'datoPadre', 'token'), 201);
    }*/

    public function emergencia(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => 'required|string|min:6|max:12',
            'dni' => 'required|integer',
            //'ganancia' => 'required|integer',
            //'porcentaje' => 'required|integer|max:50',
            'foto' => 'required', //la validacion siempre debe ir acompañada por "|image|max:2048" para poder validar existencia de imagen
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|integer',
            'codigo' => 'required|unique:users,codigo',

        ]);
        //dd($validator);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $userFoto = $request->all();
        if ($imagen = $request->file('foto')) {
            $file = $imagen->getClientOriginalName();
            $imagen->move('images', $file);
            $userFoto['foto'] = $file;
        }
        //dd($userFoto);

        //$rol = RolesUser::select('id')->where('nombre','=','Administrador')->get();
        //php artisan db:seed --class=BookSeeder CORRER UN SEEDER INDIVIDUAL        
        //dd($rol);

        $user = User::create([
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => Hash::make($request->get('password')),
                    'dni' => $request->get('dni'),
                    //'ganancia' => $request->get('ganancia'),
                    //'porcentaje' => $request->get('porcentaje'),
                    //'balance' => (($request->get('ganancia')) * ($request->get('porcentaje')) / 100),
                    'foto' => $userFoto['foto'],
                    'direccion' => $request->get('direccion'),
                    'telefono' => $request->get('telefono'),
                    'codigo' => $request->get('codigo'),
                    'rol_id' => 1,
                    //con esto se genera un codigo con la PRIMERA LETRA DEL NOMBRE Y SU DNI
                    //'codigo' => substr($request->get('name'), 0, 1) . $request->get('dni'),

                ]);
        $user = User::latest('id')->first();
        $user->user_id = $user->id;
        $user->save();
        $user->assignRole('Administrador');

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function GetUsers()
    {
        $users = User::all();
        return response()->json($users, 200); ////////FUNCION EN DESUSO ACTUALMENTE!!!!
    }
}
