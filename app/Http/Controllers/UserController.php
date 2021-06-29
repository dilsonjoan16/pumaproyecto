<?php

namespace App\Http\Controllers;

use App\Models\Promotor;
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
    public function register(Request $request) //REGISTRO DE ADMINISTRADOR
    {
        //datos hechos por Jesus{
        //dd($request);
        //return User::all();
        //}

        /*$validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confi',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }*/
        //$positivo = User::select('email')->where('tipo','=',0)->get();

       
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => ['required','email','max:255','unique:users,email'], 
            //'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore('email')->where('tipo', 0)],
            //'email' => Rule::unique('users')->where(function ($query) {
            //    return $query->where('tipo', 1);
            //}),     
            'password' => 'required|string|min:6|max:12',
            'dni' => 'required|integer',
            'ganancia' => 'required|integer',
            'porcentaje' => 'required|integer|max:50',
            'foto' => 'required|image|max:2048', //la validacion siempre debe ir acompañada por "|image" para poder validar existencia de imagen
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|integer',
            'codigo' => 'required|unique:users,codigo'

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }


        //$balance = (($request->get('porcentaje'))*($request->get('ganancia')))/100;
        //$balance = ($validator->ganancia * $validator->porcentaje)/100;


        /* Logica para tratar de generar el codigo automatico
        User::saving(function ($user) {
            $user->codigo = ""; //Logica de calculo de codigo
        }); 
        */




        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'dni' => $request->get('dni'),
            'ganancia' => $request->get('ganancia'),
            'porcentaje' => $request->get('porcentaje'),
            'balance' => (($request->get('ganancia')) * ($request->get('porcentaje')) / 100),
            'foto' => $request->get('foto'),
            'direccion' => $request->get('direccion'),
            'telefono' => $request->get('telefono'),
            'codigo' => $request->get('codigo'),
            //con esto se genera un codigo con la PRIMERA LETRA DEL NOMBRE Y SU DNI
            //'codigo' => substr($request->get('name'), 0, 1) . $request->get('dni'),

        ]);

        $user = User::latest('id')->first();

        $user->assignRole('Administrador');

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
        
    }

    public function registerVendedor(Request $request, Vendedor $vendedor)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
             //Rule::unique('email')->where('tipo', 1)],
            //'email' => 'required|email|max:255|unique:users,tipo, ' . 0,        //.$positivo,
            /*'email' => Rule::unique('users')->where(function ($query) {
                                                                                    return $query->where('account_id', 1);
                                                                                }),*/
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

        $vendedor = Vendedor::create([
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
            //con esto se genera un codigo con la PRIMERA LETRA DEL NOMBRE Y SU DNI
            //'codigo' => substr($request->get('name'), 0, 1) . $request->get('dni'),
        ]);

        $vendedor = Vendedor::latest('id')->first();
        $vendedor->assignRole('Vendedor');
        

        $vendedorPromotor = Vendedor::all();
        $vendedorPromotor->promotor;
        //////////////////////////////////////////////////////////////////////////  
        //          Posible segunda logica                                      //
        //                                                                      //
        //          $vendedorPromotor2 = Vendedor::with('Promotor')->get();     //
        //////////////////////////////////////////////////////////////////////////  
        $token = JWTAuth::fromUser($vendedor);

        return response()->json([$vendedor,$vendedorPromotor, $token], 201);
    }

    public function registerPromotor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => ['required', 'email', 'max:255', 'unique:users,email'], //Rule::unique('email')->where('tipo', 1)],
            //'email' => 'required|email|max:255|unique:users,tipo, ' . 0,        //.$positivo,
            /*'email' => Rule::unique('users')->where(function ($query) {
                                                                                    return $query->where('account_id', 1);
                                                                                }),*/
            'password' => 'required|string|min:6|max:12',
            'dni' => 'required|integer',
            'ganancia' => 'required|integer',
            'porcentaje' => 'required|integer|max:50',
            'foto' => 'required|image|max:2048',
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

        $promotor = Promotor::create([
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
            //con esto se genera un codigo con la PRIMERA LETRA DEL NOMBRE Y SU DNI
            //'codigo' => substr($request->get('name'), 0, 1) . $request->get('dni'),
        ]);

        $promotor = Promotor::latest('id')->first();
        $promotor->assignRole('Promotor');
        
        $promotorAdministrador = Promotor::all();
        $promotorAdministrador->administrador;

        //////////////////////////////////////////////////////////////////////////  
        //          Posible segunda logica                                      //
        //                                                                      //
        //          $promotorAdministrador2 = Promotor::with(Users')->get();     //
        //////////////////////////////////////////////////////////////////////////
        
        $token = JWTAuth::fromUser($promotor);
        return response()->json([$promotor, $promotorAdministrador, $token], 201);
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
