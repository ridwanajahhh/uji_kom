@extends('layouts.layouts')

@section('content')

  <section id="produk-header" class="hero bg-primary text-white py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6" data-aos="fade-right">
          <h1 class="display-4 fw-bold">Produk Kami</h1>
          <p class="lead">
            Temukan berbagai produk berkualitas dari siswa ACS Marketplace.
            Dukung karya anak bangsa dengan berbelanja produk inovatif dan kreatif.
          </p>
        </div>
      </div>
    </div>
  </section>

  <section id="filter" class="py-4 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h5 class="mb-3 fw-bold">Filter Kategori:</h5>
          <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('produk') }}" class="btn btn-outline-primary {{ !request('kategori') ? 'active' : '' }}">
              Semua Kategori
            </a>
            @foreach ($kategori as $kat)
              <a href="{{ route('produk', ['kategori' => $kat->id]) }}" class="btn btn-outline-primary {{ request('kategori') == $kat->id ? 'active' : '' }}">
                {{ $kat->nama_kategori }} ({{ $kat->produk_count }})
              </a>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="produk-list" class="py-5">
    <div class="container">
      @if($search)
        <h2 class="text-center mb-5 fw-bold text-info" data-aos="fade-up">
          Hasil Pencarian untuk "{{ $search }}"
        </h2>
      @else
        <h2 class="text-center mb-5 fw-bold text-warning" data-aos="fade-up">Semua Produk</h2>
      @endif

      @if($produk->isNotEmpty())
        <div class="row g-4">
          @foreach ($produk as $index => $p)
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index % 12)*50 }}">
              <div class="card h-100 shadow-sm border-0 hover-card product-card">
                @if($p->gambarProduk->isNotEmpty())
                  <img src="{{ asset('storage/assets/' . $p->gambarProduk->first()->nama_gambar) }}"
                       class="card-img-top" alt="{{ $p->nama_produk }}" style="height: 200px; object-fit: cover;">
                @else
                  <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
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
                  @if($p->toko->kontak_toko)
                  @php
                    $message = "Halo, saya ingin membeli produk {$p->nama_produk} dari toko {$p->toko->nama_toko} dengan harga Rp " . number_format($p->harga, 0, ',', '.') . ". Apakah masih tersedia?";
                    $encodedMessage = urlencode($message);
                    $whatsappUrl = "https://wa.me/{$p->toko->kontak_toko}?text={$encodedMessage}";
                  @endphp
                  <a href="{{ $whatsappUrl }}" target="_blank" class="btn btn-warning w-100">
                    <i class="bi bi-whatsapp me-2"></i>Beli Sekarang
                  </a>
                  @else
                  <button class="btn btn-secondary w-100" disabled>
                    <i class="bi bi-whatsapp me-2"></i>WhatsApp Tidak Tersedia
                  </button>
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        </div>

     
        <div class="d-flex justify-content-center mt-5">
          {{ $produk->appends(request()->query())->links() }}
        </div>
      @else
        <div class="text-center">
          <div class="alert alert-info" role="alert">
            <i class="bi bi-search me-2"></i>
            @if($search)
              Tidak ada produk yang ditemukan untuk "{{ $search }}"
            @else
              Belum ada produk tersedia
            @endif
          </div>
          <a href="{{ route('produk') }}" class="btn btn-primary">Lihat Semua Produk</a>
        </div>
      @endif
    </div>
  </section>

  <style>
    .hover-card {
      transition: all 0.3s ease;
    }

    .hover-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }

    .product-card:hover .btn {
      background-color: #ff6b35 !important;
      border-color: #ff6b35 !important;
    }

    .btn-warning {
      background: linear-gradient(135deg, #ff9a56 0%, #ff6b35 100%);
      border: none;
      transition: all 0.3s ease;
    }

    .btn-warning:hover {
      background: linear-gradient(135deg, #ff6b35 0%, #ff4500 100%);
      transform: scale(1.05);
    }

    .btn-outline-primary.active {
      background-color: #007bff;
      border-color: #007bff;
      color: white;
    }
  </style>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>

@endsection
