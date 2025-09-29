<?php

namespace App\Http\Controllers;

use App\Models\HakKeuangan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HakKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = HakKeuangan::where('user_id', auth()->id());

        // Filter by periode
        if ($request->filled('periode')) {
            $query->where('periode', $request->periode);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('slip_gaji', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $hakKeuangan = $query->orderBy('periode', 'desc')->paginate(10);

        // Get unique periods for filter dropdown
        $periods = HakKeuangan::where('user_id', auth()->id())
                              ->select('periode')
                              ->distinct()
                              ->orderBy('periode', 'desc')
                              ->pluck('periode');

        return view('hak-keuangan.index', compact('hakKeuangan', 'periods'));
    }
}
