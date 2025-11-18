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
                    <a class="nav-link" href="{{ route('member.toko.index') }}">
                        <i class="bi bi-shop me-2"></i> Toko Saya
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="{{ route('member.produk.index') }}">
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
                <h1 class="h2">Produk Saya</h1>
                <a href="{{ route('member.produk.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Produk
                </a>
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
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fw-bold text-primary">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                                    <small class="text-muted">Stok: {{ $p->stok }}</small>
                                </div>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('member.produk.show', $p->id_produk) }}" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('member.produk.edit', $p->id_produk) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $p->id_produk }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-box-seam display-4 text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada produk</h5>
                            <p class="text-muted">Anda belum memiliki produk. Mulai dengan membuat produk pertama Anda.</p>
                            <a href="{{ route('member.produk.create') }}" class="btn btn-success">
                                <i class="bi bi-plus-circle me-1"></i>Buat Produk Pertama
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
                <p>Apakah Anda yakin ingin menghapus produk ini?</p>
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
function confirmDelete(produkId) {
    document.getElementById('deleteForm').action = '{{ url("/member/produk") }}/' + produkId;
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

    .product-card:hover .btn {
        background-color: #198754 !important;
        border-color: #198754 !important;
    }
</style>
@endsection
