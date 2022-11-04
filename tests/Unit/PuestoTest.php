<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Testing\AssertableInertia as Assert;
use App\Models\Puesto;
use App\Models\User;

beforeEach(function () {
    //Creamos el Rol y permisos asociados al usuario
    $adminRole = Role::create(['name' => 'Admin']);
    $adminPermissions = ['manage-system', 'manage users'];
    foreach ($adminPermissions as $ap) {
        $permission = Permission::create(['name' => $ap]);
        $adminRole->givePermissionTo($permission);
    }
    //Creamos el usuario
    $this->user = User::factory()->create();
    //Asignamos el usuario
    $this->user->assignRole($adminRole);
});

it('logged user with rol admin can view puestos index', function () {
    Puesto::factory()->create(['by' => $this->user->id]);
    // $response = $this->actingAs($this->user)->get('/admin/puestos/');
    $responseInertia = $this->actingAs($this->user)->get('/admin/puestos/')->assertInertia(
        fn (Assert $page) => $page
            ->component('Puestos/ListPuestos')
            ->has('puestos')
    );
    $responseInertia->assertStatus(200);
    $this->assertCount(1, Puesto::all());
});

it('logged user with rol admin can edit an puesto', function () {
    $puesto = Puesto::factory()->create(['by' => $this->user->id]);
    $response = $this->actingAs($this->user)->get('/admin/puestos/' . $puesto->uuid . '/edit/')->assertInertia(
        fn (Assert $page) => $page
            ->component('Puestos/EditPuesto')
            ->has('puesto')
    );

    $response->assertStatus(200);
    $this->assertCount(1, Puesto::all());
});

it('logged user with rol admin can update an puesto', function () {
    $puesto = Puesto::factory()->create(['by' => $this->user->id]);
    $attributesUpdate = ['nombre' => 'Nuevo nombre', 'activo' => false];
    $response = $this->actingAs($this->user)->put('/admin/puestos/' . $puesto->uuid . '/update/', $attributesUpdate);
    $response->assertStatus(302);
    $this->assertCount(1, Puesto::all());
});

test('puesto', function () {
    expect(true)->toBeTrue();
});
