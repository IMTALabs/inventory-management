<?php

namespace App\Http\Controllers;

use App\Enums\EquipmentStatusEnum;
use App\Enums\MaintenanceScheduleStatusEnum;
use App\Models\Equipment;
use App\Models\WarrantyRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function index()
    {
        $entries = WarrantyRequest::with(['equipment', 'warrantyInformation'])->paginate();
        return view('requests.index', compact('entries'));
    }

    public function create()
    {
        $equipment = Equipment::whereHas('warrantyInformation', function ($query) {
            $query->whereNotNull('id');
        })->get();
        return view('requests.create', compact('equipment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'request_date' => 'required|date',
            'issue_description' => 'required|string',
            'equipment_id' => 'required|exists:equipment,id',
        ]);
        $equiment = Equipment::with('warrantyInformation')->find($request->equipment_id);
        $warrantyInformation =  $equiment->warrantyInformation->id;
        $request->merge([
            'warranty_information_id' => $warrantyInformation,
            'status' => 'pending',
        ]);
        WarrantyRequest::create($request->all());

        return redirect()->route('requests.index');
    }
    public function show( $id)
    {
        $requestWarranty = WarrantyRequest::with(['equipment', 'warrantyInformation'])->find($id);
        return view('requests.show', compact('requestWarranty'));
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);
        $warrantyRequest = WarrantyRequest::find($id);
        $warrantyRequest->update($request->only('status'));
        $equipmentRequest = match ($request->status) {
            MaintenanceScheduleStatusEnum::CONFIRMED->value => EquipmentStatusEnum::UNDER_REPAIR->value,
            MaintenanceScheduleStatusEnum::COMPLETED->value => EquipmentStatusEnum::AVAILABLE->value,
            MaintenanceScheduleStatusEnum::CANCELLED->value => EquipmentStatusEnum::INACTIVE->value,
        };
        $warrantyRequest->equipment->update(['status' => $equipmentRequest]);
        return back()->with('status', 'Request status updated successfully.');
    }

}
