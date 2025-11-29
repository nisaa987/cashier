@extends('layouts.app') 

@section('content') 
<style>
    .container {
        background: #ffffff;
        padding: 30px 25px;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.05);
        font-family: 'Segoe UI', sans-serif;
        color: #333;
        max-width: 800px;
        margin-top: 30px;
    }
    h2 {
        font-weight: 600;
        color: #2f4050;
        margin-bottom: 25px;
    }
    label {
        font-weight: 600;
        color: #555;
    }
    select.form-control, input.form-control {
        border-radius: 10px;
        border: 1px solid #cbd5e0;
        padding: 10px 12px;
        font-size: 15px;
        transition: border-color 0.3s ease;
    }
    select.form-control:focus, input.form-control:focus {
        outline: none;
        border-color: #4e73df;
        box-shadow: 0 0 8px rgba(78, 115, 223, 0.3);
    }
    .mb-3 {
        margin-bottom: 20px !important;
    }
    .btn-primary {
        background-color: #4e73df;
        border: none;
        padding: 12px 25px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #3754a0;
    }
    .btn-success {
        background-color: #1cc88a;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        margin-bottom: 20px;
    }
    .btn-success:hover {
        background-color: #17a673;
    }
    .btn-danger {
        background-color: #e74a3b;
        border: none;
        padding: 6px 14px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .btn-danger:hover {
        background-color: #c0392b;
    }
    .produk-item {
        margin-bottom: 15px;
        align-items: center;
    }
    .produk-item .form-control {
        font-size: 14px;
    }
    .produk-item .btn-danger {
        margin-top: 4px;
    }
</style>

<div class="container"> 
    <h2>Form Transaksi</h2> 

    @if (session('success')) 
        <div style="background-color:#d4edda; color:#155724; font-weight:600; padding:12px 16px; border-radius:10px; margin-bottom:20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            {{ session('success') }}
        </div> 
    @elseif (session('error')) 
        <div style="background-color:#f8d7da; color:#721c24; font-weight:600; padding:12px 16px; border-radius:10px; margin-bottom:20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            {{ session('error') }}
        </div> 
    @endif 

<form action="{{ route('transaksi.store') }}" method="POST"> 
    @csrf  
    <div class="mb-3"> 
        <label>Pilih Pelanggan</label> 
        <select name="pelangganID" class="form-control" required> 
            <option value="">-- Pilih Pelanggan --</option> 
            @foreach ($pelanggan as $p) 
                <option value="{{ $p->PelangganID }}">{{ $p->namaPelanggan }}</option> 
            @endforeach 
        </select> 
    </div> 

    <h4>Produk yang Dibeli</h4> 
    <div id="produk-container"> 
        <div class="row mb-3 produk-item"> 
            <div class="col-md-5"> 
                <select name="produkID[]" class="form-control produk-select" required> 
                    <option value="">-- Pilih Produk --</option> 
                    @foreach ($produk as $p) 
                        <option value="{{ $p->produkID }}" data-harga="{{ $p->harga }}"> 
                        {{ $p->namaProduk }} - Rp {{ number_format($p->harga, 2, ',', '.') }} 
                        </option> 
                    @endforeach 
                </select> 
            </div> 
            <div class="col-md-3"> 
                <input type="number" name="jumlahProduk[]" class="form-control jumlahProduk" placeholder="Jumlah" min="1" required> 
            </div> 
            <div class="col-md-3"> 
                <input type="text" name="subtotal[]" class="form-control subTotal" placeholder="Subtotal" readonly> 
            </div> 
            <div class="col-md-1"> 
                <button type="button" class="btn btn-danger btn-sm remove-produk">X</button> 
            </div> 
        </div> 
    </div> 

    <button type="button" class="btn btn-success mb-3" id="add-produk">Tambah Produk</button> 

    <div class="mb-3"> 
        <label>Total Harga</label> 
        <input type="text" id="totalHarga" name="subtotal" class="form-control" readonly> 
    </div> 

    <div class="mb-3">
        <label for="pembayaran" class="form-label">Pembayaran</label>
        <input type="number" id="pembayaran" name="pembayaran" class="form-control" required min="0">
    </div>

    <div class="mb-3">
        <label for="kembalian" class="form-label">Kembalian</label>
        <input type="text" id="kembalian" name="kembalian" class="form-control" readonly>
    </div>
    <input type="hidden" name="nama_kasir" value="{{ auth()->user()->name }}">


    <button type="submit" class="btn btn-primary" id="submitBtn">Simpan Transaksi</button>  
</form> 

<script>
document.addEventListener('DOMContentLoaded', function () {
    function hitungSubtotal(row) {
        const produkSelect = row.querySelector('.produk-select');
        const jumlahInput = row.querySelector('.jumlahProduk');
        const subtotalInput = row.querySelector('.subTotal');

        const harga = produkSelect.selectedOptions[0]?.dataset.harga || 0;
        const jumlah = parseInt(jumlahInput.value) || 0;
        const subtotal = harga * jumlah;

        subtotalInput.value = subtotal > 0 ? subtotal.toLocaleString('id-ID') : '';
    }

    function hitungTotal() {
        let total = 0;
        document.querySelectorAll('.subTotal').forEach(function (input) {
            const val = input.value.replace(/\./g, '').replace(/,/g, '') || '0';
            total += parseInt(val) || 0;
        });
        document.getElementById('totalHarga').value = total.toLocaleString('id-ID');
        return total;
    }

    function hitungKembalian() {
        const total = hitungTotal();
        const bayar = parseInt(document.getElementById('pembayaran').value) || 0;
        const kembalian = bayar - total;
        document.getElementById('kembalian').value = kembalian >= 0 ? kembalian.toLocaleString('id-ID') : '';
    }

    // Event listeners untuk perubahan produk dan jumlah di setiap baris produk
    document.getElementById('produk-container').addEventListener('change', function(e) {
        if (e.target.classList.contains('produk-select') || e.target.classList.contains('jumlahProduk')) {
            const row = e.target.closest('.produk-item');
            hitungSubtotal(row);
            hitungKembalian();
        }
    });

    document.getElementById('produk-container').addEventListener('input', function(e) {
        if (e.target.classList.contains('jumlahProduk')) {
            const row = e.target.closest('.produk-item');
            hitungSubtotal(row);
            hitungKembalian();
        }
    });

    // Tambah produk baru
    document.getElementById('add-produk').addEventListener('click', function() {
        const container = document.getElementById('produk-container');
        const newRow = container.querySelector('.produk-item').cloneNode(true);
        newRow.querySelector('select').value = '';
        newRow.querySelector('input.jumlahProduk').value = '';
        newRow.querySelector('input.subTotal').value = '';
        container.appendChild(newRow);
    });

    // Hapus produk
    document.getElementById('produk-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-produk')) {
            const container = document.getElementById('produk-container');
            if (container.querySelectorAll('.produk-item').length > 1) {
                e.target.closest('.produk-item').remove();
                hitungTotal();
                hitungKembalian();
            }
        }
    });

    // Hitung kembalian saat pembayaran diinput
    document.getElementById('pembayaran').addEventListener('input', hitungKembalian);
    });

    // Validasi sebelum submit
    document.getElementById('submitBtn').addEventListener('click', function(e) {
        const totalStr = document.getElementById('totalHarga').value.replace(/\./g, '').replace(/,/g, '') || '0';
        const total = parseInt(totalStr) || 0;
        const bayar = parseInt(document.getElementById('pembayaran').value) || 0;

        if (bayar < total) {
            e.preventDefault(); // cegah form dikirim
            alert('Pembayaran kurang. Silakan periksa kembali.');
        }
    });

</script>
@endsection
