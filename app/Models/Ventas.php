<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    use HasFactory;

    protected $fillable = [
        "Fecha",
        "Numero",
        "Valorapuesta",
        "Loteria",
        "Tipo", //Directo o Combinado

        //Menu lateral en varias vistas {

        "Sumatotalventas", //Suma total de las Ventas
        "Puntoventas", //Punto de Ventas
        "Nombrepromotor", //Nombre del Promotor
        "Puntoentregaventas" //Punto de entregas de las ventas
        //                              }
    ];
}
