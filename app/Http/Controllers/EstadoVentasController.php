<?php

namespace App\Http\Controllers;

use App\Models\Ventas;
use Illuminate\Http\Request;

class EstadoVentasController extends Controller
{
    public function index()
    {
        $ventas = Ventas::where("Estado", "=", 1)->get();
        return response()->json($ventas, 200);
    }
}
