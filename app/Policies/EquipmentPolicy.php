<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EquipmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return
            $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER
            || $user->role === RoleEnum::MAINTAINER
            || $user->role === RoleEnum::STAFF
                ? Response::allow()
                : Response::deny('You are not authorized to view equipment.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Equipment $equipment): Response
    {
        return
            $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER
            || $user->role === RoleEnum::MAINTAINER
            || $user->role === RoleEnum::STAFF
                ? Response::allow()
                : Response::deny('You are not authorized to view this equipment.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return
            $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER
                ? Response::allow()
                : Response::deny('You are not authorized to create equipment.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Equipment $equipment): Response
    {
        return
            $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER
                ? Response::allow()
                : Response::deny('You are not authorized to update this equipment.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Equipment $equipment): Response
    {
        return
            $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER
                ? Response::allow()
                : Response::deny('You are not authorized to delete this equipment.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Equipment $equipment): Response
    {
        return
            $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER
                ? Response::allow()
                : Response::deny('You are not authorized to restore this equipment.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Equipment $equipment): Response
    {
        return
            $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER
                ? Response::allow()
                : Response::deny('You are not authorized to permanently delete this equipment.');
    }
}
