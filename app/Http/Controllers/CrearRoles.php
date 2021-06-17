<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class CrearRoles extends Controller
{
    public function CrearAdministrador()
    {
        /*
            Roles del sistema
            $role1 = Role::create(['name' => 'Administrador']);
            $role2 = Role::create(['name' => 'Promotor']);
            $role3 = Role::create(['name' => 'Vendedor']);
        */
        $administrador = User::latest('id')->first();       
        $administrador->assignRole('Administrador');
        $prueba =  [
            "Role de Administrador asignado con exito!" =>$administrador
        ];
        $roles = $administrador->roles;
        return response()->json([$prueba, $roles], 201);
    }

    public function CrearPromotor()
    {
        /*
            Roles del sistema
            $role1 = Role::create(['name' => 'Administrador']);
            $role2 = Role::create(['name' => 'Promotor']);
            $role3 = Role::create(['name' => 'Vendedor']);
        */
        $promotor = User::latest('id')->first();
        $promotor->assignRole('Promotor');
        $prueba =  [
            "Role de Promotor asignado con exito!" => $promotor
        ];
        return response()->json($prueba, 201);
    }

    public function CrearVendedor()
    {
        /*
            Roles del sistema
            $role1 = Role::create(['name' => 'Administrador']);
            $role2 = Role::create(['name' => 'Promotor']);
            $role3 = Role::create(['name' => 'Vendedor']);
        */
        $vendedor = User::latest('id')->first();
        $vendedor->assignRole('Vendedor');
        $prueba =  [
            "Role de Vendedor asignado con exito!" => $vendedor
        ];
        return response()->json($prueba, 201);
    }

    public function EliminarAdministrador($id)
    {
        /*
            Roles del sistema
            $role1 = Role::create(['name' => 'Administrador']);
            $role2 = Role::create(['name' => 'Promotor']);
            $role3 = Role::create(['name' => 'Vendedor']);
        */
        $administrador = User::find($id);
        $administrador->removeRole('Administrador');
        $prueba =  [
            "Role de Administrador removido con exito!" => $administrador
        ];
        return response()->json($prueba, 200);
    }

    public function EliminarPromotor($id)
    {
         /*
            Roles del sistema
            $role1 = Role::create(['name' => 'Administrador']);
            $role2 = Role::create(['name' => 'Promotor']);
            $role3 = Role::create(['name' => 'Vendedor']);
        */
        $promotor = User::find($id);
        $promotor->removeRole('Promotor');
        $prueba =  [
            "Role de Promotor removido con exito!" => $promotor
        ];
        return response()->json($prueba, 200);
    }

    public function EliminarVendedor($id)
    {
         /*
            Roles del sistema
            $role1 = Role::create(['name' => 'Administrador']);
            $role2 = Role::create(['name' => 'Promotor']);
            $role3 = Role::create(['name' => 'Vendedor']);
        */
        $vendedor = User::find($id);
        $vendedor->removeRole('Vendedor');
        $prueba =  [
            "Role de Vendedor removido con exito!" => $vendedor
        ];
        return response()->json($prueba, 200);
    }

    public function ModificarAdministrador($id)
    {
        /*
            Roles del sistema
            $role1 = Role::create(['name' => 'Administrador']);
            $role2 = Role::create(['name' => 'Promotor']);
            $role3 = Role::create(['name' => 'Vendedor']);
        */
        $administrador = User::find($id);
        if ($promotor->hasRole('Administrador')) {
            $promotor->removeRole('Administrador');
        }
        if ($promotor->hasRole('Promotor')) {
            $promotor->removeRole('Promotor');
        }
        if ($promotor->hasRole('Vendedor')) {
            $promotor->removeRole('Vendedor');
        }
        $administrador->assignRole('Administrador');
        $prueba =  [
            "Role de Administrador asignado con exito!" => $administrador
        ];
        return response()->json($prueba, 201);
    }

    public function ModificarPromotor($id)
    {
        /*
            Roles del sistema
            $role1 = Role::create(['name' => 'Administrador']);
            $role2 = Role::create(['name' => 'Promotor']);
            $role3 = Role::create(['name' => 'Vendedor']);
        */
        $promotor = User::find($id);
        if($promotor->hasRole('Administrador')){
            $promotor->removeRole('Administrador');
        }
        if($promotor->hasRole('Promotor')){
            $promotor->removeRole('Promotor');
        }
        if($promotor->hasRole('Vendedor')){
            $promotor->removeRole('Vendedor');
        }
        //$promotor->removeRole('Promotor');
        //$promotor = User::find($id);
        $promotor->assignRole('Promotor');
        $prueba =  [
            "Role de Promotor asignado con exito!" => $promotor
        ];
        return response()->json($prueba, 201);
    }

    public function ModificarVendedor($id)
    {
        /*
            Roles del sistema
            $role1 = Role::create(['name' => 'Administrador']);
            $role2 = Role::create(['name' => 'Promotor']);
            $role3 = Role::create(['name' => 'Vendedor']);
        */
        $vendedor = User::find($id);
        if ($promotor->hasRole('Administrador')) {
            $promotor->removeRole('Administrador');
        }
        if ($promotor->hasRole('Promotor')) {
            $promotor->removeRole('Promotor');
        }
        if ($promotor->hasRole('Vendedor')) {
            $promotor->removeRole('Vendedor');
        }
        //$vendedor->removeRole('Vendedor');
        $vendedor->assignRole('Vendedor');
        $prueba =  [
            "Role de Vendedor asignado con exito!" => $vendedor
        ];
        return response()->json($prueba, 201);
    }
}
