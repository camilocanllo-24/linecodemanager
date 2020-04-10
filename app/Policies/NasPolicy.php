<?php

namespace App\Policies;

use App\Nas;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NasPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view any nas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the nas.
     *
     * @param  \App\User  $user
     * @param  \App\Nas  $nas
     * @return mixed
     */
    public function view(User $user, Nas $nas)
    {
        //
    }

    /**
     * Determine whether the user can create nas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the nas.
     *
     * @param  \App\User  $user
     * @param  \App\Nas  $nas
     * @return mixed
     */
    public function update(User $user, Nas $nas)
    {
        //
    }

    /**
     * Determine whether the user can delete the nas.
     *
     * @param  \App\User  $user
     * @param  \App\Nas  $nas
     * @return mixed
     */
    public function delete(User $user, Nas $nas)
    {
        //
    }

    /**
     * Determine whether the user can restore the nas.
     *
     * @param  \App\User  $user
     * @param  \App\Nas  $nas
     * @return mixed
     */
    public function restore(User $user, Nas $nas)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the nas.
     *
     * @param  \App\User  $user
     * @param  \App\Nas  $nas
     * @return mixed
     */
    public function forceDelete(User $user, Nas $nas)
    {
        //
    }
}
