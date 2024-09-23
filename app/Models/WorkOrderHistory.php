<?php

namespace App\Models;

use App\Enums\WorkOrderStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $work_order_id
 * @property WorkOrderStatusEnum $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property WorkOrder $workOrder
 */
class WorkOrderHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => WorkOrderStatusEnum::class,
        ];
    }

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
