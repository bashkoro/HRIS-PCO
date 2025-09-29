<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class PresensiController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'type' => 'required|in:masuk,pulang',
            'attendance_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = auth()->user();
        $today = Carbon::today();
        $now = Carbon::now();

        // Check if outside office area
        $isOutsideOffice = $this->isOutsideOffice($request->latitude, $request->longitude);

        // If outside office, require photo
        if ($isOutsideOffice && !$request->hasFile('attendance_photo')) {
            return response()->json([
                'success' => false,
                'message' => 'Foto kehadiran diperlukan untuk presensi di luar area kantor'
            ], 400);
        }

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('attendance_photo')) {
            $photo = $request->file('attendance_photo');
            $fileName = $user->id . '_' . $today->format('Y-m-d') . '_' . $request->type . '_' . time() . '.' . $photo->getClientOriginalExtension();
            $photoPath = $photo->storeAs('attendance_photos', $fileName, 'public');
        }

        // Check if attendance record exists for today
        $attendance = Presensi::firstOrCreate([
            'user_id' => $user->id,
            'tanggal' => $today
        ], [
            'location_lat' => $request->latitude,
            'location_lng' => $request->longitude,
            'is_outside_office' => $isOutsideOffice,
            'office_building' => $request->office_building
        ]);

        if ($request->type === 'masuk') {
            if ($attendance->waktu_masuk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan presensi masuk hari ini'
                ], 400);
            }

            $attendance->waktu_masuk = $now->format('H:i:s');
            $attendance->is_late = $now->format('H:i:s') > '08:00:00';

            // Save photo path for check-in
            if ($photoPath) {
                $attendance->photo_masuk = $photoPath;
            }

        } else { // pulang
            if (!$attendance->waktu_masuk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum melakukan presensi masuk hari ini'
                ], 400);
            }

            if ($attendance->waktu_pulang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan presensi pulang hari ini'
                ], 400);
            }

            $attendance->waktu_pulang = $now->format('H:i:s');
            $attendance->is_early_leave = $now->format('H:i:s') < '17:00:00';

            // Save photo path for check-out
            if ($photoPath) {
                $attendance->photo_pulang = $photoPath;
            }

            // Calculate total working hours
            if ($attendance->waktu_masuk) {
                $masuk = Carbon::createFromFormat('H:i:s', $attendance->waktu_masuk);
                $pulang = Carbon::createFromFormat('H:i:s', $attendance->waktu_pulang);
                $attendance->total_jam_kerja = $pulang->diffInHours($masuk, true);
            }
        }

        $attendance->save();

        return response()->json([
            'success' => true,
            'message' => 'Presensi ' . $request->type . ' berhasil dicatat',
            'data' => $attendance
        ]);
    }

    private function isOutsideOffice($lat, $lng)
    {
        // PCO Office coordinates
        $office1Lat = -6.169067;
        $office1Lng = 106.825635;
        $office2Lat = -6.1751660136989335;
        $office2Lng = 106.8311075439858;
        $radius = 100; // meters

        // Check distance to both offices
        $distanceToOffice1 = $this->calculateDistance($lat, $lng, $office1Lat, $office1Lng);
        $distanceToOffice2 = $this->calculateDistance($lat, $lng, $office2Lat, $office2Lng);

        // Return true if outside both offices
        return $distanceToOffice1 > $radius && $distanceToOffice2 > $radius;
    }

    private function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371000; // meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng/2) * sin($dLng/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earthRadius * $c;
    }
}
