<?php

namespace App\Models;

use App\Enums\EquipmentStatusEnum;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property int $id
 * @property string $equipment_name
 * @property string $equipment_type
 * @property string|null $model
 * @property string $serial_number
 * @property string|null $manufacturer
 * @property \Illuminate\Support\Carbon|null $purchase_date
 * @property string|null $location
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $warranty_period
 * @property \Illuminate\Support\Carbon|null $installation_date
 * @property \Illuminate\Support\Carbon|null $last_service_date
 * @property \Illuminate\Support\Carbon|null $next_service_date
 * @property string $equipment_condition
 * @property string|null $equipment_specifications
 * @property int|null $usage_duration
 * @property string|null $power_requirements
 * @property string|null $network_info
 * @property string|null $software_version
 * @property string|null $hardware_version
 * @property float|null $purchase_price
 * @property float|null $depreciation_value
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
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

    protected $casts = [
        'status' => EquipmentStatusEnum::class,
        'purchase_date' => 'date',
        'warranty_period' => 'date',
        'installation_date' => 'date',
        'last_service_date' => 'date',
        'next_service_date' => 'date',
        'usage_duration' => 'integer',
        'purchase_price' => 'decimal:2',
        'depreciation_value' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function images(): MorphMany
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

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d');
    }

    public function warrantyInformation():HasOne
    {
        return $this->hasOne(WarrantyInformation::class);
    }

    public function scopeAvailable($query): void
    {
        $query->where('status', EquipmentStatusEnum::AVAILABLE);
    }
}
