@extends('layouts.app')

@section('title', 'Jam Kerja')

@section('content')
<div class="container-lg my-4">
    <h1 class="mb-4">Informasi Jam Kerja</h1>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-sign-in-alt fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Jam Masuk</h5>
                    <h2 class="text-success">{{ $jamMasuk }}</h2>
                    <p class="text-muted mb-0">Waktu normal untuk masuk kerja</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card border-danger">
                <div class="card-body text-center">
                    <i class="fas fa-sign-out-alt fa-3x text-danger mb-3"></i>
                    <h5 class="card-title">Jam Pulang</h5>
                    <h2 class="text-danger">{{ $jamPulang }}</h2>
                    <p class="text-muted mb-0">Waktu normal untuk pulang kerja</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Penjelasan Status Absensi</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6 class="text-success">
                        <i class="fas fa-check-circle"></i> Hadir
                    </h6>
                    <p class="text-muted">Anda absen masuk pada atau sebelum jam {{ $jamMasuk }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="text-warning">
                        <i class="fas fa-clock"></i> Terlambat
                    </h6>
                    <p class="text-muted">Anda absen masuk setelah jam {{ $jamMasuk }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="text-info">
                        <i class="fas fa-hospital-user"></i> Sakit
                    </h6>
                    <p class="text-muted">Anda tidak hadir karena alasan sakit dengan surat keterangan</p>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="text-danger">
                        <i class="fas fa-file-alt"></i> Izin
                    </h6>
                    <p class="text-muted">Anda tidak hadir karena mendapat izin dari pimpinan</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Peraturan Jam Kerja</h5>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <strong>Masuk tepat waktu:</strong> Diharapkan hadir sebelum atau tepat pada jam {{ $jamMasuk }}
                </li>
                <li class="list-group-item">
                    <strong>Pulang sesuai jadwal:</strong> Waktu pulang adalah pukul {{ $jamPulang }}
                </li>
                <li class="list-group-item">
                    <strong>Izin keterlambatan:</strong> Jika terlambat, segera laporkan kepada pimpinan
                </li>
                <li class="list-group-item">
                    <strong>Sakit/Izin:</strong> Lampirkan surat keterangan sakit atau persetujuan izin ke bagian HR
                </li>
                <li class="list-group-item">
                    <strong>Absen pulang:</strong> Pastikan untuk absen pulang pada akhir hari kerja
                </li>
            </ul>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('karyawan.absensi') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Kembali ke Absensi
        </a>
    </div>
</div>
@endsection
