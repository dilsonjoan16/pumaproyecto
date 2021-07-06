<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesUser extends Model
{
    use HasFactory;

    protected $fillable =  [
        "nombre"
    ];

    public function rolUser()
    {
        return $this->hasMany(User::class);
    }

}
