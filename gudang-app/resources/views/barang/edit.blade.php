@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
    }

    .form-container {
        max-width: 600px;
        background: #ffffff;
        padding: 30px 40px;
        margin: 40px auto;
        border-radius: 10px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .form-container h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
    }

    label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        color: #2c3e50;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        box-sizing: border-box;
    }

    .text-danger {
        color: red;
        font-size: 13px;
        margin-top: -10px;
        margin-bottom: 10px;
        display: block;
    }

    .btn-wrapper {
        display: flex;
        justify-content: space-between;
        margin-top: 25px;
    }

    .btn-simpan, .btn-kembali {
        padding: 10px 25px;
        font-weight: bold;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        cursor: pointer;
        text-decoration: none;
        transition: 0.3s ease;
        color: #fff;
    }

    .btn-simpan {
        background-color: #28a745;
    }

    .btn-simpan:hover {
        background-color: #218838;
    }

    .btn-kembali {
        background-color: #dc3545;
    }

    .btn-kembali:hover {
        background-color: #c82333;
    }
</style>

<div class="form-container">
    <h2>✏️ Edit Barang</h2>

    <form action="{{ route('barang.update', $barang->id) }}" method="POST" class="mt-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" name="tanggal" value="{{ $barang->tanggal }}" required>
        </div>

        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" name="nama_barang" value="{{ $barang->nama_barang }}" required>
        </div>

        <!-- <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="text" class="form-control" name="harga" value="{{ $barang->harga }}" required>
        </div> -->
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control" name="stok" value="{{ $barang->stok }}" required>
        </div>

        <div class="mb-3">
            <label for="satuan_barang" class="form-label">Satuan</label>
            <input type="text" class="form-control" name="satuan" value="{{ $barang->satuan_barang  }}" required>
        </div>

    </form>
    
    <div class="btn-wrapper">
            <a href="{{ route('barang.index') }}" class="btn-kembali">⬅️ Batal</a>
            <button type="submit" class="btn-simpan">✅ Update</button>
        </div>
    </form>
</div>

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
