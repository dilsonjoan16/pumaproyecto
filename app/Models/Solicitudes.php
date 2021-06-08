<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitudes extends Model
{
    use HasFactory;

    protected $fillable =  [
        "Nombre", // nombre del vendedor -> POR EL MOMENTO PERO ESTA TABLA DEBO RELACIONARLA CON LA MUESTRA DE SOLICITUDES EN ADMINISTRADOR
        "CantidadSolicitada",// cantidad solicitada -> CREDITO O PRESTAMO
        "Cuotas", // cuotas de pago -> CREDITO O PRESTAMO
        "MobiliarioSolicitado", // mobiliario solicitado -> MOBILIARIO
        "Ubicacion", // punto de ubicacion -> MOBILIARIO
        "Solicitud", // otros -> OTROS
        "Tipo" //Sirve para el Borrado logico 1 ACTIVO 0 BORRADO
        

    ];
}
