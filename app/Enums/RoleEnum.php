<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case STAFF = 'staff';
    case MANAGER = 'manager';
    case MAINTAINER = 'maintainer';
}
