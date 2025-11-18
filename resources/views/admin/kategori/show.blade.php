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
                <h1 class="h2">Detail Kategori</h1>
                <div>
                    <a href="{{ route('admin.kategori.edit', $kategori->id_kategori) }}" class="btn btn-warning me-2">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Kategori Information -->
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Kategori</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">ID Kategori</label>
                                        <p class="form-control-plaintext">{{ $kategori->id_kategori }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Kategori</label>
                                        <p class="form-control-plaintext">{{ $kategori->nama_kategori }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Total Produk</label>
                                        <p class="form-control-plaintext fw-bold text-primary">{{ $kategori->produk->count() }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Dibuat Pada</label>
                                        <p class="form-control-plaintext">{{ $kategori->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Statistik Produk</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 bg-primary text-white rounded">
                                        <h4 class="mb-1">{{ $kategori->produk->count() }}</h4>
                                        <small>Total Produk</small>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 bg-success text-white rounded">
                                        <h4 class="mb-1">{{ $kategori->produk->sum('stok') }}</h4>
                                        <small>Total Stok</small>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 bg-info text-white rounded">
                                        <h4 class="mb-1">{{ $kategori->produk->avg('harga') ? 'Rp ' . number_format($kategori->produk->avg('harga'), 0, ',', '.') : '0' }}</h4>
                                        <small>Rata-rata Harga</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products in Category -->
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Produk dalam Kategori ({{ $kategori->produk->count() }})</h5>
                        </div>
                        <div class="card-body">
                            @if($kategori->produk->count() > 0)
                                <div class="row g-3">
                                    @foreach($kategori->produk as $produk)
                                        <div class="col-12">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="row g-0">
                                                    <div class="col-md-4">
                                                        @if($produk->gambarProduk->isNotEmpty())
                                                            <img src="{{ asset('storage/assets/' . $produk->gambarProduk->first()->nama_gambar) }}"
                                                                 class="img-fluid rounded-start h-100" alt="{{ $produk->nama_produk }}" style="object-fit: cover;">
                                                        @else
                                                            <div class="bg-secondary d-flex align-items-center justify-content-center h-100 rounded-start">
                                                                <i class="bi bi-image text-white display-6"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="card-body">
                                                            <h6 class="card-title">{{ $produk->nama_produk }}</h6>
                                                            <p class="card-text text-muted small mb-1">{{ $produk->toko->nama_toko }}</p>
                                                            <p class="card-text">{{ Str::limit($produk->deskripsi, 80) }}</p>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="fw-bold text-primary">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                                                                <small class="text-muted">Stok: {{ $produk->stok }}</small>
                                                            </div>
                                                            <div class="mt-2">
                                                                <a href="{{ route('admin.produk.show', $produk->id_produk) }}" class="btn btn-sm btn-outline-primary">
                                                                    <i class="bi bi-eye me-1"></i>Lihat Detail
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-box-seam display-4 text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada produk</h5>
                                    <p class="text-muted">Kategori ini belum memiliki produk.</p>
                                </div>
                            @endif
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
