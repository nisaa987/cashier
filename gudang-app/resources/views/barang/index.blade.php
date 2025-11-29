@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />

<style>
    body {
        background-color: #f8f9fa;
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 0;
        flex-wrap: wrap;
    }

    .header-section h1 {
        margin: 0;
        font-size: 24px;
        color: #343a40;
    }

    .btn-tambah {
        background-color: #4CAF50;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        transition: background-color 0.2s ease-in-out;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-tambah:hover {
        background-color: #45a049;
    }

    .btn-barangmasuk {
        background-color: #f81d05ff;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        transition: background-color 0.2s ease-in-out;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-barangmasuk:hover {
        background-color: #d81905;
    }

    .btn-keluarkan {
        background-color: #007bff;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        transition: background-color 0.2s ease-in-out;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-keluarkan:hover {
        background-color: #0056b3;
    }

    .table-hover tbody tr:hover {
        background-color: #e9f7ef;
        cursor: pointer;
    }

    .qr-img {
        width: 60px;
        height: 60px;
        object-fit: contain;
    }

    /* Modal styling */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.6);
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .modal-box {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        width: 90%;
        max-width: 500px;
        display: flex;
        gap: 20px;
        position: relative;
    }

    .modal-box img {
        width: 160px;
        height: 160px;
        object-fit: cover;
        border-radius: 10px;
    }

    .modal-info {
        flex: 1;
    }

    .close-btn {
        position: absolute;
        top: 10px; right: 14px;
        font-size: 26px;
        color: #555;
        cursor: pointer;
    }
</style>

<div class="container">
    <div class="header-section">
        <h1><i class="fas fa-boxes-stacked"></i> Daftar Barang</h1>
        <a href="{{ route('barang.create') }}" class="btn-tambah"><i class="fas fa-plus-circle"></i> Tambah Barang</a>
    </div>

    <!-- Filter Tanggal -->
<form method="GET" action="{{ route('barang.index') }}" class="row g-3 mb-4">
    <div class="col-md-4">
        <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
        <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
    </div>
    <div class="col-md-4">
        <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
        <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <button type="submit" class="btn btn-dark w-50 me-2">Tampilkan</button>
        @if(request('tanggal_awal') || request('tanggal_akhir'))
            <a href="{{ route('barang.index') }}" class="btn btn-secondary w-50">Reset</a>
        @endif
    </div>
</form>


    <!-- Pencarian -->
    <form action="{{ route('barang.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" name="search" class="form-control" placeholder="Cari barang..." value="{{ request('search') }}">
            @if(request('search'))
                <button type="button" onclick="window.location='{{ route('barang.index') }}'" class="btn btn-outline-secondary">&times;</button>
            @endif
        </div>
    </form>

    <!-- Tabel Barang -->
    <table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Nama Barang</th>
            <th>Tanggal Masuk</th>
            <th>QR Code</th>
            <th>Barcode</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barangs as $index => $barang)
            <tr onclick="showDetail({{ json_encode($barang) }})">
                <td>{{ $index + 1 }}</td>
                <td>
                    <img src="{{ asset('storage/' . $barang->foto) }}" 
                        alt="" width="80" height="80" 
                        style="object-fit:cover; border-radius:5px;">
                </td>
                <td>{{ $barang->nama_barang }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($barang->tanggal)->format('d M Y') }}</td>
                <td>
                    <div style="width:80px; height:80px; display:flex; align-items:center; justify-content:center;">
                        {!! $barang->qr_code !!}
                    </div>
                </td>
                <td>
                    <div style="display:flex; justify-content:center; align-items:center;">
                        {!! $barang->barcode !!}
                    </div>
                </td>
                <td class="text-center">
                    <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger btn-action" type="submit">
                                    <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </form>

                        <a href="{{ route('barang.print', $barang->id) }}" 
                            class="btn btn-success btn-sm" target="_blank">
                             <i class="fas fa-qrcode"></i>
                        </a>                

    <!-- 🔹 Tombol Print Barcode -->
    <a href="{{ route('barang.printbc', $barang->id) }}" 
        class="btn btn-dark btn-sm" target="_blank">
        <i class="fas fa-barcode"></i>
    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
    </table>
</div>

<!-- Modal Detail -->
<div id="detailModal" class="modal-overlay">
    <div class="modal-box">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <img id="modalFoto" src="" alt="Foto Barang">
        <div class="modal-info">
            <h3 id="viewNama">-</h3>
            <p><strong>Tanggal Input:</strong> <span id="viewTanggal">-</span></p>
            <p><strong>Stok:</strong> <span id="viewStok">-</span></p>
            <p><strong>Satuan:</strong> <span id="viewSatuan">-</span></p>

            <a href="#" id="btnKeluar" class="btn-keluarkan"><i class="fas fa-dolly"></i> Keluarkan</a>
        </div>
    </div>
</div>

<script>
function showDetail(barang) {
    const modal = document.getElementById('detailModal');
    document.getElementById('viewNama').innerText = barang.nama_barang;
    document.getElementById('viewTanggal').innerText = new Date(barang.created_at).toLocaleDateString('id-ID', {
        day: '2-digit', month: 'short', year: 'numeric'
    });
    document.getElementById('viewStok').innerText = barang.stok;
    document.getElementById('viewSatuan').innerText = barang.satuan_barang ?? '-';
            document.getElementById('modalFoto').src = '/storage/' + barang.foto;

    document.getElementById('btnKeluar').href = "/barang_keluar/create?barang_id=" + barang.id;

    modal.style.display = 'flex';
}

function closeModal() {
    document.getElementById('detailModal').style.display = 'none';
}

document.addEventListener('keydown', function(event) {
    if (event.key === "Escape") {
        closeModal();
    }
});

document.getElementById('detailModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endsection
