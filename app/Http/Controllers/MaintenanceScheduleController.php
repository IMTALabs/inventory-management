<?php

namespace App\Http\Controllers;

use App\Models\MaintenancePlan;
use App\Models\MaintenanceSchedule;
use App\Models\User;
use Illuminate\Http\Request;

class MaintenanceScheduleController extends Controller
{
    public function index(Request $request)
    {

    }

    public function create()
    {
        $maintenancePlansCompact = MaintenancePlan::select(['id', 'plan_name', 'frequency'])->get();
        $maintainersCompact = User::maintainers()->select(['id', 'name'])->get();

        return view('maintenance-schedules.create', compact([
            'maintenancePlansCompact',
            'maintainersCompact',
        ]));
    }

    public function store(Request $request)
    {

    }

    public function show(MaintenanceSchedule $maintenanceSchedule)
    {

    }

    public function edit(MaintenanceSchedule $maintenanceSchedule)
    {

    }

    public function update(Request $request, MaintenanceSchedule $maintenanceSchedule)
    {

    }

    public function destroy(MaintenanceSchedule $maintenanceSchedule)
    {

    }
}
