@extends('layouts.app')

@section('title', 'Manajemen Absensi')

@section('content')
<div class="container-lg my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manajemen Absensi</h1>
        <a href="{{ route('admin.absensi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Absensi
        </a>
    </div>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal', date('Y-m-d')) }}">
                </div>
                <div class="col-md-2">
                    <select name="bidang_id" class="form-select">
                        <option value="">-- Semua Bidang --</option>
                        @foreach ($bidangs as $bidang)
                            <option value="{{ $bidang->id }}" {{ request('bidang_id') == $bidang->id ? 'selected' : '' }}>
                                {{ $bidang->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">-- Semua Status --</option>
                        <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                        <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="user_id" class="form-select">
                        <option value="">-- Semua Karyawan --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Absensi Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Karyawan</th>
                        <th>Bidang</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($absensis as $absensi)
                        <tr>
                            <td>{{ $absensi->user->name }}</td>
                            <td>
                                <span class="badge bg-info">{{ $absensi->user->bidang->nama ?? '-' }}</span>
                            </td>
                            <td>{{ $absensi->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $absensi->jam_masuk ?? '-' }}</td>
                            <td>{{ $absensi->jam_pulang ?? '-' }}</td>
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
                            <td>
                                <a href="{{ route('admin.absensi.edit', $absensi->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger" onclick="deleteAbsensi({{ $absensi->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Tidak ada data absensi</td>
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
</div>

<script>
function deleteAbsensi(id) {
    if (confirm('Apakah Anda yakin ingin menghapus absensi ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/absensi/${id}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
