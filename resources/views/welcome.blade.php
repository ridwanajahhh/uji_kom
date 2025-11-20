@extends('layouts.layouts')

@section('content')

  <section id="home" class="hero bg-primary text-white py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6" data-aos="fade-right">
          <h1 class="display-4 fw-bold">Selamat Datang di ACS Marketplace </h1>
          <p class="lead">
            Sekolah Menengah Kejuruan yang berkomitmen untuk mencetak generasi muda
            yang berkualitas, inovatif, dan siap menghadapi tantangan dunia kerja.
          </p>
        </div>
      </div>
    </div>
  </section>



  <section id="about" class="py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6" data-aos="fade-up">
          <h2 class="mb-4">Tentang Toko</h2>
          <p>
            Toko ini adalah wadah kreativitas dan wirausaha bagi siswa untuk mengembangkan kemampuan bisnis sejak dini.
            Melalui toko ini, siswa mempraktikkan langsung ilmu kewirausahaan dengan menjual produk hasil karya sendiri, mulai dari kerajinan, teknologi, hingga kuliner.
            Setiap produk mencerminkan semangat inovasi, kualitas, dan kemandirian generasi muda ACS.
          </p>
          <p>
            Dukung karya anak ACS!
            Temukan produk kreatif, inovatif, dan berkualitas dari siswa ACS.
            Belanja sambil berkontribusi untuk masa depan generasi produktif Indonesia
          </p>
          <ul class="list-unstyled">
            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Pendidikan Berkualitas</li>
            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Fasilitas Modern</li>
            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Pembelanjaan Lengkap</li>
            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Program Keahlian Beragam</li>
          </ul>
        </div>
        <div class="col-lg-6 d-flex justify-content-end" data-aos="fade-up" data-aos-delay="200">
          <img
            src="{{ asset('storage/assets/we.webp') }}"
            width="500"
            height="200"
            class="img-fluid rounded"
          >
        </div>
      </div>
    </div>
  </section>

  <section id="kategori" class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center mb-5 fw-bold text-primary" data-aos="fade-up">Kategori Produk</h2>
      <div class="row g-4">
        @foreach ($kategori as $index => $kat)
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index+1)*100 }}">
            <div class="card h-100 shadow-sm border-0 hover-card">
              <div class="card-body text-center p-4">
                <div class="icon-wrapper mb-3">
                  <i class="bi bi-tags-fill display-4 text-primary"></i>
                </div>
                <h5 class="card-title fw-bold">{{ $kat->nama_kategori }}</h5>
                <p class="card-text text-muted">{{ $kat->produk_count }} Produk Tersedia</p>
                <a href="#produk" class="btn btn-outline-primary">Lihat Produk</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <section id="toko" class="py-5">
    <div class="container">
      <h2 class="text-center mb-5 fw-bold text-success" data-aos="fade-up">Toko Kami</h2>
      <div class="row g-4">
        @foreach ($toko as $index => $t)
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ ($index+1)*150 }}">
            <div class="card h-100 shadow-sm border-0 hover-card">
              <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                  <div class="store-icon me-3">
                    <i class="bi bi-shop display-6 text-success"></i>
                  </div>
                  <div>
                    <h5 class="card-title fw-bold mb-1">{{ $t->nama_toko }}</h5>
                    <p class="text-muted mb-0">Oleh: {{ $t->user->nama }}</p>
                  </div>
                </div>
                <p class="card-text">{{ $t->deskripsi }}</p>
                <div class="row text-muted small">
                  <div class="col-6">
                    <i class="bi bi-telephone me-1"></i>{{ $t->kontak_toko }}
                  </div>
                  <div class="col-6">
                    <i class="bi bi-geo-alt me-1"></i>{{ $t->alamat }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <section id="produk" class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center mb-5 fw-bold text-warning" data-aos="fade-up">Produk Unggulan</h2>
      <div class="row g-4">
        @php
          $allProduk = \App\Models\Produk::with(['toko', 'kategori', 'gambarProduk'])->get();
        @endphp
        @foreach ($allProduk as $index => $p)
          <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index+1)*100 }}">
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
    </div>
  </section>

  @if($search)
  <section id="search-results" class="py-5">
    <div class="container">
      <h2 class="text-center mb-5 fw-bold text-info" data-aos="fade-up">
        Hasil Pencarian untuk "{{ $search }}"
      </h2>
      @if($produk->isNotEmpty())
      <div class="row g-4">
        @foreach ($produk as $index => $p)
          <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index+1)*100 }}">
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
      @else
      <div class="text-center">
        <div class="alert alert-info" role="alert">
          <i class="bi bi-search me-2"></i>
          Tidak ada produk yang ditemukan untuk "{{ $search }}"
        </div>
        <a href="{{ url('/') }}" class="btn btn-primary">Lihat Semua Produk</a>
      </div>
      @endif
    </div>
  </section>
  @endif

  <section id="galeri" class="py-5">
    <div class="container">
      <h2 class="text-center mb-5" data-aos="fade-up">Galeri</h2>
      <div class="row">
        @php
          $galleryImages = [
            'storage/assets/taro.png',
            'storage/assets/fs.webp',
            'storage/assets/pulpen.webp',
            'storage/assets/eskrim.jpg',
          ];
        @endphp

        @foreach ($galleryImages as $i => $img)
          <div class="col-md-3 mb-3" data-aos="zoom-in" data-aos-delay="{{ ($i+1)*100 }}">
            <img
              src="{{ asset($img) }}"
              alt="Gallery {{ $i+1 }}"
              class="img-fluid rounded shadow-sm"
            >
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <section id="contact" class="bg-primary text-white py-5">
    <div class="container">
      <h2 class="text-center mb-5" data-aos="fade-up">Hubungi Kami</h2>
      <div class="row">
        <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
          <h4>Informasi Kontak</h4>
          <p><i class="bi bi-geo-alt-fill me-2"></i>Jl. Raya Tasikmalaya No. 123, Tasikmalaya</p>
          <p><i class="bi bi-telephone-fill me-2"></i>(0265) 123456</p>
          <p><i class="bi bi-envelope-fill me-2"></i>info@smkypc-tasikmalaya.sch.id</p>
          <p><i class="bi bi-clock-fill me-2"></i>Senin - Jumat: 07:00 - 15:00</p>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
          <form>
            <div class="mb-3">
              <label for="name" class="form-label">Nama</label>
              <input type="text" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">Pesan</label>
              <textarea class="form-control" id="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-light">Kirim Pesan</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-dark text-white py-4">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <p class="mb-0">&copy; 2024 SMK YPC Tasikmalaya. All rights reserved.</p>
        </div>
        <div class="col-md-6 text-end">
          <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
          <a href="#" class="text-white me-3"><i class="bi bi-twitter"></i></a>
          <a href="#" class="text-white me-3"><i class="bi bi-instagram"></i></a>
          <a href="#" class="text-white"><i class="bi bi-youtube"></i></a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Custom Styles -->
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

    .icon-wrapper {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 50%;
      width: 80px;
      height: 80px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
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

    .btn-warning {
      background: linear-gradient(135deg, #ff9a56 0%, #ff6b35 100%);
      border: none;
      transition: all 0.3s ease;
    }

    .btn-warning:hover {
      background: linear-gradient(135deg, #ff6b35 0%, #ff4500 100%);
      transform: scale(1.05);
    }
  </style>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>

@endsection
