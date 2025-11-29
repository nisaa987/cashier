@extends('layouts.app') 

@section('content')  
<div class="container" style="background-color: #f9fafb; padding: 40px; border-radius: 18px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); font-family: 'Segoe UI', sans-serif;">
    <h2 style="font-weight: 700; color: #3b4252; margin-bottom: 30px;">📊 Laporan Penjualan</h2>

    {{-- Alert notifikasi hapus --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form method="POST" action="{{ route('laporan.index') }}" class="mb-5">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold text-secondary">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="form-control rounded-3 shadow-sm">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold text-secondary">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="form-control rounded-3 shadow-sm">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100 rounded-3" style="padding: 12px 0; font-weight: 600; background-color: #6366f1; border: none; transition: 0.3s;">
                    🔎 Filter
                </button>
            </div>
        </div>
    </form>

    <div class="table-responsive rounded-4 shadow-sm">
        <table class="table table-hover align-middle text-center" style="font-size: 15px;">
            <thead style="background-color: #e0e7ff; color: #1e293b;">
                <tr>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penjualan as $p)
                <tr style="background-color: {{ $loop->index % 2 === 0 ? '#ffffff' : '#f1f5f9' }};">
                    <td>{{ \Carbon\Carbon::parse($p->tanggalPenjualan)->format('d M Y') }}</td>
                    <td>{{ $p->pelanggan->namaPelanggan }}</td>
                    <td>Rp {{ number_format($p->totalHarga, 2, ',', '.') }}</td>
                    <td>
                        <div class="d-flex justify-content-center gap-2 align-items-center">
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $p->PenjualanID }}">
                                Lihat
                            </button>
                            <a href="{{ route('transaksi.printStruk', $p->PenjualanID) }}" target="_blank" class="btn btn-success btn-sm">
                                Print Struk
                            </a>
                            <form action="{{ route('laporan-penjualan.destroy', $p->PenjualanID ?? $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')" style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>

                        <!-- Modal Detail -->
                        <div class="modal fade" id="detailModal{{ $p->PenjualanID }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content rounded-4">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-semibold">Detail Penjualan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($p->detailPenjualan as $detail)
                                            <li class="list-group-item">
                                                {{ $detail->produk->namaProduk }} ({{ $detail->jumlahProduk }}x) - Rp {{ number_format($detail->subTotal, 2, ',', '.') }}
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-5" style="background-color: #ffffff; padding: 20px 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
        <h4 style="font-weight: 700; color: #2c3e50; margin-bottom: 10px;">🔥 Laporan Data Penjualan</h4>
        <p style="color: #7f8c8d; margin-bottom: 15px;">Berikut data menu berdasarkan data penjualan:</p>
            <form method="POST" action="{{ route('laporan.index') }}" class="mb-5">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold text-secondary">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="form-control rounded-3 shadow-sm">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold text-secondary">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="form-control rounded-3 shadow-sm">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100 rounded-3" style="padding: 12px 0; font-weight: 600; background-color: #6366f1; border: none; transition: 0.3s;">
                    🔎 Filter
                </button>
            </div>
        </div>
    </form>

        @if(isset($menuTerlaris) && $menuTerlaris->count() > 0)
            <ul style="list-style: none; padding-left: 0;">
                @foreach($menuTerlaris as $menu)
                    <li style="background-color: #f9f9f9; border: 1px solid #eaeaea; padding: 10px 15px; margin-bottom: 8px; border-radius: 8px;">
                        <strong style="color:rgb(1, 1, 2);">{{ $menu->namaProduk }}</strong>
                        <span style="color: #16a085; float: right;">Terjual: {{ $menu->total_terjual }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p style="color: #e74c3c;">Tidak ada data produk terlaris.</p>
        @endif
        
    </div>
</div>

{{-- Script untuk auto hide alert --}}
<script>
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if(alert) {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }
    }, 4000); // 4 detik
</script>

@endsection
