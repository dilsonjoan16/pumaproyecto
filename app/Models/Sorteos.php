<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sorteos extends Model
{
    use HasFactory;

    protected $fillable =  [
        "NombreSorteo",
        "Tipo", //Tipo del sorteo
        "FechaCulminacion",
        "Numeros",
        "Estado", //ACTIVO 1 INACTIVO 0
        //"Lugarpodio",
        "NombreGanador",
        "Vendedor"
    ];

    public function premios()
    {
        return $this->hasMany(Premios::class);
    }

    public function acumulado()
    {
        return $this->hasMany(Acumulado::class);
    }
}
