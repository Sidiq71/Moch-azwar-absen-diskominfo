<?php

namespace Database\Seeders;

use App\Models\Bidang;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed bidangs first
        $this->call(BidangSeeder::class);

        // Default photo URL from public folder
        $defaultPhoto = asset('build/RobloxScreenShot20251113_092815183.png');

        // Create admin user
        User::create([
            'name' => 'Admin Diskominfo',
            'email' => 'admin@diskominfo.local',
            'password' => Hash::make('password'),
            'nip' => '19800101202201001',
            'bidang_id' => null,
            'jabatan' => 'Administrator',
            'jam_masuk' => '08:00:00',
            'jam_pulang' => '17:00:00',
            'foto' => $defaultPhoto,
            'role' => 'admin',
        ]);

        // Create sample karyawan with default photo
        $bidangs = Bidang::all();

        foreach ($bidangs as $index => $bidang) {
            User::create([
                'name' => 'Karyawan ' . $bidang->nama,
                'email' => 'karyawan' . ($index + 1) . '@diskominfo.local',
                'password' => Hash::make('password'),
                'nip' => '198001010001000' . ($index + 1),
                'bidang_id' => $bidang->id,
                'jabatan' => 'Staff ' . $bidang->nama,
                'jam_masuk' => '08:00:00',
                'jam_pulang' => '17:00:00',
                'foto' => $defaultPhoto,
                'role' => 'karyawan',
            ]);
        }
    }
}
