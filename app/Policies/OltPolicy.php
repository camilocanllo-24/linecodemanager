<?php

namespace App\Policies;

use App\Olt;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OltPolicy
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
     * Determine whether the user can view any olts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the olt.
     *
     * @param  \App\User  $user
     * @param  \App\Olt  $olt
     * @return mixed
     */
    public function view(User $user, Olt $olt)
    {
        //
    }

    /**
     * Determine whether the user can create olts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the olt.
     *
     * @param  \App\User  $user
     * @param  \App\Olt  $olt
     * @return mixed
     */
    public function update(User $user, Olt $olt)
    {
        //
    }

    /**
     * Determine whether the user can delete the olt.
     *
     * @param  \App\User  $user
     * @param  \App\Olt  $olt
     * @return mixed
     */
    public function delete(User $user, Olt $olt)
    {
        //
    }

    /**
     * Determine whether the user can restore the olt.
     *
     * @param  \App\User  $user
     * @param  \App\Olt  $olt
     * @return mixed
     */
    public function restore(User $user, Olt $olt)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the olt.
     *
     * @param  \App\User  $user
     * @param  \App\Olt  $olt
     * @return mixed
     */
    public function forceDelete(User $user, Olt $olt)
    {
        //
    }
}
