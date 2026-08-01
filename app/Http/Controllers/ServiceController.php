<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display all active services ordered by the order column.
     */
    public function index()
    {
        $services = Service::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('services.index', compact('services'));
    }
}
