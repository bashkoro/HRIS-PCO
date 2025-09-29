<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Presensi;
use App\Models\Cuti;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class HRISSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test users
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@hris-pco.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'unit_kerja' => 'IT Department',
            'status_pns' => 'PNS',
            'status_kepegawaian' => 'Tetap',
            'sisa_cuti' => 12
        ]);

        $employee = User::create([
            'name' => 'John Doe',
            'email' => 'john@hris-pco.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'unit_kerja' => 'Human Resources',
            'status_pns' => 'Non-PNS',
            'status_kepegawaian' => 'Kontrak',
            'sisa_cuti' => 8
        ]);

        $employee2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@hris-pco.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'unit_kerja' => 'Finance',
            'status_pns' => 'PNS',
            'status_kepegawaian' => 'Tetap',
            'sisa_cuti' => 15
        ]);

        // Create sample attendance records for the past week
        $users = [$admin, $employee, $employee2];

        foreach ($users as $user) {
            for ($i = 7; $i >= 1; $i--) {
                $date = Carbon::now()->subDays($i);

                // Skip weekends
                if ($date->isWeekend()) {
                    continue;
                }

                $waktuMasuk = Carbon::createFromTime(8, rand(0, 30), 0);
                $waktuPulang = Carbon::createFromTime(17, rand(0, 30), 0);

                Presensi::create([
                    'user_id' => $user->id,
                    'tanggal' => $date->toDateString(),
                    'waktu_masuk' => $waktuMasuk->toTimeString(),
                    'waktu_pulang' => $waktuPulang->toTimeString(),
                    'is_late' => $waktuMasuk->hour >= 8 && $waktuMasuk->minute > 0,
                    'is_early_leave' => $waktuPulang->hour < 17,
                    'location_lat' => -6.200000 + (rand(-100, 100) / 10000),
                    'location_lng' => 106.816666 + (rand(-100, 100) / 10000),
                    'is_outside_office' => rand(0, 10) > 8, // 20% chance outside office
                    'total_jam_kerja' => $waktuPulang->diffInHours($waktuMasuk, true),
                    'keterangan' => rand(0, 10) > 8 ? 'WFH' : null
                ]);
            }
        }

        // Create sample leave requests
        $jenisOptions = ['Cuti Tahunan', 'Cuti Sakit', 'Cuti Melahirkan', 'Cuti Besar', 'Cuti Alasan Penting'];
        $statusOptions = ['pending', 'approved', 'rejected'];

        foreach ($users as $user) {
            for ($i = 0; $i < 3; $i++) {
                $startDate = Carbon::now()->addDays(rand(1, 30));
                $endDate = $startDate->copy()->addDays(rand(1, 5));

                Cuti::create([
                    'user_id' => $user->id,
                    'tanggal_mulai' => $startDate->toDateString(),
                    'tanggal_selesai' => $endDate->toDateString(),
                    'jenis_cuti' => $jenisOptions[array_rand($jenisOptions)],
                    'alasan' => 'Alasan cuti untuk keperluan ' . strtolower($jenisOptions[array_rand($jenisOptions)]),
                    'status' => $statusOptions[array_rand($statusOptions)],
                    'created_at' => Carbon::now()->subDays(rand(1, 15))
                ]);
            }
        }
    }
}
