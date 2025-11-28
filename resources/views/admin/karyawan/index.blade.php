@extends('layouts.app')

@section('title', 'Manajemen Karyawan')

@section('content')
<div class="container-lg py-5">
    <!-- Header -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="fw-bold" style="color: #1f2937;">Manajemen Karyawan</h1>
                <p class="text-muted">Kelola data karyawan Diskominfo</p>
            </div>
            <a href="{{ route('admin.karyawan.create') }}" class="btn btn-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                <i class="fas fa-plus"></i> Tambah Karyawan
            </a>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama atau NIP..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
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
                    <button type="submit" class="btn w-100" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border: none;">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Karyawan Grid/Table -->
    <div class="row g-4">
        @forelse ($karyawans as $karyawan)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100" style="transition: all 0.3s ease;">
                    <div class="card-body text-center">
                        <!-- Foto Profil -->
                        <div class="mb-3">
                            @php
                                $fotoUrl = $karyawan->foto;
                                // Jika foto adalah URL (dari public atau external), gunakan langsung
                                // Jika foto adalah path storage, konversi ke asset URL
                                if (!str_starts_with($fotoUrl, 'http')) {
                                    $fotoUrl = asset('storage/' . $fotoUrl);
                                }
                            @endphp
                            <img src="{{ $fotoUrl }}" alt="{{ $karyawan->name }}" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #f0f0f0; background: #f0f0f0;" onerror="this.src='{{ asset('build/RobloxScreenShot20251113_092815183.png') }}'">
                        </div>

                        <!-- Info Karyawan -->
                        <h5 class="card-title fw-bold mb-1" style="color: #1f2937;">{{ $karyawan->name }}</h5>
                        <p class="text-muted small mb-2">NIP: {{ $karyawan->nip }}</p>

                        <div class="mb-3">
                            <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                {{ $karyawan->bidang->nama ?? '-' }}
                            </span>
                        </div>

                        <div class="text-start mb-3">
                            <p class="mb-1"><small class="text-muted">Email:</small><br>
                                <small style="color: #1f2937;">{{ $karyawan->email }}</small>
                            </p>
                            <p class="mb-1"><small class="text-muted">Jabatan:</small><br>
                                <small style="color: #1f2937;">{{ $karyawan->jabatan }}</small>
                            </p>
                            <p class="mb-1"><small class="text-muted">Jam Kerja:</small><br>
                                <small style="color: #1f2937;">{{ $karyawan->jam_masuk }} - {{ $karyawan->jam_pulang }}</small>
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border: none;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteKaryawan({{ $karyawan->id }})">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-5x text-muted mb-3" style="opacity: 0.5;"></i>
                    <p class="text-muted">Tidak ada data karyawan</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        {{ $karyawans->links() }}
    </div>
</div>

<style>
    .card {
        cursor: pointer;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    }
</style>

<script>
function deleteKaryawan(id) {
    if (confirm('Apakah Anda yakin ingin menghapus karyawan ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/karyawan/${id}`;
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
