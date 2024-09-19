<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $equipment_id
 * @property Carbon $maintenance_date
 * @property int $maintenance_plan_id
 * @property int $performed_by
 * @property string|null $description
 * @property string|null $outcome
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class MaintenanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'maintenance_date',
        'maintenance_plan_id',
        'performed_by',
        'description',
        'outcome',
    ];

    protected $casts = [
        'maintenance_date' => 'date',
    ];
}
