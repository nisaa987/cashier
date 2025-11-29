<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name', 'Gudang App') }}</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap');
    :root {
      --main-dark: #272323ff;
    }

    body, html {
      height: 100%;
      overflow-y: auto;
    }

    body {
      font-family: 'Inter', sans-serif;
    }

    .navbar.bg-custom-dark {
      background-color: var(--main-dark) !important;
    }

    .sidebar {
      width: 250px;
      height: 100vh;
      background-color: var(--main-dark);
      color: white;
      position: fixed;
      left: 0;
      top: 0;
      transform: translateX(-100%);
      transition: transform 0.3s ease;
      z-index: 999;
    }

    .sidebar.show {
      transform: translateX(0);
    }

    .sidebar .nav-link,
    .sidebar .btn {
      color: white;
    }

    .sidebar .nav-link:hover,
    .sidebar .btn:hover {
      background-color: #555050ff;
    }

    .content {
      transition: margin-left 0.3s ease;
      padding-top: 80px;
      padding-bottom: 50px;
    }

    /* Content bergeser saat sidebar muncul */
    .content.shifted {
      margin-left: 250px; /* Sama dengan lebar sidebar */
    }

    /* Overlay saat sidebar muncul */
    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.4);
      z-index: 998;
      display: none;
    }
    .overlay.show {
      display: block;
    }

    .avatar-img {
      border: 2px solid white;
      object-fit: cover;
    }

    .navbar {
      z-index: 1000;
    }
  </style>
</head>
<body>

@php
  $isLoginPage = Request::is('login');
@endphp

@if (!$isLoginPage)
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-custom-dark navbar-dark fixed-top">
    <div class="container-fluid">
      <span class="navbar-brand mb-0 h1" onclick="toggleSidebar()" style="cursor: pointer;">
        <i class="fas fa-bars me-2"></i>Inventory
      </span>
      <div class="d-flex ms-auto align-items-center">
        @auth
          <span class="text-white me-3">Halo, {{ Auth::user()->name }}</span>
          <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" alt="Profile" class="rounded-circle avatar-img" width="35" height="35">
        @endauth
      </div>
    </div>
  </nav>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <ul class="nav flex-column p-3 pt-5">
      <li class="nav-item">
        <a href="{{ url('/dashboard') }}" class="nav-link"><i class="fas fa-home me-2"></i> Dashboard</a>
      </li>
      <li class="nav-item">
        <a href="{{ url('/user') }}" class="nav-link"><i class="fas fa-users me-2"></i> Pengguna</a>
      </li>

      <!-- Barang -->
      <button class="btn w-100 text-start" data-bs-toggle="collapse" data-bs-target="#barangMenu">
        <i class="fas fa-box-open me-2"></i> Barang
      </button>
      <div class="collapse ps-3" id="barangMenu">
        <a href="{{ route('barang.index') }}" class="nav-link"><i class="fas fa-boxes me-2"></i> Daftar Barang</a>
        <a href="{{ route('barang_masuk.index') }}" class="nav-link"><i class="fas fa-boxes-packing me-2"></i> Barang Masuk</a>
        <a href="{{ route('barang_keluar.index') }}" class="nav-link"><i class="fas fa-truck me-2"></i> Barang Keluar</a>
      </div>

      <!-- Laporan -->
      <button class="btn w-100 text-start mt-2" data-bs-toggle="collapse" data-bs-target="#laporanMenu">
        <i class="fas fa-chart-line me-2"></i> Laporan
      </button>
      <div class="collapse ps-3" id="laporanMenu">
        <a href="{{ route('laporan.masuk') }}" class="nav-link">
          <i class="fas fa-arrow-down me-2"></i> Barang Masuk
        </a>
        <a href="{{ route('laporan.keluar') }}" class="nav-link">
          <i class="fas fa-arrow-up me-2"></i> Barang Keluar
        </a>
      </div>

      <!-- Logout -->
      <li class="nav-item mt-2">
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn text-white w-100 text-start">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
          </button>
        </form>
      </li>
    </ul>
  </div>

  <!-- Overlay -->
  <div class="overlay" id="overlay"></div>
@endif

<!-- Content -->
<div class="content" id="mainContent">
  <div class="container">
    @yield('content')
  </div>
</div>

<!-- Bootstrap Bundle JS (sudah termasuk Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('mainContent');
  const overlay = document.getElementById('overlay');

  function toggleSidebar() {
    sidebar.classList.toggle('show');
    mainContent.classList.toggle('shifted');
    overlay.classList.toggle('show');
  }

  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && sidebar.classList.contains('show')) {
      toggleSidebar();
    }
  });

  overlay.addEventListener('click', function() {
    toggleSidebar();
  });
</script>
</body>
</html>
