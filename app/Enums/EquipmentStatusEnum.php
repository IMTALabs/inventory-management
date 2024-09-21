<?php

namespace App\Enums;

enum EquipmentStatusEnum :string
{
    case AVAILABLE = 'Available';
    case UNAVAILABLE = 'Unavailable';
    case INACTIVE = 'Inactive';
    case PENDING_DISPOSAL = 'Pending Disposal';
    case UNDER_MAINTENANCE = 'Under Maintenance';
    case UNDER_REPAIR = 'Under Repair';
}

