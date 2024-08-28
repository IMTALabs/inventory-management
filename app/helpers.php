<?php

use App\Enums\MaintenancePlanFrequencyEnum;

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
