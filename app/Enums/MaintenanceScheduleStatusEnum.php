<?php

namespace App\Enums;

enum MaintenanceScheduleStatusEnum: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case OVERDUE = 'overdue';
    case CANCELLED = 'cancelled';
}
