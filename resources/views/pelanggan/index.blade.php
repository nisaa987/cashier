@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; margin: auto; font-family: Arial, sans-serif; background-color: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); color: #333;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="color: #2f4050; font-weight: 600; margin: 0;">🧾 Daftar Pelanggan</h2>
        <a href="{{ route('pelanggan.create') }}"
           style="background-color: #007bff; color: white; font-weight: 600; padding: 8px 16px; border-radius: 6px; text-decoration: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: background-color 0.3s ease; cursor: pointer;"
           onmouseover="this.style.backgroundColor='#0056b3'" 
           onmouseout="this.style.backgroundColor='#007bff'">
            + Tambah Pelanggan
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success" style="position: relative; padding: 15px 40px 15px 15px; background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; border-radius: 5px; margin-bottom: 20px;">
            {{ session('success') }}
            <button onclick="this.parentElement.style.display='none';"
                    style="position: absolute; top: 8px; right: 12px; background: none; border: none; font-size: 20px; font-weight: bold; color: #155724; cursor: pointer; line-height: 1;">
                &times;
            </button>
        </div>
    @endif

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: center; color: #2f4050;">Nama</th>
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: center; color: #2f4050;">Alamat</th>
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: center; color: #2f4050;">Nomor Telepon</th>
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: center; color: #2f4050;">Jenis Pelanggan</th>
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: center; color: #2f4050; width: 200px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pelanggan as $index => $p)
                <tr style="background-color: {{ $index % 2 === 0 ? '#ffffff' : '#fafafa' }}; transition: background-color 0.3s ease;"
                    onmouseover="this.style.backgroundColor='#e9f5ff'" 
                    onmouseout="this.style.backgroundColor='{{ $index % 2 === 0 ? '#ffffff' : '#fafafa' }}'">
                    
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: center;">{{ $p->namaPelanggan }}</td>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: center;">{{ $p->alamat }}</td>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: center;">{{ $p->nomor_telepon }}</td>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: center;">{{ $p->jenis_pelanggan }}</td>
                    <td style="border: 1px solid #ddd; padding: 10px;">
                        <div style="display: flex; justify-content: center; gap: 10px;">
                            <a href="{{ route('pelanggan.edit', $p->PelangganID) }}"
                               style="background-color: #ffc107; color: #212529; font-weight: 500; padding: 6px 12px; border-radius: 6px; text-decoration: none; transition: background-color 0.3s ease;"
                               onmouseover="this.style.backgroundColor='#e0a800'" 
                               onmouseout="this.style.backgroundColor='#ffc107'">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('pelanggan.destroy', $p->PelangganID) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        style="background-color: #dc3545; color: white; font-weight: 500; padding: 6px 12px; border: none; border-radius: 6px; cursor: pointer; transition: background-color 0.3s ease;"
                                        onmouseover="this.style.backgroundColor='#b02a37'" 
                                        onmouseout="this.style.backgroundColor='#dc3545'">
                                    🗑 Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="border: 1px solid #ddd; padding: 16px; text-align: center; color: #999;">
                        Tidak ada pelanggan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
