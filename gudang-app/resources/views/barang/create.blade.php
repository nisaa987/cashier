@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Tambah Barang</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Masuk</label>
                    <input type="date" name="tanggal" 
                           class="form-control" 
                           value="{{ old('tanggal', date('Y-m-d')) }}" required>
                </div>

                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" 
                           class="form-control" 
                           value="{{ old('nama_barang') }}" required>
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Foto Barang (1:1)</label>
                    <input type="file" name="foto" 
                           class="form-control" 
                           accept="image/*" onchange="previewFoto(this)">
                    <div id="preview-area" class="mt-2" style="display:none;">
                        <img id="preview-image" src="#" alt="Preview" class="img-thumbnail" style="width:100px;height:100px;object-fit:cover;">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" name="stok" 
                           class="form-control" 
                           min="1" value="{{ old('stok') }}" required>
                </div>

                <div class="mb-3">
                    <label for="satuan_barang" class="form-label">Satuan Barang</label>
                    <input type="text" name="satuan_barang" 
                           class="form-control" 
                           value="{{ old('satuan_barang') }}" required>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<script>
    function previewFoto(input) {
        const preview = document.getElementById('preview-image');
        const container = document.getElementById('preview-area');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                container.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            container.style.display = 'none';
        }
    }
</script>
@endsection
