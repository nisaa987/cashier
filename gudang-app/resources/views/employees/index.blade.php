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
        gap: 15px;
        padding: 20px 30px 0;
        flex-wrap: wrap;
    }

    .header-section h1 {
        margin: 0;
        font-size: 24px;
        color: #343a40;
        display: flex;
        align-items: center;
    }

    .header-section h1 i {
        margin-right: 10px;
        color: #17a2b8;
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
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-tambah:hover {
        background-color: #45a049;
    }

    .search-bar {
        display: flex;
        align-items: center;
        margin: 20px auto 0;
        width: 80%;
        max-width: 700px;
        background: #fff;
        border-radius: 8px;
        padding: 6px 14px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        gap: 10px;
    }

    .search-bar input,
    .search-bar select {
        border: none;
        outline: none;
        padding: 8px;
        font-size: 14px;
        border-radius: 6px;
        flex: 1;
    }

    .search-bar i {
        color: #888;
        font-size: 16px;
        margin-right: 8px;
    }

    .grid-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: center;
        padding: 30px 20px;
    }

    .card-barang {
        width: 180px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        text-align: center;
        padding: 10px;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .card-barang:hover {
        transform: scale(1.03);
    }

    .card-barang img {
        width: 100%;
        height: 110px;
        object-fit: cover;
        border-radius: 6px;
    }

    .card-barang h5 {
        font-size: 16px;
        margin: 8px 0 4px;
        color: #333;
    }

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

    .modal-info input,
    .modal-info select {
        width: 100%;
        padding: 6px;
        font-size: 14px;
        border-radius: 6px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
    }

    .close-btn {
        position: absolute;
        top: 10px; right: 14px;
        font-size: 26px;
        color: #555;
        cursor: pointer;
        font-weight: bold;
    }

    .btn-kembali {
        margin-top: 8px;
        display: inline-block;
        padding: 6px 12px;
        background-color: #dee2e6;
        border-radius: 5px;
        font-size: 14px;
        color: #333;
        text-decoration: none;
    }

    .btn-kembali:hover {
        background-color: #ced4da;
    }
</style>

<div class="header-section">
    <h1><i class="fas fa-users"></i> Daftar Karyawan</h1>
    <a href="{{ route('departemen.index') }}" 
   style="
       display: inline-block;
       padding: 6px 12px;
       background-color: #fff;
       border: 1px solid #ced4da;
       border-radius: 5px;
       color: #212529;
       text-decoration: none;
       position: relative;
       background-image: url('data:image/svg+xml,%3Csvg viewBox=%270 0 140 140%27 width=%2710%27 height=%2710%27 xmlns=%27http://www.w3.org/2000/svg%27%3E%3Cpath d=%27M10 50 l60 60 60-60%27 fill=%27none%27 stroke=%27gray%27 stroke-width=%2715%27/%3E%3C/svg%3E');
       background-repeat: no-repeat;
       background-position: right 10px center;
       background-size: 10px;
   ">
   Departemen
</a>

</div>

<div style="padding: 0 30px; margin-top: 10px;">
    <a href="{{ route('employees.create') }}" class="btn-tambah">
        <i class="fas fa-plus-circle"></i> Tambah Karyawan
    </a>
</div>

<div class="search-bar">
    <i class="fas fa-search"></i>
    <form action="{{ route('employees.index') }}" method="GET" style="display: flex; width: 100%; gap: 10px;">
        <input type="text" name="search" placeholder="Cari nama karyawan..." value="{{ request('search') }}">

        <button type="submit" class="btn-tambah" style="padding: 6px 12px;">Cari</button>

        @if(request('search') || request('departemen'))
            <a href="{{ route('employees.index') }}" class="btn-kembali">Reset</a>
        @endif
    </form>
</div>

<div class="grid-container">
    @forelse ($employees as $employee)
        <div class="card-barang" onclick="showDetail({{ $employee->toJson() }})">
            <img src="{{ $employee->photo ? asset('storage/' . $employee->photo) : asset('images/default-profile.png') }}" alt="{{ $employee->name }}">
            <h5>{{ $employee->nama }}</h5>
        </div>
    @empty
        <p>Tidak ada karyawan ditemukan.</p>
    @endforelse
</div>

<!-- Modal -->
<div id="detailModal" class="modal-overlay">
    <div class="modal-box">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <img id="modalFoto" src="" alt="Foto Karyawan">
        <div class="modal-info">
            <!-- View Mode -->
            <div id="viewMode">
                <h3 id="viewNama">-</h3>
                <p><strong>Jabatan:</strong> <span id="viewJabatan">-</span></p>
                <p><strong>Email:</strong> <span id="viewEmail">-</span></p>
                <p><strong>Telepon:</strong> <span id="viewTelepon">-</span></p>
                <p><strong>Departemen:</strong> <span id="viewDepartemen">-</span></p>

                <button class="btn-tambah" onclick="switchToEdit()">Edit</button>
                <button class="btn-kembali" onclick="hapusKaryawan()">Hapus</button>
                <button class="btn-kembali" onclick="closeModal()">Kembali</button>
            </div>

            <!-- Edit Mode -->
            <form id="editForm" style="display:none;" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="modalId">
                <label>Nama:</label>
                <input type="text" name="name" id="editNama" required>
                <label>Jabatan:</label>
                <input type="text" name="job_title" id="editJabatan" required>
                <label>Email:</label>
                <input type="text" name="email" id="editEmail">
                <label>Telepon:</label>
                <input type="text" name="phone" id="editTelepon">
                <label>Departemen:</label>
                <select name="departemen" id="editDepartemen" class="form-control">
                    <option value="">Pilih Departemen</option>
                    @foreach ($departemens as $dep)
                        <option value="{{ $dep->nama_departemen }}">{{ $dep->nama_departemen }}</option>
                    @endforeach
                </select>

                <label>Foto (kosongkan jika tidak diganti):</label>
                <input type="file" name="photo">
                <button type="submit" class="btn-tambah">Simpan</button>
                <button type="button" class="btn-kembali" onclick="cancelEdit()">Batal</button>
            </form>
        </div>
    </div>
</div>

<script>
function showDetail(emp) {
    // View Mode
    document.getElementById('viewNama').innerText = emp.nama ?? '-';
    document.getElementById('viewJabatan').innerText = emp.job_title ?? '-';
    document.getElementById('viewEmail').innerText = emp.email ?? '-';
    document.getElementById('viewTelepon').innerText = emp.telepon ?? '-';
    document.getElementById('viewDepartemen').innerText = emp.departemen ?? '-';

    // Edit Mode
    document.getElementById('editNama').value = emp.nama ?? '';
    document.getElementById('editJabatan').value = emp.job_title ?? '';
    document.getElementById('editEmail').value = emp.email ?? '';
    document.getElementById('editTelepon').value = emp.telepon ?? '';
    document.getElementById('editDepartemen').value = emp.departemen;



    // Foto
    document.getElementById('modalFoto').src = emp.photo ? '/storage/' + emp.photo : 'https://via.placeholder.com/150';

    // Form
    document.getElementById('editForm').action = `/employees/${emp.id}`;
    document.getElementById('modalId').value = emp.id;

    // Show modal
    document.getElementById('viewMode').style.display = 'block';
    document.getElementById('editForm').style.display = 'none';
    document.getElementById('detailModal').style.display = 'flex';
}

    function closeModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    function switchToEdit() {
        document.getElementById('viewMode').style.display = 'none';
        document.getElementById('editForm').style.display = 'block';
    }

    function cancelEdit() {
        document.getElementById('editForm').style.display = 'none';
        document.getElementById('viewMode').style.display = 'block';
    }

    function hapusKaryawan() {
        if (confirm('Yakin ingin menghapus karyawan ini?')) {
            const id = document.getElementById('modalId').value;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/employees/${id}`;

            const token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = '{{ csrf_token() }}';
            form.appendChild(token);

            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';
            form.appendChild(method);

            document.body.appendChild(form);
            form.submit();
        }
    }
</script>

@endsection
