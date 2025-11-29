@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Laporan Barang Masuk dan Keluar</h1>

    {{-- Filter tanggal --}}
    <form method="GET" action="{{ route('laporan.index') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
        </div>
        <div class="col-md-4">
            <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-dark w-100">Tampilkan</button>
        </div>
    </form>

    <div class="row">
        {{-- Barang Masuk --}}
        <div class="col-md-6 mb-4">
            <div class="card border">
                <div class="card-header bg-light fw-bold">Barang Masuk</div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Tanggal Masuk</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barangMasuk as $index => $bm)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $bm->barang->nama_barang ?? '-' }}</td>
                                    <td>{{ $bm->jumlah }}</td>
                                    <td>{{ $bm->tanggal }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data barang masuk</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Barang Keluar --}}
        <div class="col-md-6 mb-4">
            <div class="card border">
                <div class="card-header bg-light fw-bold">Barang Keluar</div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Tanggal Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barangKeluar as $index => $bk)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $bk->nama_barang }}</td>
                                    <td>{{ $bk->jumlah_keluar }}</td>
                                    <td>{{ $bk->tanggal_keluar }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data barang keluar</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
