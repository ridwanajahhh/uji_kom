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
                    <a class="nav-link active" href="{{ route('admin.toko.index') }}">
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
                <h1 class="h2">Manajemen Toko</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('admin.toko.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Tambah Toko
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
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Toko</th>
                                    <th>Pemilik</th>
                                    <th>Kontak</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($toko as $t)
                                <tr>
                                    <td>{{ $t->id_toko }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($t->gambar)
                                                <img src="{{ asset('storage/assets/' . $t->gambar) }}" alt="{{ $t->nama_toko }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="bi bi-shop text-white"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <strong>{{ $t->nama_toko }}</strong>
                                                @if($t->deskripsi)
                                                    <br><small class="text-muted">{{ Str::limit($t->deskripsi, 50) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $t->user->nama }}</td>
                                    <td>{{ $t->kontak_toko ?: '-' }}</td>
                                    <td>{{ $t->alamat ? Str::limit($t->alamat, 30) : '-' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.toko.show', $t) }}" class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.toko.edit', $t) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.toko.destroy', $t) }}" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus toko ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="bi bi-shop display-4 text-muted mb-3"></i>
                                        <h5 class="text-muted">Belum ada toko</h5>
                                        <p class="text-muted">Klik tombol "Tambah Toko" untuk menambah toko baru.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $toko->links() }}
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

    .table th {
        border-top: none;
        font-weight: 600;
        color: #495057;
    }

    .btn-group .btn {
        margin-right: 2px;
    }
</style>
@endsection
