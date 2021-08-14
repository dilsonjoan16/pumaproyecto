<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sorteos extends Model
{
    use HasFactory;

    protected $fillable =  [
        "Fecha",
        "Loteria",
        "Codigo",
        "Max",
        "Estado", //ACTIVO 1 INACTIVO 0
        "user_id",
        "venta_id",
        "porc_4cifras", // % de 4 cifras
        "porc_triple",  // % de triple
        "porc_combn3",  // % de combinado de 3
        "porc_combn4",  // % de combinado de 4
        "porc_terminal", //% de terminal
    ];

    public function premios()
    {
        return $this->hasMany(Premios::class);
    }

    public function acumulado()
    {
        return $this->hasMany(Acumulado::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ventas()
    {
        return $this->hasMany(Ventas::class);
    }
}
