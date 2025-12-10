@extends('components.app')

@section('content')
<div class="container-fluid py-4">

    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4 text-success fw-bold">Dashboard PT Duta Kencana Swaguna</h1>
            <p class="lead text-muted">Selamat datang di sistem pemesanan makanan sehat.</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title text-muted mb-3">Total Omzet</h5>
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="card-title mb-0">Rp {{ number_format($totalOmzet, 2, ',', '.') }}</h3>
                        <span class="fs-1 fw-bold text-success">Rp</span>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success">
                            +{{ $growth }}% dari kemarin
                        </span>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title text-muted mb-3">Pesanan Aktif</h5>
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="card-title mb-0">{{ $activeOrders }}</h3>
                        <i class="bi bi-cart-check fs-1 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title text-muted mb-3">Produk Terlaris</h5>
                    <ul class="list-group list-group-flush">
                        @foreach ($bestSellers as $food)
                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <span>{{ $food->name }}</span>
                            <span class="badge bg-success">{{ $food->order_items_count }}x Terjual</span>
                        </div>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-muted mb-4">Omzet Bulanan</h5>
                    <div style="height: 300px;">
                        <canvas id="omzetChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-muted mb-4">Aktivitas Terbaru</h5>
                    <ul class="list-group list-group-flush">
                        @if ($latestOrder)
                        <p class="mb-1">
                            #ORD{{ str_pad($latestOrder->id, 3, '0', STR_PAD_LEFT) }}
                            -
                            {{ $latestOrder->user->name ?? 'No customer' }}
                        </p>
                        @php
                        $status = strtolower($latestOrder->status);
                        $badgeClass = match($status) {
                        'completed' => 'bg-success',
                        'pending' => 'bg-warning',
                        'cancelled' => 'bg-danger',
                        default => 'bg-secondary',
                        };
                        @endphp
                        <span class="badge {{ $badgeClass }} w-100 py-2 fw-semibold">
                            {{ ucfirst($status) }}
                        </span>
                        @else
                        <p class="mb-1 text-muted">Belum ada order yang dibuat</p>
                        <span class="badge bg-secondary w-100 py-2 fw-semibold">N/A</span>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    window.addEventListener("DOMContentLoaded", () => {
        const ctx = document.getElementById("omzetChart").getContext("2d");

        const labels = JSON.parse(`@json($chartLabels)`);
        const data = JSON.parse(`@json($chartData)`);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Omzet (Rp)',
                    data: data,
                    borderColor: 'green',
                    backgroundColor: 'rgba(0, 128, 0, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Omzet: Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    });
</script>

@endsection