<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\MaintenanceSchedule;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MaintenanceSchedulePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER
            || $user->role === RoleEnum::MAINTAINER;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MaintenanceSchedule $maintenanceSchedule): bool
    {
        return $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER
            || $user->role === RoleEnum::MAINTAINER;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MaintenanceSchedule $maintenanceSchedule): bool
    {
        return $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER
            || $user->role === RoleEnum::MAINTAINER;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MaintenanceSchedule $maintenanceSchedule): bool
    {
        return $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MaintenanceSchedule $maintenanceSchedule): bool
    {
        return $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MaintenanceSchedule $maintenanceSchedule): bool
    {
        return $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER;
    }
}
