<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Struk Barang Keluar</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px;
            max-width: 350px;
            margin: auto;
            color: #222;
            background: #fff;
        }
        .center {
            text-align: center;
        }
        h3 {
            margin-bottom: 4px;
            font-size: 18px;
            font-weight: 600;
        }
        p {
            margin: 2px 0;
        }
        .footer {
            margin-top: 16px;
            font-size: 11.5px;
            text-align: center;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 13px;
        }
        th {
            border-bottom: 1px solid #ccc;
            text-align: left;
            padding-bottom: 4px;
        }
        td {
            padding: 4px 0;
            vertical-align: top;
        }
        .text-end {
            text-align: right;
        }
        hr {
            border: none;
            border-top: 1px dashed #aaa;
            margin: 12px 0;
        }
        .btn-group {
            margin-top: 20px;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 8px 14px;
            margin: 6px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            border-radius: 6px;
            color: #fff;
            background-color: #28a745;
            border: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
            transition: background 0.3s ease;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .btn-print {
            background-color: #007bff;
        }
        .btn-export {
            background-color: #6f42c1;
        }
        h4 {
            font-size: 15px;
            font-weight: bold;
            margin-top: 12px;
            margin-bottom: 4px;
        }

        @media print {
            body {
                color: #000;
            }
            .btn-group {
                display: none;
            }
        }
    </style>
</head>
<body>
    <h3 class="center">PT. ForIT Asta Solusindo - SIDNet</h3>
    <p class="center">Jl. Kerkof No.35A, Cibeber, Kec.Cimahi Selatan, Kota Cimahi, Jawa Barat</p>
    <hr>

    <p><strong>Tanggal Keluar:</strong> {{ \Carbon\Carbon::parse($barangKeluar->tanggal_keluar)->format('d M Y') }}</p>
    <p><strong>Tanggal Input:</strong> {{ \Carbon\Carbon::parse($barangKeluar->tanggal_input)->format('d M Y') }}</p>
    <p><strong>Barang:</strong> {{ $barangKeluar->nama_barang }}</p>
    <p><strong>Jumlah:</strong> {{ $barangKeluar->jumlah_keluar }}</p>
    <p><strong>Keterangan:</strong> {{ $barangKeluar->keterangan }}</p>

    <hr>
    <h4 class="center">Barang Telah Keluar</h4>
    <p class="footer">Terima kasih! Data telah tercatat.</p>

    <div class="btn-group">
        <a href="{{ route('barangkeluar.index') }}" class="btn">Kembali</a>
        <a href="#" class="btn btn-print" onclick="window.print()">Cetak Ulang</a>
    </div>

    <script>
        window.onload = function () {
            setTimeout(() => {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
