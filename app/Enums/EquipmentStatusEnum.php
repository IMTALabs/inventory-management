<?php

namespace App\Enums;

enum EquipmentStatusEnum :string
{
    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
    case PENDING_DISPOSAL = 'Pending Disposal';
    case UNDER_MAINTENANCE = 'Under Maintenance';
    case UNDER_REPAIR = 'Under Repair';
}

