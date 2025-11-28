@extends('layouts.app')

@section('title', 'Absensi')

@section('content')
<div class="container-lg my-4">
    <h1 class="mb-4">Form Absensi</h1>

    <div class="row">
        <!-- Main Absensi Cards -->
        <div class="col-md-8 mb-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Absen Hari Ini - {{ date('d/m/Y H:i:s') }}</h5>
                </div>
                <div class="card-body">
                    @if ($absensiHariIni)
                        <div class="alert alert-info">
                            <h6>Status Absensi Hari Ini:</h6>
                            <p class="mb-0">
                                <strong>Jam Masuk:</strong> {{ $absensiHariIni->jam_masuk ?? 'Belum absen masuk' }}<br>
                                <strong>Status:</strong> <span class="badge bg-{{ $absensiHariIni->status == 'hadir' ? 'success' : 'warning' }}">{{ ucfirst($absensiHariIni->status) }}</span>
                            </p>
                            @if ($absensiHariIni->jam_pulang)
                                <p class="mb-0"><strong>Jam Pulang:</strong> {{ $absensiHariIni->jam_pulang }}</p>
                            @else
                                <form action="{{ route('karyawan.absensi.checkout') }}" method="POST" class="mt-3">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-sign-out-alt"></i> Absen Pulang
                                    </button>
                                </form>
                            @endif
                        </div>
                    @else
                        <div class="row text-center">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <i class="fas fa-sign-in-alt fa-3x text-primary mb-3"></i>
                                    <h6>Absen Masuk</h6>
                                    <p class="text-muted text-sm">Jam kerja: {{ $user->jam_masuk }} - {{ $user->jam_pulang }}</p>
                                    <form action="{{ route('karyawan.absensi.checkin') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-lg">
                                            <i class="fas fa-check-circle"></i> Absen Masuk
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Info Jam Kerja -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Informasi Jam Kerja Anda</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-success">Jam Masuk</h6>
                            <h3 class="text-success">{{ $user->jam_masuk }}</h3>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-danger">Jam Pulang</h6>
                            <h3 class="text-danger">{{ $user->jam_pulang }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Absensi 7 Hari -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Riwayat 7 Hari Terakhir</h5>
                </div>
                <div class="card-body p-0">
                    @if ($riwayatAbsensi->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <tbody>
                                    @foreach ($riwayatAbsensi as $absensi)
                                        <tr>
                                            <td>{{ $absensi->tanggal->format('d/m') }}</td>
                                            <td>
                                                @php
                                                    $statusColor = match($absensi->status) {
                                                        'hadir' => 'success',
                                                        'terlambat' => 'warning',
                                                        'izin' => 'danger',
                                                        'sakit' => 'info',
                                                        default => 'secondary'
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $statusColor }}">{{ ucfirst($absensi->status) }}</span>
                                            </td>
                                            <td class="text-end">
                                                {{ $absensi->jam_masuk ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-muted py-3 mb-0">Belum ada riwayat absensi</p>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('karyawan.absensi.history') }}" class="btn btn-sm btn-outline-primary w-100">
                        Lihat Riwayat Lengkap
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
