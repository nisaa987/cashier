@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="text-center mb-4">Diagram Barang Paling Sering Keluar</h4>

    <canvas id="barangKeluarChart" width="400" height="400"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('barangKeluarChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Jumlah Keluar',
                data: @json($data),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)'
                ]
            }]
        }
    });
</script>
@endsection
