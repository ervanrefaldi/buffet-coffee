@extends('layouts.owner')

@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan aktivitas dan statistik toko.')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Stat Card 1 -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Event Aktif</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $totalActiveEvents }}</h3>
                </div>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Menu</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $totalMenu }}</h3>
                </div>
                <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Admin / Owner</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $totalStaff }}</h3>
                </div>
                <div class="p-3 bg-purple-50 text-purple-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Omzet Hari Ini</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h3>
                </div>
                <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Aktivitas Bisnis Mingguan</h3>
                <p class="text-xs text-gray-500">Perbandingan jumlah pesanan yang belum dibayar dan transaksi yang berhasil dalam 7 hari terakhir.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                    <span class="text-xs font-medium text-gray-600">Pesanan</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-green-500"></span>
                    <span class="text-xs font-medium text-gray-600">Transaksi</span>
                </div>
            </div>
        </div>
        <div class="relative h-80">
            <canvas id="businessChart"></canvas>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-900">Aksi Cepat</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('event.create') }}" class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200 hover:bg-white hover:border-amber-300 hover:shadow-sm transition-all group">
                <div class="mr-4 bg-white p-2 rounded-md shadow-sm group-hover:bg-amber-50 transition-colors">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm">Tambah Event</h4>
                    <p class="text-[11px] text-gray-500">Buat event / acara baru</p>
                </div>
            </a>

            <a href="{{ route('menu.create') }}" class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200 hover:bg-white hover:border-amber-300 hover:shadow-sm transition-all group">
                <div class="mr-4 bg-white p-2 rounded-md shadow-sm group-hover:bg-amber-50 transition-colors">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm">Tambah Menu</h4>
                    <p class="text-[11px] text-gray-500">Input produk baru</p>
                </div>
            </a>

            <a href="{{ route('admin.create') }}" class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200 hover:bg-white hover:border-amber-300 hover:shadow-sm transition-all group">
                <div class="mr-4 bg-white p-2 rounded-md shadow-sm group-hover:bg-amber-50 transition-colors">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm">Tambah Akun Owner</h4>
                    <p class="text-[11px] text-gray-500">Registrasi akun staff</p>
                </div>
            </a>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('businessChart').getContext('2d');
    
    // Gradient Setup
    const blueGradient = ctx.createLinearGradient(0, 0, 0, 400);
    blueGradient.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
    blueGradient.addColorStop(1, 'rgba(59, 130, 246, 0)');
    
    const greenGradient = ctx.createLinearGradient(0, 0, 0, 400);
    greenGradient.addColorStop(0, 'rgba(34, 197, 94, 0.2)');
    greenGradient.addColorStop(1, 'rgba(34, 197, 94, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [
                {
                    label: 'Pesanan',
                    data: {!! json_encode($orderCounts) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: blueGradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6
                },
                {
                    label: 'Transaksi',
                    data: {!! json_encode($transactionCounts) !!},
                    borderColor: '#22c55e',
                    backgroundColor: greenGradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#22c55e',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index',
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleFont: { size: 12, weight: 'bold' },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 1,
                        font: { size: 11 }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: { size: 11 }
                    }
                }
            }
        }
    });
</script>
@endsection
