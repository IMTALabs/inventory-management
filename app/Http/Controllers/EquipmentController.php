<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
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
}
