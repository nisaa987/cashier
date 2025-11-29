@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #f0f4ff, #dbeafe);
        font-family: 'Segoe UI', sans-serif;
    }

    .detail-container {
        max-width: 800px;
        margin: 60px auto;
        background: #ffffff;
        padding: 30px 40px;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        display: flex;
        align-items: flex-start;
        gap: 25px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .detail-container:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    }

    .foto-barang {
        flex: 0 0 200px;
    }

    .foto-barang img {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 12px;
        border: 3px solid #f1f5f9;
        background: #f8fafc;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .info-barang {
        flex: 1;
    }

    .info-barang h2 {
        font-size: 26px;
        margin-bottom: 15px;
        color: #1e293b;
        font-weight: 600;
    }

    .info-barang p {
        font-size: 16px;
        margin: 8px 0;
        color: #475569;
        line-height: 1.6;
    }

    .info-barang p strong {
        color: #1e40af;
    }

    .btn-back {
        display: inline-block;
        margin-top: 30px;
        padding: 10px 18px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #fff;
        border-radius: 8px;
        text-decoration: none;
        font-size: 15px;
        font-weight: 500;
        box-shadow: 0 3px 8px rgba(37, 99, 235, 0.3);
        transition: background 0.3s, transform 0.2s;
    }

    .btn-back:hover {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        transform: translateY(-2px);
    }
</style>

<div class="detail-container">
    <div class="foto-barang">
        @if($barang->foto)
            <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}">
        @else
            <img src="https://via.placeholder.com/200" alt="No Foto">
        @endif
    </div>

    <div class="info-barang">
        <h2>{{ $barang->nama_barang }}</h2>
        <p><strong>Stok:</strong> {{ $barang->stok }}</p>
        {{-- <p><strong>Harga:</strong> Rp{{ number_format($barang->harga, 0, ',', '.') }}</p> --}}

        @if($barang->satuan_barang)
            <p><strong>Satuan:</strong> {{ $barang->satuan_barang }}</p>
        @endif

        @if($barang->kategori)
            <p><strong>Kategori:</strong> {{ $barang->kategori }}</p>
        @endif

        @if($barang->deskripsi)
            <p><strong>Deskripsi:</strong> {{ $barang->deskripsi }}</p>
        @endif

        <a href="{{ route('barang_keluar.create') }}" class="btn-back">&larr; Kembali</a>
    </div>
</div>
@endsection
