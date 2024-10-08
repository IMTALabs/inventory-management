<?php

namespace App\Models;

use App\Enums\MaintenanceScheduleStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarrantyRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'request_date',
        'issue_description',
        'status',
        'equipment_id',
        'warranty_information_id',
        'created_by'
    ];

    protected $casts = [
        'request_date' => 'date',
        'status' => MaintenanceScheduleStatusEnum::class,
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function warrantyInformation(): BelongsTo
    {
        return $this->belongsTo(WarrantyInformation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
