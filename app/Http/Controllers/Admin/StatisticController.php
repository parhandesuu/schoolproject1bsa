<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('statistik.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat statistik.');
        }

        $statistics = Statistic::orderBy('order')->paginate(15);
        return view('admin.statistics.index', compact('statistics'));
    }

    public function create()
    {
        if (!auth()->user()->can('statistik.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah statistik.');
        }

        return view('admin.statistics.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('statistik.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah statistik.');
        }

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
                         ->with('success', 'Statistik berhasil ditambahkan.');
    }

    public function show(Statistic $statistic)
    {
        if (!auth()->user()->can('statistik.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat statistik.');
        }

        return view('admin.statistics.show', compact('statistic'));
    }

    public function edit(Statistic $statistic)
    {
        if (!auth()->user()->can('statistik.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah statistik.');
        }

        return view('admin.statistics.edit', compact('statistic'));
    }

    public function update(Request $request, Statistic $statistic)
    {
        if (!auth()->user()->can('statistik.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah statistik.');
        }

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
                         ->with('success', 'Statistik berhasil diperbarui.');
    }

    public function destroy(Statistic $statistic)
    {
        if (!auth()->user()->can('statistik.delete')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus statistik.');
        }

        $statistic->delete();

        return redirect()->route('admin.statistics.index')
                         ->with('success', 'Statistik berhasil dihapus.');
    }
}
