@extends('layouts.app')

@section('content')
<style>
    form label {
        font-weight: bold;
        color: #2c3e50;
    }
    form button {
        margin-top: 15px;
    }
    input[type="text"],
    input[type="number"],
    select,
    textarea {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }
    small#error-stok {
        color: red;
        display: none;
    }
</style>

<div class="container">
    <h2>Tambah Produk</h2>
    <form action="{{ route('produk.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="namaProduk" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="text" name="harga" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" min="0" oninput="validasiStok(this)" required>
            <small id="stok-error" style="color:red; display:none;">jumlah stok salah</small>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>

<script>
    function validasiStok(input) {
        const error = document.getElementById('stok-error');
        const value = parseInt(input.value);

        if (isNaN(value) || value <= 0) {
            error.style.display = 'block';
            input.setCustomValidity("Stok tidak boleh nol atau negatif");
        } else {
            error.style.display = 'none';
            input.setCustomValidity("");
        }
    }
</script>
@endsection
