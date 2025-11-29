<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<title>Kasir App Nisa Café - Simpel</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap');

  :root {
    --primary-color: #4b5563; /* abu gelap (Gray-600) */
    --bg-color: #f3f4f6;      /* abu sangat terang (Gray-100) */
    --text-color: #1f2937;    /* abu sangat gelap (Gray-800) */
    --text-light: #6b7280;    /* abu medium (Gray-500) */
    --sidebar-bg: #e5e7eb;    /* abu terang (Gray-200) */
    --sidebar-hover: #d1d5db; /* abu medium (Gray-300) */
  }

  * {
    box-sizing: border-box;
  }
  html, body {
    margin: 0; padding: 0; height: 100%;
    font-family: 'Poppins', sans-serif;
    background: var(--bg-color);
    color: var(--text-color);
    display: flex;
    flex-direction: row;
    overflow: hidden;  /* supaya tidak muncul scrollbar horizontal */
  }

  body {
    height: 100vh;  /* full viewport height */
  }

  .container {
  display: flex;
  flex-direction: row;
  height: 100vh;
  width: 100vw;
  overflow: hidden;
  }


  .sidebar {
    width: 220px;
    background: var(--sidebar-bg);
    border-right: 1px solid #cbd5e1;
    display: flex;
    flex-direction: column;
    padding: 40px 20px;
    height: 100vh;    /* full height */
    box-sizing: border-box;
  }
  .sidebar h2 {
    font-weight: 600;
    font-size: 1.8rem;
    margin-bottom: 50px;
    text-align: center;
    color: var(--primary-color);
  }
  nav {
    display: flex;
    flex-direction: column;
    gap: 18px;
  }
  nav label, nav a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 18px;
    font-weight: 600;
    font-size: 1.1rem;
    color: var(--text-color);
    text-decoration: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.2s ease;
  }
  nav label:hover, nav a:hover {
    background-color: var(--sidebar-hover);
    color: var(--primary-color);
  }
  nav label i, nav a i {
    font-size: 1.3rem;
    width: 22px;
    text-align: center;
  }
  input[type="radio"] {
    display: none;
  }
  #tab-selamat:checked ~ .sidebar nav label[for="tab-selamat"],
  #tab-terlaris:checked ~ .sidebar nav label[for="tab-terlaris"],
  #tab-produk:checked ~ .sidebar nav label[for="tab-produk"] {
    background-color: var(--primary-color);
    color: #fff;
  }

  .logout-form {
    margin-top: auto;
    text-align: center;
  }
  .logout-button {
    width: 100%;
    background: var(--primary-color);
    border: none;
    padding: 12px 0;
    color: #fff;
    font-weight: 600;
    border-radius: 25px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s ease;
  }
  .logout-button:hover {
    background: #374151;
  }

  .main-content {
    flex: 1; /* alias dari flex-grow: 1; flex-shrink: 1; flex-basis: 0 */
    padding: 40px 50px;
    background: #fff;
    overflow-y: auto;
    min-width: 0;
    height: 100vh;
    box-sizing: border-box;
  }

  .main-content h1 {
    font-weight: 600;
    font-size: 2.8rem;
    margin-bottom: 16px;
    color: var(--primary-color);
  }
  .main-content p {
    font-weight: 300;
    font-size: 1.15rem;
    color: var(--text-light);
    margin-bottom: 40px;
  }

  .menu-list {
    display: grid;
    grid-template-columns: repeat(auto-fill,minmax(280px,1fr));
    gap: 24px;
  }
  .menu-card {
    background: var(--bg-color);
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    padding: 20px;
    cursor: pointer;
    transition: box-shadow 0.25s ease, background-color 0.3s ease;
  }
  .menu-card:hover {
    box-shadow: 0 8px 20px rgba(75, 85, 99, 0.3);
    background-color: #f9fafb;
  }
  .menu-card img {
    width: 100%;
    height: 180px;
    border-radius: 12px;
    object-fit: cover;
    margin-bottom: 16px;
  }
  .menu-info h3 {
    margin: 0 0 8px;
    font-weight: 600;
    color: var(--primary-color);
    font-size: 1.3rem;
  }
  .menu-desc {
    font-weight: 300;
    font-size: 1rem;
    color: var(--text-light);
  }

  .content-section {
    display: none;
  }
  #tab-selamat:checked ~ .main-content #selamat,
  #tab-terlaris:checked ~ .main-content #terlaris,
  #tab-produk:checked ~ .main-content #produk {
    display: block;
  }

  @media (max-width: 900px) {
    body {
      flex-direction: column;
    }
    .sidebar {
      width: 100%;
      border-right: none;
      border-bottom: 1px solid #cbd5e1;
      padding: 20px 10px;
      flex-direction: row;
      justify-content: center;
      gap: 12px;
      overflow-x: auto;
      height: auto;  /* supaya di mobile tingginya otomatis */
    }
    .sidebar h2 {
      display: none;
    }
    nav {
      flex-direction: row;
      gap: 12px;
    }
    nav label, nav a {
      padding: 8px 12px;
      font-size: 0.95rem;
    }
    .main-content {
      padding: 30px 25px;
      width: 100%;
      height: auto;    /* supaya di mobile tingginya otomatis */
    }
    .menu-list {
      grid-template-columns: repeat(auto-fill,minmax(220px,1fr));
      gap: 18px;
    }
    .menu-card img {
      height: 140px;
    }
  }

  @media (max-width: 480px) {
    .menu-list {
      grid-template-columns: 1fr;
    }
    .menu-card img {
      height: 160px;
    }
  }

