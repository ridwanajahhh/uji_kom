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
                    <a class="nav-link active" href="{{ route('admin.produk.index') }}">
                        <i class="bi bi-box-seam me-2"></i> Produk
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.kategori.index') }}">
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
                <h1 class="h2">Detail Produk</h1>
                <div>
                    <a href="{{ route('admin.produk.edit', $produk->id_produk) }}" class="btn btn-warning me-2">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Product Images -->
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-images me-2"></i>Gambar Produk</h5>
                        </div>
                        <div class="card-body">
                            @if($produk->gambarProduk->count() > 0)
                                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($produk->gambarProduk as $index => $gambar)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/assets/' . $gambar->nama_gambar) }}"
                                                     class="d-block w-100 rounded" alt="Gambar Produk" style="height: 300px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($produk->gambarProduk->count() > 1)
                                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    @endif
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted">{{ $produk->gambarProduk->count() }} gambar</small>
                                </div>
                            @else
                                <div class="text-center py-5 bg-light rounded">
                                    <i class="bi bi-image display-4 text-muted mb-3"></i>
                                    <h5 class="text-muted">Tidak ada gambar</h5>
                                    <p class="text-muted">Produk ini belum memiliki gambar.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Product Information -->
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Produk</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">ID Produk</label>
                                        <p class="form-control-plaintext">{{ $produk->id_produk }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Produk</label>
                                        <p class="form-control-plaintext">{{ $produk->nama_produk }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Harga</label>
                                        <p class="form-control-plaintext fw-bold text-primary">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Stok</label>
                                        <p class="form-control-plaintext">{{ $produk->stok }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kategori</label>
                                        <p class="form-control-plaintext">{{ $produk->kategori->nama_kategori }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Toko</label>
                                        <p class="form-control-plaintext">{{ $produk->toko->nama_toko }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Deskripsi</label>
                                <p class="form-control-plaintext">{{ $produk->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Dibuat Pada</label>
                                        <p class="form-control-plaintext">{{ $produk->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Diupdate Pada</label>
                                        <p class="form-control-plaintext">{{ $produk->updated_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Store Information -->
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="bi bi-shop me-2"></i>Informasi Toko</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Toko</label>
                                        <p class="form-control-plaintext">{{ $produk->toko->nama_toko }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Pemilik</label>
                                        <p class="form-control-plaintext">{{ $produk->toko->user->nama }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kontak</label>
                                        <p class="form-control-plaintext">{{ $produk->toko->kontak_toko ?: '-' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Alamat</label>
                                        <p class="form-control-plaintext">{{ $produk->toko->alamat ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <a href="{{ route('admin.toko.show', $produk->toko->id_toko) }}" class="btn btn-info">
                                    <i class="bi bi-eye me-1"></i>Lihat Detail Toko
                                </a>
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

    .carousel-item img {
        border-radius: 0.5rem;
    }
</style>
@endsection
