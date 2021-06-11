<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acumulado extends Model
{
    use HasFactory;

    protected $fillable =  [
        "Nombre",
        "Estado",
        //ID ENTRE LA RELACION ENTRE ACUMULADOS Y SORTEOS
    ];
}