</style>
</head>
<body>
  <div class="container">

  <input type="radio" name="tabs" id="tab-selamat" checked />
  <input type="radio" name="tabs" id="tab-terlaris" />
  <input type="radio" name="tabs" id="tab-produk" />

  <div class="sidebar">
    <h2>Kasir App</h2>
    <nav>
      <a href="user"><i class="fas fa-user"></i> User</a>
      <a href="pelanggan"><i class="fas fa-users"></i> Pelanggan</a>
      <a href="produk"><i class="fas fa-box"></i> Produk</a>
      <a href="laporan"><i class="fas fa-file-alt"></i> Laporan</a>
      <a href="transaksi"><i class="fas fa-cash-register"></i> Transaksi</a>
    </nav>
<form method="POST" action="{{ route('logout') }}" style="margin-top: auto; text-align: center;">
    @csrf
    <button type="submit"
        style="
            width: 100%;
            background: var(--primary-color);
            border: none;
            padding: 12px 0;
            color: #fff;
            font-weight: 600;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        "
        onmouseover="this.style.background='#374151';"
        onmouseout="this.style.background='var(--primary-color)';"
    >
        Logout
    </button>
</form>

  </div>

  <div class="main-content">
    <div style="
      max-width: 700px;
      margin: 80px auto;
      padding: 20px;
      text-align: center;
      font-family: 'Poppins', sans-serif;
      color: #444;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeInUp 1s ease-out forwards;
    ">
      <h1 style="
        font-size: 42px;
        font-weight: 600;
        margin-bottom: 14px;
        color: #2f2f2f;
      ">
        SELAMAT DATANG
      </h1>
      <h2 style="
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        letter-spacing: 6px;
        font-weight: 500;
        color: #6b7280;
        margin-top: 0;
      ">
        K a s i r &nbsp;&nbsp; A p p &nbsp;&nbsp; N i s a
      </h2>
    </div>

    <!-- Animasi keyframes tetap harus didefinisikan dalam <style> karena tidak bisa inline -->
    <style>
    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    </style>
