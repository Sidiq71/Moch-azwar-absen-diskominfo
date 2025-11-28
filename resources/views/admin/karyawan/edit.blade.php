@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
<div class="container-lg my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Edit Karyawan - {{ $karyawan->name }}</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.karyawan.update', $karyawan->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $karyawan->name) }}" required>
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $karyawan->email) }}" required>
                            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nip" class="form-label">NIP/NIK</label>
                            <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip', $karyawan->nip) }}" required>
                            @error('nip') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bidang_id" class="form-label">Bidang</label>
                            <select class="form-select @error('bidang_id') is-invalid @enderror" id="bidang_id" name="bidang_id" required>
                                <option value="">-- Pilih Bidang --</option>
                                @foreach ($bidangs as $bidang)
                                    <option value="{{ $bidang->id }}" {{ old('bidang_id', $karyawan->bidang_id) == $bidang->id ? 'selected' : '' }}>
                                        {{ $bidang->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bidang_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" value="{{ old('jabatan', $karyawan->jabatan) }}" required>
                            @error('jabatan') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jam_masuk" class="form-label">Jam Masuk</label>
                                    <input type="time" class="form-control @error('jam_masuk') is-invalid @enderror" id="jam_masuk" name="jam_masuk" value="{{ old('jam_masuk', $karyawan->jam_masuk) }}" required>
                                    @error('jam_masuk') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jam_pulang" class="form-label">Jam Pulang</label>
                                    <input type="time" class="form-control @error('jam_pulang') is-invalid @enderror" id="jam_pulang" name="jam_pulang" value="{{ old('jam_pulang', $karyawan->jam_pulang) }}" required>
                                    @error('jam_pulang') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Profil</label>
                            <div class="mb-2">
                                <img id="fotoPreview" src="{{ $karyawan->foto }}" alt="{{ $karyawan->name }}" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #f0f0f0;">
                            </div>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*" onchange="previewFoto(event)">
                            <small class="text-muted d-block mt-2">Format: JPG, PNG, GIF (Max: 2MB). Kosongkan jika tidak ingin mengubah.</small>
                            @error('foto') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
function previewFoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('fotoPreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}
</script>
