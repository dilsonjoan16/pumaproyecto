<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    use HasFactory;

    protected $fillable = [
        
        
        
        'Referencia',
        'Numero',
        'Valorapostado',
        'Loteria',
        'Usuario', //Debo importarlo desde la bd User
        'Transaccion', //Exitosa o en espera
        
    ];

}
