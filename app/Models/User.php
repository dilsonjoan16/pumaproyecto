<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

//Para el uso de Spatie, en la relacion de usuarios con roles
use Spatie\Permission\Traits\HasRoles;


//Añadimos la clase JWTSubject 
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
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
        'user_id',
        'rol_id',
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

    public function promotors()
    {
        return $this->hasMany(Promotor::class);
    }
    /////////// FUNCIONES NUEVAS //////////////
    public function tieneUsuarios()
    {
        return $this->hasMany(User::class);
    }

    public function perteneceUsuarios()
    {
        return $this->belongsTo(User::class);
    }

    public function tieneRoles()
    {
        return $this->belongsTo(RolesUser::class);
    }

    public function Ventas()
    {
        return $this->hasMany(Ventas::class);
    }

    public function solicitudes()
    {
        return $this->hasMany(Solicitudes::class);
    }

    public function sorteos()
    {
        return $this->hasMany(Sorteos::class);
    }
    //////////// FIN FUNCIONES NUEVAS /////////
}
