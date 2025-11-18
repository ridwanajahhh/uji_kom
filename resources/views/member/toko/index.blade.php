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
                <h1 class="h2">Toko Saya</h1>
                <!-- <a href="{{ route('member.toko.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Toko
                </a> -->
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-4">
                @forelse($toko as $t)
                    <div class="col-lg-6 col-xl-4">
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
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('member.toko.show', $t->id_toko) }}">
                                                <i class="bi bi-eye me-2"></i>Lihat Detail</a></li>
                                            <li><a class="dropdown-item" href="{{ route('member.toko.edit', $t->id_toko) }}">
                                                <i class="bi bi-pencil me-2"></i>Edit</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#" onclick="confirmDelete({{ $t->id_toko }})">
                                                <i class="bi bi-trash me-2"></i>Hapus</a></li>
                                        </ul>
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
                                    <span class="badge bg-primary">ID: {{ $t->id_toko }}</span>
                                    <span class="badge bg-success ms-1">{{ $t->produk->count() }} Produk</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-shop display-4 text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada toko</h5>
                            <p class="text-muted">Anda belum memiliki toko. Mulai dengan membuat toko pertama Anda.</p>
                            <a href="{{ route('member.toko.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>Buat Toko Pertama
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus toko ini? Semua produk di dalam toko ini juga akan dihapus.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(tokoId) {
    document.getElementById('deleteForm').action = '{{ url("/member/toko") }}/' + tokoId;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>

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

    .store-icon {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
    }
</style>
@endsection
