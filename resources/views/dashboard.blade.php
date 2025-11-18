@extends('layouts.layouts')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-2 d-md-block sidebar p-3 rounded-end-4 shadow-sm">
            <h5 class="text-center mb-4 fw-bold text-primary">
                <i class="bi bi-shop-window me-2"></i>{{ $user->role === 'admin' ? 'Admin Panel' : 'Member Panel' }}
            </h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="{{ route('dashboard') }}">
                        <i class="bi bi-house-door me-2"></i> Dashboard
                    </a>
                </li>
                @if($user->role === 'admin')
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('admin.user.index') }}">
                            <i class="bi bi-people me-2"></i> User
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
                @else
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('member.toko.index') }}">
                            <i class="bi bi-shop me-2"></i> Toko Saya
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('member.produk.index') }}">
                            <i class="bi bi-box-seam me-2"></i> Produk Saya
                        </a>
                    </li>
                @endif
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
            <div class="pt-3 pb-2 mb-4 border-bottom">
                <h2 class="fw-bold text-dark">Dashboard</h2>
                <p class="text-muted">Selamat datang di marketplace SMK YPC Tasikmalaya, {{ $user->nama }}!</p>
            </div>

            @if($user->role === 'member' && $totalToko == 0)
            <div class="alert alert-info border-0 shadow-sm mb-5" role="alert">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-info-circle-fill display-6 text-info"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="alert-heading mb-2">Mulai Perjalanan Anda!</h5>
                        <p class="mb-3">Anda belum memiliki toko. Buat toko pertama Anda untuk mulai menjual produk di marketplace ini.</p>
                        <a href="{{ route('member.toko.create') }}" class="btn btn-info fw-semibold">
                            <i class="bi bi-plus-circle me-2"></i>Buat Toko Sekarang
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Statistics Cards -->
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm stat-card">
                        <div class="card-body text-center">
                            <div class="stat-icon mb-3">
                                <i class="bi bi-shop display-4 text-primary"></i>
                            </div>
                            <h3 class="fw-bold text-primary">{{ $totalToko }}</h3>
                            <p class="text-muted mb-0">Total Toko</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm stat-card">
                        <div class="card-body text-center">
                            <div class="stat-icon mb-3">
                                <i class="bi bi-box-seam display-4 text-success"></i>
                            </div>
                            <h3 class="fw-bold text-success">{{ $totalProduk }}</h3>
                            <p class="text-muted mb-0">Total Produk</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm stat-card">
                        <div class="card-body text-center">
                            <div class="stat-icon mb-3">
                                <i class="bi bi-tags display-4 text-warning"></i>
                            </div>
                            <h3 class="fw-bold text-warning">{{ $totalKategori }}</h3>
                            <p class="text-muted mb-0">Total Kategori</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row g-4 mb-5">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-lightning me-2"></i>Aksi Cepat</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                @if($user->role === 'admin')
                                    <div class="col-md-6 col-lg-3">
                                        <a href="{{ route('admin.user.create') }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-center py-3">
                                            <i class="bi bi-person-plus me-2"></i>
                                            <span>Tambah User</span>
                                        </a>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <a href="{{ route('admin.toko.create') }}" class="btn btn-success w-100 d-flex align-items-center justify-content-center py-3">
                                            <i class="bi bi-plus-circle me-2"></i>
                                            <span>Buat Toko</span>
                                        </a>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <a href="{{ route('admin.produk.create') }}" class="btn btn-info w-100 d-flex align-items-center justify-content-center py-3">
                                            <i class="bi bi-plus-circle me-2"></i>
                                            <span>Tambah Produk</span>
                                        </a>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <a href="{{ route('admin.kategori.create') }}" class="btn btn-warning w-100 d-flex align-items-center justify-content-center py-3">
                                            <i class="bi bi-tags me-2"></i>
                                            <span>Buat Kategori</span>
                                        </a>
                                    </div>
                                @else
                                    <div class="col-md-6 col-lg-6">
                                        <!-- <a href="{{ route('member.toko.create') }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-center py-3">
                                            <i class="bi bi-plus-circle me-2"></i>
                                            <span>Buat Toko</span>
                                        </a> -->
                                    </div>
                                    <div class="col-md-13 col-lg-13">
                                        <a href="{{ route('member.produk.create') }}" class="btn btn-success w-100 d-flex align-items-center justify-content-center py-3">
                                            <i class="bi bi-plus-circle me-2"></i>
                                            <span>Tambah Produk</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Products -->
            @if($produk->isNotEmpty())
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-header bg-success text-white fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-clock-history me-2"></i> Produk Terbaru</span>
                    <a href="{{ $user->role === 'admin' ? route('admin.produk.index') : route('member.produk.index') }}" class="btn btn-light btn-sm fw-semibold">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        @foreach($produk->take(4) as $p)
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
                                        <p class="text-muted small mb-2">{{ $p->kategori->nama_kategori ?? '-' }}</p>
                                        <p class="text-muted small mb-2">
                                            <i class="bi bi-shop me-1"></i>{{ $p->toko->nama_toko ?? 'Tidak ada toko' }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="fw-bold text-primary">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                                            <small class="text-muted">Stok: {{ $p->stok }}</small>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Categories -->
            @if($kategori->isNotEmpty() && $user->role === 'admin')
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-header bg-warning text-white fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-tags me-2"></i> Kategori Terbaru</span>
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-light btn-sm fw-semibold">
                        Kelola Kategori
                    </a>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        @foreach($kategori->take(6) as $k)
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="card h-100 border-0 shadow-sm hover-card text-center">
                                    <div class="card-body p-3">
                                        <div class="category-icon mb-3">
                                            <i class="bi bi-tag display-6 text-warning"></i>
                                        </div>
                                        <h6 class="card-title fw-bold mb-2">{{ $k->nama_kategori }}</h6>
                                        <small class="text-muted">{{ $k->produk->count() }} Produk</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Stores -->
            @if($toko->isNotEmpty())
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-shop me-2"></i> Toko Terbaru</span>
                    <a href="{{ $user->role === 'admin' ? route('admin.toko.index') : route('member.toko.index') }}" class="btn btn-light btn-sm fw-semibold">
                        {{ $user->role === 'admin' ? 'Kelola Toko' : 'Toko Saya' }}
                    </a>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        @foreach($toko->take(3) as $t)
                            <div class="col-lg-4">
                                <div class="card h-100 border-0 shadow-sm hover-card">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="store-icon me-3">
                                                <i class="bi bi-shop display-6 text-primary"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="card-title fw-bold mb-1">{{ $t->nama_toko }}</h6>
                                                <p class="text-muted small mb-0">Oleh: {{ $t->user->nama }}</p>
                                            </div>
                                        </div>
                                        <p class="card-text text-muted small mb-3">{{ Str::limit($t->deskripsi, 100) }}</p>
                                        <div class="row g-2 text-muted small">
                                            <div class="col-6">
                                                <i class="bi bi-telephone me-1"></i>{{ $t->kontak_toko ?: '-' }}
                                            </div>
                                            <div class="col-6">
                                                <i class="bi bi-geo-alt me-1"></i>{{ Str::limit($t->alamat, 30) ?: '-' }}
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <span class="badge bg-success">{{ $t->produk->count() }} Produk</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
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
