<?php

namespace App\Policies;

use App\Agency;
use App\Service;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the user can view any services.
     *
     * @param User $user
     * @param Agency $agency
     * @return mixed
     */
    public function index(User $user, Agency $agency)
    {
        if ($user->isAdmin()) {
            return $user->agency->isp->id === $agency->isp->id;
        }
        return $user->agency->id === $agency->id;
    }

    /**
     * Determine whether the user can view the service.
     *
     * @param User $user
     * @param Service $service
     * @return mixed
     */
    public function view(User $user, Service $service)
    {
        //
    }

    /**
     * Determine whether the user can create services.
     *
     * @param User $user
     * @param Agency $agency
     * @return mixed
     */
    public function create(User $user, Agency $agency)
    {
        if ($user->isAdmin()) {
            return $user->agency->isp->id === $agency->isp->id;
        } else if ($user->isTecnico()) {
            return false;
        }
        return $user->agency->id === $agency->id;
    }

    /**
     * Determine whether the user can update the service.
     *
     * @param User $user
     * @param Service $service
     * @return mixed
     */
    public function update(User $user, Service $service)
    {
        if ($user->isAdmin()) {
            return $user->agency->isp->id === $service->subscriber->agency->isp->id;
        } else if ($user->isTecnico()) {
            return false;
        }
        return $user->agency->id === $service->subscriber->agency->id;
    }

    /**
     * Determine whether the user can delete the service.
     *
     * @param User $user
     * @param Service $service
     * @return mixed
     */
    public function delete(User $user, Service $service)
    {
        if ($user->isAdmin()) {
            return $user->agency->isp->id === $service->subscriber->agency->isp->id;
        } elseif ($user->isCajero() || $user->isTecnico()) {
            return false;
        }
        return $user->agency->id === $service->subscriber->agency->id;
    }

    /**
     * Determine whether the user can restore the service.
     *
     * @param User $user
     * @param Service $service
     * @return mixed
     */
    public function restore(User $user, Service $service)
    {
        if ($user->isAdmin()) {
            return $user->agency->isp->id === $service->subscriber->agency->isp->id;
        } elseif ($user->isCajero() || $user->isTecnico()) {
            return false;
        }
        return $user->agency->id === $service->subscriber->agency->id;
    }

    /**
     * Determine whether the user can permanently delete the service.
     *
     * @param User $user
     * @param Service $service
     * @return mixed
     */
    public function forceDelete(User $user, Service $service)
    {
        if ($user->isAdmin()) {
            return $user->agency->isp->id === $service->agency->isp->id;
        } elseif ($user->isCajero() || $user->isTecnico()) {
            return false;
        }
        return $user->agency->id === $service->agency->id;
    }
}
