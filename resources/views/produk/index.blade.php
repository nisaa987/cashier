@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; margin: auto; font-family: Arial, sans-serif; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 8px rgba(0,0,0,0.1);">
    <h2 class="mb-3" style="color: #333;">Daftar Produk</h2>
    <a href="{{ route('produk.create') }}" class="btn btn-primary mb-3" style="background-color: #007bff; color: white; padding: 8px 12px; text-decoration: none; border-radius: 4px; display: inline-block;">Tambah Produk</a>

    @if (session('success'))
        <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px;">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Nama Produk</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Harga</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Stok</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produk as $p)
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $p->namaProduk }}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">Rp {{ number_format($p->harga, 2, ',', '.') }}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $p->stok }}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                    <a href="{{ route('produk.edit', $p->produkID) }}" class="btn btn-warning btn-sm" style="background-color: #ffc107; color: #212529; padding: 4px 8px; text-decoration: none; border-radius: 4px; margin-right: 5px;">Edit</a>
                    <form action="{{ route('produk.destroy', $p->produkID) }}" method="POST" class="d-inline" style="display: inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini?')" style="background-color: #dc3545; color: white; padding: 4px 8px; border: none; border-radius: 4px; cursor: pointer;">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
