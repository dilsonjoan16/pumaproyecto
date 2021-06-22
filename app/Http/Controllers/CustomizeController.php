<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use App\Models\Customize;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Mail\Mailable;


//clases usadas para el envio del email
use Mail;
use App\Mail\TestMail;
//
class CustomizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$customize = Customize::all();
        if ($customize = Customize::where("estado", "=", 1)->get()) {
            if ($customize = Customize::where("tipo", "=", 1)->get()) {
                $tipo1 = $customize;
            }
            if ($customize2 = Customize::where("tipo", "=", 2)->get()) {
                $tipo2 = $customize2;
            }
            if ($customize3 = Customize::where("tipo", "=", 3)->get()) {
                $tipo3 = $customize3;
            }
            if ($customize4 = Customize::where("tipo", "=", 4)->get()) {
                $tipo4 = $customize4;
            }
        }
    
        $prueba = [
            "Datos tipo 1: Resultados" => $tipo1,
            "Datos tipo 2: Sorteos" => $tipo2,
            "Datos tipo 3: Ubicanos" => $tipo3,
            "Datos tipo 4: Testimonios" => $tipo4
        ];
        
        return response()->json($prueba, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Customize $customize)
    {

        
        $validator = Validator::make($request->all(),[
            'rutaImagen' => 'required|image|max:2048',
            'titulo' => 'required|string',
            'contenido' => 'required|string',
            'rutaVideo' => 'video',
            'orden' => 'required|integer',
            'tipo' => 'required|integer|max:4',
            'link' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        //////////////////////PLANTEAMIENTO SECUNDARIO/////////////////////
        $customize = $request->all();

        if($imagenes = $request->file('rutaImagen')){
            $file = $imagenes->getClientOriginalName();
            $imagenes->move('images', $file);
            $customize['rutaImagen'] = $file;
        }
        
        if($videos = $request->file('rutaVideo')){
            $file2 = $videos->getClientOriginalName();
            $videos->move('videos', $file2);
            $customize['rutaVideo'] = $file2;
        }

        Customize::create($customize);

        return response()->json($customize, 201);
        //////////////////////FIN DE PLANTEAMIENTO SECUNDARIO//////////////

        /////////////////////PLANTEAMIENTO ORIGINAL///////////////////////
        /*$imagen = $request->get('rutaImagen'); 
        $imagen->move('images', $imagen);
        $video = $request->get('rutaVdeo');
        $video->move('videos', $video);
        $customize = Customize::create([
            'rutaImagen' => $request->get('rutaImagen'),
            'titulo' => $request->get('titulo'),
            'contenido' => $request->get('contenido'),
            'rutaVideo' => $request->get('rutaVideo'),
            'orden' => $request->get('orden'), //orden en el que quiera que se vean las imagenes
            'tipo' => $request->get('tipo'), //orden de muestra tipo: 1->resultados 2->sorteos 3->testimonios 4->ubicanos
            'link' => $request->get('link')
        ]);

        return response()->json($customize, 201);*/
        ///////////////////FIN DE PLANTEAMIENTO ORIGINAL////////////////////

        /*$contacto = Contacto::create([
            'nombre_contacto' => $request->get('nombre_contacto'),
            'correo_contacto' => $request->get('correo_contacto'),
            'mensaje_contacto' => $request->get('mensaje_contacto'),
        ]);   
        //$contacto = Contacto::where('id')->last();
        $contacto = Contacto::find(\DB::table('contacto')->max('id'));
        Mail::to($contacto['correo_contacto'])->send(new TestMail($contacto));
        return response()->json($contacto, 201);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customize = Customize::find($id);
        $respuesta = [
            "Objeto encontrado con exito!" =>$customize
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
        $customize = Customize::find($id);

        $customize->update($request->all());

        $respuesta =  [
            "El objeto fue actualizado con exito!" => $customize
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
        $customize = Customize::find($id);
        $customize->estado = "0";
        $customize->save();

        $respuesta = [
            "El objeto fue eliminado con exito!" => $customize
        ];

        return response()->json($respuesta, 200);
    }

}
