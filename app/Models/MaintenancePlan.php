<?php

namespace App\Models;

use App\Enums\MaintenancePlanFrequencyEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenancePlan extends Model
{
    use HasFactory;

    protected $casts = [
        'frequency' => MaintenancePlanFrequencyEnum::class,
    ];
}
