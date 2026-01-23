@extends('layouts.owner')

@section('title', 'Laporan Penjualan')
@section('subtitle', 'Analisis performa bisnis Bufet Coffee.')

@push('styles')
<style>
    @media print {
        /* Hide everything except report content */
        aside, nav, header, .no-print, .filter-section, button, .alert {
            display: none !important;
        }
        
        body {
            background: white !important;
            color: black !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }

        .grid {
            display: block !important;
        }

        .bg-white {
            border: none !important;
            box-shadow: none !important;
        }

        .metric-card {
            border: 1px solid #ddd !important;
            margin-bottom: 10px !important;
            width: 100% !important;
        }

        table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        th, td {
            border: 1px solid #eee !important;
            padding: 8px !important;
            font-size: 10px !important;
        }

        /* Prevent large charts or images from breaking layout */
        canvas, img {
            max-width: 100% !important;
            height: auto !important;
        }

        /* Header for Print */
        .print-header {
            display: block !important;
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
    }

    .print-header {
        display: none;
    }
</style>
@endpush

@section('content')
    <!-- Print Header Only for PDF -->
    <div class="print-header">
        <h1 class="text-2xl font-bold">BUFET COFFEE - LAPORAN PENJUALAN</h1>
        <p class="text-sm">Periode: {{ date('d M Y', strtotime($startDate)) }} - {{ date('d M Y', strtotime($endDate)) }}</p>
        <p class="text-[10px] text-gray-400 mt-1">Dicetak pada: {{ now()->format('d M Y, H:i') }}</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8 mt-2 no-print">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <form action="{{ route('owner.laporan.index') }}" method="GET" class="flex flex-wrap items-end gap-4 flex-1">
                <div class="flex-1 min-w-[180px]">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-all">
                </div>
                <div class="flex-1 min-w-[180px]">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Tanggal Selesai</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-all">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-sm font-bold transition-all shadow-sm">
                        Apply
                    </button>
                    <a href="{{ route('owner.laporan.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg text-sm font-bold transition-all">
                        Reset
                    </a>
                </div>
            </form>

            <div class="flex items-center gap-3">
                <a href="{{ route('owner.laporan.export.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-bold transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export Excel
                </a>
                <a href="{{ route('owner.laporan.export.word', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-bold transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export Word
                </a>
            </div>
        </div>
    </div>

    <!-- Metrics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 shadow-sm border-l-4 border-l-amber-500">
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Total Pendapatan</p>
            <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <p class="text-[10px] text-gray-500 mt-2">Periode {{ date('d M Y', strtotime($startDate)) }} - {{ date('d M Y', strtotime($endDate)) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 shadow-sm border-l-4 border-l-blue-500">
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Jumlah Transaksi</p>
            <h3 class="text-2xl font-black text-gray-900">{{ $totalTransactions }} <span class="text-sm font-medium text-gray-400">Trx</span></h3>
            <p class="text-[10px] text-gray-500 mt-2">Transaksi yang berhasil dibayar</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 shadow-sm border-l-4 border-l-green-500">
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Rata-rata Penjualan</p>
            <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($avgTransaction, 0, ',', '.') }}</h3>
            <p class="text-[10px] text-gray-500 mt-2">Per transaksi dalam periode ini</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Top Products List -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 h-full overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Produk Terlaris</h3>
                </div>
                <div class="p-6">
                    @forelse($topProducts as $top)
                        <div class="flex items-center justify-between mb-4 last:mb-0">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600 font-bold text-sm">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ $top->product->name ?? 'Produk' }}</p>
                                    <p class="text-[11px] text-gray-500">{{ $top->total_qty }} Unit terjual</p>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-amber-600">Rp {{ number_format($top->total_sales, 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <p class="text-center text-sm text-gray-400 py-8">Belum ada data penjualan.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Transaction Table -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Riwayat Penjualan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                                <th class="px-6 py-4 border-b">Kode Trx</th>
                                <th class="px-6 py-4 border-b">Tanggal</th>
                                <th class="px-6 py-4 border-b">Pembeli</th>
                                <th class="px-6 py-4 border-b">Status Member</th>
                                <th class="px-6 py-4 border-b">Total</th>
                                <th class="px-6 py-4 border-b text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($transactions as $trx)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 text-xs font-bold text-amber-600">{{ $trx->transaction_code }}</td>
                                    <td class="px-6 py-4 text-xs text-gray-600">{{ date('d M Y, H:i', strtotime($trx->created_at)) }}</td>
                                    <td class="px-6 py-4 text-xs font-medium text-gray-900">{{ $trx->order->user->name ?? 'Guest' }}</td>
                                    <td class="px-6 py-4 text-xs">
                                        @php
                                            $userLapor = $trx->order->user ?? null;
                                            $statusLapor = 'Pelanggan';
                                            $badgeClassLapor = 'text-gray-400';

                                            if ($userLapor) {
                                                if ($userLapor->role === 'owner') {
                                                    $statusLapor = 'Owner';
                                                    $badgeClassLapor = 'bg-red-100 text-red-700 border border-red-200';
                                                } elseif ($userLapor->membership === 'membership') {
                                                    $statusLapor = 'Member';
                                                    $badgeClassLapor = 'bg-yellow-100 text-yellow-700 border border-yellow-200';
                                                }
                                            }
                                        @endphp
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $badgeClassLapor }}">
                                            {{ $statusLapor }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-xs font-black text-gray-900">Rp {{ number_format($trx->order->total_price ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2 py-1 rounded-full text-[9px] font-bold uppercase tracking-tighter
                                            @if($trx->status == 'dibayar') bg-amber-100 text-amber-700
                                            @elseif($trx->status == 'diproses') bg-blue-100 text-blue-700
                                            @elseif($trx->status == 'dikirim') bg-indigo-100 text-indigo-700
                                            @elseif($trx->status == 'selesai') bg-green-100 text-green-700
                                            @endif">
                                            {{ $trx->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400 italic">Tidak ada transaksi ditemukan pada periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
