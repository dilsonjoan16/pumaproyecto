<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

//importamos la clase de Role 
use Spatie\Permission\Models\Role;
//importamos la clase de los permisos
use Spatie\Permission\Models\Permission;



class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Roles del sistema
        $role1 = Role::create(['name' => 'Administrador']);
        $role2 = Role::create(['name' => 'Promotor']);
        $role3 = Role::create(['name' => 'Vendedor']);

        //Permisos del sistema
        Permission::create(['name' => 'login'])->syncRoles([$role1,$role2,$role3]);

        //Permisos del Rol vendedor
        Permission::create(['name' => 'perfil.vendedor.index'])->assignRole($role3);
        Permission::create(['name' => 'estado.cuenta.vendedor.index'])->assignRole($role3);
        Permission::create(['name' => 'reporte.ventas.vendedor'])->assignRole($role3);
        Permission::create(['name' => 'solicitudes.vendedor'])->assignRole($role3);

        //Permisos del Rol promotor
        Permission::create(['name' => 'perfil.promotor.index'])->assignRole($role2);
        Permission::create(['name' => 'reporte.ventas.promotor'])->assignRole($role2);
        //CRUD de vendedores del promotor
        Permission::create(['name' => 'mostrar.vendedor.promotor'])->assignRole($role2);
        Permission::create(['name' => 'eliminar.vendedor.promotor'])->assignRole($role2);
        Permission::create(['name' => 'editar.vendedor.promotor'])->assignRole($role2);
        Permission::create(['name' => 'crear.vendedor.promotor'])->assignRole($role2);
        /*********************************************************/
        Permission::create(['name' => 'solicitudes.promotor'])->assignRole($role2);
        //Este permiso verifica el estado de cuenta de vendedores
        Permission::create(['name' => 'verificar.estado.cuenta.promotor'])->assignRole($role2);
                
        //Permisos del Rol Administrador
        Permission::create(['name' => 'perfil.administrador.index'])->assignRole($role1);
        //CRUD para galerias
        Permission::create(['name' => 'crear.galeria.administrador'])->assignRole($role1);
        Permission::create(['name' => 'editar.galeria.administrador'])->assignRole($role1);
        Permission::create(['name' => 'mostrar.galeria.administrador'])->assignRole($role1);
        Permission::create(['name' => 'eliminar.galeria.administrador'])->assignRole($role1);
        /************************************************************/
        //CRUD para metricas
        Permission::create(['name' => 'crear.metricas.administrador'])->assignRole($role1);
        Permission::create(['name' => 'editar.metricas.administrador'])->assignRole($role1);
        Permission::create(['name' => 'mostrar.metricas.administrador'])->assignRole($role1);
        Permission::create(['name' => 'eliminar.metricas.administrador'])->assignRole($role1);
        /*************************************************************/
        //CRUD para vendedores y promotores
        Permission::create(['name' => 'crear.vendedor.administrador'])->assignRole($role1);
        Permission::create(['name' => 'editar.vendedor.administrador'])->assignRole($role1);
        Permission::create(['name' => 'mostrar.vendedor.administrador'])->assignRole($role1);
        Permission::create(['name' => 'eliminar.vendedor.administrador'])->assignRole($role1);
        /*************************************************************/
        Permission::create(['name' => 'crear.sorteos.administrador'])->assignRole($role1);
        Permission::create(['name' => 'reporte.ventas.administrador'])->assignRole($role1);
        Permission::create(['name' => 'crear.gastos.administrador'])->assignRole($role1);
        Permission::create(['name' => 'buscador.fecha.administrador'])->assignRole($role1);
        //Gestion de solicitudes
        Permission::create(['name' => 'mostrar.solicitudes.administrador'])->assignRole($role1);
        Permission::create(['name' => 'aceptar.solicitudes.administrador'])->assignRole($role1);
        Permission::create(['name' => 'eliminar.solicitudes.administrador'])->assignRole($role1);

        
    }
}
