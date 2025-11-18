@extends('layouts.layouts')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-2 d-md-block sidebar p-3 rounded-end-4 shadow-sm">
            <h5 class="text-center mb-4 fw-bold text-primary">
                <i class="bi bi-shop-window me-2"></i>Member Panel
            </h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="bi bi-house-door me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="{{ route('member.toko.index') }}">
                        <i class="bi bi-shop me-2"></i> Toko Saya
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('member.produk.index') }}">
                        <i class="bi bi-box-seam me-2"></i> Produk Saya
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
                <h1 class="h2">Detail Toko</h1>
                <div>
                    <a href="{{ route('member.toko.edit', $toko->id_toko) }}" class="btn btn-warning me-2">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <a href="{{ route('member.toko.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Toko Information -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Toko</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">ID Toko</label>
                                        <p class="form-control-plaintext">{{ $toko->id_toko }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Toko</label>
                                        <p class="form-control-plaintext">{{ $toko->nama_toko }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Pemilik</label>
                                        <p class="form-control-plaintext">{{ $toko->user->nama }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kontak Toko</label>
                                        <p class="form-control-plaintext">{{ $toko->kontak_toko ?: '-' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Alamat</label>
                                        <p class="form-control-plaintext">{{ $toko->alamat ?: '-' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Dibuat Pada</label>
                                        <p class="form-control-plaintext">{{ $toko->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Deskripsi</label>
                                <p class="form-control-plaintext">{{ $toko->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Produk di Toko Ini -->
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Produk di Toko Ini ({{ $toko->produk->count() }})</h5>
                        </div>
                        <div class="card-body">
                            @if($toko->produk->count() > 0)
                                <div class="row g-3">
                                    @foreach($toko->produk as $produk)
                                        <div class="col-lg-4 col-md-6">
                                            <div class="card h-100 border-0 shadow-sm">
                                                @if($produk->gambarProduk->isNotEmpty())
                                                    <img src="{{ asset('storage/assets/' . $produk->gambarProduk->first()->nama_gambar) }}"
                                                         class="card-img-top" alt="{{ $produk->nama_produk }}" style="height: 150px; object-fit: cover;">
                                                @else
                                                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 150px;">
                                                        <i class="bi bi-image text-white display-6"></i>
                                                    </div>
                                                @endif
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $produk->nama_produk }}</h6>
                                                    <p class="text-muted small mb-1">{{ $produk->kategori->nama_kategori }}</p>
                                                    <p class="fw-bold text-primary mb-1">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                                                    <small class="text-muted">Stok: {{ $produk->stok }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-box-seam display-4 text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada produk</h5>
                                    <p class="text-muted">Toko ini belum memiliki produk.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar Info -->
                <div class="col-lg-4">
                    <!-- Gambar Toko -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="bi bi-image me-2"></i>Gambar Toko</h5>
                        </div>
                        <div class="card-body text-center">
                            @if($toko->gambar)
                                <img src="{{ asset('storage/assets/' . $toko->gambar) }}" class="img-fluid rounded" alt="Gambar Toko">
                            @else
                                <div class="bg-light rounded p-4">
                                    <i class="bi bi-image display-4 text-muted"></i>
                                    <p class="text-muted mt-2">Tidak ada gambar</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Statistik</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-12 mb-3">
                                    <div class="p-3 bg-primary text-white rounded">
                                        <h4 class="mb-1">{{ $toko->produk->count() }}</h4>
                                        <small>Total Produk</small>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="p-3 bg-success text-white rounded">
                                        <h4 class="mb-1">{{ $toko->produk->sum('stok') }}</h4>
                                        <small>Total Stok</small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-3 bg-info text-white rounded">
                                        <h4 class="mb-1">{{ $toko->produk->avg('harga') ? 'Rp ' . number_format($toko->produk->avg('harga'), 0, ',', '.') : '0' }}</h4>
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
