<?php

namespace App\Http\Controllers;

use App\Models\Solicitudes;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\SolicitudMail;
use Mail;

class SolicitudesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()//SOLICITUDES EN ESPERA
    {
        $usuario = auth()->user();
        $usuario->id;
        $solicitudes = Solicitudes::with('user')->where('user_id','=', $usuario->id)->get();

        return response()->json($solicitudes, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Solicitudes $solicitudes)
    {
        $usuario = auth()->user();
        $usuario->id;


        /*$solicitudes = Solicitudes::create($request->all());
        return $solicitudes;*/
        $request->validate([
            "CantidadSolicitada" => "integer",
            "Cuotas" => "integer",
            "MobiliarioSolicitado" => "string",
            "Ubicacion" => "string",
            "Solicitud" => "string",

        ]);

        if($request->get("CantidadSolicitada") !== null && $request->get("Cuotas") !== null)
        {



            //$users = User::where('rol_id', 1)->get();


            //$subset = $users->map->only(['email']);

            //dd($subset);
            $solicitudes = new Solicitudes;
            $solicitudes->CantidadSolicitada = $request->get("CantidadSolicitada");
            $solicitudes->Cuotas = $request->get("Cuotas");
            $solicitudes->Categoria = "Prestamo/Credito";
            $solicitudes->user_id = $usuario->id;
            //dd($solicitudes);

            $userEmail = User::where('rol_id', 1)->get();
            //dd($userEmail);
            foreach ($userEmail as $um) {
                $contacto = new SolicitudMail([$solicitudes->Categoria, $solicitudes->CantidadSolicitada, $solicitudes->Cuotas, $usuario->name]);
                Mail::to($um->email)->send($contacto);
            };

            //envio de correo
            $contacto = new SolicitudMail([$solicitudes->Categoria, $solicitudes->CantidadSolicitada, $solicitudes->Cuotas, $usuario->name]);
            //dd($contacto);

            $correo = [
                //$usuario->email,
                "agenciapumaweb@gmail.com"
            ];
            //dd($correo);
            Mail::to($correo)->send($contacto);
            //fin de envio de correo
            $solicitudes->Tipo = 1;
            $solicitudes->save();

            $usuario->solicitud_id = $solicitudes->id;
            $usuario->save();

            $Solicitante = User::where('id', '=', $solicitudes->user_id)->first();

            $respuesta =  [
                "La solicitud ha sido creada y enviada con exito!" => $solicitudes,
                "Usuario afiliado a la solicitud" => $Solicitante,
                "Mensaje enviado con exito al correo"
            ];

            return response()->json($respuesta, 201);
        }
        if($request->get("MobiliarioSolicitado") !== null && $request->get("Ubicacion") !== null)
        {
            $solicitudes = new Solicitudes;
            $solicitudes->MobiliarioSolicitado = $request->get("MobiliarioSolicitado");
            $solicitudes->Ubicacion = $request->get("Ubicacion");
            $solicitudes->Categoria = "Mobiliario";
            $solicitudes->user_id = $usuario->id;

            $userEmail = User::where('rol_id', 1)->get();
            //dd($userEmail);
            foreach ($userEmail as $um) {
                $contacto = new SolicitudMail([$solicitudes->Categoria, $solicitudes->MobiliarioSolicitado, $solicitudes->Ubicacion, $usuario->name]);
                Mail::to($um->email)->send($contacto);
            };

            //envio de correo
            $contacto = new SolicitudMail([$solicitudes->Categoria, $solicitudes->MobiliarioSolicitado, $solicitudes->Ubicacion, $usuario->name]);
            //dd($contacto);

            $correo = [
                //$usuario->email,
                "agenciapumaweb@gmail.com"
            ];
            //dd($correo);
            Mail::to($correo)->send($contacto);
            //fin de envio de correo
            $solicitudes->Tipo = 1;
            $solicitudes->save();

            $usuario->solicitud_id = $solicitudes->id;
            $usuario->save();

            $Solicitante = User::where('id', '=', $solicitudes->user_id)->first();

            $respuesta =  [
                "La solicitud ha sido creada y enviada con exito!" => $solicitudes,
                "Usuario afiliado a la solicitud" => $Solicitante,
                "Mensaje enviado con exito al correo"
            ];

            return response()->json($respuesta, 201);
        }
        if($request->get("Solicitud") !== null)
        {
            $solicitudes = new Solicitudes;
            $solicitudes->Solicitud = $request->get("Solicitud");
            $solicitudes->Categoria = "Solicitud/Otro";
            $solicitudes->user_id = $usuario->id;

            $userEmail = User::where('rol_id', 1)->get();
            //dd($userEmail);
            foreach ($userEmail as $um) {
                $contacto = new SolicitudMail([$solicitudes->Categoria, $solicitudes->Solicitud, $usuario->name]);
                Mail::to($um->email)->send($contacto);
            };

            //envio de correo
            $contacto = new SolicitudMail([$solicitudes->Categoria,  $solicitudes->Solicitud, $usuario->name]);
            //dd($contacto);

            $correo = [
                //$usuario->email,
                "agenciapumaweb@gmail.com"
            ];
            //dd($correo);
            Mail::to($correo)->send($contacto);
            //fin de envio de correo
            $solicitudes->Tipo = 1;
            $solicitudes->save();

            $usuario->solicitud_id = $solicitudes->id;
            $usuario->save();

            $Solicitante = User::where('id', '=', $solicitudes->user_id)->first();

            $respuesta =  [
                "La solicitud ha sido creada y enviada con exito!" => $solicitudes,
                "Usuario afiliado a la solicitud" => $Solicitante,
                "Mensaje enviado con exito al correo"
            ];

            return response()->json($respuesta, 201);
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
        $solicitudes = Solicitudes::find($id);
        $respuesta =  [
            "Objeto encontrado con exito!" => $solicitudes
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
        $solicitudes = Solicitudes::find($id);
        $solicitudes->Tipo = "2";
        $solicitudes->save();
        
        if ($solicitudes->Categoria == "Prestamo/Credito") {

            $usuario = User::find($solicitudes->user_id);
            $usuario->user_credito = ($usuario->user_credito + $solicitudes->CantidadSolicitada);
            $usuario->update();

        }
       
        $respuesta =  [
            "El objeto fue validado con exito!" => $solicitudes,
            "prueba" => $usuario
        ];
        return response()->json($respuesta, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $solicitudes = Solicitudes::find($id);
        $solicitudes->Tipo = "0";
        $solicitudes->save();

        /*
            Otra logica posible:
            MyModel::where('confirmed', '=', 0)->update(['confirmed' => 1])
        */

        $respuesta =  [
            "El objeto fue eliminado con exito!" => $solicitudes
        ];

        return response()->json($respuesta, 200);
    }

    public function SolicitudesRechazadas()
    {
        $solicitudes = Solicitudes::where('Tipo','=',0)->get();
        $respuesta =  [
            "Solicitudes Rechazadas" => $solicitudes
        ];
        return response()->json($respuesta, 200);
    }

    public function SolicitudesAceptadas()
    {
        $solicitudes = Solicitudes::where('Tipo', '=', 2)->get();
        $respuesta =  [
            "Solicitudes Aceptadas" => $solicitudes
        ];
        return response()->json($respuesta, 200);
    }

    public function solicitudVendedor()
    {
        $usuario = auth()->user();
        $solicitudes = User::with('solicitudes')->find($usuario->id);
        return response()->json($solicitudes, 200);
    }

    public function verSolicitudPromotor()
    {
        $usuario = auth()->user();
        $usuario->id;

        $promotorSolicitud = Solicitudes::with('user')->where('user_id','=', $usuario->id)->get();
        $userPromotor = User::with('tieneUsuarios')->where('user_id','=', $usuario->id)->with('solicitudes')->get();
        $respuesta =  [
            "Solicitudes del promotor" => $promotorSolicitud,
            "Usuarios afiliados" => $userPromotor
        ];

        return response()->json($respuesta, 200);
    }

    public function SolicitudesAdministrador()
    {
        $SolicitudesProm = User::with('solicitudes')->where('rol_id', '=', 2)->get();
        $SolicitudesVend = User::with('solicitudes')->where('rol_id', '=', 3)->get();
        $solicitudes =  [
            "Solicitudes de vendedores" => $SolicitudesVend,
            "Solicitudes de promotores" => $SolicitudesProm
        ];

        return response()->json($solicitudes, 200);
    }
}
