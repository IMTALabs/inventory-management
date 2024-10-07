<?php

namespace App\Policies;

use App\Enums\MaintenanceScheduleStatusEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use App\Models\WarrantyRequest;
use Illuminate\Auth\Access\Response;

class WarrantyRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER
            || $user->role === RoleEnum::STAFF;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, WarrantyRequest $warrantyRequest): bool
    {
        return $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER
            || $user->role === RoleEnum::STAFF;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER
            || $user->role === RoleEnum::STAFF;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, WarrantyRequest $warrantyRequest): bool
    {
        return $warrantyRequest->status === MaintenanceScheduleStatusEnum::PENDING
            && ($user->role === RoleEnum::ADMIN
                || $user->role === RoleEnum::MANAGER
                || $user->role === RoleEnum::STAFF);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WarrantyRequest $warrantyRequest): bool
    {
        return $warrantyRequest->status === MaintenanceScheduleStatusEnum::PENDING
            && ($user->role === RoleEnum::ADMIN
                || $user->role === RoleEnum::MANAGER
                || $user->role === RoleEnum::STAFF);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, WarrantyRequest $warrantyRequest): bool
    {
        return $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER
            || $user->role === RoleEnum::STAFF;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, WarrantyRequest $warrantyRequest): bool
    {
        return $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER
            || $user->role === RoleEnum::STAFF;
    }
}
