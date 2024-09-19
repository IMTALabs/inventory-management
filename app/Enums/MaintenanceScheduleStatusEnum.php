<?php

namespace App\Enums;

enum MaintenanceScheduleStatusEnum: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case COMPLETED = 'completed';
    case OVERDUE = 'overdue';
    case CANCELLED = 'cancelled';

    public function getBadgeClass(): string
    {
        return match ($this) {
            self::PENDING => 'bg-primary text-white',
            self::CONFIRMED => 'bg-info text-white',
            self::COMPLETED => 'bg-success text-white',
            self::OVERDUE => 'bg-danger text-white',
            self::CANCELLED => 'bg-dark text-white',
        };
    }
}
