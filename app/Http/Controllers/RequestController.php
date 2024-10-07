<?php

namespace App\Http\Controllers;

use App\Enums\EquipmentStatusEnum;
use App\Enums\MaintenanceScheduleStatusEnum;
use App\Enums\WorkOrderStatusEnum;
use App\Models\Equipment;
use App\Models\WarrantyRequest;
use App\Models\WorkOrder;
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
                    $query->where('equipment_name', 'like', "%$equipment_name%")
                        ->when(isset($request->sort_by) && $request->sort_by == 'equipment_name', function ($query) use ($request) {
                            $query->orderBy('equipment_name', $request->order_by ?? 'desc');
                        })->when(isset($request->sort_by) && $request->sort_by == 'warranty_name', function ($query) use ($request) {
                            $query->whereHas('warrantyInformation', function ($query) use ($request) {
                                $query->orderBy('warranty_name', $request->order_by ?? 'desc');
                            });
                        });
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
            ->orderBy(isset($request->sort_by) && $request->sort_by == 'status' ? 'status' : 'id', $request->order_by ?? 'desc')
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

            'issue_description' => 'required|string',
            'equipment_id' => 'required|exists:equipment,id',
        ]);
        $equiment = Equipment::with('warrantyInformation')->find($request->equipment_id);
        $warrantyInformation = $equiment->warrantyInformation->id;
        $request->merge([
            'warranty_information_id' => $warrantyInformation,
            'status' => 'pending',
            'created_by' => auth()->id(),
            'request_date' => now(),
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
            $status = $request->input('status');
            $data = ['status' => $status];

            if ($status == MaintenanceScheduleStatusEnum::CONFIRMED->value) {
                $data['request_date'] = now();
            }

            $warrantyRequest->update($data);

            $equipmentStatus = $this->determineEquipmentStatus($warrantyRequest, $status);

            if ($equipmentStatus) {
                $warrantyRequest->equipment->update(['status' => $equipmentStatus]);
            }

            $this->logWarrantyRequest($warrantyRequest);
            DB::commit();
            return back()->with('status', 'Request status updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Request status update failed.');
        }
    }

    private function determineEquipmentStatus($warrantyRequest, $status)
    {
        $equipmentStatus = null;

        switch ($status) {
            case MaintenanceScheduleStatusEnum::CONFIRMED->value:
                $equipmentStatus = EquipmentStatusEnum::UNDER_REPAIR->value;
                $this->archiveWorkOrder($warrantyRequest->equipment_id, WorkOrderStatusEnum::ACTIVE->value);
                break;

            case MaintenanceScheduleStatusEnum::COMPLETED->value:
                $workOrder = $this->checkWorkOrderArchived($warrantyRequest->equipment_id, WorkOrderStatusEnum::ARCHIVED->value);
                if ($workOrder) {
                    $equipmentStatus = $workOrder->due_date > now() ? EquipmentStatusEnum::AVAILABLE->value : EquipmentStatusEnum::IN_USE->value;
                } else {
                    $equipmentStatus = EquipmentStatusEnum::AVAILABLE->value;
                }
                break;
            case MaintenanceScheduleStatusEnum::CANCELLED->value:
                $workOrder = $this->checkWorkOrderArchived($warrantyRequest->equipment_id, WorkOrderStatusEnum::ARCHIVED->value);
                if ($workOrder) {
                    $equipmentStatus = $workOrder->due_date > now() ? EquipmentStatusEnum::AVAILABLE->value : EquipmentStatusEnum::IN_USE->value;
                } else {
                    $equipmentStatus = EquipmentStatusEnum::INACTIVE->value;
                }
                break;
        }

        return $equipmentStatus;
    }

    private function archiveWorkOrder($equipmentId, $status)
    {
        $workOrder = $this->checkWorkOrderArchived($equipmentId, $status);
        if ($workOrder) {
            $workOrder->update(['status' => WorkOrderStatusEnum::ARCHIVED->value]);
        }
    }

    private function checkWorkOrderArchived($equipmentId, $status)
    {
        return WorkOrder::where('equipment_id', $equipmentId)
            ->where('status', $status)
            ->first();
    }

    public function edit($id)
    {
        $equipment = Equipment::whereHas('warrantyInformation', function ($query) {
            $query->whereNotNull('id');
        })->get();
        $requestWarranty = WarrantyRequest::with(['equipment', 'warrantyInformation'])->find($id);
        return view('requests.edit', compact(['requestWarranty', 'equipment']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'request_date' => 'required|date',
            'issue_description' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $warrantyRequest = WarrantyRequest::find($id);
            $warrantyRequest->update($request->only('request_date', 'issue_description', 'equipment_id'));

            $this->logWarrantyRequest($warrantyRequest);

            DB::commit();
            return redirect()->route('requests.show', $id)->with('status', 'Request updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Request update failed.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $warrantyRequest = WarrantyRequest::find($id);
            if ($warrantyRequest) {
                $warrantyRequest->delete();
                DB::commit();
                return redirect()->route('requests.index')->with('status', 'Request deleted successfully.');
            } else {
                return redirect()->route('requests.index')->with('error', 'Request not found.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('requests.index')->with('error', 'Request deletion failed.');
        }
    }
}
