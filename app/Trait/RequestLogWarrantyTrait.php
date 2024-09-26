<?php

namespace App\Trait;

use App\Models\WarrantyLog;

trait RequestLogWarrantyTrait
{
    public function logWarrantyRequest($warrantyRequest)
    {
        WarrantyLog::query()->create([
            'warranty_request_id' => $warrantyRequest->id,
            'status' => $warrantyRequest->status,
            'log_date' => now(),
            'updated_by' => auth()->id(),
        ]);
    }
}
