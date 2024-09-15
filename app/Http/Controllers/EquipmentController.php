<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->name;
        $type = $request->type;
        $location = $request->location;
        $status = $request->status;
        $condition = $request->condition;

        $entries = Equipment::query()->when($name, function ($query) use ($name) {
            $query->where('equipment_name', 'like', "%$name%");
        })
            ->when($condition, function ($query) use ($condition) {
                $query->where('equipment_condition', $condition);
            })
            ->when($type, function ($query) use ($type) {
                $query->where('equipment_type', $type);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('equipment_type', $status);
            })
            ->when($location, function ($query) use ($location) {
                $query->where('model', 'like', "%$location%");
            })
            ->orderBy('id', 'desc')
            ->paginate(5)
            ->withQueryString();

        return view('equipments.index', compact(['entries', 'name', 'type', 'status','location', 'condition']));
    }

    public function create()
    {
        return view('equipments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipment_name' => 'required|string|max:255',
            'equipment_type' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:equipment,serial_number',
            'equipment_condition' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'warranty_period' => 'nullable|date',
            'installation_date' => 'nullable|date',
            'last_service_date' => 'nullable|date',
            'next_service_date' => 'nullable|date',
            'equipment_specifications' => 'nullable|string',
            'usage_duration' => 'nullable|integer',
            'power_requirements' => 'nullable|string|max:255',
            'network_info' => 'nullable|string|max:255',
            'software_version' => 'nullable|string|max:255',
            'hardware_version' => 'nullable|string|max:255',
            'purchase_price' => 'nullable|numeric',
            'depreciation_value' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $equipment = Equipment::create($request->all());
//            "3,4"
            if(trim($request->additional_data) != "") {
                $additionalData = json_decode($request->additional_data, true);
                Image::whereIn('id', $additionalData)->update(['imageable_id' => $equipment->id]);
            }
            DB::commit();
            return view('equipments.show', ['equipment' => $equipment]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->with('error', 'An error occurred while creating the equipment');
        }
    }

    public function show(Equipment $equipment)
    {
        return view('equipments.show', compact('equipment'));
    }

    public function edit(Equipment $equipment)
    {
        return view('equipments.edit', compact('equipment'));
    }

    public function update(Equipment $equipment, Request $request)
    {
        $request->validate([
            'equipment_name' => 'required|string|max:255',
            'equipment_type' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:equipment,serial_number,' . $equipment->id,
            'equipment_condition' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'warranty_period' => 'nullable|date',
            'installation_date' => 'nullable|date',
            'last_service_date' => 'nullable|date',
            'next_service_date' => 'nullable|date',
            'equipment_specifications' => 'nullable|string',
            'usage_duration' => 'nullable|integer',
            'power_requirements' => 'nullable|string|max:255',
            'network_info' => 'nullable|string|max:255',
            'software_version' => 'nullable|string|max:255',
            'hardware_version' => 'nullable|string|max:255',
            'purchase_price' => 'nullable|numeric',
            'depreciation_value' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $equipment->update($request->all());

            if ($request->use_old_image !== 'on' && trim($request->additional_data) != "") {
                $equipment->images()->delete();
                $additionalData = json_decode($request->additional_data, true);
                Image::whereIn('id', $additionalData)->update(['imageable_id' => $equipment->id]);
            }

            DB::commit();
            return to_route('equipments.edit', ['equipment' => $equipment])->with('status', 'Equipment updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while updating the equipment');
        }
    }

    public function destroy(Equipment $equipment)
    {
        DB::beginTransaction();
        try {
            $equipment->delete();
            Storage::delete($equipment->images->pluck('image')->toArray());
            $equipment->images()->delete();
            DB::commit();
            return redirect()->route('equipments.index')->with('success', 'Equipment deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while deleting the equipment');
        }
    }

    public function image(Request $request)
    {
        $image = $request->file;
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = $image->storeAs('images', $imageName, 'public');

        $image = Image::create([
            'image' => $imagePath,
            'imageable_type' => Equipment::class,
        ]);
        return response()->json(['image_path' => $image->id]);
    }
}
