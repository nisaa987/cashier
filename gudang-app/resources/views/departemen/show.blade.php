@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Karyawan Departemen: {{ $departemen->nama_departemen }}</h3>

    <a href="{{ route('departemen.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali ke Daftar Departemen</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Job Title</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($employees as $emp)
                <tr>
                    <td>{{ $emp->nama }}</td>
                    <td>{{ $emp->telepon }}</td>
                    <td>{{ $emp->email }}</td>
                    <td>{{ $emp->job_title }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Tidak ada karyawan di departemen ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
