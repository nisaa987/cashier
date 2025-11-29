@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Karyawan di Departemen <strong>{{ $departemen->nama_departemen }}</strong></h4>
    <div class="container">
    <h4 class="mb-4">Karyawan di Departemen <strong>{{ $departemen->nama_departemen }}</strong></h4>

    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau job title..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
    </form>

     <table class="table table-bordered table-striped">
        <thead class="table-dark">
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
            <tr>
                <td colspan="4" class="text-center">Tidak ditemukan karyawan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>
@endsection
