@extends('layouts.app')

@section('title', 'Tambah Pelanggan')

@section('content')
<style>
    form label {
        font-weight: bold;
        color:rgb(9, 9, 9);
    }
    form button {
        margin-top: 15px;
    }
</style>


<h2>Tambah Pelanggan</h2>
<form action="{{ route('pelanggan.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Nama Pelanggan</label>
        <input type="text" name="namaPelanggan" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
        <label>Nomor Telepon</label>
        <input type="text" name="nomor_telepon" class="form-control" required>
    </div>
    <label for="jenis_pelanggan">Jenis Pelanggan:</label>
    <select name="jenis_pelanggan" id="jenis_pelanggan" class="form-control">
        <option value="biasa">Biasa</option>
        <option value="member">Member (5% Diskon)</option>
        <option value="vip">VIP (10% Diskon)</option>
    </select>
    <button type="submit" class="btn btn-success">Simpan</button>
</form>
@endsection
