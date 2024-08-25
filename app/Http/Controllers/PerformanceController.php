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
            ->simplePaginate(30)
            ->withQueryString();
        return view('performance.history', compact('performanceHistories'));
    }
}
