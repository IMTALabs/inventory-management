<?php

namespace App\Enums;

enum MaintenancePlanFrequencyEnum: string
{
    case ONE_TIME = 'one_time';
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case QUARTERLY = 'quarterly';
    case SEMI_ANNUALLY = 'semi_annually';
    case ANNUALLY = 'annually';

    public static function frequencyBadgeClasses(): array
    {
        return [
            self::DAILY->value => 'bg-primary text-white',
            self::WEEKLY->value => 'bg-success text-white',
            self::MONTHLY->value => 'bg-warning text-white',
            self::QUARTERLY->value => 'bg-secondary text-white',
            self::SEMI_ANNUALLY->value => 'bg-danger text-white',
            self::ANNUALLY->value => 'bg-info text-white',
            self::ONE_TIME->value => 'bg-dark text-white',
        ];
    }
}
