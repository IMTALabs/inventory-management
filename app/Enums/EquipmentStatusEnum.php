<?php

namespace App\Enums;

enum EquipmentStatusEnum: string
{
    case AVAILABLE = 'Available';
    case IN_USE = 'In Use';
    case PENDING_DISPOSAL = 'Pending Disposal';
    case INACTIVE = 'Inactive';
    case UNDER_MAINTENANCE = 'Under Maintenance';
    case UNDER_REPAIR = 'Under Repair';

    public static function active(): array
    {
        return [self::AVAILABLE, self::IN_USE, self::PENDING_DISPOSAL];
    }
}

