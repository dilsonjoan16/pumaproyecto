<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customize extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruta-imagen',
        'titulo',
        'contenido',
        'ruta-video',
        'orden', //manera de ordenar las galerias
        'estado', //para el borrado logico : 1 aparece 2 oculto 3 borrado-logico
        'tipo'  //1 resultados 2 sorteos 3 testimonios 4 ubicanos 5 contacto
    ];
}
