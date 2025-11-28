@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container-lg py-5">
    <!-- Header -->
    <div class="mb-5">
        <h1 class="fw-bold" style="color: #1f2937;">Profil Saya</h1>
        <p class="text-muted">Kelola informasi profil Anda</p>
    </div>

    <div class="row g-4">
        <!-- Profil Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <!-- Foto Profil -->
                    <div class="mb-4">
                        <img src="{{ auth()->user()->foto }}" alt="{{ auth()->user()->name }}" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 5px solid #f0f0f0; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
                    </div>

                    <!-- Nama -->
                    <h3 class="fw-bold mb-1" style="color: #1f2937;">{{ auth()->user()->name }}</h3>
                    <p class="text-muted mb-3">{{ auth()->user()->jabatan }}</p>

                    <!-- Badge Status -->
                    <div class="mb-4">
                        <span class="badge" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 8px 12px; font-size: 12px;">
                            <i class="fas fa-check-circle"></i> Karyawan Aktif
                        </span>
                    </div>

                    <!-- Info Detail -->
                    <div class="text-start mb-4">
                        <p class="mb-2"><small class="text-muted fw-bold">NIP:</small><br>
                            <small style="color: #1f2937;">{{ auth()->user()->nip }}</small>
                        </p>
                        <p class="mb-2"><small class="text-muted fw-bold">Email:</small><br>
                            <small style="color: #1f2937;">{{ auth()->user()->email }}</small>
                        </p>
                        <p class="mb-2"><small class="text-muted fw-bold">Bidang:</small><br>
                            <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                {{ auth()->user()->bidang->nama ?? '-' }}
                            </span>
                        </p>
                        <p class="mb-2"><small class="text-muted fw-bold">Jam Kerja:</small><br>
                            <small style="color: #1f2937;">{{ auth()->user()->jam_masuk }} - {{ auth()->user()->jam_pulang }}</small>
                        </p>
                    </div>

                    <!-- Edit Button -->
                    <a href="{{ route('karyawan.profile.edit') }}" class="btn w-100" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border: none;">
                        <i class="fas fa-edit"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistik Kehadiran -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);" class="text-white">
                    <h5 class="mb-0 text-white fw-bold"><i class="fas fa-chart-bar"></i> Statistik Kehadiran Bulan Ini</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 col-md-3 mb-3">
                            <div class="p-3" style="background: #ecfdf5; border-radius: 8px;">
                                <h6 style="color: #059669;"><i class="fas fa-check-circle"></i></h6>
                                <p class="text-muted small mb-0">Hadir</p>
                                <h2 class="fw-bold" style="color: #059669;">20</h2>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="p-3" style="background: #fffbeb; border-radius: 8px;">
                                <h6 style="color: #d97706;"><i class="fas fa-hourglass-start"></i></h6>
                                <p class="text-muted small mb-0">Terlambat</p>
                                <h2 class="fw-bold" style="color: #d97706;">2</h2>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="p-3" style="background: #fee2e2; border-radius: 8px;">
                                <h6 style="color: #dc2626;"><i class="fas fa-file-alt"></i></h6>
                                <p class="text-muted small mb-0">Izin</p>
                                <h2 class="fw-bold" style="color: #dc2626;">1</h2>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="p-3" style="background: #dbeafe; border-radius: 8px;">
                                <h6 style="color: #2563eb;"><i class="fas fa-hospital-user"></i></h6>
                                <p class="text-muted small mb-0">Sakit</p>
                                <h2 class="fw-bold" style="color: #2563eb;">0</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kehadiran Terbaru -->
            <div class="card border-0 shadow-sm">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" class="text-white">
                    <h5 class="mb-0 text-white fw-bold"><i class="fas fa-history"></i> Riwayat Kehadiran Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < 5; $i++)
                                    <tr>
                                        <td>{{ now()->subDays($i)->format('d/m/Y') }}</td>
                                        <td>08:15</td>
                                        <td>17:00</td>
                                        <td>
                                            @if ($i == 0)
                                                <span class="badge" style="background: #ecfdf5; color: #059669;">Hadir</span>
                                            @elseif ($i == 1)
                                                <span class="badge" style="background: #fffbeb; color: #d97706;">Terlambat</span>
                                            @else
                                                <span class="badge" style="background: #ecfdf5; color: #059669;">Hadir</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
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
</style>
@endsection
