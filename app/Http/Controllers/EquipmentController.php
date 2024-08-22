<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        $entries = Equipment::paginate();

        return view('equipments.index', compact('entries'));
    }
    public function create()
    {

    }
}
