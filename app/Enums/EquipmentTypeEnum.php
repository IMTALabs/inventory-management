<?php

namespace App\Enums;

enum EquipmentTypeEnum :string
{
    case COMPUTER = 'Computer';
    case NETWORK_DEVICE = 'Network Device';
    case SERVER = 'Server';
    case PRINTER = 'Printer';
    case ORTHER = 'Other';
}

