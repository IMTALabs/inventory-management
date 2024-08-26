<?php

namespace App\Http\Controllers;

use App\Models\Metric;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class MetricController extends Controller
{
    public function index()
    {
        $metrics = Metric::all();
        return view('metrics.index', compact('metrics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|array',
            'name.*' => 'nullable|string|max:255',
            'unit' => 'nullable|array',
            'unit.*' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            Metric::query()->delete();

            foreach (Arr::get($validated, 'name', []) as $index => $name) {
                $unit = Arr::get($validated, 'unit.' . $index);
                if (trim($name) !== '') {
                    Metric::create([
                        'name' => $name,
                        'unit' => $unit,
                    ]);
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['name' => 'Failed to create metrics.']);
        }

        return redirect()->route('metrics.index')->with('status', 'Metrics created successfully.');
    }
}
