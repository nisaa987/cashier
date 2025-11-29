@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />
<style>
    .dept-card {
        transition: box-shadow 0.3s ease;
        cursor: pointer;
        border-radius: 12px;
        border: 1px solid #e3e3e3;
        background-color: #fff;
    }

    .dept-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        background-color: #f9f9f9;
    }

    .dept-badge {
        background-color: #198754;
        font-size: 0.85rem;
        padding: 5px 10px;
        border-radius: 20px;
        color: white;
    }

    .search-input {
        width: 100%;
        max-width: 400px;
    }
</style>

<div class="container mt-4">
    <h3 class="mb-4"><i class="fas fa-building"></i> Daftar Departemen</h3>

    <form action="{{ route('departemen.index') }}" method="GET" class="mb-4 d-flex flex-wrap gap-2">
        <input type="text" name="search" class="form-control search-input" placeholder="Cari Departemen..." value="{{ $search }}">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-search"></i> Cari
        </button>
        <a href="{{ route('departemen.index') }}" class="btn btn-secondary">
            <i class="fas fa-sync-alt"></i> Reset
        </a>
    </form>

    <div class="row g-3">
        @forelse ($departemens as $dept)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('departemen.show', $dept->id) }}" style="text-decoration: none; color: inherit;">
                    <div class="p-3 dept-card h-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-1">{{ $dept->nama_departemen }}</h5>
                            <span class="dept-badge">
                                <i class="fas fa-users"></i> {{ $dept->employees_count }}
                            </span>
                        </div>
                        <small class="text-muted">Klik untuk lihat karyawan</small>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">
                    Departemen tidak ditemukan.
                </div>
            </div>
        @endforelse
    </div>
    <a href="{{ route('employees.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali ke Daftar Karyawan</a>
</div>

    
@endsection
