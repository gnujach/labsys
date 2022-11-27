<?php

use App\Models\Categoria;
use App\Models\Grupo;
use App\Models\Tipoventa;
use App\Models\User;
use App\Models\Estudio;
use Inertia\Testing\AssertableInertia as Assert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    //Creamos el Rol y permisos asociados al usuario
    $cajeroRole = Role::create(['name' => 'Cajero']);
    $cajeroPermissions = [
        'manage-estudios','create-estudio', 'update-estudio', 'delete-estudio',
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

it ("logged user with role admin can view Estudios Index", function () {
    $this->withoutExceptionHandling();
    Estudio::factory()->create(['by' => $this->user->id]);
    $response = $this->actingAs($this->user)->get('/admin/estudios')->assertInertia(
        fn(Assert $page) => $page->component('Estudios/ListEstudios')->has('estudios')
    );
    $response->assertStatus(200);
    $this->assertCount(1,Estudio::all());
});

it ("logged user with role admin can add Estudio", function () {
    $this->withoutExceptionHandling();
    Categoria::factory()->create(['by' => $this->user->id]);
    Tipoventa::factory()->create(['by' => $this->user->id]);
    Grupo::factory()->create(['by' => $this->user->id]);
    $attributes = [
        'nombre' => fake()->name,
        'clave' => fake()->name,
        'precio_mostrador' => fake()->randomDigitNotZero(),
        'precio_preferencial' => fake()->randomDigitNotZero(),
        'costo' => fake()->randomDigitNotZero(),
        'ganancia' => fake()->randomDigitNotZero(),
        'tipoventa_id' => 1,
        'grupo_id' => 1,
        'categoria_id' => 1,
        'corte_id' => 1,
        'activo' => true,
        'by' => $this->user->id,
    ];
    $response = $this->actingAs($this->user)->post('/admin/estudios/', $attributes);
    $response->assertStatus(302);
    $this->assertDatabaseHas('estudios', $attributes);
});

it ('logger user with role admin can update Estudio', function () {
    $this->withoutExceptionHandling();
    Categoria::factory()->create(['by' => $this->user->id]);
    Tipoventa::factory()->create(['by' => $this->user->id]);
    Grupo::factory()->create(['by' => $this->user->id]);
    $estudio = Estudio::factory()->create(['by' => $this->user->id]);
    $attributes = [
        'nombre' => fake()->name,
        'clave' => fake()->name,
        'precio_mostrador' => fake()->randomDigitNotZero(),
        'precio_preferencial' => fake()->randomDigitNotZero(),
        'costo' => fake()->randomDigitNotZero(),
        'ganancia' => fake()->randomDigitNotZero(),
        'tipoventa_id' => 1,
        'grupo_id' => 1,
        'categoria_id' => 1,
        'corte_id' => 1,
        'activo' => true,
        'by' => $this->user->id,
    ];
    $response = $this->actingAs($this->user)->put('/admin/estudios/' . $estudio->uuid . '/update/', $attributes);
    $response->assertStatus(302);
    $this->assertDatabaseHas('estudios', $attributes);
    $this->assertCount(1,Estudio::all());
});

it ('user with role admin can delete estudio', function()
{
    $this->withoutExceptionHandling();
    $estudio = Estudio::factory()->create(['by' => $this->user->id]);
    $response = $this->actingAs($this->user)->delete('/admin/estudios/' . $estudio->uuid . '/delete/');
    $response->assertRedirect();
    $this->assertCount(0,Estudio::all());
});

it('user with role admin can edit estudio', function () {
    $this->withoutExceptionHandling();
    $estudio = Estudio::factory()->create(['by' => $this->user->id]);
    $response = $this->actingAs($this->user)->get('/admin/estudios/' . $estudio->uuid . '/edit/')->assertInertia(
        fn(Assert $page) => $page->component('Estudios/EditEstudio')->has('estudio')
    );
    $this->assertCount(1,Estudio::all());
    $response->assertStatus(200);
});

it('user with role admin can create estudio', function () {
    $this->withoutExceptionHandling();
    $response = $this->actingAs($this->user)->get('/admin/estudios/create')->assertInertia(
        fn(Assert $page) => $page->component('Estudios/CreateEstudio')
    );
    $this->assertCount(0,Estudio::all());
    $response->assertStatus(200);
});
