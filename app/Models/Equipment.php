<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_name',
        'equipment_type',
        'model',
        'serial_number',
        'manufacturer',
        'purchase_date',
        'location',
        'status',
        'warranty_period',
        'installation_date',
        'last_service_date',
        'next_service_date',
        'equipment_condition',
        'equipment_specifications',
        'usage_duration',
        'power_requirements',
        'network_info',
        'software_version',
        'hardware_version',
        'purchase_price',
        'depreciation_value',
        'notes',
    ];

    public function image(): MorphMany
    {
        return $this->MorphMany(Image::class, 'imageable');
    }

    public function performanceMetrics(): HasMany
    {
        return $this->hasMany(PerformanceMetric::class);
    }

    public function maintenancePlans(): HasMany
    {
        return $this->hasMany(MaintenancePlan::class);
    }
}
