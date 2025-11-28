<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController
{
    /**
     * Display the profile page.
     */
    public function show(): View
    {
        $user = auth()->user();
        return view('karyawan.profile.show', compact('user'));
    }

    /**
     * Show the form for editing the profile.
     */
    public function edit(): View
    {
        $user = auth()->user();
        return view('karyawan.profile.edit', compact('user'));
    }

    /**
     * Update the profile.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
            'password_current' => 'required_with:password|string',
        ]);

        // Verify current password if trying to change password
        if ($request->filled('password')) {
            if (!Hash::check($validated['password_current'], $user->password)) {
                return back()->with('error', 'Password lama tidak sesuai');
            }

            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        // Update foto
        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::delete($user->foto);
            }
            $path = $request->file('foto')->store('public/karyawan');
            $user->update(['foto' => $path]);
        }

        return redirect()->route('karyawan.profile.show')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
