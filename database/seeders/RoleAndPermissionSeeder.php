<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminPermissions = [
            'manage-users', 'view-users', 'create-users',
            'edit-users', 'delete-users',
        ];
        $adminRole = Role::create(['name' => 'Admin']);
        foreach ($adminPermissions as $ap) {
            $permission = Permission::create(['name' => $ap]);
            $adminRole->givePermissionTo($permission);
        }

        $salesPermissions = [
            'manage-sales', 'view-sales', 'create-sales',
            'edit-sales', 'delete-sales',
        ];
        $pacientesPermissions = [
            'manage-pacientes', 'view-paciente', 'create-paciente',
            'update-paciente', 'delete-paciente',
        ];
        $estudiosPermissions = [
            'manage-estudios', 'view-estudio', 'create-estudio',
            'update-estudio', 'delete-estudio',
        ];

        foreach ($salesPermissions as $ap) {
            $permission = Permission::create(['name' => $ap]);
            $adminRole->givePermissionTo($permission);
        }
        foreach ($pacientesPermissions as $ap) {
            $permission = Permission::create(['name' => $ap]);
            $adminRole->givePermissionTo($permission);
        }
         foreach ($estudiosPermissions as $ap) {
            $permission = Permission::create(['name' => $ap]);
            $adminRole->givePermissionTo($permission);
         }

    }
}
