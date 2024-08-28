<?php

namespace App\Models;

use App\Enums\MaintenancePlanFrequencyEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $plan_name
 * @property int $equipment_id
 * @property MaintenancePlanFrequencyEnum $frequency
 * @property string $description
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
    ];

    protected $casts = [
        'frequency' => MaintenancePlanFrequencyEnum::class,
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
