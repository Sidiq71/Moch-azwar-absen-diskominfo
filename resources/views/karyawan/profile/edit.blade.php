@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container-lg my-4">
    <h1 class="mb-4">Edit Profil</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Edit Informasi Profil</h5>
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

                    <form method="POST" action="{{ route('karyawan.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Foto Profil -->
                        <div class="mb-4">
                            <label for="foto" class="form-label">Foto Profil</label>
                            @if ($user->foto)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $user->foto) }}" alt="{{ $user->name }}" class="rounded" style="max-width: 200px; max-height: 200px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">
                            <small class="text-muted d-block mt-2">Format: JPEG, PNG, JPG, GIF. Max size: 2MB</small>
                            @error('foto') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <hr>

                        <!-- Password Section -->
                        <div class="mb-3">
                            <h5>Ubah Password</h5>
                            <p class="text-muted">Kosongkan jika tidak ingin mengubah password</p>
                        </div>

                        <div class="mb-3">
                            <label for="password_current" class="form-label">Password Lama <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password_current') is-invalid @enderror" id="password_current" name="password_current">
                            @error('password_current') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('karyawan.profile.show') }}" class="btn btn-secondary">
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
