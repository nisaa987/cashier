@extends('layouts.app')

@section('content')
<style>
    form label {
        font-weight: bold;
        color:rgb(7, 7, 7);
    }
    form button {
        margin-top: 15px;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"],
    select,
    textarea {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }
    .alert-success {
        background-color: #d4edda;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
        color: #155724;
    }
    .alert-error {
        background-color: #f8d7da;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
        color: #721c24;
    }
</style>

<div class="container" style="max-width:600px; margin-top:40px;">
    <h2>Tambah User Baru
        <i class="fas fa-user"></i>
    </h2>

    {{-- Tampilkan pesan sukses --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tampilkan error validasi --}}
    @if ($errors->any())
        <div class="alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.store') }}" method="POST">
        @csrf

        <div style="margin-bottom:15px;">
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div style="margin-bottom:15px;">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div style="margin-bottom:15px;">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div style="margin-bottom:15px;">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div style="margin-bottom:15px;">
            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="">-- Pilih Role --</option>
                <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
