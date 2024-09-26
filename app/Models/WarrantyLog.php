<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarrantyLog extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'warranty_request_id',
        'status',
        'log_date',
        'updated_by',
    ];

    public function warrantyRequest()
    {
        return $this->belongsTo(WarrantyRequest::class);
    }
}
