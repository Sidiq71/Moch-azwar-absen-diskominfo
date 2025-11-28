@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-lg py-5">
    <!-- Header -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="fw-bold" style="color: #1f2937;">azwar Admin</h1>
                <p class="text-muted">Kelola absensi dan manajemen karyawan Diskominfo</p>
            </div>
            <div class="text-end">
                <p class="mb-0 text-muted">{{ date('l, d F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Row dengan gradient colors -->
    <div class="row mb-5 g-4">
        <!-- Total Karyawan -->
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-white-50 mb-1 small">Total Karyawan</p>
                            <h2 class="mb-0 fw-bold">{{ $totalKaryawan }}</h2>
                        </div>
                        <i class="fas fa-users fa-2x opacity-50"></i>
                    </div>
                    <small class="text-white-50 d-block mt-3">Seluruh karyawan aktif</small>
                </div>
            </div>
        </div>

        <!-- Total Bidang -->
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-white-50 mb-1 small">Total Bidang</p>
                            <h2 class="mb-0 fw-bold">{{ $totalBidang }}</h2>
                        </div>
                        <i class="fas fa-building fa-2x opacity-50"></i>
                    </div>
                    <small class="text-white-50 d-block mt-3">Unit organisasi</small>
                </div>
            </div>
        </div>

        <!-- Hadir Hari Ini -->
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-white-50 mb-1 small">Hadir Hari Ini</p>
                            <h2 class="mb-0 fw-bold">{{ $rekapHariIni->get('hadir', 0) ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                    <small class="text-white-50 d-block mt-3">Karyawan hadir</small>
                </div>
            </div>
        </div>

        <!-- Terlambat Hari Ini -->
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-white-50 mb-1 small">Terlambat Hari Ini</p>
                            <h2 class="mb-0 fw-bold">{{ $rekapHariIni->get('terlambat', 0) ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-clock fa-2x opacity-50"></i>
                    </div>
                    <small class="text-white-50 d-block mt-3">Karyawan terlambat</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row g-4 mb-5">
        <!-- Karyawan Terbaru -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" class="text-white">
                    <h5 class="mb-0 text-white fw-bold"><i class="fas fa-user-plus"></i> Karyawan Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-bold">Foto</th>
                                    <th class="fw-bold">Nama</th>
                                    <th class="fw-bold">Bidang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($karyawanTerbaru as $karyawan)
                                    <tr>
                                        <td>
                                            @php
                                                $fotoUrl = $karyawan->foto;
                                                if (!str_starts_with($fotoUrl, 'http')) {
                                                    $fotoUrl = asset('storage/' . $fotoUrl);
                                                }
                                            @endphp
                                            <img src="{{ $fotoUrl }}" alt="{{ $karyawan->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; background: #f0f0f0;" onerror="this.src='{{ asset('build/RobloxScreenShot20251113_092815183.png') }}'">
                                        </td>
                                        <td class="fw-500">{{ $karyawan->name }}</td>
                                        <td>
                                            <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                {{ $karyawan->bidang->nama ?? '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">Belum ada karyawan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rekap Kehadiran -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);" class="text-white">
                    <h5 class="mb-0 text-white fw-bold"><i class="fas fa-chart-pie"></i> Rekap Kehadiran - Hari Ini</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="p-3" style="background: #ecfdf5; border-radius: 8px;">
                                <h6 style="color: #059669;"><i class="fas fa-check-circle"></i> Hadir</h6>
                                <h2 class="fw-bold" style="color: #059669;">{{ $rekapHariIni->get('hadir', 0) ?? 0 }}</h2>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="p-3" style="background: #fffbeb; border-radius: 8px;">
                                <h6 style="color: #d97706;"><i class="fas fa-hourglass-start"></i> Terlambat</h6>
                                <h2 class="fw-bold" style="color: #d97706;">{{ $rekapHariIni->get('terlambat', 0) ?? 0 }}</h2>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="p-3" style="background: #fee2e2; border-radius: 8px;">
                                <h6 style="color: #dc2626;"><i class="fas fa-file-alt"></i> Izin</h6>
                                <h2 class="fw-bold" style="color: #dc2626;">{{ $rekapHariIni->get('izin', 0) ?? 0 }}</h2>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="p-3" style="background: #dbeafe; border-radius: 8px;">
                                <h6 style="color: #2563eb;"><i class="fas fa-hospital-user"></i> Sakit</h6>
                                <h2 class="fw-bold" style="color: #2563eb;">{{ $rekapHariIni->get('sakit', 0) ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);" class="text-white">
                    <h5 class="mb-0 text-white fw-bold"><i class="fas fa-zap"></i> Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.karyawan.create') }}" class="btn btn-lg me-3 mb-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                        <i class="fas fa-plus"></i> Tambah Karyawan
                    </a>
                    <a href="{{ route('admin.karyawan.index') }}" class="btn btn-lg me-3 mb-2" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border: none;">
                        <i class="fas fa-list"></i> Manajemen Karyawan
                    </a>
                    <a href="{{ route('admin.absensi.index') }}" class="btn btn-lg mb-2" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border: none;">
                        <i class="fas fa-clock"></i> Lihat Absensi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    }
    .btn {
        transition: all 0.3s ease;
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection
