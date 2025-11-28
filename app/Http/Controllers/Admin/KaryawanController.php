<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bidang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class KaryawanController
{
    /**
     * Display a listing of karyawan.
     */
    public function index(Request $request): View
    {
        $query = User::where('role', 'karyawan')
            ->with('bidang');

        // Filter berdasarkan bidang
        if ($request->filled('bidang_id')) {
            $query->where('bidang_id', $request->bidang_id);
        }

        // Filter berdasarkan pencarian nama
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('nip', 'like', '%' . $request->search . '%');
        }

        $karyawans = $query->paginate(10);
        $bidangs = Bidang::all();

        return view('admin.karyawan.index', compact('karyawans', 'bidangs'));
    }

    /**
     * Show the form for creating a new karyawan.
     */
    public function create(): View
    {
        $bidangs = Bidang::all();
        return view('admin.karyawan.create', compact('bidangs'));
    }

    /**
     * Store a newly created karyawan in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nip' => 'required|string|unique:users,nip',
            'bidang_id' => 'required|exists:bidangs,id',
            'jabatan' => 'required|string|max:255',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_pulang' => 'required|date_format:H:i',
            'password' => 'required|string|min:6|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'karyawan';

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/karyawan');
            $validated['foto'] = Storage::url($path);
        } else {
            // Use default image from public folder
            $validated['foto'] = asset('build/RobloxScreenShot20251113_092815183.png');
        }

        User::create($validated);

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan');
    }

    /**
     * Display the specified karyawan.
     */
    public function show(User $karyawan): View
    {
        return view('admin.karyawan.show', compact('karyawan'));
    }

    /**
     * Show the form for editing the specified karyawan.
     */
    public function edit(User $karyawan): View
    {
        $bidangs = Bidang::all();
        return view('admin.karyawan.edit', compact('karyawan', 'bidangs'));
    }

    /**
     * Update the specified karyawan in storage.
     */
    public function update(Request $request, User $karyawan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $karyawan->id,
            'nip' => 'required|string|unique:users,nip,' . $karyawan->id,
            'bidang_id' => 'required|exists:bidangs,id',
            'jabatan' => 'required|string|max:255',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_pulang' => 'required|date_format:H:i',
            'password' => 'nullable|string|min:6|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (filled($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('foto')) {
            if ($karyawan->foto && strpos($karyawan->foto, 'ui-avatars.com') === false) {
                Storage::delete($karyawan->foto);
            }
            $path = $request->file('foto')->store('public/karyawan');
            $validated['foto'] = Storage::url($path);
        }

        $karyawan->update($validated);

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil diperbarui');
    }

    /**
     * Remove the specified karyawan from storage.
     */
    public function destroy(User $karyawan)
    {
        if ($karyawan->foto) {
            Storage::delete($karyawan->foto);
        }

        $karyawan->delete();

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil dihapus');
    }
}
