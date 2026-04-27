<?php

namespace App\Http\Controllers;

use App\Models\CourseAssignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

    public function history(Request $request)
    {
        $search = $request->search;
        $type = $request->type;

        $completedAssignments = CourseAssignment::with('courseCall.course')
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->when($search, fn($q) => $q->whereHas('courseCall.course', fn($q2) =>
            $q2->where('title', 'like', "%{$search}%")))
            ->when($type, fn($q) => $q->whereHas('courseCall.course', fn($q2) =>
            $q2->where('type', $type)))
            ->get();

        return view('dashboard.history', compact('completedAssignments'));
    }
}
