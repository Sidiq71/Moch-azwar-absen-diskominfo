<?php

namespace Database\Seeders;

use App\Models\Bidang;
use Illuminate\Database\Seeder;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bidangs = [
            ['nama' => 'APTIKA', 'deskripsi' => 'Aplikasi Teknologi Informasi dan Komunikasi'],
            ['nama' => 'Statistik', 'deskripsi' => 'Bidang Statistik dan Data'],
            ['nama' => 'IKP', 'deskripsi' => 'Inovasi dan Komunikasi Publik'],
            ['nama' => 'Persandian', 'deskripsi' => 'Bidang Persandian dan Keamanan'],
        ];

        foreach ($bidangs as $bidang) {
            Bidang::create($bidang);
        }
    }
}