<div style="max-width: 960px; margin: 0 auto 40px; display: flex; gap: 24px; flex-wrap: wrap;">

  <!-- Tabel Pemasukan -->
  <div class="income-summary" style="flex: 1 1 320px; background: #f9fafb; border-radius: 16px; box-shadow: 0 4px 12px rgba(75,85,99,0.1); padding: 24px;">
    <h2 style="font-weight: 700; font-size: 1.8rem; margin-bottom: 20px; color: var(--primary-color); text-align: center;">Pemasukan</h2>
    <table style="width: 100%; border-collapse: separate; border-spacing: 0 12px; font-weight: 600; font-size: 1.2rem; color: var(--text-color);">
      <thead>
        <tr>
          <th style="text-align: center; font-weight: 700; color: var(--primary-color); padding-bottom: 8px;">Periode</th>
          <th style="text-align: right; font-weight: 700; color: var(--primary-color); padding-bottom: 8px;">Jumlah</th>
        </tr>
      </thead>
      <tbody>
        <tr style="background: #ffffff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
          <td style="padding: 12px 16px; text-align: center; color: var(--text-light); font-size: 0.9rem;">Hari ini</td>
          <td style="padding: 12px 16px; text-align: right;">Rp {{ number_format($todayIncome ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr style="background: #ffffff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
          <td style="padding: 12px 16px; text-align: center; color: var(--text-light); font-size: 0.9rem;">Minggu ini</td>
          <td style="padding: 12px 16px; text-align: right;">Rp {{ number_format($weekIncome ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr style="background: #ffffff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
          <td style="padding: 12px 16px; text-align: center; color: var(--text-light); font-size: 0.9rem;">Bulan ini</td>
          <td style="padding: 12px 16px; text-align: right;">Rp {{ number_format($monthIncome ?? 0, 0, ',', '.') }}</td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Tabel Produk Terlaris -->
  <div style="flex: 1 1 600px; font-family: Arial, sans-serif; background-color: #f7f9fc; border-radius: 16px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); padding: 30px;">
    <h2 style="color: var(--text-light);; font-weight: 700; font-size: 1.8rem; margin-bottom: 30px;">🔥 5 Produk Terlaris</h2>

    @if($bestSellers->isEmpty())
      <p style="color: #888; font-style: italic;">Tidak ada data best seller saat ini.</p>
    @else
      <table style="width: 100%; border-collapse: collapse; font-size: 1.1rem; color: var(--text-color);">
        <thead>
          <tr style="background-color: #f3f4f6;">
            <th style="text-align: left; padding: 12px 15px; border-bottom: 2px solid #ddd;">Nama Produk</th>
            <th style="text-align: right; padding: 12px 15px; border-bottom: 2px solid #ddd;">Terjual</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($bestSellers as $item)
            <tr>
              <td style="padding: 12px 15px; border-bottom: 1px solid #eee;">
                @if($item->produk)
                  {{ $item->produk->namaProduk }}
                @else
                  Produk tidak ditemukan (ID: {{ $item->produkID }})
                @endif
              </td>
              <td style="padding: 12px 15px; border-bottom: 1px solid #eee; text-align: right;">
                {{ $item->total_terjual }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif

    <a href="{{ route('laporan.index') }}" style="
      display: inline-block;
      margin-top: 30px;
      font-weight: 600;
      color: #4a90e2;
      text-decoration: none;
      transition: color 0.3s ease;
    "
    onmouseover="this.style.color='#357ABD'; this.style.textDecoration='underline';"
    onmouseout="this.style.color='#4a90e2'; this.style.textDecoration='none';"
    >
      Lihat Detail Laporan &rarr;
    </a>
  </div>
</div>


<section id="produk" class="content-section" style="font-family: Arial, sans-serif; max-width: 960px; margin: 40px auto; padding: 0 20px;">
  <h1>Daftar Produk</h1>
  <p>Semua menu yang tersedia:</p>
  <ul style="list-style: none; padding-left: 0; font-size: 1.1rem; color: #222;">
    <li style="padding: 6px 0; border-bottom: 1px solid #ddd;">Espresso</li>
    <li style="padding: 6px 0; border-bottom: 1px solid #ddd;">Latte</li>
    <li style="padding: 6px 0; border-bottom: 1px solid #ddd;">Chocolate Cake</li>
  </ul>
</section>

</div>
  </body>
</html>
