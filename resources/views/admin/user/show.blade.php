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
                <h1 class="h2">Detail User</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-person-circle me-2"></i>Informasi User</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-3 fw-semibold">ID User</div>
                                <div class="col-md-9">{{ $user->id_user }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3 fw-semibold">Nama Lengkap</div>
                                <div class="col-md-9">{{ $user->nama }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3 fw-semibold">Username</div>
                                <div class="col-md-9">{{ $user->username }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3 fw-semibold">Kontak</div>
                                <div class="col-md-9">{{ $user->kontak ?: '-' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3 fw-semibold">Role</div>
                                <div class="col-md-9">
                                    <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-info' }} fs-6">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3 fw-semibold">Dibuat</div>
                                <div class="col-md-9">{{ $user->created_at->format('d F Y, H:i') }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3 fw-semibold">Terakhir Update</div>
                                <div class="col-md-9">{{ $user->updated_at->format('d F Y, H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-gear me-2"></i>Aksi</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil me-2"></i>Edit User
                                </a>
                                @if($user->id_user != auth()->user()->id_user)
                                <form method="POST" action="{{ route('admin.user.destroy', $user) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-trash me-2"></i>Hapus User
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($user->role === 'member')
                    <div class="card shadow-sm border-0 mt-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-shop me-2"></i>Toko User</h5>
                        </div>
                        <div class="card-body">
                            @if($user->toko->count() > 0)
                                @foreach($user->toko as $toko)
                                    <div class="mb-2">
                                        <strong>{{ $toko->nama_toko }}</strong><br>
                                        <small class="text-muted">{{ $toko->produk->count() }} produk</small>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted mb-0">Belum memiliki toko</p>
                            @endif
                        </div>
                    </div>
                    @endif
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
