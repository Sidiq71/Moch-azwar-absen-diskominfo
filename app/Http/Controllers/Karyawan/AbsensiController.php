<?php

namespace App\Http\Controllers\Karyawan;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AbsensiController
{
    /**
     * Display absensi form page.
     */
    public function index(): View
    {
        $user = auth()->user();
        $hari_ini = date('Y-m-d');

        // Check if user has already checked in today
        $absensiHariIni = Absensi::where('user_id', $user->id)
            ->where('tanggal', $hari_ini)
            ->first();

        // Get last 7 days of attendance
        $riwayatAbsensi = Absensi::where('user_id', $user->id)
            ->where('tanggal', '>=', now()->subDays(7)->toDateString())
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('karyawan.absensi.index', compact(
            'user',
            'absensiHariIni',
            'riwayatAbsensi'
        ));
    }

    /**
     * Store check-in attendance.
     */
    public function checkin(Request $request)
    {
        $user = auth()->user();
        $hari_ini = date('Y-m-d');
        $jam_sekarang = date('H:i:s');

        // Check if user already checked in today
        $existingAbsensi = Absensi::where('user_id', $user->id)
            ->where('tanggal', $hari_ini)
            ->first();

        if ($existingAbsensi) {
            return back()->with('error', 'Anda sudah melakukan absen masuk hari ini');
        }

        // Determine status
        $jam_masuk_user = $user->jam_masuk;
        $status = 'hadir';

        if ($jam_sekarang > $jam_masuk_user) {
            $status = 'terlambat';
        }

        // Create absensi record
        Absensi::create([
            'user_id' => $user->id,
            'tanggal' => $hari_ini,
            'jam_masuk' => $jam_sekarang,
            'status' => $status,
            'lokasi' => $request->input('lokasi', null),
        ]);

        return back()->with('success', 'Absen masuk berhasil. Status: ' . ucfirst($status));
    }

    /**
     * Store check-out attendance.
     */
    public function checkout(Request $request)
    {
        $user = auth()->user();
        $hari_ini = date('Y-m-d');
        $jam_sekarang = date('H:i:s');

        // Get absensi record for today
        $absensi = Absensi::where('user_id', $user->id)
            ->where('tanggal', $hari_ini)
            ->first();

        if (!$absensi) {
            return back()->with('error', 'Anda belum melakukan absen masuk');
        }

        if ($absensi->jam_pulang) {
            return back()->with('error', 'Anda sudah melakukan absen pulang');
        }

        // Update with checkout time
        $absensi->update([
            'jam_pulang' => $jam_sekarang,
        ]);

        return back()->with('success', 'Absen pulang berhasil');
    }

    /**
     * Display attendance history.
     */
    public function history(Request $request): View
    {
        $user = auth()->user();

        $query = Absensi::where('user_id', $user->id);

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $absensis = $query->orderBy('tanggal', 'desc')->paginate(20);

        return view('karyawan.absensi.history', compact('absensis', 'user'));
    }
}
