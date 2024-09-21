<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarrantyInformation extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'provider_name',
        'provider_address',
        'contact_info',
        'equipment_id',
        'warranty_start_date',
        'warranty_end_date',
    ];

    protected $casts = [
        'warranty_start_date' => 'date',
        'warranty_end_date' => 'date',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
