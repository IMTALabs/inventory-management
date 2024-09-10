<?php

namespace App\Models;

use App\Enums\MaintenanceScheduleStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $maintenance_plan_id
 * @property string $scheduled_date
 * @property MaintenanceScheduleStatusEnum $status
 * @property string $performed_by
 * @property string $remarks
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property MaintenancePlan $maintenancePlan
 * @property User $performer
 */
class MaintenanceSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'maintenance_plan_id',
        'scheduled_date',
        'status',
        'performed_by',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'status' => MaintenanceScheduleStatusEnum::class,
        ];
    }

    public function maintenancePlan(): BelongsTo
    {
        return $this->belongsTo(MaintenancePlan::class);
    }

    public function performer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by', 'id');
    }
}
