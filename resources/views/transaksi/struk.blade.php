<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Struk Pembelian</title>
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
    <h3 class="center">Nisa Café</h3>
    <p class="center">Jl. Contoh No. 123, Kota ABC</p>
    <hr>

    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($penjualan->tanggalPenjualan)->format('d M Y H:i') }}</p>
    <p><strong>Pelanggan:</strong> {{ optional($penjualan->pelanggan)->namaPelanggan }}</p>
    <p><strong>Kasir:</strong> {{ $namaKasir }}</p>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualan->detailPenjualan as $detail)
            <tr>
                <td>{{ optional($detail->produk)->namaProduk }}</td>
                <td>{{ $detail->jumlahProduk }}</td>
                <td class="text-end">Rp {{ number_format($detail->subTotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <hr>
    <table>
        <tr>
            <td><strong>Subtotal</strong></td>
            <td class="text-end">Rp {{ number_format($totalHargaSebelumDiskon, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Diskon ({{ ucfirst(optional($penjualan->pelanggan)->jenis_pelanggan) }} - {{ $diskonRate * 100 }}%)</strong></td>
            <td class="text-end">-Rp {{ number_format($diskon, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Bayar</strong></td>
            <td class="text-end"><strong>Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td><strong>Pembayaran</strong></td>
            <td class="text-end">Rp {{ number_format($pembayaran ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Kembalian</strong></td>
            <td class="text-end">Rp {{ number_format($kembalian ?? 0, 0, ',', '.') }}</td>
        </tr>
    </table>

    <hr>
    <h4 class="center">Total Bayar: Rp {{ number_format($totalHarga, 0, ',', '.') }}</h4>
    <p class="footer">Terima kasih telah berkunjung ke Nisa Café!</p>

    <div class="btn-group">
        <a href="{{ route('laporan.index') }}" class="btn">Selesai</a>
        <a href="{{ route('transaksi.printStruk', $penjualan->PenjualanID) }}" class="btn btn-print">Cetak Ulang</a>
        <a href="{{ route('transaksi.cetakPdf', $penjualan->PenjualanID) }}" class="btn btn-export" target="_blank">Export PDF</a>
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
