<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\Cuti;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = Carbon::today();

        // Check if user already has attendance today
        $todaysAttendance = Presensi::where('user_id', $user->id)
            ->where('tanggal', $today)
            ->first();

        // Get recent attendance history (last 10 records)
        $recentAttendance = Presensi::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->take(10)
            ->get();

        // Get attendance history with filters
        $year = request('year', date('Y'));
        $month = request('month', date('m'));

        $attendanceHistory = Presensi::where('user_id', $user->id)
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('dashboard.index', compact(
            'user',
            'todaysAttendance',
            'recentAttendance',
            'attendanceHistory',
            'year',
            'month'
        ));
    }
}
