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
        "Estado", //1 ESTA ACTIVO 0 ESTA ELIMINADO

        //Agregado REFERENCIA
        "Referencia",

        //Menu lateral en varias vistas {

        "Sumatotalventas", //Suma total de las Ventas
        "Puntoventas", //Punto de Ventas
        //"Nombrepromotor", //Nombre del Promotor -> AFILIADO ESTE CAMPO SE DEBE ELIMINAR
        "Puntoentregaventas" //Punto de entregas de las ventas
        //                              }
    ];

    public function vendedores()
    {
        return $this->belongsToMany(Vendedor::class)->withTimestamps();
    }

    public function promotor()
    {
        return $this->belongsTo(Promotor::class);
    }


}
