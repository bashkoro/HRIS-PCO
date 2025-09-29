<?php

namespace App\Http\Controllers;

use App\Models\BuktiPotongPajak;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BuktiPotongPajakController extends Controller
{
    public function index(Request $request)
    {
        $query = BuktiPotongPajak::where('user_id', auth()->id());

        // Filter by periode
        if ($request->filled('periode')) {
            $query->where('periode', $request->periode);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('keterangan', 'like', "%{$search}%");
            });
        }

        $buktiPotongPajak = $query->orderBy('periode', 'desc')->paginate(10);

        // Get unique periods for filter dropdown
        $periods = BuktiPotongPajak::where('user_id', auth()->id())
                                  ->select('periode')
                                  ->distinct()
                                  ->orderBy('periode', 'desc')
                                  ->pluck('periode');

        return view('bukti-potong-pajak.index', compact('buktiPotongPajak', 'periods'));
    }

    public function view($id)
    {
        $buktiPotongPajak = BuktiPotongPajak::where('user_id', auth()->id())->findOrFail($id);

        // Return view for PDF or redirect to file
        return response()->json([
            'message' => 'Viewing bukti potong pajak',
            'data' => $buktiPotongPajak
        ]);
    }

    public function download($id)
    {
        $buktiPotongPajak = BuktiPotongPajak::where('user_id', auth()->id())->findOrFail($id);

        // In a real application, this would download the actual PDF file
        return response()->json([
            'message' => 'Downloading bukti potong pajak',
            'filename' => $buktiPotongPajak->file_path
        ]);
    }
}
