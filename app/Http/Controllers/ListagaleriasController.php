<?php

namespace App\Http\Controllers;

use App\Models\Customize;


use Illuminate\Http\Request;

class ListagaleriasController extends Controller
{
    //FUNCION PARA ASIGNAR A QUE MENU SE MOSTRARA TIPO 1->RESULTADOS 2->SORTEOS 3->TESTIMONIOS 4->UBICANOS
    public function update(Request $request, $id)
    {
        $customize = Customize::find($id);

        $request->get('tipo');

        $customize->tipo = $request;

        $customize->save();

        $respuesta =  [
            "El objeto fue cambiado de categoria con exito!" => $customize
        ];

        return response()->json($respuesta, 200);
    }
}
