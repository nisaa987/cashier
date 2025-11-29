@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; margin: auto; font-family: Arial, sans-serif; background-color: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); color: #333;">
    <h3 style="color: #2f4050; font-weight: 600; margin-bottom: 24px;">
        <i class="fas fa-user" style="margin-right: 8px; color: #7a8ca2;"></i> Daftar User
    </h3>

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ auth()->user()->role === 'admin' ? route('user.create') : '#' }}" 
       style="background-color: #007bff; color: white; font-weight: 600; padding: 8px 16px; border-radius: 6px; text-decoration: none; display: inline-block; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 20px; cursor: {{ auth()->user()->role === 'admin' ? 'pointer' : 'not-allowed' }};"
       onclick="{{ auth()->user()->role !== 'admin' ? 'alert(\'Akses ditolak: hanya admin yang bisa menambah user.\')' : '' }}">
       + Tambah User
    </a>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color:rgb(251, 247, 247);">
                <th style="border: 1px solid #ddd; padding: 10px; text-align: center; color:rgb(5, 5, 5);">Nama</th>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: center; color: rgb(5, 5, 5);">Email</th>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: center; color: rgb(5, 5, 5);">Role</th>
                <th style="border: 1px solid #ddd; padding: 10px; text-align: center; color: rgb(5, 5, 5);">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
            <tr style="background-color: {{ $index % 2 === 0 ? '#ffffff' : '#fafafa' }}; transition: background-color 0.3s ease;"
                onmouseover="this.style.backgroundColor='#e9f5ff'" onmouseout="this.style.backgroundColor='{{ $index % 2 === 0 ? '#ffffff' : '#fafafa' }}'">
                <td style="border: 1px solid #ddd; padding: 10px; text-align: center; color: black;">{{ $user->name }}</td>
                <td style="border: 1px solid #ddd; padding: 10px; text-align: center; color: #111;">{{ $user->email }}</td>
                <td style="border: 1px solid #ddd; padding: 10px; text-align: center; color: #111;">{{ $user->role }}</td>
                <td style="border: 1px solid #ddd; padding: 10px; text-align: center;">
                    {{-- Tombol Edit --}}
                    <a href="{{ auth()->user()->role === 'admin' ? route('user.edit', $user->id) : '#' }}" 
                       style="background-color: #ffc107; color: #212529; font-weight: 500; padding: 6px 12px; border-radius: 6px; text-decoration: none; margin-right: 8px; transition: background-color 0.3s ease; cursor: {{ auth()->user()->role === 'admin' ? 'pointer' : 'not-allowed' }};"
                       onclick="{{ auth()->user()->role !== 'admin' ? 'alert(\'Akses ditolak: hanya admin yang bisa mengedit user.\')' : '' }}">
                       Edit
                    </a>

                    {{-- Tombol Hapus --}}
                    @if(auth()->user()->role === 'admin')
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin hapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    style="background-color: #dc3545; color: white; font-weight: 500; padding: 6px 12px; border: none; border-radius: 6px; cursor: pointer; transition: background-color 0.3s ease;"
                                    onmouseover="this.style.backgroundColor='#b02a37'" onmouseout="this.style.backgroundColor='#dc3545'">
                                Hapus
                            </button>
                        </form>
                    @else
                        <button disabled
                                style="background-color: #ccc; color: #666; font-weight: 500; padding: 6px 12px; border: none; border-radius: 6px; cursor: not-allowed;">
                            Hapus
                        </button>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="border: 1px solid #ddd; padding: 16px; text-align: center; color: #999;">Tidak ada user</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
