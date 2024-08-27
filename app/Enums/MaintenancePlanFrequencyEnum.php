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
}
