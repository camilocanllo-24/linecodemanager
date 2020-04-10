<?php

namespace App\Policies;

use App\Agency;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgencyPolicy
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
     * Determine whether the user can view any agencies.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {

    }

    /**
     * Determine whether the user can view the agency.
     *
     * @param User $user
     * @param  \App\Agency  $agency
     * @return mixed
     */
    public function view(User $user, Agency $agency)
    {
        //
    }

    /**
     * Determine whether the user can create agencies.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the agency.
     *
     * @param User $user
     * @param  \App\Agency  $agency
     * @return mixed
     */
    public function update(User $user, Agency $agency)
    {
        //
    }

    /**
     * Determine whether the user can delete the agency.
     *
     * @param User $user
     * @param  \App\Agency  $agency
     * @return mixed
     */
    public function delete(User $user, Agency $agency)
    {
        //
    }

    /**
     * Determine whether the user can restore the agency.
     *
     * @param User $user
     * @param  \App\Agency  $agency
     * @return mixed
     */
    public function restore(User $user, Agency $agency)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the agency.
     *
     * @param User $user
     * @param  \App\Agency  $agency
     * @return mixed
     */
    public function forceDelete(User $user, Agency $agency)
    {
        //
    }
}
