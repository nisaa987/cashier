@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />

<style>
    .table thead {
        background-color: #343a40;
        color: white;
    }

    .table td, .table th {
        vertical-align: middle;
    }

    .table-wrapper {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    h4 {
        margin-bottom: 20px;
        font-weight: bold;
        color: #343a40;
    }

    .filter-bar, .search-bar {
        background: #fff;
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .filter-bar input {
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 6px 10px;
    }

    .filter-bar button, .search-bar button {
        border-radius: 6px;
        padding: 6px 15px;
    }

    .search-bar {
        display: flex;
        align-items: center;
    }

    .search-bar i {
        margin-right: 10px;
        color: #888;
    }

    .search-bar input[type="text"] {
        width: 100%;
        border: none;
        outline: none;
        font-size: 16px;
    }

        .pagination-wrapper {
    display: flex;
    gap: 6px;
    justify-content: flex-end;
    align-items: center;
}

.pagination-wrapper a, 
.pagination-wrapper span {
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    border: 1px solid #ddd;
    color: #333;
    transition: all 0.2s ease;
    font-size: 14px;
}

.pagination-wrapper a:hover {
    background: #007bff;
    color: #fff;
    border-color: #007bff;
}

.pagination-wrapper .active {
    background: #007bff;
    color: #fff;
    font-weight: bold;
    border-color: #007bff;
}

.pagination-wrapper .disabled {
    color: #aaa;
    cursor: not-allowed;
    background: #f8f9fa;
}
</style>

<div class="container mt-4">
    <div class="table-wrapper">
        <h4><i class="fas fa-arrow-up me-2"></i> Laporan Barang Keluar</h4>

        {{-- 🔎 Filter tanggal --}}
        <form method="GET" action="{{ route('laporan.keluar') }}" class="filter-bar row g-3 mb-3">
            <div class="col-md-4">
                <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
            </div>
            <div class="col-md-4">
                <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-50 me-2"> Tampilkan</button>
                @if(request('tanggal_awal') || request('tanggal_akhir'))
                    <a href="{{ route('laporan.keluar') }}" class="btn btn-secondary w-50"><i class="fas fa-times"></i> Reset</a>
                @endif
            </div>
        </form>

        {{-- 🔍 Search --}}
        <div class="search-bar mb-3">
            <i class="fas fa-search"></i>
            <form method="GET" action="{{ route('laporan.keluar') }}" style="display: flex; width: 100%;">
                <input type="text" name="search" placeholder="Cari barang keluar..." value="{{ request('search') }}">
                @if(request('search'))
                    <button type="button" onclick="window.location='{{ route('laporan.keluar') }}'" style="background:none;border:none;font-size:18px;margin-left:10px;color:#888;cursor:pointer;" title="Clear Search">&times;</button>
                @endif
            </form>
        </div>

        <table class="table table-bordered table-hover">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Tanggal Keluar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangKeluar as $index => $bk)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $bk->nama_barang }}</td>
                        <td class="text-center">{{ $bk->jumlah_keluar }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($bk->tanggal_keluar)->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Tidak ada data barang keluar</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
        @if ($barangKeluar->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted small">
            Menampilkan {{ $barangKeluar->firstItem() ?? 0 }} 
            sampai {{ $barangKeluar->lastItem() ?? 0 }} 
            dari total {{ $barangKeluar->total() }} data
        </div>

        <div class="pagination-wrapper">
            @if ($barangKeluar->onFirstPage())
                <span class="disabled">&laquo; Prev</span>
            @else
                <a href="{{ $barangKeluar->previousPageUrl() }}" rel="prev">&laquo; </a>
            @endif

            @foreach ($barangKeluar->getUrlRange(1, $barangKeluar->lastPage()) as $page => $url)
                @if ($page == $barangKeluar->currentPage())
                    <span class="active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            @if ($barangKeluar->hasMorePages())
                <a href="{{ $barangKeluar->nextPageUrl() }}" rel="next"> &raquo;</a>
            @else
                <span class="disabled">Next &raquo;</span>
            @endif
        </div>
    </div>
@endif

</div>
@endsection
