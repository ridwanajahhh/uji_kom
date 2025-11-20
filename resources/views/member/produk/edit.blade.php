@extends('layouts.layouts')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        
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
                <h1 class="h2">Edit Produk</h1>
                <div>
                    <a href="{{ route('member.produk.show', $produk->id_produk) }}" class="btn btn-info me-2">
                        <i class="bi bi-eye me-1"></i>Lihat Detail
                    </a>
                    <a href="{{ route('member.produk.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Form Edit Produk</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('member.produk.update', $produk->id_produk) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="nama_produk" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                                    @error('nama_produk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="harga" class="form-label">Harga <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga', $produk->harga) }}" min="0" required>
                                            @error('harga')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok" value="{{ old('stok', $produk->stok) }}" min="0" required>
                                        @error('stok')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="id_toko" class="form-label">Toko <span class="text-danger">*</span></label>
                                        <select class="form-select @error('id_toko') is-invalid @enderror" id="id_toko" name="id_toko" required>
                                            <option value="">Pilih Toko</option>
                                            @foreach($toko as $t)
                                                <option value="{{ $t->id_toko }}" {{ old('id_toko', $produk->id_toko) == $t->id_toko ? 'selected' : '' }}>
                                                    {{ $t->nama_toko }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_toko')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="id_kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                        <select class="form-select @error('id_kategori') is-invalid @enderror" id="id_kategori" name="id_kategori" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($kategori as $k)
                                                <option value="{{ $k->id_kategori }}" {{ old('id_kategori', $produk->id_kategori) == $k->id_kategori ? 'selected' : '' }}>
                                                    {{ $k->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_kategori')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="gambar" class="form-label">Gambar Produk</label>
                                    <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar[]" multiple accept="image/*">
                                    <div class="form-text">
                                        Format: JPG, PNG, GIF. Maksimal 2MB per gambar. Bisa pilih multiple gambar.
                                        <strong>Gambar baru akan ditambahkan ke gambar yang sudah ada.</strong>
                                    </div>
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if($produk->gambarProduk->count() > 0)
                                <div class="mb-3">
                                    <label class="form-label">Gambar Saat Ini</label>
                                    <div class="row g-2">
                                        @foreach($produk->gambarProduk as $gambar)
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <img src="{{ asset('storage/assets/' . $gambar->nama_gambar) }}" class="card-img-top" alt="Gambar Produk" style="height: 120px; object-fit: cover;">
                                                    <div class="card-body p-2">
                                                        <button type="button" class="btn btn-sm btn-outline-danger w-100"
                                                        onclick="deleteImage('{{ $gambar->id_gambar }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-check-circle me-1"></i>Update Produk
                                    </button>
                                    <a href="{{ route('member.produk.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-x-circle me-1"></i>Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function deleteImage(imageId) {
    if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
        fetch(`{{ url('/member/produk/gambar') }}/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal menghapus gambar');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus gambar');
        });
    }
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
</style>
@endsection
