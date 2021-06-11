<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premios extends Model
{
    use HasFactory;

    protected $fillable =  [
        "Nombre",
        "Estado",
        //ID DE LA RELACION ENTRE PREMIOS Y SORTEOS
    ];
}
