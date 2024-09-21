<?php

namespace App\Enums;

enum WorkOrderStatusEnum: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public static function unavailableStatuses(): array
    {
        return [
            self::PENDING,
            self::ACTIVE,
        ];
    }

    public function getBadgeClass(): string
    {
        return match ($this) {
            self::PENDING => 'bg-primary text-white',
            self::ACTIVE => 'bg-info text-white',
            self::COMPLETED => 'bg-success text-white',
            self::CANCELLED => 'bg-dark text-white',
        };
    }
}
