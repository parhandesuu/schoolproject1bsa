<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        $statistics = Statistic::orderBy('order')->paginate(15);
        return view('admin.statistics.index', compact('statistics'));
    }

    public function create()
    {
        return view('admin.statistics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label'     => 'required|string|max:255',
            'value'     => 'required|string|max:100',
            'icon'      => 'nullable|string|max:100',
            'color'     => 'nullable|string|max:50',
            'order'     => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Statistic::create($validated);

        return redirect()->route('admin.statistics.index')
                         ->with('success', 'Statistic created successfully.');
    }

    public function show(Statistic $statistic)
    {
        return view('admin.statistics.show', compact('statistic'));
    }

    public function edit(Statistic $statistic)
    {
        return view('admin.statistics.edit', compact('statistic'));
    }

    public function update(Request $request, Statistic $statistic)
    {
        $validated = $request->validate([
            'label'     => 'required|string|max:255',
            'value'     => 'required|string|max:100',
            'icon'      => 'nullable|string|max:100',
            'color'     => 'nullable|string|max:50',
            'order'     => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $statistic->update($validated);

        return redirect()->route('admin.statistics.index')
                         ->with('success', 'Statistic updated successfully.');
    }

    public function destroy(Statistic $statistic)
    {
        $statistic->delete();

        return redirect()->route('admin.statistics.index')
                         ->with('success', 'Statistic deleted successfully.');
    }
}
