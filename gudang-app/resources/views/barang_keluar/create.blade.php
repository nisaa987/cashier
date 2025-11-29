@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Tambah Barang Keluar</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger"> 
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<div class="card mb-3">
    <div class="card-body">
        <p><strong>Nama Barang:</strong> {{ optional($barang)->nama_barang ?? '-' }}</p>
        <p><strong>Stok Sekarang:</strong> {{ optional($barang)->stok ?? '-' }}</p>
        <p><strong>Satuan:</strong> {{ optional($barang)->satuan_barang ?? '-' }}</p>
    </div>
</div>

    <form method="POST" action="{{ route('barangkeluar.store') }}">
        @csrf
        <input type="hidden" name="barang_id" value="{{ $barang->id ?? '' }}">
        <input type="hidden" name="nama_barang" value="{{ $barang->nama_barang ?? '' }}">

        <div class="mb-3">
            <label>Jumlah Keluar</label>
            <input type="number" name="jumlah_keluar" 
                   class="form-control" 
                   max="{{ $barang->stok ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label>Tanggal Keluar</label>
            <input type="date" name="tanggal_keluar" 
                   class="form-control" 
                   value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label>Tanggal Input</label>
            <input type="date" name="tanggal_input" 
                   class="form-control" 
                   value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"></textarea>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
    </form>

    <!-- @if(!empty($barang->id))
        <a href="{{ route('barang.show', $barang->id) }}">Lihat Detail</a>
    @endif -->
</div>
@endsection
