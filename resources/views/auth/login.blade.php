@extends('layouts.app')

@section('title', 'Login - Absensi Diskominfo')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg" style="width: 100%; max-width: 450px;">
        <div class="card-body p-5">
            <h1 class="h3 mb-4 text-center fw-bold text-primary">Absensi Diskominfo</h1>
            
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Login Gagal!</strong>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>

            <hr class="my-4">

            <!-- Demo Credentials -->
            <div class="alert alert-info alert-sm mt-3 mb-0" role="alert">
                <small>
                    <strong>Demo Admin:</strong> admin@diskominfo.local / password<br>
                    <strong>Demo User:</strong> karyawan1@diskominfo.local / password
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
