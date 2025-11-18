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
                <h1 class="h2">Manajemen Produk</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('admin.produk.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i>Tambah Produk
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="row g-4">
                        @forelse($produk as $p)
                            <div class="col-lg-3 col-md-6">
                                <div class="card h-100 border-0 shadow-sm hover-card product-card">
                                    @if($p->gambarProduk->isNotEmpty())
                                        <img src="{{ asset('storage/assets/' . $p->gambarProduk->first()->nama_gambar) }}"
                                             class="card-img-top" alt="{{ $p->nama_produk }}" style="height: 180px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 180px;">
                                            <i class="bi bi-image text-white display-4"></i>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold">{{ $p->nama_produk }}</h6>
                                        <p class="text-muted small mb-2">{{ $p->kategori->nama_kategori }}</p>
                                        <p class="text-muted small mb-2"><i class="bi bi-shop me-1"></i>{{ $p->toko->nama_toko }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold text-primary">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                                            <small class="text-muted">Stok: {{ $p->stok }}</small>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent border-0 p-3">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.produk.show', $p) }}" class="btn btn-outline-info btn-sm flex-fill">
                                                <i class="bi bi-eye me-1"></i>Lihat
                                            </a>
                                            <a href="{{ route('admin.produk.edit', $p) }}" class="btn btn-outline-warning btn-sm flex-fill">
                                                <i class="bi bi-pencil me-1"></i>Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.produk.destroy', $p) }}" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm flex-fill">
                                                    <i class="bi bi-trash me-1"></i>Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="bi bi-box-seam display-4 text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada produk tersedia</h5>
                                    <p class="text-muted">Klik tombol "Tambah Produk" untuk menambah produk baru.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $produk->links() }}
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

    .hover-card {
        transition: all 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }

    .product-card:hover .btn {
        background-color: #198754 !important;
        border-color: #198754 !important;
    }
</style>
@endsection
