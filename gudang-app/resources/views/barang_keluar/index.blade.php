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

    .btn-action {
        margin-right: 5px;
    }

    .table-wrapper {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
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

    .filter-bar input, .search-bar input {
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
        color: #f8f3f3ff;
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
        <h4><i class="fas fa-dolly"></i> Data Barang Keluar</h4>

        <form action="{{ route('barangkeluar.index') }}" method="GET" class="filter-bar row g-3 mb-3">
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
                    <a href="{{ route('barangkeluar.index') }}" class="btn btn-secondary w-50"><i class="fas fa-times"></i> Reset</a>
                @endif
            </div>
        </form>

        {{-- 🔍 Search --}}
        <form action="{{ route('barangkeluar.index') }}" method="GET" class="search-bar mb-3">
            <i class="fas fa-search"></i>
            <input 
                type="text" 
                name="search" 
                placeholder="Cari barang keluar..." 
                value="{{ request('search') }}"
                onkeydown="if(event.key === 'Enter'){ this.form.submit(); }"
            >
            <button type="submit" class="btn btn-primary ms-2"><i class="fas fa-search"></i></button>
            @if(request('search'))
                <a href="{{ route('barangkeluar.index') }}" class="btn btn-secondary ms-2"><i class="fas fa-times"></i> Reset</a>
            @endif
        </form>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-hover">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Tanggal Keluar</th>
                    <th>Tanggal Input</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangKeluar as $index => $bk)
                    <tr>
                        <td class="text-center">{{ $barangKeluar->firstItem() + $index }}</td>
                        <td>{{ $bk->nama_barang }}</td>
                        <td class="text-center">{{ $bk->jumlah_keluar }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($bk->tanggal_keluar)->format('d M Y') }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($bk->tanggal_input)->format('d M Y') }}</td>
                        <td>{{ $bk->keterangan ?? '-' }}</td>
                        <td class="text-center">
                            <form action="{{ route('barangkeluar.destroy', $bk->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger btn-action" type="submit">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                            <a href="{{ route('barangkeluar.struk', $bk->id) }}" target="_blank" class="btn btn-sm btn-success btn-action">
                                <i class="fas fa-print"></i> Struk
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada data barang keluar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($barangKeluar->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    {{ $barangKeluar->firstItem() ?? 0 }} 
                    sampai {{ $barangKeluar->lastItem() ?? 0 }} 
                    dari total {{ $barangKeluar->total() }} data
                </div>

                <div class="pagination-wrapper">
                    {{-- Tombol Prev --}}
                    @if ($barangKeluar->onFirstPage())
                        <span class="disabled">&laquo; </span>
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
</div>
@endsection
