<?php

namespace App\Models;

use App\Enums\MaintenanceScheduleStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $equipment_id
 * @property Carbon $maintenance_date
 * @property int $maintenance_plan_id
 * @property int $maintenance_schedule_id
 * @property int $performed_by
 * @property string|null $description
 * @property string|null $outcome
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Equipment $equipment
 * @property MaintenancePlan $maintenancePlan
 * @property MaintenanceSchedule $maintenanceSchedule
 * @property User $performer
 */
class MaintenanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'maintenance_date',
        'maintenance_plan_id',
        'maintenance_schedule_id',
        'performed_by',
        'description',
        'outcome',
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'outcome' => MaintenanceScheduleStatusEnum::class,
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function maintenancePlan(): BelongsTo
    {
        return $this->belongsTo(MaintenancePlan::class);
    }

    public function maintenanceSchedule(): BelongsTo
    {
        return $this->belongsTo(MaintenanceSchedule::class);
    }

    public function performer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
