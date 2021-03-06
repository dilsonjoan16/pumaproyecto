<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    protected $fillable = [
        'Monto',
        'Tipo', //Esto es Gasto, Pago, Premio
        'Salida', // Esto es Acumulado o Caja
        'Descripcion',
        'Referencia',
        'Transaccion',
        'user_id',
        'user_pago',
        'MontoCredito',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
