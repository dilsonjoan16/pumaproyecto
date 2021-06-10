<?php

namespace App\Http\Controllers;

use App\Models\Customize;


use Illuminate\Http\Request;

class ListagaleriasController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //FUNCION PARA ASIGNAR A QUE MENU SE MOSTRARA TIPO 1->RESULTADOS 2->SORTEOS 3->TESTIMONIOS 4->UBICANOS
    public function updateResultados($id)
    {
        $customize = Customize::find($id);
        $customize->tipo = 1;
        $customize->save();
        $respuesta =  [
            "El objeto fue cambiado de categoria con exito!" => $customize
        ];

        return response()->json($respuesta, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //FUNCION PARA ASIGNAR A QUE MENU SE MOSTRARA TIPO 1->RESULTADOS 2->SORTEOS 3->TESTIMONIOS 4->UBICANOS
    public function updateSorteos($id)
    {
        $customize = Customize::find($id);
        $customize->tipo = 2;
        $customize->save();
        $respuesta =  [
            "El objeto fue cambiado de categoria con exito!" => $customize
        ];

        return response()->json($respuesta, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //FUNCION PARA ASIGNAR A QUE MENU SE MOSTRARA TIPO 1->RESULTADOS 2->SORTEOS 3->TESTIMONIOS 4->UBICANOS
    public function updateUbicanos($id)
    {
        $customize = Customize::find($id);
        $customize->tipo = 3;
        $customize->save();
        $respuesta =  [
            "El objeto fue cambiado de categoria con exito!" => $customize
        ];

        return response()->json($respuesta, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //FUNCION PARA ASIGNAR A QUE MENU SE MOSTRARA TIPO 1->RESULTADOS 2->SORTEOS 3->TESTIMONIOS 4->UBICANOS
    public function updateTestimonios($id)
    {
        $customize = Customize::find($id);
        $customize->tipo = 4;
        $customize->save();
        $respuesta =  [
            "El objeto fue cambiado de categoria con exito!" => $customize
        ];

        return response()->json($respuesta, 200);
    }
}
