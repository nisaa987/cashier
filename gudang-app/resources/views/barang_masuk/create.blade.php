@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />

<div class="container">
    <h4><i class="fas fa-plus-circle"></i> Tambah Barang Masuk</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('barang-masuk.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="barang_id">Pilih Barang</label>
            <select name="barang_id" id="barangSelect" class="form-control" required>
                <option value="">-- Pilih Barang --</option>
                @foreach($barang as $b)
                    <option value="{{ $b->id }}">{{ $b->nama_barang }}</option>
                @endforeach
                <option value="add_new_barang">🔧 Belum ada barang? Tambahkan barang</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="jumlah">Jumlah Masuk</label>
            <input type="number" name="jumlah" class="form-control" min="1" required>
        </div>

        <div class="form-group mb-3">
            <label for="tanggal">Tanggal Masuk</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

                <div class="form-group mb-3">
            <label for="tanggal_input">Tanggal Input</label>
            <input type="date" name="tanggal_input" class="form-control" required>
        </div>

        <div class="form-group mb-4">
            <label for="keterangan">Keterangan (Opsional)</label>
            <input type="text" name="keterangan" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Simpan
        </button>
        <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const barangSelect = document.getElementById('barangSelect');
        barangSelect.addEventListener('change', function () {
            if (this.value === 'add_new_barang') {
                // Redirect ke form barang.create dan kirim query dari barang-masuk
                window.location.href = "{{ route('barang.create', ['from' => 'barang-masuk']) }}";
            }
        });
    });
</script>
@endsection
