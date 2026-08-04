<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('agenda.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat agenda.');
        }

        $agendas = Agenda::orderBy('start_date', 'desc')->paginate(15);
        return view('admin.agendas.index', compact('agendas'));
    }

    public function create()
    {
        if (!auth()->user()->can('agenda.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah agenda.');
        }

        return view('admin.agendas.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('agenda.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah agenda.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'location'    => 'nullable|string|max:255',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'color'       => 'nullable|string|max:50',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Agenda::create($validated);

        return redirect()->route('admin.agendas.index')
                         ->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function show(Agenda $agenda)
    {
        if (!auth()->user()->can('agenda.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat agenda.');
        }

        return view('admin.agendas.show', compact('agenda'));
    }

    public function edit(Agenda $agenda)
    {
        if (!auth()->user()->can('agenda.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah agenda.');
        }

        return view('admin.agendas.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        if (!auth()->user()->can('agenda.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah agenda.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'location'    => 'nullable|string|max:255',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'color'       => 'nullable|string|max:50',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $agenda->update($validated);

        return redirect()->route('admin.agendas.index')
                         ->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda)
    {
        if (!auth()->user()->can('agenda.delete')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus agenda.');
        }

        $agenda->delete();

        return redirect()->route('admin.agendas.index')
                         ->with('success', 'Agenda berhasil dihapus.');
    }
}
