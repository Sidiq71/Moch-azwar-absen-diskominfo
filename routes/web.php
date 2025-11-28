<?php

use App\Http\Controllers\Admin\AbsensiController as AdminAbsensiController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Karyawan\AbsensiController;
use App\Http\Controllers\Karyawan\JamKerjaController;
use App\Http\Controllers\Karyawan\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard or login
Route::get('/', function () {
    return auth()->check() 
        ? redirect()->route(auth()->user()->isAdmin() ? 'admin.dashboard' : 'karyawan.absensi')
        : redirect()->route('login');
});

// Auth Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Karyawan Management
    Route::resource('karyawan', KaryawanController::class);

    // Absensi Management
    Route::resource('absensi', AdminAbsensiController::class);
});

// Karyawan Routes
Route::middleware(['auth', 'karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
    // Absensi
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi');
    Route::post('/absensi/checkin', [AbsensiController::class, 'checkin'])->name('absensi.checkin');
    Route::post('/absensi/checkout', [AbsensiController::class, 'checkout'])->name('absensi.checkout');
    Route::get('/absensi/history', [AbsensiController::class, 'history'])->name('absensi.history');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Jam Kerja
    Route::get('/jam-kerja', [JamKerjaController::class, 'index'])->name('jam-kerja');
});
