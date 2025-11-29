@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Barang Keluar</h2>
    <form action="{{ route('barangkeluar.update', $barangKeluar->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="barang_id" class="form-label">Pilih Barang</label>
            <select name="barang_id" class="form-control" required>
                @foreach($barangs as $barang)
                    <option value="{{ $barang->id }}" {{ $barang->id == $barangKeluar->barang_id ? 'selected' : '' }}>
                        {{ $barang->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="jumlah_keluar" class="form-label">Jumlah Keluar</label>
            <input type="number" name="jumlah_keluar" class="form-control" value="{{ $barangKeluar->jumlah_keluar }}" required>
        </div>
        <div class="mb-3">
            <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
            <input type="date" name="tanggal_keluar" class="form-control" value="{{ $barangKeluar->tanggal_keluar }}" required>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ $barangKeluar->keterangan }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('barangkeluar.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
