<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\PacienteController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::middleware('auth:sanctum')->name('admin.')->prefix('admin')->group(function () {
    /** Puestos */
    Route::get('/puestos/', [PuestoController::class, 'index'])->name('puestos/');
    Route::get('/puestos/create', [Puestocontroller::class, 'create'])->name('puestos/create');
    Route::get('/puestos/{puesto:uuid}/edit', [Puestocontroller::class, 'edit'])->name('puestos/edit');
    Route::post('/puestos/', [Puestocontroller::class, 'store'])->name('puestos/store');
    Route::put('/puestos/{puesto:uuid}/update', [Puestocontroller::class, 'update'])->name('puestos/update');
    Route::get('/puestos/fuse', [Puestocontroller::class, 'fuse'])->name('puestos/fuse');

    /**Users */
    Route::get('/usuarios/', [UserController::class, 'index'])->name('usuarios/');
    Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios/create');
    Route::get('/usuarios/{user:uuid}/edit', [Usercontroller::class, 'edit'])->name('usuarios/edit');
    Route::post('/usuarios/', [Usercontroller::class, 'store'])->name('usuarios/store');
    Route::put('/usuarios/{user:uuid}/updateroles', [Usercontroller::class, 'updateRoles'])->name('usuarios/updateroles');
    Route::put('/usuarios/{user:uuid}/update', [Usercontroller::class, 'update'])->name('usuarios/update');
    Route::put('/usuarios/{user:uuid}/updatedatostrabajo', [Usercontroller::class, 'updateTrabajo'])->name('usuarios/updatedatostrabajo');

    /** Roles y Permisos */
    Route::get('/roles/', [RoleController::class, 'index'])->name('roles/');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles/create');
    Route::get('/roles/{role:id}/edit', [Rolecontroller::class, 'edit'])->name('roles/edit');
    Route::put('/roles/{role:id}/update', [Rolecontroller::class, 'update'])->name('roles/update');
    Route::post('/roles/', [Rolecontroller::class, 'store'])->name('roles/store');

    /** Pacientes */
    Route::get('/pacientes/', [PacienteController::class, 'index'])->name('pacientes/');
    Route::get('/pacientes/create', [PacienteController::class, 'create'])->name('pacientes/create');
    Route::get('/pacientes/{paciente:uuid}/edit', [PacienteController::class, 'edit'])->name('pacientes/edit');
    Route::post('/pacientes/', [PacienteController::class, 'store'])->name('pacientes/store');
    Route::put('/pacientes/{paciente:uuid}/update', [PacienteController::class, 'update'])->name('pacientes/update');
    Route::delete('/pacientes/{paciente:uuid}/delete', [PacienteController::class, 'destroy'])->name('pacientes/delete');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
