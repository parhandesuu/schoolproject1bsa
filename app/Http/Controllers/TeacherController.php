<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display all active teachers and staff, separated into two groups.
     *
     * Teachers: those whose type/role is 'teacher' (guru).
     * Staff: those whose type/role is 'staff' (tenaga kependidikan).
     */
    public function index()
    {
        // Active teachers (type = 'teacher' or 'guru')
        $teachers = Teacher::where('is_active', true)
            ->where(function ($query) {
                $query->where('type', 'teacher')
                      ->orWhere('type', 'guru');
            })
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        // Active staff (type = 'staff' or 'tendik')
        $staff = Teacher::where('is_active', true)
            ->where(function ($query) {
                $query->where('type', 'staff')
                      ->orWhere('type', 'tendik');
            })
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        return view('teachers.index', compact('teachers', 'staff'));
    }
}
