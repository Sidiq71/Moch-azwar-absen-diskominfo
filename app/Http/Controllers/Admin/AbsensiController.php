<?php

namespace App\Http\Controllers\Admin;

use App\Models\Absensi;
use App\Models\Bidang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AbsensiController
{
    /**
     * Display a listing of absensi.
     */
    public function index(Request $request): View
    {
        $query = Absensi::with('user.bidang');

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        } else {
            $query->where('tanggal', date('Y-m-d'));
        }

        // Filter berdasarkan bidang
        if ($request->filled('bidang_id')) {
            $query->whereHas('user', function ($q) {
                $q->where('bidang_id', request('bidang_id'));
            });
        }

        // Filter berdasarkan karyawan
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $absensis = $query->paginate(20);
        $bidangs = Bidang::all();
        $users = User::where('role', 'karyawan')->get();

        return view('admin.absensi.index', compact('absensis', 'bidangs', 'users'));
    }

    /**
     * Show the form for creating a new absensi.
     */
    public function create(): View
    {
        $users = User::where('role', 'karyawan')->get();
        return view('admin.absensi.create', compact('users'));
    }

    /**
     * Store a newly created absensi in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i:s',
            'jam_pulang' => 'nullable|date_format:H:i:s',
            'status' => 'required|in:hadir,terlambat,izin,sakit',
            'keterangan' => 'nullable|string',
        ]);

        Absensi::create($validated);

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Absensi berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified absensi.
     */
    public function edit(Absensi $absensi): View
    {
        $users = User::where('role', 'karyawan')->get();
        return view('admin.absensi.edit', compact('absensi', 'users'));
    }

    /**
     * Update the specified absensi in storage.
     */
    public function update(Request $request, Absensi $absensi)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i:s',
            'jam_pulang' => 'nullable|date_format:H:i:s',
            'status' => 'required|in:hadir,terlambat,izin,sakit',
            'keterangan' => 'nullable|string',
        ]);

        $absensi->update($validated);

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Absensi berhasil diperbarui');
    }

    /**
     * Remove the specified absensi from storage.
     */
    public function destroy(Absensi $absensi)
    {
        $absensi->delete();

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Absensi berhasil dihapus');
    }
}
