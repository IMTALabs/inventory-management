<?php

namespace App\Enums;

enum MaintenancePlanStatusEnum: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
}
