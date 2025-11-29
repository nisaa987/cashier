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

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .btn-tambah {
        background-color: #198754;
        color: white;
        padding: 8px 15px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
    }

    .btn-tambah i {
        margin-right: 5px;
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
        <div class="header-section">
            <h4><i class="fas fa-boxes-packing"></i> Data Barang Masuk</h4>
            <a href="{{ route('barang-masuk.create') }}" class="btn-tambah">
                <i class="fas fa-plus-circle"></i> Tambah Barang Masuk
            </a>
        </div>

        <form action="{{ route('barang-masuk.index') }}" method="GET" class="filter-bar row g-3 mb-3">
            <div class="col-md-4">
                <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" value="{{ $tanggal_awal }}">
            </div>
            <div class="col-md-4">
                <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{ $tanggal_akhir }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-50 me-2"> Tampilkan</button>
                @if($tanggal_awal || $tanggal_akhir)
                    <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary w-50"><i class="fas fa-times"></i> Reset</a>
                @endif
            </div>
        </form>

        <div class="search-bar mb-3">
            <i class="fas fa-search"></i>
            <form action="{{ route('barang-masuk.index') }}" method="GET" style="display: flex; width: 100%;">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari barang masuk..." 
                    value="{{ $search }}"
                >
                @if($search)
                    <button 
                        type="button" 
                        onclick="window.location='{{ route('barang-masuk.index') }}'" 
                        style="background: none; border: none; font-size: 18px; margin-left: 10px; color: #888; cursor: pointer;" 
                        title="Clear Search"
                    >&times;</button>
                @endif
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-hover">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Input</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $item)
                    <tr>
                        <td class="text-center">{{ $data->firstItem() + $index }}</td>
                        <td>{{ $item->barang->nama_barang }}</td>
                        <td class="text-center">{{ $item->jumlah }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_input)->format('d M Y') }}</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                        <td class="text-center">
                            <form action="{{ route('barang-masuk.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger btn-action" type="submit">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada data barang masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($data->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    {{ $data->firstItem() ?? 0 }} 
                    sampai {{ $data->lastItem() ?? 0 }} 
                    dari total {{ $data->total() }} data
                </div>

                <div class="pagination-wrapper">
                    {{-- Tombol Prev --}}
                    @if ($data->onFirstPage())
                        <span class="disabled">&laquo; </span>
                    @else
                        <a href="{{ $data->previousPageUrl() }}" rel="prev">&laquo; </a>
                    @endif

                    @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                        @if ($page == $data->currentPage())
                            <span class="active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($data->hasMorePages())
                        <a href="{{ $data->nextPageUrl() }}" rel="next"> &raquo;</a>
                    @else
                        <span class="disabled">Next &raquo;</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
