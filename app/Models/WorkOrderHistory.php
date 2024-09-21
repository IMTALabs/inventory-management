<?php

namespace App\Models;

use App\Enums\WorkOrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $work_order_id
 * @property WorkOrderStatusEnum $status
 */
class WorkOrderHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_id',
        'status',
    ];

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
