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
        "Estado", //ACTIVO 1 INACTIVO 0
        "user_id"
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
}
