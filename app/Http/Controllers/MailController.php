<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Illuminate\Http\Request;
//use Illuminate\Http\Facades\Mail;
//use Illuminate\Support\Facades\Mail;
use Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\Contacto;
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
        
        
        return response()->json($contacto);
    }

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
