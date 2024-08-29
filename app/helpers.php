<?php

use App\Enums\MaintenancePlanFrequencyEnum;
use App\Enums\RoleEnum;

/*
|--------------------------------------------------------------------------
| Template helper
|--------------------------------------------------------------------------
*/

if (! function_exists('maintenance_plan_frequency_badge_class')) {
    function maintenance_plan_frequency_badge_class($frequency): string
    {
        return match ($frequency) {
            MaintenancePlanFrequencyEnum::DAILY => 'bg-primary text-white',
            MaintenancePlanFrequencyEnum::WEEKLY => 'bg-success text-white',
            MaintenancePlanFrequencyEnum::MONTHLY => 'bg-warning text-white',
            MaintenancePlanFrequencyEnum::QUARTERLY => 'bg-secondary text-white',
            MaintenancePlanFrequencyEnum::SEMI_ANNUALLY => 'bg-danger text-white',
            MaintenancePlanFrequencyEnum::ANNUALLY => 'bg-info text-white',
            default => 'bg-dark text-white',
        };
    }
}

if (! function_exists('role_badge_class')) {
    function role_badge_class($role): string
    {
        return match ($role) {
            RoleEnum::ADMIN => 'bg-success text-white',
            RoleEnum::MAINTAINER => 'bg-warning text-white',
            default => 'bg-dark text-white',
        };
    }
}
