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
                    <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="#dashboard">
                        <i class="bi bi-house-door me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#toko"><i class="bi bi-shop me-2"></i> Toko</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#produk"><i class="bi bi-box-seam me-2"></i> Produk</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#kategori"><i class="bi bi-tags me-2"></i> Kategori</a>
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
            <div class="pt-3 pb-2 mb-4 border-bottom">
                <h2 class="fw-bold text-dark">📊 Dashboard Administrator</h2>
                <p class="text-muted">Kelola marketplace SMK YPC Tasikmalaya dengan mudah.</p>
            </div>

            <!-- Welcome Banner -->
            <div class="alert alert-primary shadow-sm border-0 rounded-3 mb-4">
                <h5 class="fw-bold mb-1">Selamat Datang, {{ $user->nama }} 👋</h5>
                <p class="mb-0">Anda login sebagai <strong class="text-uppercase">{{ $user->role }}</strong>.</p>
            </div>

            <!-- Statistic Cards -->
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-white" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                        <div class="card-body text-center">
                            <i class="bi bi-shop display-5 mb-2"></i>
                            <h5 class="fw-bold">Total Toko</h5>
                            <h2>{{ $totalToko }}</h2>
                            <p class="text-white-50">Jumlah toko yang terdaftar</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-white" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                        <div class="card-body text-center">
                            <i class="bi bi-box-seam display-5 mb-2"></i>
                            <h5 class="fw-bold">Total Produk</h5>
                            <h2>{{ $totalProduk }}</h2>
                            <p class="text-white-50">Jumlah produk yang tersedia</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-white" style="background: linear-gradient(135deg, #00c6ff, #0072ff);">
                        <div class="card-body text-center">
                            <i class="bi bi-tags display-5 mb-2"></i>
                            <h5 class="fw-bold">Total Kategori</h5>
                            <h2>{{ $totalKategori }}</h2>
                            <p class="text-white-50">Jumlah kategori produk</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Toko Table -->
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="bi bi-shop me-2"></i> Daftar Toko
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Toko</th>
                                    <th>Deskripsi</th>
                                    <th>Pemilik</th>
                                    <th>Kontak</th>
                                    <th>Alamat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($toko as $t)
                                    <tr>
                                        <td>{{ $t->id_toko }}</td>
                                        <td class="fw-semibold">{{ $t->nama_toko }}</td>
                                        <td>{{ $t->deskripsi }}</td>
                                        <td>{{ $t->user->nama }}</td>
                                        <td>{{ $t->kontak_toko }}</td>
                                        <td>{{ $t->alamat }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Belum ada toko terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Produk Table -->
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-header bg-success text-white fw-bold">
                    <i class="bi bi-box-seam me-2"></i> Daftar Produk
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Kategori</th>
                                    <th>Toko</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($produk as $p)
                                    <tr>
                                        <td>{{ $p->id_produk }}</td>
                                        <td class="fw-semibold">{{ $p->nama_produk }}</td>
                                        <td>Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                                        <td>{{ $p->stok }}</td>
                                        <td>{{ $p->kategori->nama_kategori }}</td>
                                        <td>{{ $p->toko->nama_toko }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Belum ada produk tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Kategori Table -->
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-header bg-info text-white fw-bold">
                    <i class="bi bi-tags me-2"></i> Daftar Kategori
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Kategori</th>
                                    <th>Jumlah Produk</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kategori as $k)
                                    <tr>
                                        <td>{{ $k->id_kategori }}</td>
                                        <td class="fw-semibold">{{ $k->nama_kategori }}</td>
                                        <td>{{ $k->produk->count() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Belum ada kategori tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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

    table thead {
        background-color: #f1f3f5;
    }
</style>
@endsection
