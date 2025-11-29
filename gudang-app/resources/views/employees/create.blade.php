@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />

<style>
    body {
        background-color: #f8f9fa;
    }

    .form-container {
        max-width: 700px;
        margin: 30px auto;
        padding: 30px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        font-family: 'Segoe UI', sans-serif;
    }

    .form-container h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #343a40;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        font-weight: 600;
        display: block;
        margin-bottom: 6px;
        color: #333;
    }

    input[type="text"],
    input[type="email"],
    input[type="file"],
    select {
        width: 100%;
        padding: 8px 12px;
        font-size: 14px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    .btn-submit {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 14px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }

    .btn-submit:hover {
        background-color: #45a049;
    }

    .btn-kembali {
        display: inline-block;
        margin-top: 15px;
        color: #333;
        font-size: 14px;
        text-decoration: none;
        padding: 6px 12px;
        background-color: #dee2e6;
        border-radius: 5px;
    }

    .btn-kembali:hover {
        background-color: #ced4da;
    }
</style>

<div class="form-container">
    <h2><i class="fas fa-user-plus"></i> Tambah Karyawan</h2>

    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" required>
        </div>

<div class="mb-3">
    <label for="job_title" class="form-label">Jabatan</label>
    <input type="text" name="job_title" id="job_title" class="form-control" required>
</div>


        <div class="form-group">
            <label for="email">Email (Opsional)</label>
            <input type="email" name="email" id="email">
        </div>

        <div class="form-group">
            <label for="telepon">Telepon</label>
            <input type="text" name="telepon" id="telepon">
        </div>

        <div class="form-group">
            <label for="departemen">Departemen</label>
<select name="departemen" class="form-control" required>
    <option value="">-- Pilih Departemen --</option>
    @foreach($departemen as $dep)
        <option value="{{ $dep->nama_departemen }}">{{ $dep->nama_departemen }}</option>
    @endforeach
</select>

        </div>

        <div class="form-group">
            <label for="foto">Foto Karyawan</label>
            <input type="file" name="foto" id="foto" accept="image/*">
        </div>

        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan</button>
        <a href="{{ route('employees.index') }}" class="btn-kembali">Kembali</a>
    </form>
</div>
@endsection
