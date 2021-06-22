<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Promotor extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'dni',
        'ganancia',
        'porcentaje',
        'balance',
        'foto',
        'direccion',
        'telefono',
        'codigo',
        'tipo',
        'busqueda',
        //role_id
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Metodos del JWT 

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function vendedors()
    {
        return $this->hasMany(Vendedor::class);
    }

    public function administrador()
    {
        return $this->belongsTo(User::class);
    }

    public function ventas()
    {
        return $this->hasMany(Ventas::class);
    }

    public function solicitudes()
    {
        return $this->hasMany(Solicitudes::class);
    }

    public function ventaVendedor()
    {
        return $this->hasOneThrough(Ventas::class, Vendedor::class);
    }

    public function solicitudVendedor()
    {
        return $this->hasOneThrough(Solicitudes::class, Vendedor::class);
    }
}
