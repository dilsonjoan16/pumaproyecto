<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sorteos extends Model
{
    use HasFactory;

    protected $fillable =  [
        "NombreSorteo",
        "Tipo",
        "FechaCulminacion",
        "Numeros",
        "Estado",
        //"Lugarpodio",
        "NombreGanador",
        "Vendedor"
    ];
}
