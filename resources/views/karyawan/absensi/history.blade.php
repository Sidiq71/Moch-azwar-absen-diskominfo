@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="container-lg my-4">
    <h1 class="mb-4">Riwayat Absensi</h1>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="bulan" class="form-label">Bulan</label>
                    <select name="bulan" id="bulan" class="form-select">
                        <option value="">-- Semua Bulan --</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::createFromDate(null, $i, 1)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="tahun" class="form-label">Tahun</label>
                    <select name="tahun" id="tahun" class="form-select">
                        <option value="">-- Semua Tahun --</option>
                        @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                            <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-info w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Absensi History Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Tanggal</th>
                        <th>Hari</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($absensis as $absensi)
                        <tr>
                            <td>{{ $absensi->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $absensi->tanggal->format('l') }}</td>
                            <td>{{ $absensi->jam_masuk ?? '-' }}</td>
                            <td>{{ $absensi->jam_pulang ?? '-' }}</td>
                            <td>
                                @php
                                    $statusColor = match($absensi->status) {
                                        'hadir' => 'success',
                                        'terlambat' => 'warning',
                                        'izin' => 'danger',
                                        'sakit' => 'info',
                                        'belum_absen' => 'secondary',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusColor }}">{{ ucfirst(str_replace('_', ' ', $absensi->status)) }}</span>
                            </td>
                            <td>{{ $absensi->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Tidak ada riwayat absensi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $absensis->links() }}
    </div>

    <!-- Back Button -->
    <div class="mt-4">
        <a href="{{ route('karyawan.absensi') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Absensi
        </a>
    </div>
</div>
@endsection
