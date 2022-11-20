<?php

use App\Models\Paciente;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    //Creamos el Rol y permisos asociados al usuario
    $cajeroRole = Role::create(['name' => 'Cajero']);
    $cajeroPermissions = [
        'manage-pacientes','create-paciente', 'update-paciente', 'delete-paciente',
    ];
    foreach ($cajeroPermissions as $ap) {
        $permission = Permission::create(['name' => $ap]);
        $cajeroRole->givePermissionTo($permission);
    }
    //Creamos el usuario principal
    $this->user = User::factory()->create();
    //Creamos usuario invitado
    //Asignamos el usuario
    $this->guest = User::factory()->create();
    $this->user->assignRole($cajeroRole);
});

it ("logged user with role admin can view Pacientes Index", function () {
    $this->withoutExceptionHandling();
    Paciente::factory()->create(['by' => $this->user->id]);
    $response = $this->actingAs($this->user)->get('/admin/pacientes')->assertInertia(
        fn(Assert $page) => $page->component('Pacientes/ListPacientes')->has('pacientes')
    );
    $response->assertStatus(200);
    $this->assertCount(1,Paciente::all());
});

it ('logger user with role admin can add paciente', function () {
    $this->withoutExceptionHandling();
    $attributes = [
        'nombre' => strtoupper(fake()->name),
        'ap1' => strtoupper(fake()->lastName),
        'ap2' => strtoupper(fake()->lastName),
        'tel' => 4686896385,
        'correo' => strtoupper(fake()->email),
        'edad' => fake()->randomElement([23,34,43,56,78]),
        'genero' => fake()->randomElement(['Másculino', 'Femenino']),
        'direccion' => fake()->address,
        'activo' => fake()->boolean,
        'by' => $this->user->id,
    ];
    $response = $this->actingAs($this->user)->post('/admin/pacientes/', $attributes);
    $response->assertStatus(302);
    $this->assertDatabaseHas('pacientes', $attributes);
    }
);

it ('logger user with role admin can update paciente', function () {
    $this->withoutExceptionHandling();
    $paciente = Paciente::factory()->create(['by' => $this->user->id]);
    $attributes = [
        'nombre' => strtoupper(fake()->name),
        'ap1' => strtoupper(fake()->lastName),
        'ap2' => strtoupper(fake()->lastName),
        'tel' => 4686896385,
        'correo' => strtoupper(fake()->email),
        'edad' => fake()->randomElement([23, 34, 43, 56, 78]),
        'genero' => fake()->randomElement(['Másculino', 'Femenino']),
        'direccion' => fake()->address,
        'activo' => fake()->boolean,
        'by' => $this->user->id,
    ];
    $response = $this->actingAs($this->user)->put('/admin/pacientes/' . $paciente->uuid . '/update/', $attributes);
    $response->assertStatus(302);
    $this->assertDatabaseHas('pacientes', $attributes);
    $this->assertCount(1, Paciente::all());
});

it ('user with role admin can delete paciente', function()
{
    $this->withoutExceptionHandling();
    $paciente = Paciente::factory()->create(['by' =>$this->user->id]);
    $response = $this->actingAs($this->user)->delete('/admin/pacientes/' . $paciente->uuid . '/delete/');
    $response->assertRedirect();
    $this->assertCount(0, Paciente::all());
});

it('user with role admin can edit pacientes', function () {
    $this->withoutExceptionHandling();
    $paciente = Paciente::factory()->create(['by' =>$this->user->id]);
    $response = $this->actingAs($this->user)->get('/admin/pacientes/'.$paciente->uuid.'/edit')->assertInertia(
        fn(Assert $page) => $page->component('Pacientes/EditPaciente')->has('paciente')
    );
    $this->assertCount(1, Paciente::all());
    $response->assertStatus(200);
});

it('user with role admin can create paciente', function () {
    $this->withoutExceptionHandling();
    $response = $this->actingAs($this->user)->get('/admin/pacientes/create')->assertInertia(
        fn(Assert $page) => $page->component('Pacientes/CreatePaciente')
    );
    $response->assertStatus(200);
});
