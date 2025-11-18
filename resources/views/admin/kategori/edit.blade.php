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
                    <a class="nav-link active" href="{{ route('admin.kategori.index') }}">
                        <i class="bi bi-tags me-2"></i> Kategori
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
                <h1 class="h2">Edit Kategori</h1>
                <div>
                    <a href="{{ route('admin.kategori.show', $kategori->id_kategori) }}" class="btn btn-info me-2">
                        <i class="bi bi-eye me-1"></i>Lihat Detail
                    </a>
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Form Edit Kategori</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.kategori.update', $kategori->id_kategori) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="nama_kategori" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required placeholder="Contoh: Makanan, Minuman, ATK">
                                    @error('nama_kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="alert alert-warning" role="alert">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Perhatian:</strong> Mengubah nama kategori akan mempengaruhi semua produk yang menggunakan kategori ini.
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-info">
                                        <i class="bi bi-check-circle me-1"></i>Update Kategori
                                    </button>
                                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-x-circle me-1"></i>Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Current Statistics -->
                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Statistik Kategori Saat Ini</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-12 mb-3">
                                    <div class="p-3 bg-primary text-white rounded">
                                        <h4 class="mb-1">{{ $kategori->produk->count() }}</h4>
                                        <small>Total Produk</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="p-3 bg-success text-white rounded">
                                        <h4 class="mb-1">{{ $kategori->produk->sum('stok') }}</h4>
                                        <small>Total Stok</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="p-3 bg-info text-white rounded">
                                        <h4 class="mb-1">{{ $kategori->produk->avg('harga') ? 'Rp ' . number_format($kategori->produk->avg('harga'), 0, ',', '.') : '0' }}</h4>
                                        <small>Rata-rata Harga</small>
                                    </div>
                                </div>
                            </div>
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
