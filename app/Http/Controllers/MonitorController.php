<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Metric;
use Illuminate\Http\Request;

class MonitorController extends Controller
{
    public function show(Request $request)
    {
        $equipmentId = $request->query('equipment_id');

        $metrics = Metric::all();
        $equipments = Equipment::select(['id', 'equipment_name'])->get();
        $currentEquipment = Equipment::find($equipmentId);
        if ($currentEquipment) {
            $currentEquipment->performanceMetrics = $metrics->mapWithKeys(function (Metric $metric) use (
                $currentEquipment
            ) {
                return [
                    $metric->id => $currentEquipment->performanceMetrics()
                        ->where('metric_id', $metric->id)
                        ->orderBy('created_at', 'desc')
                        ->limit(10)->get()->reverse(),
                ];
            });
        }

        return view('monitor.show', compact('equipments', 'equipmentId', 'metrics', 'currentEquipment'));
    }

    public function fetchEquipment(Equipment $equipment)
    {
        $metrics = Metric::all();
        $performance = $metrics->mapWithKeys(function (Metric $metric) use ($equipment) {
            return [
                $metric->chart_key => $equipment->performanceMetrics()
                    ->where('metric_id', $metric->id)
                    ->orderBy('created_at', 'desc')
                    ->limit(10)->get()
                    ->map(function ($performance) {
                        return [
                            'created_at' => $performance->created_at->format('Y-m-d H:i:s'),
                            'metric_value' => $performance->metric_value,
                        ];
                    })
                    ->reverse()
                    ->values(),
            ];
        });

        return response()->json($performance);
    }
}
