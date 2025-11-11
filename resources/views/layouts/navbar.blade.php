<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SMK YPC Tasikmalaya</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .navbar {
      background: linear-gradient(90deg, #007bff 0%, #0056d6 100%);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease-in-out;
    }

    .navbar-brand {
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: color 0.3s ease;
    }

    .navbar-brand:hover {
      color: #f8f9fa !important;
      text-shadow: 0 0 10px rgba(255,255,255,0.5);
    }

    .nav-link {
      font-weight: 500;
      color: #e9ecef !important;
      margin-left: 1rem;
      position: relative;
      transition: all 0.3s ease;
    }

    .nav-link::after {
      content: "";
      position: absolute;
      width: 0%;
      height: 2px;
      left: 0;
      bottom: 0;
      background-color: #fff;
      transition: width 0.3s ease-in-out;
    }

    .nav-link:hover::after {
      width: 100%;
    }

    .nav-link.active {
      color: #fff !important;
      font-weight: 600;
    }

    /* Efek sticky dengan transparansi */
    .navbar.sticky-top {
      backdrop-filter: blur(8px);
      background: rgba(0, 86, 214, 0.85);
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="{{ asset('storage/assets/iconss.png') }}" alt="SMK YPC Tasikmalaya" width="30" height="30" class="me-2">
        Marketplace SMK YPC Tasikmalaya
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto text-center">
          <li class="nav-item">
            <a class="nav-link active" href="/#home">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/#about">Tentang Kami</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/#news">Produk</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/#gallery">Galeri</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/#contact">Kontak</a>
          </li>
          @auth
            <li class="nav-item">
              <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link nav-link text-white">Logout</button>
              </form>
            </li>
          @else
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
