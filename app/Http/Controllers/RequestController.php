<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\WarrantyRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function index()
    {
        $entries = WarrantyRequest::with(['equipment', 'warrantyInformation'])->get();
        dd($entries);
        return view('requests.index');
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
}
