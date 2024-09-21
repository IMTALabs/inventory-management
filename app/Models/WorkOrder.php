<?php

namespace App\Models;

use App\Enums\WorkOrderStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $employee_id
 * @property int $equipment_id
 * @property int $created_by
 * @property WorkOrderStatusEnum $status
 * @property Carbon $due_date
 * @property string $notes
 * @property string $created_at
 * @property string $updated_at
 */
class WorkOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'equipment_id',
        'created_by',
        'status',
        'due_date',
        'notes',
    ];

    protected $casts = [
        'due_date' => 'date',
        'status' => WorkOrderStatusEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function workOrderHistories(): HasMany
    {
        return $this->hasMany(WorkOrderHistory::class);
    }
}
