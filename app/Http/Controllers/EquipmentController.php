<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {

        $name = $request->name;
        $type = $request->type;
        $model = $request->model;

        $entries = Equipment::query()->when($name, function ($query) use ($name) {
            $query->where('equipment_name', 'like', "%$name%");
        })
            ->when($name, function ($query) use ($type) {
                $query->where('equipment_type', 'like', "%$type%");
            })
            ->when($name, function ($query) use ($model) {
                $query->where('model', 'like', "%$model%");
            })
            ->orderBy('id', 'desc')
            ->paginate(5)->withQueryString();

        return view('equipments.index', compact(['entries', 'name', 'type', 'model']));
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
            'serial_number' => 'required|numeric|unique:equipment,serial_number',
            'equipment_condition' => 'required',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $equipment = Equipment::create($request->only('equipment_name', 'equipment_type', 'serial_number', 'equipment_condition'));

            // Process additional data
            $additionalData = json_decode($request->input('additional_data'));
            foreach ($additionalData as $image) {
                $imageName = time() . '_' . $image->upload->filename;
                $imagePath = Storage::disk('public')->putFileAs('images', $image->dataURL, $imageName);

                $equipment->images()->create(['image' => $imagePath]);
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
            'serial_number' => 'required|numeric|unique:equipment,serial_number,' . $equipment->id,
            'equipment_condition' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $equipment->update($request->only('equipment_name', 'equipment_type', 'serial_number', 'equipment_condition'));

            if ($request->use_old_image !== 'on') {
//                dd($request);
                $request->validate([
                    'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);

                // Delete old images from storage
                Storage::delete($equipment->images->pluck('image')->toArray());

                // Delete old images from database
                $equipment->images()->delete();

                // Save new images
                foreach ($request->file('images') as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $imagePath = $image->storeAs('images', $imageName, 'public');

                    $equipment->images()->create(['image' => $imagePath]);
                }
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
//        $image = $request->file;
//        $imageName = time() . '_' . $image->getClientOriginalName();
//        $imagePath = $image->storeAs('images', $imageName, 'public');
        return response()->json(['image_path' => $request]);
    }
}
