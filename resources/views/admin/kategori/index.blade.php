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
                <h1 class="h2">Manajemen Kategori</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('admin.kategori.create') }}" class="btn btn-info">
                        <i class="bi bi-plus-circle me-1"></i>Tambah Kategori
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
                        @forelse($kategori as $k)
                            <div class="col-lg-4 col-md-6">
                                <div class="card h-100 border-0 shadow-sm hover-card">
                                    <div class="card-body text-center p-4">
                                        <div class="icon-wrapper mb-3">
                                            <i class="bi bi-tags-fill display-4 text-info"></i>
                                        </div>
                                        <h5 class="card-title fw-bold">{{ $k->nama_kategori }}</h5>
                                        <p class="card-text text-muted">{{ $k->produk->count() }} Produk Tersedia</p>
                                        <div class="mt-3">
                                            <span class="badge bg-info">ID: {{ $k->id_kategori }}</span>
                                        </div>
                                        <div class="mt-3 d-flex gap-2 justify-content-center">
                                            <a href="{{ route('admin.kategori.show', $k) }}" class="btn btn-outline-info btn-sm">
                                                <i class="bi bi-eye me-1"></i>Lihat
                                            </a>
                                            <a href="{{ route('admin.kategori.edit', $k) }}" class="btn btn-outline-warning btn-sm">
                                                <i class="bi bi-pencil me-1"></i>Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.kategori.destroy', $k) }}" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
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
                                    <i class="bi bi-tags display-4 text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada kategori tersedia</h5>
                                    <p class="text-muted">Klik tombol "Tambah Kategori" untuk menambah kategori baru.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $kategori->links() }}
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

    .icon-wrapper {
        background: linear-gradient(135deg, #0dcaf0 0%, #0d6efd 100%);
        border-radius: 50%;
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        box-shadow: 0 4px 15px rgba(13, 202, 240, 0.3);
    }
</style>
@endsection
