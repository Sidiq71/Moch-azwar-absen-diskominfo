@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container-lg my-4">
    <h1 class="mb-4">Profil Saya</h1>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    @if ($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="{{ $user->name }}" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="mb-3">
                            <i class="fas fa-user-circle" style="font-size: 150px; color: #ccc;"></i>
                        </div>
                    @endif
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->jabatan ?? 'Karyawan' }}</p>
                    <a href="{{ route('karyawan.profile.edit') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Informasi Pribadi</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Nama Lengkap</label>
                            <p class="h6">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">NIP/NIK</label>
                            <p class="h6">{{ $user->nip }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Email</label>
                            <p class="h6">{{ $user->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Jabatan</label>
                            <p class="h6">{{ $user->jabatan ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Bidang</label>
                            <p class="h6">{{ $user->bidang->nama ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Jam Kerja</label>
                            <p class="h6">{{ $user->jam_masuk }} - {{ $user->jam_pulang }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Akun</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Terakhir login: {{ $user->updated_at->diffForHumans() }}</p>
                    <a href="{{ route('karyawan.profile.edit') }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Profil & Ubah Password
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
