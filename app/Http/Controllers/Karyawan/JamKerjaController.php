<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\View\View;

class JamKerjaController
{
    /**
     * Display jam kerja information.
     */
    public function index(): View
    {
        $user = auth()->user();

        $jamMasuk = $user->jam_masuk;
        $jamPulang = $user->jam_pulang;

        return view('karyawan.jam-kerja.index', compact('user', 'jamMasuk', 'jamPulang'));
    }
}
