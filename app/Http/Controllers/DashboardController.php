<?php

namespace App\Http\Controllers;

use App\Models\CourseAssignment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingAssignments = CourseAssignment::with('courseCall.course')
            ->where('user_id', auth()->id())
            ->where('status', '!=', 'completed')
            ->get();

        return view('dashboard.index', compact('pendingAssignments'));
    }

    public function history()
    {
        $completedAssignments = CourseAssignment::with('courseCall.course')
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->get();

        return view('dashboard.history', compact('completedAssignments'));
    }
}

