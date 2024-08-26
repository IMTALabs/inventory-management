<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $equipment_id
 * @property int $metric_id
 * @property float $metric_value
 * @property string $formatted_value
 */
class PerformanceMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'metric_id',
        'metric_value',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function metric(): BelongsTo
    {
        return $this->belongsTo(Metric::class);
    }
}
