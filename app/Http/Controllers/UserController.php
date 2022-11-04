<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\User as UsuarioResource;
use App\Http\Resources\UserCollection as UserCollection;
use App\Http\Resources\Rol as RolResource;
use App\Http\Resources\RolCollection as RolCollection;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateRolRequest;
use App\Http\Requests\UpdateUserTrabajoRequest;
use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Redirect;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);
        return Inertia\Inertia::render(
            'Users/ListUsers',
            [
                'users' => new UserCollection(User::orderBy('id', 'desc')->with(['puesto', 'departamento'])->paginate(config('openlink.perpage'))),
            ]
        );
    }

    public function create()
    {
        $this->authorize('updatebyUser', User::class);
        return Inertia\Inertia::render(
            'Users/CreateUser',
            [
                'departamentos' => DB::table('departamentos')->where('activo', true)->select('id', 'nombre')->get(),
                'puestos' => DB::table('puestos')->where('activo', true)->select('id', 'nombre')->get(),
                'roles' => DB::table('roles')->select('id', 'name AS nombre')->get(),
            ]
        );
    }

    public function edit(User $user)
    {
        $this->authorize('updatebyUser', User::class);
        return Inertia\Inertia::render(
            'Users/EditUser',
            [
                'user' => new UsuarioResource($user),
                'departamentos' => DB::table('departamentos')->where('activo', true)->select('id', 'nombre')->get(),
                'puestos' => DB::table('puestos')->where('activo', true)->select('id', 'nombre')->get(),
                'roles' => DB::table('roles')->select('id', 'name AS nombre')->get(),
                'rolesUsario' => $user->getRoleNames()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request,  UserService $userService)
    {
        $this->authorize('create', User::class);
        $user = $userService->storeUser($request);
        return Redirect::route('admin.usuarios/');
    }

    /**
     * Update roles
     * @author @gnujach
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRoles(UpdateRolRequest $request, User $user, UserService $userService)
    {
        $this->authorize('updatebyUser', User::class);
        $user = $userService->updateRolUser($request, $user);
        return Redirect::route('admin.usuarios/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user, UserService $userService)
    {
        $this->authorize('updatebyUser', User::class);
        $user = $userService->updateUser($request, $user);
        return Redirect::route('admin.usuarios/');
    }

    /**
     * Update Departamento y puesto de usuario
     */
    public function updateTrabajo(UpdateUserTrabajoRequest $request, User $user, UserService $userService)
    {
        $this->authorize('updatebyUser', User::class);
        $user = $userService->updateUserTrabajo($request, $user);
        return Redirect::route('admin.usuarios/');
    }
}
