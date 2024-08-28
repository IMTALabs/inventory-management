<?php

namespace App\Http\Controllers;

use App\Enums\MaintenancePlanFrequencyEnum;
use App\Models\Equipment;
use App\Models\MaintenancePlan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MaintenancePlanController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'plan_name' => 'nullable|string',
            'equipment_id' => 'nullable|exists:equipment,id',
            'frequency' => 'nullable|in:' . implode(',', array_column(MaintenancePlanFrequencyEnum::cases(), 'value')),
            'sort_by' => 'nullable|in:id,plan_name,equipment_equipment_name,frequency',
            'sort_order' => 'nullable|in:asc,desc',
        ]);

        $maintenancePlanQuery = MaintenancePlan::withAggregate('equipment', 'equipment_name');

        $maintenancePlanQuery->when($request->query('plan_name'), function (Builder $query) use ($request) {
            $query->where('plan_name', 'like', '%' . $request->query('plan_name') . '%');
        });

        $maintenancePlanQuery->when($request->query('equipment_id'), function (Builder $query) use ($request) {
            $query->where('equipment_id', $request->query('equipment_id'));
        });

        $maintenancePlanQuery->when($request->query('frequency'), function (Builder $query) use ($request) {
            $query->where('frequency', $request->query('frequency'));
        });

        $maintenancePlanQuery->when($request->query('sort_by'), function (Builder $query) use ($request) {
            $query->orderBy($request->query('sort_by'), $request->query('sort_order', 'desc'));
        }, function (Builder $query) {
            $query->orderBy('id', 'desc');
        });

        $maintenancePlans = $maintenancePlanQuery->paginate(10)->withQueryString();
        $equipmentsCompact = Equipment::select(['id', 'equipment_name'])->get();
        return view('maintenance-plans.index', compact([
            'maintenancePlans',
            'equipmentsCompact',
        ]));
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
            'equipment_id' => 'required|exists:equipment,id',
            'frequency' => 'required|in:' . implode(',', array_column(MaintenancePlanFrequencyEnum::cases(), 'value')),
            'description' => 'nullable|string',
        ]);

        $equipment = Equipment::find($request->equipment_id);

        $equipment->maintenancePlans()->create([
            'plan_name' => $request->plan_name,
            'frequency' => $request->frequency,
            'description' => $request->description,
        ]);

        return redirect()->route('maintenance-plans.index')->with('status', 'Maintenance plan created successfully.');
    }

    public function show(MaintenancePlan $maintenancePlan)
    {
        return view('maintenance-plans.show', compact([
            'maintenancePlan',
        ]));
    }

    public function edit(MaintenancePlan $maintenancePlan)
    {
        $equipmentsCompact = Equipment::select(['id', 'equipment_name'])->get();

        return view('maintenance-plans.edit', compact([
            'maintenancePlan',
            'equipmentsCompact',
        ]));
    }

    public function update(Request $request, MaintenancePlan $maintenancePlan)
    {
        $request->validate([
            'plan_name' => 'required|string',
            'equipment_id' => 'required|exists:equipment,id',
            'frequency' => 'required|in:' . implode(',', array_column(MaintenancePlanFrequencyEnum::cases(), 'value')),
            'description' => 'nullable|string',
        ]);

        $maintenancePlan->update([
            'plan_name' => $request->plan_name,
            'frequency' => $request->frequency,
            'description' => $request->description,
        ]);

        return redirect()->route('maintenance-plans.show', ['maintenancePlan' => $maintenancePlan])
            ->with('status', 'Maintenance plan updated successfully.');
    }

    public function destroy(MaintenancePlan $maintenancePlan)
    {
        $maintenancePlan->delete();
        return redirect()->back()->with('status', 'Maintenance plan deleted successfully.');
    }
}
