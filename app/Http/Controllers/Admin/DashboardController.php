<?php

namespace App\Http\Controllers\Admin;

use App\Models\Absensi;
use App\Models\Bidang;
use App\Models\User;
use Illuminate\View\View;

class DashboardController
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $totalKaryawan = User::where('role', 'karyawan')->count();
        $totalBidang = Bidang::count();

        // Rekap kehadiran hari ini
        $hariIni = date('Y-m-d');
        $rekapHariIni = Absensi::where('tanggal', $hariIni)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Grafik kehadiran mingguan
        $grafikMingguan = Absensi::where('tanggal', '>=', now()->subDays(7)->toDateString())
            ->selectRaw('DATE(tanggal) as tanggal, status, count(*) as total')
            ->groupBy('tanggal', 'status')
            ->get()
            ->groupBy('tanggal');

        // Karyawan terbaru
        $karyawanTerbaru = User::where('role', 'karyawan')
            ->with('bidang')
            ->latest('created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalKaryawan',
            'totalBidang',
            'rekapHariIni',
            'grafikMingguan',
            'karyawanTerbaru'
        ));
    }
}
