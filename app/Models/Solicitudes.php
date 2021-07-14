<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitudes extends Model
{
    use HasFactory;

    protected $fillable =  [
        
        "CantidadSolicitada",// cantidad solicitada -> CREDITO O PRESTAMO
        "Cuotas", // cuotas de pago -> CREDITO O PRESTAMO
        "MobiliarioSolicitado", // mobiliario solicitado -> MOBILIARIO
        "Ubicacion", // punto de ubicacion -> MOBILIARIO
        "Solicitud", // otros -> OTROS
        "Tipo", //Sirve para el Borrado logico 1 EN ESPERA 0 RECHAZADO 2 ACEPTADA
        "Categoria", //Si es Prestamo/Credito -> Mobiliario -> Otros
        "user_id"
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
