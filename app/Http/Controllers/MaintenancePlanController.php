<?php

namespace App\Http\Controllers;

use App\Enums\MaintenancePlanFrequencyEnum;
use App\Models\Equipment;
use Illuminate\Http\Request;

class MaintenancePlanController extends Controller
{
    public function index()
    {
        return view('maintenance-plans.index');
    }

    public function create()
    {
        $equipmentsCompact = Equipment::select(['id', 'equipment_name'])->get();

        return view('maintenance-plans.create', compact([
            'equipmentsCompact',
        ]));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan_name' => 'required|string',
            'equipment_id' => 'required|exists:equipments,id',
            'frequency' => 'required|in:' . implode(',', array_column(MaintenancePlanFrequencyEnum::cases(), 'value')),
            'description' => 'nullable|string',
        ]);

        $equipment = Equipment::find($request->equipment_id);

        $equipment->maintenancePlans()->create([
            'frequency' => $request->frequency,
            'description' => $request->description,
        ]);

        return redirect()->route('maintenance-plans.index')->with('status', 'Maintenance plan created successfully.');
    }
}
