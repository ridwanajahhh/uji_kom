@extends('layouts.layouts')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-2 d-md-block sidebar p-3 rounded-end-4 shadow-sm">
            <h5 class="text-center mb-4 fw-bold text-primary">
                <i class="bi bi-shop-window me-2"></i>Admin Panel
            </h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="bi bi-house-door me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.toko.index') }}">
                        <i class="bi bi-shop me-2"></i> Toko
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.produk.index') }}">
                        <i class="bi bi-box-seam me-2"></i> Produk
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.kategori.index') }}">
                        <i class="bi bi-tags me-2"></i> Kategori
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="{{ route('admin.user.index') }}">
                        <i class="bi bi-people me-2"></i> User
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 fw-semibold">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit User</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('admin.user.update', $user) }}">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="nama" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required>
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="kontak" class="form-label fw-semibold">Kontak <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('kontak') is-invalid @enderror" id="kontak" name="kontak" value="{{ old('kontak', $user->kontak) }}" required>
                                        @error('kontak')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="username" class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="role" class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                            <option value="">Pilih Role</option>
                                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="member" {{ old('role', $user->role) == 'member' ? 'selected' : '' }}>Member</option>
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Biarkan kosong jika tidak ingin mengubah password.</div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary me-2">Batal</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-1"></i>Update User
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
    body {
        background-color: #f8fafc;
        font-family: 'Poppins', sans-serif;
    }

    .sidebar {
        background-color: #ffffff;
        border-right: 1px solid #e5e7eb;
    }

    .sidebar .nav-link {
        color: #444;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
        background-color: #e0f7ff;
        color: #007bff !important;
        font-weight: 600;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
    }

    .card {
        border-radius: 1rem;
    }
</style>
@endsection
