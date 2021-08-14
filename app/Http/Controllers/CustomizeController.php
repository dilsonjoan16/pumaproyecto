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
        $customize = Customize::where('tipo', 1)->where('estado', 1)->get();
        $customize2 = Customize::where('tipo', 2)->where('estado', 1)->get();
        $customize3 = Customize::where('tipo', 3)->where('estado', 1)->get();
        $customize4 = Customize::where('tipo', 4)->where('estado', 1)->get();
        $customize5 = Customize::where('tipo', 5)->where('estado', 1)->get();
        $customize6 = Customize::where('tipo', 6)->where('estado', 1)->get();
        $prueba = [
            "Datos tipo 1: Resultados" => $customize,
            "Datos tipo 2: Sorteos" => $customize2,
            "Datos tipo 3: Ubicanos" => $customize3,
            "Datos tipo 4: Testimonios" => $customize4,
            "Datos tipo 5: Slider" => $customize5,
            "Datos tipo 6: Video" => $customize6
        ];

        return response()->json($prueba, 200);
    }

    public function general()
    {
        $customize = Customize::where('tipo', 1)->get();
        $customize2 = Customize::where('tipo', 2)->get();
        $customize3 = Customize::where('tipo', 3)->get();
        $customize4 = Customize::where('tipo', 4)->get();
        $customize5 = Customize::where('tipo', 5)->get();
        $customize6 = Customize::where('tipo', 6)->get();
        $prueba = [
            "Datos tipo 1: Resultados" => $customize,
            "Datos tipo 2: Sorteos" => $customize2,
            "Datos tipo 3: Ubicanos" => $customize3,
            "Datos tipo 4: Testimonios" => $customize4,
            "Datos tipo 5: Slider" => $customize5,
            "Datos tipo 6: Video" => $customize6
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


        $validator = Validator::make($request->all(), [
            'rutaImagen' => 'required|image|max:2048',
            'titulo' => 'required|string',
            'contenido' => 'required|string',
            'rutaVideo' => 'required|video',
            'orden' => 'required|integer',
            'tipo' => 'required|integer|max:4',
            'link' => 'required|string'
        ]);

        //if ($validator->fails()) {
        //  return response()->json($validator->errors()->toJson(), 400);
        // }

        /*$request->validate([
            'rutaImagen' => 'image|max:2048',
            'titulo' => 'required|string',
            'contenido' => 'required|string',
            'rutaVideo' => 'video',
            'orden' => 'required|integer',
            'tipo' => 'required|integer|max:4',
            'link' => 'required|string'
        ]);*/

        //////////////////////PLANTEAMIENTO SECUNDARIO/////////////////////
        $customize = $request->all();

        if ($imagenes = $request->file('rutaImagen')) {
            $file = $imagenes->getClientOriginalName();
            $imagenes->move('images', $file);
            $customize['rutaImagen'] = $file;
        }

        if ($videos = $request->file('rutaVideo')) {
            $file2 = $videos->getClientOriginalName();
            $videos->move('videos', $file2);
            $customize['rutaVideo'] = $file2;
        }

        Customize::create($customize);

        $id = Customize::latest('id')->first();

        return response()->json([$customize, $id], 201);
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
            "Objeto encontrado con exito!" => $customize
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
    public function update(Request $request, $id, Customize $customize)
    {
        //$variable;
        $customize = Customize::find($id);
        ////////////////////////////////////////////////////////

        if ($imagenes = $request->file('rutaImagen')) {
            $file = $imagenes->getClientOriginalName();
            $imagenes->move('images', $file);
            $customize['rutaImagen'] = $file;
            //$customize->rutaImagen = $file;
        }

        if ($videos = $request->file('rutaVideo')) {
            $file2 = $videos->getClientOriginalName();
            $videos->move('videos', $file2);
            $customize['rutaVideo'] = $file2;
            //$customize->rutaVideo = $file2;
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        if ($imagenes === null) {
            $customize->update($request->all());
            $respuesta =  [
                "El objeto fue actualizado con exito!" => $customize,
            ];

            return response()->json($respuesta, 200);
        }

        if ($imagenes === null && $videos !== null) {
            $customize->update([
                'titulo' => $request->get('titulo'),
                'contenido' => $request->get('contenido'),
                'rutaVideo' => $file2,
                'link' => $request->get('link')
            ]);
            //$customize->update($request->all());
            $respuesta =  [
                "El objeto fue actualizado con exito!" => $customize,
            ];

            return response()->json($respuesta, 200);
        }
        if ($videos === null) {
            $customize->update([
                'rutaImagen' => $file,
                'titulo' => $request->get('titulo'),
                'contenido' => $request->get('contenido'),
                'link' => $request->get('link')
            ]);
            $respuesta =  [
                "El objeto fue actualizado con exito!" => $customize,
            ];

            return response()->json($respuesta, 200);
        }
        if ($imagenes === null && $videos === null) {
            $customize->update($request->all());
            $respuesta =  [
                "El objeto fue actualizado con exito!" => $customize,
            ];

            return response()->json($respuesta, 200);
        }
        if ($imagenes !== null && $videos !== null) {
            $customize->update([
                'rutaImagen' => $file,
                'titulo' => $request->get('titulo'),
                'contenido' => $request->get('contenido'),
                'rutaVideo' => $file2,
                'link' => $request->get('link')
            ]);
            $respuesta =  [
                "El objeto fue actualizado con exito!" => $customize,
            ];

            return response()->json($respuesta, 200);
        }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        /////////    BLOQUE DE CODIGO QUE CAMBIA EL ESTADO DE 0 A 1  /////////
        ////////    DESBLOQUEA UN ELEMENTO BLOQUEADO Y LO MODIFICA  /////////

        /*if ($imagenes === null && $customize->estado == 0) {
            $customize->update($request->all()+$customize->estado=1);
            $respuesta =  [
                "El objeto fue actualizado con exito!" => $customize,
            ];

            return response()->json($respuesta, 200);
        }
        if ($videos === null && $customize->estado==0) {
            $customize->update([
                'rutaImagen' => $file,
                'titulo' => $request->get('titulo'),
                'contenido' => $request->get('contenido'),
                'link' => $request->get('link'),
                $customize->estado=1
            ]);
            $respuesta =  [
                "El objeto fue actualizado con exito!" => $customize,
            ];

            return response()->json($respuesta, 200);
        }
        if ($imagenes === null && $videos === null) {
            return $variable = 3;
        }
        if ($imagenes !== null && $videos !== null && $customize->estado==0) {
            $customize->update([
                'rutaImagen' => $file,
                'titulo' => $request->get('titulo'),
                'contenido' => $request->get('contenido'),
                'rutaVideo' => $file2,
                'link' => $request->get('link'),
                $customize->estado=1
            ]);
            $respuesta =  [
                "El objeto fue actualizado con exito!" => $customize,
            ];

            return response()->json($respuesta, 200);
        }*/

        ////////  FIN DE BLOQUE DE CODIGO QUE CAMBIA EL ESTADO DE 0 A 1  ///////
        ////////  DESBLOQUEA UN ELEMENTO BLOQUEADO Y LO MODIFICA    ///////

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //////// BLOQUE DE CODIGO QUE PERMITE A TRAVES DE UN SWICH REALIZAR LA FUNCIONALIDAD DE LOS CONDICIONALES /////////

        /*switch ($variable) {
            case '1':
                $customize->update([
                    'titulo' => $request->get('titulo'),
                    'contenido' => $request->get('contenido'),
                    'rutaVideo' => $file2,
                    'link' => $request->get('link')
                ]);
                $respuesta =  [
                    "El objeto fue actualizado con exito!" => $customize,
                ];

                return response()->json($respuesta, 200);
                break;
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            case '2':
                $customize->update([
                    'rutaImagen' => $file,
                    'titulo' => $request->get('titulo'),
                    'contenido' => $request->get('contenido'),
                    'link' => $request->get('link')
                ]);
                $respuesta =  [
                    "El objeto fue actualizado con exito!" => $customize,
                ];

                return response()->json($respuesta, 200);
                break;
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            case '3':
                $customize->update($request->all());
                $respuesta =  [
                    "El objeto fue actualizado con exito!" => $customize,
                ];

                return response()->json($respuesta, 200);
                break;
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            case '4':
                $customize->update([
                    'rutaImagen' => $file,
                    'titulo' => $request->get('titulo'),
                    'contenido' => $request->get('contenido'),
                    'rutaVideo' => $file2,
                    'link' => $request->get('link')
                ]);
                $respuesta =  [
                    "El objeto fue actualizado con exito!" => $customize,
                ];

                return response()->json($respuesta, 200);
                break;
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            default:
                $respuesta =  [
                    "No existe ese caso posible"
                ];
                return response()->json($respuesta, 205);
                break;
        }*/

        /////// FIN DEL BLOQUE DE CODIGO CON LOS SWITCH ////////

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /*$vendedor = Vendedor::find($id);
        $vendedor->promotor = $nuevoId;
        $vendedor->update($request->all());*/
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////

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

    public function UpdateEstado($id)
    {
        $customize = Customize::find($id);
        $customize->estado = 1;
        $customize->save();
        return response()->json($customize->estado, 200);
    }

}
