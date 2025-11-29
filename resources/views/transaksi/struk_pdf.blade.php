<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembelian</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            max-width: 100%;
        }
        .center {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 4px 0;
            vertical-align: top;
        }
        .text-end {
            text-align: right;
        }
        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="center">
        <h4>Albana Store</h4>
        <p>Jl. Contoh No. 123, Kota ABC</p>
    </div>
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
            <td class="text-end">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
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
    <p class="center">Terima kasih telah berbelanja!</p>
</body>
</html>
