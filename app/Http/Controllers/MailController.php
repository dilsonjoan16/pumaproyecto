<?php

namespace App\Http\Controllers;

use App\Mail\RecoveryMail;
use App\Mail\TestMail;
use Illuminate\Http\Request;
//use Illuminate\Http\Facades\Mail;
//use Illuminate\Support\Facades\Mail;
use Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\Contacto;
use App\Models\Promotor;
use App\Models\User;
use App\Models\RecoveryPassword;
use App\Models\Vendedor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class MailController extends Controller
{
    public function index(){
        return view('contactanos.index');
    }

    public function store(Request $request, Contacto $contacto){

        $request->validate([
            "nombre_contacto" => "required",
            "correo_contacto" => "required|email",
            "mensaje_contacto" => "required|string"
        ]);

        $correo = new TestMail($request->all());
        Mail::to('dilsonjoan16@gmail.com')->send($correo);

        $contacto = Contacto::create([
            'nombre_contacto' => $request->get('nombre_contacto'),
            'correo_contacto' => $request->get('correo_contacto'),
            'mensaje_contacto' => $request->get('mensaje_contacto'),
        ]); 

        return "mensaje enviado";
        
        
        return response()->json($contacto, 200);
    }
    ///////////////////////////////  FUNCION DONDE DEBO GENERAR LA LOGICA DEL RECOVERY //////////////////////////////
    public function MailRecovery(Request $request, Contacto $contacto) 
    {
        $newpassword = Str::random(8);
        $hashed_random_password = Hash::make($newpassword);
        //dd($hashed_random_password);
        $correo = $request->get('correo_contacto');
        
        $request->validate([
            'correo_contacto' => 'required|string|email',
        ]);

        //dd($request->get('correo_contacto'));
        
        $user = User::where('email', $correo)->first();
        if (!$user)
            return response()->json('No se encontro algun usuario con el correo ingresado', 404);
        //dd($user);
            $user->password = $hashed_random_password;
            $user->update();

            $contacto = new RecoveryMail([$newpassword,$user->name,]);
            //dd($contacto);
            
            $recovery = new RecoveryPassword;
            $recovery->email = $correo;
            $recovery->name = $user->name;
            $recovery->dni = $user->dni;
            $recovery->save();

            Mail::to($correo)->send($contacto);
            
        return response()->json("Mensaje enviado con exito", 200);

    }
    
}
