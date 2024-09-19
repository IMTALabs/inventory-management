<?php

namespace App\Enums;

enum EquipmentConditionEnum :string
{
    case GOOD = 'Good';
    case FAIR = 'Fair';
    case POOR = 'Poor';
    case EXCELLENT = 'Excellent';
}
