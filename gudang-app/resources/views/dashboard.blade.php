@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    .card-simple {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        transition: box-shadow 0.2s ease;
        background-color: #faf9f7;
    }
    .card-simple:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    .badge-soft {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.85rem;
    }
    .badge-warning-soft { background-color: #fdf3e6; color: #7c5e2b; }
    .badge-danger-soft { background-color: #f6e2e2; color: #7a3b3b; }
    .btn-quick {
        width: 100%;
        margin-bottom: 12px;
        background-color: #dcd7c9;
        color: #333;
        border: none;
        border-radius: 8px;
    }
    .btn-quick:hover { background-color: #cfc6b8; }
    .modal-lg { max-width: 900px; }
    .section-title { font-weight: 600; font-size: 1.2rem; margin-bottom: 1rem; color: #4a4a4a; }
    .welcome-msg {
        text-align: center;
        font-size: 1.3rem;
        font-weight: 500;
        color: #4a4a4a;
        background: linear-gradient(135deg, #edece8, #dcd7c9);
        padding: 20px 15px;
        border-radius: 12px;
        margin: 20px auto;
        max-width: 600px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }
    .welcome-msg strong { color: #a68a64; }
    .progress { height: 18px; border-radius: 10px; }
</style>



<div class="container mt-4">
    <div class="welcome-msg">
        Selamat datang, <strong>{{ Auth::user()->name }}</strong>! 
        Anda login sebagai <strong>{{ Auth::user()->role }}</strong>.
    </div>
    <div class="row g-3">
        @php
            $today = now()->toDateString();
            $summary = [
                ['label' => 'Data Barang', 'icon' => 'box', 'model' => \App\Models\Barang::class, 'field' => 'tanggal', 'modal' => 'produkModal'],
                ['label' => 'Barang Masuk', 'icon' => 'arrow-down', 'model' => \App\Models\BarangMasuk::class, 'field' => 'tanggal', 'modal' => 'masukModal'],
                ['label' => 'Barang Keluar', 'icon' => 'arrow-up', 'model' => \App\Models\BarangKeluar::class, 'field' => 'tanggal_keluar', 'modal' => 'keluarModal'],
            ];
        @endphp

        @foreach($summary as $item)
        <div class="col-md-4">
            <div class="card card-simple p-3" data-bs-toggle="modal" data-bs-target="#{{ $item['modal'] }}" style="cursor:pointer">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1"><i class="fas fa-{{ $item['icon'] }}"></i> {{ $item['label'] }}</h6>
                        <strong>{{ $item['model']::whereDate($item['field'], $today)->count() }} Barang</strong>
                    </div>
                    <small class="text-muted">{{ now()->format('d M Y') }}</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @php
        $weekAgo = now()->subDays(7)->toDateString();
        $monthAgo = now()->subDays(30)->toDateString();
    @endphp

    @foreach($summary as $item)
    <div class="modal fade" id="{{ $item['modal'] }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title">Laporan {{ $item['label'] }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @php
                        $model = $item['model'];
                        $field = $item['field'];
                    @endphp
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Hari Ini: <strong>{{ $model::whereDate($field, $today)->count() }}</strong></li>
                        <li class="list-group-item">7 Hari Terakhir: <strong>{{ $model::whereBetween($field, [$weekAgo, $today])->count() }}</strong></li>
                        <li class="list-group-item">30 Hari Terakhir: <strong>{{ $model::whereBetween($field, [$monthAgo, $today])->count() }}</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    {{-- ✅ Akses Cepat --}}
    <div class="mt-5">
        <div class="section-title"><i class="fas fa-bolt"></i> Akses Cepat</div>
        <div class="row g-3">
            @php
                $quick = [
                    ['label' => 'Data Barang', 'route' => 'barang.index', 'icon' => 'boxes', 'color' => 'secondary'],
                    ['label' => 'Barang Masuk', 'route' => 'barang_masuk.index', 'icon' => 'arrow-down', 'color' => 'secondary'],
                    ['label' => 'Barang Keluar', 'route' => 'barang_keluar.index', 'icon' => 'arrow-up', 'color' => 'secondary'],
                    ['label' => 'Laporan', 'route' => 'laporan.index', 'icon' => 'chart-line', 'color' => 'secondary'],
                ];
            @endphp
            @foreach($quick as $btn)
            <div class="col-md-3">
                <a href="{{ route($btn['route']) }}" class="btn btn-outline-{{ $btn['color'] }} btn-quick">
                    <i class="fas fa-{{ $btn['icon'] }}"></i> {{ $btn['label'] }}
                </a>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ✅ Reminder Stok --}}
    <div class="mt-5">
        <div class="section-title"><i class="fas fa-exclamation-triangle text-warning"></i> Reminder Stok</div>
        <div class="row g-3">
            @php
                $stokMenipis = \App\Models\Barang::where('stok', '<', 10)->where('stok', '>', 0)->get();
                $stokHabis = \App\Models\Barang::where('stok', 0)->get();
            @endphp

            <div class="col-md-6">
                <div class="card card-simple">
                    <div class="card-header bg-white"><strong><i class="fas fa-box"></i> Stok Menipis (&lt; 10)</strong></div>
                    <div class="card-body" style="max-height: 220px; overflow-y: auto;">
                        @if($stokMenipis->isNotEmpty())
                            <ul class="list-group list-group-flush">
                                @foreach($stokMenipis as $barang)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $barang->nama_barang }}
                                    <span class="badge-soft badge-warning-soft">{{ $barang->stok }}</span>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Tidak ada barang yang stoknya menipis.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-simple">
                    <div class="card-header bg-white"><strong><i class="fas fa-times-circle"></i> Stok Habis</strong></div>
                    <div class="card-body" style="max-height: 220px; overflow-y: auto;">
                        @if($stokHabis->isNotEmpty())
                            <ul class="list-group list-group-flush">
                                @foreach($stokHabis as $barang)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $barang->nama_barang }}
                                    <span class="badge-soft badge-danger-soft">Habis</span>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Tidak ada barang yang stoknya habis.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div> 
<div class="mt-5">
    <div class="row g-4">
        <div class="col-md-6">
            <div class="section-title">
                <i class="fas fa-chart-bar text-primary"></i> Statistik Barang Masuk & Keluar (Bulanan)
            </div>
            <div class="card card-simple p-3">
                <canvas id="barChart" height="250"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="section-title">
                <i class="fas fa-star text-warning"></i> Top 3 Barang dengan Perputaran Tertinggi
            </div>
            <div class="card card-simple p-3">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topBarangKeluar as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->total_keluar }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: @json($bulan),
            datasets: [
                {
                    label: 'Barang Masuk',
                    data: @json($barangMasuk),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Barang Keluar',
                    data: @json($barangKeluar),
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
