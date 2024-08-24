<?php

namespace App\Http\Controllers;

use App\Models\PerformanceMetric;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function history()
    {
        $performanceHistories = PerformanceMetric::with('equipment', 'metric')
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();
        return view('performance.history', compact('performanceHistories'));
    }
}
