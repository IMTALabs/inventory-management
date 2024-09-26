<?php

namespace App\Http\Controllers;

use App\Enums\EquipmentStatusEnum;
use App\Enums\MaintenanceScheduleStatusEnum;
use App\Models\Equipment;
use App\Models\WarrantyRequest;
use App\Trait\RequestLogWarrantyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    use RequestLogWarrantyTrait;

    public function index(Request $request)
    {
        $equipment_name = $request->equipment_name;
        $status = $request->status;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $request->validate([
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after:from_date',
        ]);
        $entries = WarrantyRequest::query()->when($equipment_name, function ($query) use ($equipment_name) {
            $query->when($equipment_name, function ($query) use ($equipment_name) {
                $query->whereHas('equipment', function ($query) use ($equipment_name) {
                    $query->where('equipment_name', 'like', "%$equipment_name%");
                });
            });

        })
            ->when(isset($from_date) && isset($to_date), function ($query) use ($from_date, $to_date) {
                $query->whereBetween('request_date', [$from_date, $to_date]);
            })
            ->when(isset($status), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->with(['equipment', 'warrantyInformation'])
            ->orderBy('id', 'desc')
            ->paginate(5)
            ->withQueryString();
        return view('requests.index', compact(['entries', 'equipment_name', 'status', 'from_date', 'to_date']));
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
        $warrantyInformation = $equiment->warrantyInformation->id;
        $request->merge([
            'warranty_information_id' => $warrantyInformation,
            'status' => 'pending',
        ]);
        $warrantyRequest = WarrantyRequest::create($request->all());
        $this->logWarrantyRequest($warrantyRequest);
        return redirect()->route('requests.index');
    }

    public function show($id)
    {
        $requestWarranty = WarrantyRequest::with(['equipment', 'warrantyInformation'])->find($id);
        return view('requests.show', compact('requestWarranty'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $warrantyRequest = WarrantyRequest::find($id);
            $warrantyRequest->update($request->only('status'));
            $equipmentRequest = match ($request->status) {
                MaintenanceScheduleStatusEnum::CONFIRMED->value => EquipmentStatusEnum::UNDER_REPAIR->value,
                MaintenanceScheduleStatusEnum::COMPLETED->value => EquipmentStatusEnum::AVAILABLE->value,
                MaintenanceScheduleStatusEnum::CANCELLED->value => EquipmentStatusEnum::INACTIVE->value,
            };
            $warrantyRequest->equipment->update(['status' => $equipmentRequest]);
            $this->logWarrantyRequest($warrantyRequest);
            DB::commit();
            return back()->with('status', 'Request status updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->with('error', 'Request status update failed.');
        }

    }

}
