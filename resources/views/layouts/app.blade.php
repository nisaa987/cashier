<!DOCTYPE html>
<html lang="id"> 
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> 

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-custom {
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 0 0 12px 12px;
        }
        .navbar-custom a {
            color: #333;
            margin-right: 20px;
            font-weight: 500;
        }
        .navbar-custom a:hover {
            text-decoration: underline;
            color:rgb(253, 253, 253);
        }
        .content-container {
            padding: 30px;
        }
    </style>
</head> 
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom px-4 py-3">
        <div class="container-fluid justify-content-center">
            <a href="home" class="nav-link">Home</a>
            <a href="user" class="nav-link">User</a>
            <a href="pelanggan" class="nav-link">Pelanggan</a>
            <a href="produk" class="nav-link">Produk</a>
            <a href="laporan" class="nav-link">Laporan</a>
            <a href="transaksi" class="nav-link">Transaksi</a>
        </div>

    </nav>

    <!-- Main Content -->
    <div class="container content-container"> 
        @yield('content') 
    </div> 

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</body> 
</html>
