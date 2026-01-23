@extends('layouts.owner')

@section('title', 'Kelola Transaksi')
@section('subtitle', 'Daftar transaksi keuangan dari pesanan pelanggan.')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-500">Kode Transaksi</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-500">Kode Pesanan</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-500">Nama</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-500">Nomor User</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-500">Status User</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-500">Tanggal</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-500">Metode</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-500">Total</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-500">Status</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($transactions as $trx)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-bold text-amber-700">{{ $trx->transaction_code }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $trx->order->order_code ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $trx->order->user->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $trx->order->user->phone ?? '-' }}</td>
                    <td class="px-6 py-4">
                        @php
                            $user = $trx->order->user ?? null;
                            $status = 'Pelanggan';
                            $badgeClass = 'bg-gray-100 text-gray-600';

                            if ($user) {
                                if ($user->role === 'owner') {
                                    $status = 'Owner';
                                    $badgeClass = 'bg-amber-100 text-amber-700';
                                } elseif ($user->membership === 'membership') {
                                    $status = 'Member';
                                    $badgeClass = 'bg-purple-100 text-purple-700';
                                }
                            }
                        @endphp
                        <span class="px-2 py-0.5 rounded-md {{ $badgeClass }} text-[10px] font-bold uppercase tracking-wider">{{ $status }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $trx->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 uppercase">{{ $trx->payment_method ?? 'Unknown' }}</td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-900">Rp {{ number_format($trx->order->total_price ?? 0, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest
                            @if($trx->status == 'dibayar') bg-amber-100 text-amber-700
                            @elseif($trx->status == 'diproses') bg-blue-100 text-blue-700
                            @elseif($trx->status == 'dikirim') bg-indigo-100 text-indigo-700
                            @elseif($trx->status == 'selesai') bg-green-100 text-green-700
                            @endif">
                            {{ $trx->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 flex items-center gap-2">
                        <button onclick="showTrxDetail('{{ $trx->transactions_id }}')" class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-50 hover:border-amber-300 hover:text-amber-700 transition-all">
                            Detail
                        </button>
                        <form action="{{ route('owner.transactions.destroy', $trx->transactions_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Transaksi">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-6 py-12 text-center text-gray-500 italic">Belum ada transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $transactions->links() }}
    </div>
</div>

<!-- Modal Detail Transaksi -->
<div id="trxModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-900/50 transition-opacity" onclick="closeTrxModal()"></div>
        
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="text-lg font-bold text-gray-900">Detail Transaksi: <span id="modalTrxCode" class="text-amber-700"></span></h3>
                <button onclick="closeTrxModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-2 gap-6 mb-8">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Pelanggan</p>
                        <p id="modalUser" class="text-sm font-bold text-gray-900"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Nomor Telepon</p>
                        <p id="modalPhone" class="text-sm font-medium text-gray-900"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Kode Pesanan</p>
                        <p id="modalOrder" class="text-sm font-bold text-amber-700"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Metode Pembayaran</p>
                        <p id="modalMethod" class="text-sm text-gray-900 uppercase font-medium"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Tanggal Transaksi</p>
                        <p id="modalDate" class="text-sm text-gray-900"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Status User</p>
                        <p id="modalMembership" class="text-sm font-bold"></p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Total Nominal</span>
                        <span id="modalAmount" class="text-xl font-black text-amber-700"></span>
                    </div>
                </div>

                <!-- Update Status Form -->
                <div class="mb-8 p-4 border border-gray-100 rounded-xl bg-gray-50/50">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-3">Update Status Transaksi</p>
                    <form id="updateStatusForm" method="POST" class="flex gap-2">
                        @csrf
                        <select name="status" id="modalStatusSelect" class="flex-1 bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-all">
                            <option value="dibayar">Dibayar</option>
                            <option value="diproses">Diproses</option>
                            <option value="dikirim">Dikirim</option>
                            <option value="selesai">Selesai</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-sm font-bold transition-colors">
                            Update
                        </button>
                    </form>
                </div>

                <div id="modalItemsSection">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Item Pesanan</p>
                    <div class="space-y-2" id="modalItemsList">
                        <!-- Items list -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    }

    function showTrxDetail(trxId) {
        const modal = document.getElementById('trxModal');
        
        fetch(`/owner/transactions/${trxId}`)
            .then(response => response.json())
            .then(trx => {
                document.getElementById('modalTrxCode').innerText = trx.transaction_code;
                document.getElementById('modalUser').innerText = trx.order.user ? trx.order.user.name : 'Guest';
                document.getElementById('modalPhone').innerText = trx.order.user ? trx.order.user.phone : '-';
                document.getElementById('modalOrder').innerText = trx.order.order_code;
                document.getElementById('modalMethod').innerText = trx.payment_method || 'Unknown';
                document.getElementById('modalDate').innerText = new Date(trx.created_at).toLocaleString('id-ID', { dateStyle: 'long', timeStyle: 'short' });
                document.getElementById('modalAmount').innerText = formatRupiah(trx.order.total_price);
                
                const membershipEl = document.getElementById('modalMembership');
                if (trx.order.user && trx.order.user.role === 'owner') {
                    membershipEl.innerText = 'OWNER';
                    membershipEl.className = 'text-sm font-bold text-amber-700';
                } else if (trx.order.user && trx.order.user.membership === 'membership') {
                    membershipEl.innerText = 'MEMBER';
                    membershipEl.className = 'text-sm font-bold text-purple-700';
                } else {
                    membershipEl.innerText = 'PELANGGAN';
                    membershipEl.className = 'text-sm font-bold text-gray-600';
                }
                
                // Update form action and selection
                const updateForm = document.getElementById('updateStatusForm');
                updateForm.action = `/owner/transactions/${trxId}/status`;
                document.getElementById('modalStatusSelect').value = trx.status;
                
                const list = document.getElementById('modalItemsList');
                list.innerHTML = '';
                trx.order.items.forEach(item => {
                    const el = `
                        <div class="flex justify-between items-center bg-white p-3 rounded-lg border border-gray-100 shadow-sm">
                            <div class="text-xs">
                                <p class="font-bold text-gray-900">${item.product ? item.product.name : 'Produk'}</p>
                                <p class="text-gray-500">${item.quantity} x ${formatRupiah(item.price)}</p>
                            </div>
                            <span class="text-xs font-bold text-gray-900">${formatRupiah(item.subtotal)}</span>
                        </div>
                    `;
                    list.insertAdjacentHTML('beforeend', el);
                });

                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
    }

    function closeTrxModal() {
        document.getElementById('trxModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
@endsection
