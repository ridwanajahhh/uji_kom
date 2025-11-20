@extends('layouts.layouts')

@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
          <h4>Register ke Marketplace</h4>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nama -->
            <div class="mb-3">
              <label for="nama" class="form-label">Nama</label>
              <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" required autofocus>
              @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Kontak -->
            <div class="mb-3">
              <label for="kontak" class="form-label">Kontak</label>
              <input id="kontak" type="text" class="form-control @error('kontak') is-invalid @enderror" name="kontak" value="{{ old('kontak') }}" required>
              @error('kontak')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Username -->
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required>
              @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
              <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary">
                Register
              </button>
            </div>
          </form>

          <div class="text-center mt-3">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
