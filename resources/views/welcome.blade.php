@extends('layouts.layouts')

@section('content')

  <section id="home" class="hero bg-primary text-white py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6" data-aos="fade-right">
          <h1 class="display-4 fw-bold">Selamat Datang di Marketplace SMK YPC Tasikmalaya</h1>
          <p class="lead">
            Sekolah Menengah Kejuruan yang berkomitmen untuk mencetak generasi muda
            yang berkualitas, inovatif, dan siap menghadapi tantangan dunia kerja.
          </p>
          <a href="{{ route('login') }}" class="btn btn-light btn-lg">Login</a>
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
            Toko SMK YPC Tasikmalaya adalah wadah kreativitas dan wirausaha bagi siswa untuk mengembangkan kemampuan bisnis sejak dini.
            Melalui toko ini, siswa mempraktikkan langsung ilmu kewirausahaan dengan menjual produk hasil karya sendiri, mulai dari kerajinan, teknologi, hingga kuliner.
            Setiap produk mencerminkan semangat inovasi, kualitas, dan kemandirian generasi muda SMK YPC Tasikmalaya.
          </p>
          <p>
            Dukung karya anak SMK!
            Temukan produk kreatif, inovatif, dan berkualitas dari siswa SMK YPC Tasikmalaya.
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
            src="{{ asset('storage/assets/ypc.jpeg') }}"
            width="500"
            height="200"
            class="img-fluid rounded"
          >
        </div>
      </div>
    </div>
  </section>

  <section id="news" class="bg-light py-5">
    <div class="container">
      <h2 class="text-center mb-5" data-aos="fade-up">Produk</h2>
      <div class="row">
        @php
          $produkList = [
            [
              'title' => 'Chiki Twist',
              'desc' => 'Informasi lengkap tentang pendaftaran siswa baru untuk tahun ajaran 2024/2025.',
              'img' => 'storage/assets/chiki.jpg'
            ],
            [
              'title' => 'Jetz Sweet Stick',
              'desc' => 'Siswa SMK YPC Tasikmalaya berhasil meraih juara dalam kompetisi programming nasional.',
              'img' => 'storage/assets/jetz.jpg'
            ],
            [
              'title' => 'Teh Pucuk Harum',
              'desc' => 'SMK YPC Tasikmalaya menjalin kerjasama dengan perusahaan teknologi terkemuka.',
              'img' => 'storage/assets/pucuk.png'
            ],
          ];
        @endphp

        @foreach ($produkList as $i => $produk)
          <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ ($i+1)*100 }}">
            <div class="card h-100 shadow-sm border-0">
              <img
                src="{{ asset($produk['img']) }}"
                class="card-img-top"
                alt="{{ $produk['title'] }}"
              >
              <div class="card-body">
                <h5 class="card-title">{{ $produk['title'] }}</h5>
                <p class="card-text">{{ $produk['desc'] }}</p>
                <a href="#" class="btn btn-primary">Lihat Detail</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <section id="gallery" class="py-5">
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

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>

@endsection
