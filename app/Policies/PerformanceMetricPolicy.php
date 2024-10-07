<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\PerformanceMetric;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PerformanceMetricPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PerformanceMetric $performanceMetric): bool
    {
        return $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER;
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
    public function update(User $user, PerformanceMetric $performanceMetric): bool
    {
        return $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PerformanceMetric $performanceMetric): bool
    {
        return $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PerformanceMetric $performanceMetric): bool
    {
        return $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PerformanceMetric $performanceMetric): bool
    {
        return $user->role === RoleEnum::ADMIN
            || $user->role === RoleEnum::MANAGER;
    }
}
