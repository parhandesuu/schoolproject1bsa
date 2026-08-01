<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AgendaController extends Controller
{
    /**
     * Display all active agendas split into upcoming and past.
     */
    public function index()
    {
        $today = Carbon::today()->toDateString();

        // Upcoming agendas: start_date >= today, ordered ascending
        $upcomingAgendas = Agenda::where('is_active', true)
            ->where('start_date', '>=', $today)
            ->orderBy('start_date', 'asc')
            ->get();

        // Past agendas: start_date < today, ordered descending (most recent first)
        $pastAgendas = Agenda::where('is_active', true)
            ->where('start_date', '<', $today)
            ->orderBy('start_date', 'desc')
            ->get();

        return view('agendas.index', compact('upcomingAgendas', 'pastAgendas'));
    }
}
