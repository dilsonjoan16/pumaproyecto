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
use App\Models\Vendedor;
use Illuminate\Support\Facades\Hash;
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
        $request->validate([
            "correo_contacto" => "required|email",
        ]);
        $hashed_random_password = Hash::make(str_random(8));
        /*$recovery =  [
            "Password" => $hashed_random_password
        ];*/
        
        $correosAdmin = User::select('email')->where('tipo', 1)->get();
        $correosProm = Promotor::select('email')->where('tipo', 1)->get();
        $correosVend = Vendedor::select('email')->where('tipo', 1)->get();
        if ($request->get("correo_contacto") === $correosAdmin) {
            
            $user = User::find($request->get("correo_contacto"));
            $user->password = $hashed_random_password;
            $correo = new RecoveryMail($request->all());
            Mail::to($request->get('correo_contacto'))->send($correo);
            $contacto = Contacto::create([
            'nombre_contacto' => $user->name,
            'correo_contacto' => $request->get('correo_contacto'),
            'mensaje_contacto' => $hashed_random_password,
        ]);
            return response()->json($contacto, 200);
        }
        if($request->get("correo_contacto") === $correosProm){

            $promotor = Promotor::find($request->get("correo_contacto"));
            $promotor->password = $hashed_random_password;
            $correo = new RecoveryMail($request->all());
            Mail::to($request->get('correo_contacto'))->send($correo);
            $contacto = Contacto::create([
                'nombre_contacto' => $promotor->name,
                'correo_contacto' => $request->get('correo_contacto'),
                'mensaje_contacto' => $hashed_random_password,
        ]);

        }
        if ($request->get("correo_contacto") === $correosVend) {

            $vendedor = Vendedor::find($request->get("correo_contacto"));
            $vendedor->password = $hashed_random_password;
            $correo = new RecoveryMail($request->all());
            Mail::to($request->get('correo_contacto'))->send($correo);
            $contacto = Contacto::create([
            'nombre_contacto' => $vendedor->name,
            'correo_contacto' => $request->get('correo_contacto'),
            'mensaje_contacto' => $hashed_random_password,
        ]);

        }

        //$PasswordAleatoria = Hash::make(str_random(8));

        return "mensaje enviado";

        return respose()->json($recovery, 200);
    }
    /////////////////////////////// FUNCION RECOVERY PASSWORD ///////////////////////////////////
    public function getMail(Request $request)
    {

        /*$validator = Validator::make($request->all(), [
            'nombre_contacto' => 'required|max:120',
            'correo_contacto' => 'required|max:255|email',
            'mensaje_contacto' => 'required|max:255|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }*/

        /*$contacto = $request->validate([
            'nombre_contacto' => 'required|max:120',
            'correo_contacto' => 'required|max:255|email',
            'mensaje_contacto' => 'required|max:255|string',
        ]);
        
        $contacto = new TestMail($request->all());
        Mail::to($validator['correo_contacto'])->send($contacto);
        return redirect()->route('contactanos.index');*/
        
        /*$details = $request->validate([
            "nombre_contacto" => "required",
            "correo_contacto" => "required",
            "mensaje_contacto" => "required"
        ]);

        $details=[
            "nombre_contacto" => $request->get("nombre_contacto"),
            "correo_contacto" => $request->get("correo_contacto"),
            "mensaje_contacto" => $request->get("mensaje_contacto")
        ];*/
        /*$details=[
            'title'=>'Correo de prueba 3',
            'body'=>'este es un ejemplo para enviar correos desde laravel a gmail',
            'correo' => 'dilsonjoan16@gmail.com'
        ];*/

        /*Mail::to($details['correo'])->send(new TestMail($details));
        return "correo electronico enviado 3";*/
    }
}
