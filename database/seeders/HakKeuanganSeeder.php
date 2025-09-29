<?php

namespace Database\Seeders;

use App\Models\HakKeuangan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HakKeuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $periods = ['2024-01', '2024-02', '2024-03', '2024-04', '2024-05', '2024-06', '2024-07', '2024-08', '2024-09', '2024-10', '2024-11', '2024-12'];

            foreach ($periods as $period) {
                $hakKeuangan = rand(8000000, 15000000); // Random salary between 8M - 15M
                $pph21 = $hakKeuangan * 0.05; // 5% tax
                $bpjs = $hakKeuangan * 0.04; // 4% BPJS
                $penghasilanBersih = $hakKeuangan - $pph21 - $bpjs;

                HakKeuangan::create([
                    'user_id' => $user->id,
                    'slip_gaji' => 'SG-' . strtoupper($user->name[0]) . '-' . str_replace('-', '', $period) . '-' . rand(1000, 9999),
                    'periode' => $period,
                    'status' => collect(['pending', 'approved', 'paid'])->random(),
                    'hak_keuangan' => $hakKeuangan,
                    'pph_21' => $pph21,
                    'iuran_bpjs' => $bpjs,
                    'penghasilan_bersih' => $penghasilanBersih,
                ]);
            }
        }
    }
}
