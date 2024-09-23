<?php

namespace App\Http\Controllers;

use App\Enums\EquipmentStatusEnum;
use App\Enums\WorkOrderStatusEnum;
use App\Models\Equipment;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkOrderController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'equipment_id' => 'nullable|exists:equipment,id',
            'status' => 'nullable|in:' . implode(',', array_column(WorkOrderStatusEnum::cases(), 'value')),
            'sort_by' => 'nullable|in:id,user_name,equipment_equipment_name,due_date',
            'sort_order' => 'nullable|in:asc,desc',
        ]);

        $workOrderQuery = WorkOrder::with(['user', 'equipment'])
            ->withAggregate('user', 'name')
            ->withAggregate('equipment', 'equipment_name');

        $workOrderQuery->when($request->query('user_id'), function ($query) use ($request) {
            $query->where('user_id', $request->query('user_id'));
        });

        $workOrderQuery->when($request->query('equipment_id'), function ($query) use ($request) {
            $query->where('equipment_id', $request->query('equipment_id'));
        });

        $workOrderQuery->when($request->query('status'), function ($query) use ($request) {
            $query->where('status', $request->query('status'));
        });

        $workOrderQuery->when($request->query('sort_by'), function ($query) use ($request) {
            $query->orderBy($request->query('sort_by'), $request->query('sort_order', 'desc'));
        }, function ($query) {
            $query->orderBy('id', 'desc');
        });

        $workOrders = $workOrderQuery->paginate(10)->onEachSide(0);

        $equipmentsCompact = Equipment::select(['id', 'equipment_name'])->get();
        $usersCompact = User::select(['id', 'name'])->get();

        return view('work-orders.index', compact(
            'workOrders',
            'equipmentsCompact',
            'usersCompact'
        ));
    }

    public function create()
    {
        $usersCompact = User::notAdmin()->select(['id', 'name'])->get();
        $equipmentsCompact = Equipment::available()->select(['id', 'equipment_name'])->get();

        return view('work-orders.create', compact(
            'usersCompact',
            'equipmentsCompact'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'equipment_id' => 'required|exists:equipment,id',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ], [
            'user_id.required' => 'The user field is required.',
            'user_id.exists' => 'The selected user is invalid.',
            'equipment_id.required' => 'The equipment field is required.',
            'equipment_id.exists' => 'The selected equipment is invalid.',
        ]);

        $isEquipmentUnavailable = WorkOrder::where('equipment_id', $request->equipment_id)
            ->whereIn('status', WorkOrderStatusEnum::unavailableStatuses())
            ->exists();
        if ($isEquipmentUnavailable) {
            return back()->withErrors([
                "equipment_id" => "The equipment is currently unavailable.",
            ])->withInput();
        }

        $data = $request->all();
        $data['status'] = WorkOrderStatusEnum::PENDING;
        $data['created_by'] = Auth::id();
        $workOrder = WorkOrder::create($data);
        if ($workOrder) {
            Equipment::find($request->equipment_id)->update([
                'status' => EquipmentStatusEnum::PENDING_DISPOSAL,
            ]);
        }

        return redirect()->route('work-orders.index')->with('status', 'Work order created successfully.');
    }

    public function show(WorkOrder $workOrder)
    {
        $workOrder->load('user', 'equipment', 'workOrderHistories');

        return view('work-orders.show', compact('workOrder'));
    }

    public function updateStatus(WorkOrder $workOrder, Request $request)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', array_column(WorkOrderStatusEnum::cases(), 'value')),
        ]);

        $status = $request->input('status');

        $workOrder->update([
            'status' => $status,
        ]);

        switch ($status) {
            case WorkOrderStatusEnum::ACTIVE->value:
                $workOrder->workOrderHistories()->create([
                    'status' => WorkOrderStatusEnum::ACTIVE,
                    'created_by' => Auth::id(),
                ]);
                $workOrder->equipment()->update([
                    'status' => EquipmentStatusEnum::IN_USE,
                ]);
                break;
            case WorkOrderStatusEnum::COMPLETED->value:
                $workOrder->workOrderHistories()->create([
                    'status' => WorkOrderStatusEnum::COMPLETED,
                    'created_by' => Auth::id(),
                ]);
                $workOrder->equipment()->update([
                    'status' => EquipmentStatusEnum::AVAILABLE,
                ]);
                break;
            case WorkOrderStatusEnum::CANCELLED->value:
                $workOrder->workOrderHistories()->create([
                    'status' => WorkOrderStatusEnum::CANCELLED,
                    'created_by' => Auth::id(),
                ]);
                $workOrder->equipment()->update([
                    'status' => EquipmentStatusEnum::AVAILABLE,
                ]);
                break;
        }

        return redirect()->route('work-orders.show', $workOrder)->with('status',
            'Work order status updated successfully.');
    }

    public function edit(WorkOrder $workOrder)
    {
        $usersCompact = User::notAdmin()->select(['id', 'name'])->get();
        $equipmentsCompact = Equipment::where('status', EquipmentStatusEnum::AVAILABLE)
            ->orWhere('id', $workOrder->equipment_id)
            ->select(['id', 'equipment_name'])->get();

        return view('work-orders.edit', compact(
            'workOrder',
            'usersCompact',
            'equipmentsCompact'
        ));
    }

    public function update(WorkOrder $workOrder, Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'equipment_id' => 'required|exists:equipment,id',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ], [
            'user_id.required' => 'The user field is required.',
            'user_id.exists' => 'The selected user is invalid.',
            'equipment_id.required' => 'The equipment field is required.',
            'equipment_id.exists' => 'The selected equipment is invalid.',
        ]);

        $isEquipmentUnavailable = WorkOrder::where('equipment_id', $request->equipment_id)
            ->where('id', '!=', $workOrder->id)
            ->whereIn('status', WorkOrderStatusEnum::unavailableStatuses())
            ->exists();
        if ($isEquipmentUnavailable) {
            return back()->withErrors([
                "equipment_id" => "The equipment is currently unavailable.",
            ])->withInput();
        }

        $oldEquipmentId = $workOrder->equipment_id;
        $workOrder->update($request->all());
        $newEquipmentId = $workOrder->equipment_id;
        if ($oldEquipmentId != $newEquipmentId) {
            Equipment::find($oldEquipmentId)->update([
                'status' => EquipmentStatusEnum::AVAILABLE,
            ]);
            Equipment::find($newEquipmentId)->update([
                'status' => EquipmentStatusEnum::PENDING_DISPOSAL,
            ]);
        }

        return redirect()->route('work-orders.show', $workOrder)->with('status', 'Work order updated successfully.');
    }

    public function destroy(WorkOrder $workOrder)
    {
        $workOrder->delete();

        return redirect()->route('work-orders.index')->with('status', 'Work order deleted successfully.');
    }
}
