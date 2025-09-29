<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\HakKeuanganController;
use App\Http\Controllers\BuktiPotongPajakController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Protected routes (require authentication)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Presensi (Attendance)
    Route::post('/presensi', [PresensiController::class, 'store'])->name('presensi.store');

    // Cuti (Leave Management)
    Route::get('/cuti', [CutiController::class, 'index'])->name('cuti.index');
    Route::post('/cuti', [CutiController::class, 'store'])->name('cuti.store');

    // Hak Keuangan (Financial Rights)
    Route::get('/hak-keuangan', [HakKeuanganController::class, 'index'])->name('hak-keuangan.index');

    // Bukti Potong Pajak (Tax Cut Evidence)
    Route::get('/bukti-potong-pajak', [BuktiPotongPajakController::class, 'index'])->name('bukti-potong-pajak.index');
    Route::get('/bukti-potong-pajak/{id}/view', [BuktiPotongPajakController::class, 'view'])->name('bukti-potong-pajak.view');
    Route::get('/bukti-potong-pajak/{id}/download', [BuktiPotongPajakController::class, 'download'])->name('bukti-potong-pajak.download');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
