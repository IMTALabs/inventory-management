<?php

namespace App\Models;

use App\Enums\MaintenancePlanFrequencyEnum;
use App\Enums\MaintenancePlanStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $plan_name
 * @property int $equipment_id
 * @property MaintenancePlanFrequencyEnum $frequency
 * @property string $description
 * @property MaintenancePlanStatusEnum $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class MaintenancePlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_name',
        'equipment_id',
        'frequency',
        'description',
        'status',
    ];

    protected $casts = [
        'frequency' => MaintenancePlanFrequencyEnum::class,
        'status' => MaintenancePlanStatusEnum::class,
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function maintenanceSchedules(): HasMany
    {
        return $this->hasMany(MaintenanceSchedule::class);
    }
}
