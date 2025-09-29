<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuti;

class CutiController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $cutiHistory = Cuti::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('cuti.index', compact('user', 'cutiHistory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jenis_cuti' => 'required|string|max:255',
            'alasan' => 'required|string|max:1000',
        ]);

        Cuti::create([
            'user_id' => auth()->id(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jenis_cuti' => $request->jenis_cuti,
            'alasan' => $request->alasan,
            'status' => 'pending'
        ]);

        return redirect()->route('cuti.index')
            ->with('success', 'Permohonan cuti berhasil diajukan');
    }
}
