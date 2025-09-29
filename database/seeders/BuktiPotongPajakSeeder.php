<?php

namespace Database\Seeders;

use App\Models\BuktiPotongPajak;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuktiPotongPajakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $keteranganTemplates = [
            'Bukti Potong PPh 21 untuk periode {periode}',
            'SPT Masa PPh 21 {periode}',
            'Bukti pemotongan pajak penghasilan pasal 21 periode {periode}',
            'Laporan pajak bulanan {periode}',
            'Form 1721-A1 periode {periode}',
            'Bukti setor pajak {periode}'
        ];

        foreach ($users as $user) {
            $periods = ['2024-01', '2024-02', '2024-03', '2024-04', '2024-05', '2024-06', '2024-07', '2024-08', '2024-09', '2024-10', '2024-11', '2024-12'];

            foreach ($periods as $period) {
                // Randomly make some documents unavailable
                $isAvailable = rand(1, 10) > 2; // 80% chance available

                $keterangan = str_replace('{periode}', \Carbon\Carbon::createFromFormat('Y-m', $period)->format('F Y'),
                    collect($keteranganTemplates)->random());

                BuktiPotongPajak::create([
                    'user_id' => $user->id,
                    'periode' => $period,
                    'file_path' => $isAvailable ? 'documents/bukti-potong-pajak/' . $user->id . '/' . $period . '.pdf' : null,
                    'keterangan' => $keterangan,
                    'is_available' => $isAvailable,
                ]);
            }
        }
    }
}
