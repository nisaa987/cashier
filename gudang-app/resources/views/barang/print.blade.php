<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Print QR Code - {{ $barang->nama_barang }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px;
            max-width: 350px;
            margin: auto;
            color: #222;
            background: #fff;
            text-align: center;
        }
        h3 {
            margin-bottom: 6px;
            font-size: 18px;
            font-weight: 600;
        }
        p { margin: 2px 0; }
        hr {
            border: none;
            border-top: 1px dashed #aaa;
            margin: 12px 0;
        }
        .qrcode { margin: 15px 0; }
        .btn-group { margin-top: 20px; text-align: center; }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin: 6px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 6px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
        }
        .btn-back { background-color: #28a745; }
        @media print {
            .btn-group { display: none; }
        }
    </style>
</head>
<body>
    <h3>{{ $barang->nama_barang }}</h3>
    <p>Stok: {{ $barang->stok }}</p>
    <hr>

    <div class="qrcode">
        {!! QrCode::size(150)->generate($barang->id) !!}
        <p>{{ $barang->id }}</p>
    </div>

    <hr>
    <p><em>QR Code Barang</em></p>

    <div class="btn-group">
        <a href="{{ route('barang.index') }}" class="btn btn-back">Kembali</a>
        <a href="#" class="btn" onclick="window.print()">Cetak Ulang</a>
    </div>

    <script>
        window.onload = function() {
            setTimeout(() => window.print(), 500);
        };
    </script>
</body>
</html>
