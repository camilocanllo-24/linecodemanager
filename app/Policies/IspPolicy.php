<?php

namespace App\Policies;

use App\Isp;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IspPolicy
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
     * Determine whether the user can view any isps.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {

    }

    /**
     * Determine whether the user can view the isp.
     *
     * @param  \App\User  $user
     * @param  \App\Isp  $isp
     * @return mixed
     */
    public function view(User $user, Isp $isp)
    {

    }

    /**
     * Determine whether the user can create isps.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {

    }

    /**
     * Determine whether the user can update the isp.
     *
     * @param  \App\User  $user
     * @param  \App\Isp  $isp
     * @return mixed
     */
    public function update(User $user, Isp $isp)
    {
        //
    }

    /**
     * Determine whether the user can delete the isp.
     *
     * @param  \App\User  $user
     * @param  \App\Isp  $isp
     * @return mixed
     */
    public function delete(User $user, Isp $isp)
    {
        //
    }

    /**
     * Determine whether the user can restore the isp.
     *
     * @param  \App\User  $user
     * @param  \App\Isp  $isp
     * @return mixed
     */
    public function restore(User $user, Isp $isp)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the isp.
     *
     * @param  \App\User  $user
     * @param  \App\Isp  $isp
     * @return mixed
     */
    public function forceDelete(User $user, Isp $isp)
    {
        //
    }
}
