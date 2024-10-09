<?php

namespace App\Enums;

enum EquipmentConditionEnum: string
{
    case GOOD = 'Good';
    case FAIR = 'Fair';
    case POOR = 'Poor';
    case EXCELLENT = 'Excellent';

    public function getBadgeClass(): string
    {
        return match ($this) {
            self::EXCELLENT => 'bg-success text-white',
            self::GOOD => 'bg-primary text-white',
            self::FAIR => 'bg-info text-white',
            self::POOR => 'bg-warning text-white',
        };
    }
}
