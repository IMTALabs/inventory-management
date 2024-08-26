<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Http\Request;

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
        ]);
        $equipment = Equipment::create($request->only('equipment_name', 'equipment_type', 'serial_number', 'equipment_condition'));
        return view('equipments.show', ['equipment' => $equipment]);
    }

    public function show(Equipment $equipment)
    {
        return view('equipments.show', compact('equipment'));
    }
    public function edit(Equipment $equipment)
    {
        return view('equipments.edit', compact('equipment'));
    }
}
