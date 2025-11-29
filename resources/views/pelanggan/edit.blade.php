@extends('layouts.app')

@section('content')
<style>
    form label {
        font-weight: bold;
        color:rgb(1, 1, 1);
    }
    form button {
        margin-top: 15px;
    }
</style>

<div class="container">
    <h2>Edit Pelanggan</h2>
    <form action="{{ route('pelanggan.update', $pelanggan->PelangganID) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nama Pelanggan</label>
            <input type="text" name="namaPelanggan" class="form-control" value="{{ $pelanggan->namaPelanggan }}" required>
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required>{{ $pelanggan->alamat }}</textarea>
        </div>
        <div class="mb-3">
            <label>Nomor Telepon</label>
            <input type="text" name="nomor_telepon" class="form-control" value="{{ $pelanggan->nomor_telepon }}" required>
        </div>

        <label for="jenis_pelanggan">Jenis Pelanggan:</label>
        <select name="jenis_pelanggan" id="jenis_pelanggan" class="form-control">
            <option value="biasa" {{ $pelanggan->jenis_pelanggan == 'biasa' ? 'selected' : '' }}>Biasa</option>
            <option value="member" {{ $pelanggan->jenis_pelanggan == 'member' ? 'selected' : '' }}>Member (5% Diskon)</option>
            <option value="vip" {{ $pelanggan->jenis_pelanggan == 'vip' ? 'selected' : '' }}>VIP (10% Diskon)</option>
        </select>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
