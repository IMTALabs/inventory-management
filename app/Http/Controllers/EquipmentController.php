<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Image;
use App\Models\WarrantyInformation;
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
                $query->where('status', $status);
            })
            ->when($location, function ($query) use ($location) {
                $query->where('model', 'like', "%$location%");
            })
            ->orderBy($request->sort_by ?? 'id', $request->sort_order ?? 'desc')
            ->paginate(5)
            ->withQueryString();

        return view('equipments.index', compact(['entries', 'name', 'type', 'status', 'location', 'condition']));
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
            'model' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'location' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'warranty_period' => 'required|date',
            'installation_date' => 'required|date',
            'last_service_date' => 'required|date',
            'next_service_date' => 'required|date',
            'equipment_specifications' => 'required|string',
            'usage_duration' => 'required|integer',
            'power_requirements' => 'required|string|max:255',
            'network_info' => 'required|string|max:255',
            'software_version' => 'required|string|max:255',
            'hardware_version' => 'required|string|max:255',
            'purchase_price' => 'required|numeric',
            'depreciation_value' => 'required|numeric',
            'notes' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $equipment = Equipment::create($request->all());
//            "3,4"
            if (trim($request->additional_data) != "") {
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
            'model' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'location' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'warranty_period' => 'required|date',
            'installation_date' => 'required|date',
            'last_service_date' => 'required|date',
            'next_service_date' => 'required|date',
            'equipment_specifications' => 'required|string',
            'usage_duration' => 'required|integer',
            'power_requirements' => 'required|string|max:255',
            'network_info' => 'required|string|max:255',
            'software_version' => 'required|string|max:255',
            'hardware_version' => 'required|string|max:255',
            'purchase_price' => 'required|numeric',
            'depreciation_value' => 'required|numeric',
            'notes' => 'required|string',
            'provider_name' => 'required|string',
            'provider_address' => 'required|string',
            'contact_info' => 'required|string',
            'warranty_start_date' => 'required|date',
            'warranty_end_date' => 'required|date',
        ]);
        DB::beginTransaction();
        try {
            $equipment->update($request->only([
                'equipment_name',
                'equipment_type',
                'serial_number',
                'equipment_condition',
                'model',
                'manufacturer',
                'purchase_date',
                'location',
                'status',
                'warranty_period',
                'installation_date',
                'last_service_date',
                'next_service_date',
                'equipment_specifications',
                'usage_duration',
                'power_requirements',
                'network_info',
                'software_version',
                'hardware_version',
                'purchase_price',
                'depreciation_value',
                'notes',
            ]));
            WarrantyInformation::updateOrCreate(
                ['equipment_id' => $equipment->id],
                $request->only([
                    'provider_name',
                    'provider_address',
                    'contact_info',
                    'warranty_start_date',
                    'warranty_end_date'
                ])
            );
            if ($request->use_old_image !== 'on' && trim($request->additional_data) != "") {
                $equipment->images()->delete();
                $additionalData = json_decode($request->additional_data, true);
                Image::whereIn('id', $additionalData)->update(['imageable_id' => $equipment->id]);
            }

            DB::commit();
            return to_route('equipments.edit', ['equipment' => $equipment])->with('status', 'Equipment updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
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

    public function deleteImage(Request $request, int $id)
    {
        try {
            Image::find($id)->delete();
            return back()->with('status', 'Image deleted successfully');
        } catch (\Exception $e) {
//            $debug = de($request->debug)  $e->getMessage();
            return response()->json(['error' => 'An error occurred while deleting the image' . $e->getMessage()], 500);
        }

    }

    public function deleteAllImage($id)
    {
        try {
            Image::where('imageable_type', Equipment::class)->where('imageable_id', $id)->delete();
            return back()->with('status', 'All image deleted successfully');
        } catch (\Exception $e) {
//            $debug = de($request->debug)  $e->getMessage();
            return response()->json(['error' => 'An error occurred while deleting the image' . $e->getMessage()], 500);
        }
    }
}
