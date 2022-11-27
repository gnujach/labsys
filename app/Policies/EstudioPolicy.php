<?php

namespace App\Policies;

use App\Models\Estudio;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EstudioPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('manage-estudios');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Estudio  $estudio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Estudio $estudio)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create-estudio');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Estudio  $estudio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return $user->can('update-estudio');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Estudio  $estudio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return $user->can('delete-estudio');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Estudio  $estudio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Estudio $estudio)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Estudio  $estudio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Estudio $estudio)
    {
        //
    }
}
