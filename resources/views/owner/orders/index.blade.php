@extends('layouts.owner')

@section('title', 'Kelola Pemesanan')
@section('subtitle', 'Daftar pesanan dari pelanggan yang belum dibayar.')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-500">Kode Pesanan</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-500">Tanggal</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-500">Pelanggan</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-500">Total</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-500">Status</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-bold text-amber-700">{{ $order->order_code }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-900">{{ $order->user->name ?? 'Guest' }}</div>
                        <div class="text-xs text-gray-500">{{ $order->user->phone ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest
                            @if($order->status == 'menunggu_pembayaran') bg-amber-100 text-amber-700
                            @elseif($order->status == 'dibayar') bg-green-100 text-green-700
                            @endif">
                            {{ str_replace('_', ' ', $order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 flex items-center gap-2">
                        <button onclick="showDetail('{{ $order->orders_id }}')" class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-50 hover:border-amber-300 hover:text-amber-700 transition-all">
                            Detail
                        </button>
                        <form action="{{ route('owner.orders.destroy', $order->orders_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Pesanan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic">Belum ada pesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $orders->links() }}
    </div>
</div>

<!-- Modal Detail -->
<div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-900/50 transition-opacity" onclick="closeModal()"></div>
        
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="text-lg font-bold text-gray-900">Detail Pesanan: <span id="modalOrderCode" class="text-amber-700"></span></h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6">
                <!-- User Info -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Pelanggan</p>
                        <p id="modalUserName" class="text-sm font-bold text-gray-900"></p>
                        <p id="modalUserPhone" class="text-xs text-gray-500"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Tanggal Pesanan</p>
                        <p id="modalOrderDate" class="text-sm text-gray-900"></p>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="mb-6">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Produk Yang Dipesan</p>
                    <div class="bg-gray-50 rounded-xl overflow-hidden border border-gray-200">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="bg-gray-100 border-b border-gray-200">
                                    <th class="px-4 py-2 font-bold">Produk</th>
                                    <th class="px-4 py-2 font-bold text-center">Qty</th>
                                    <th class="px-4 py-2 font-bold text-right">Harga</th>
                                    <th class="px-4 py-2 font-bold text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="modalOrderItems" class="divide-y divide-gray-200">
                                <!-- JS items here -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Totals & Address -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Alamat Pengiriman</p>
                        <p id="modalAddress" class="text-sm text-gray-600 italic"></p>
                    </div>
                    <div class="space-y-1">
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-500">Subtotal</span>
                            <span id="modalSubtotal" class="font-bold text-gray-900"></span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-500">Diskon</span>
                            <span id="modalDiscount" class="font-bold text-green-600"></span>
                        </div>
                        <div class="pt-2 border-t border-gray-200 flex justify-between text-base">
                            <span class="font-bold text-gray-900">Total</span>
                            <span id="modalTotal" class="font-black text-amber-700"></span>
                        </div>
                    </div>
                </div>

                <!-- Update Status -->
                <form id="statusForm" action="" method="POST" class="mt-8 pt-6 border-t border-gray-100">
                    @csrf
                    <div class="flex items-end gap-4">
                        <div class="flex-1">
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Perbarui Status</label>
                            <select name="status" id="modalStatusSelect" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500 transition">
                                <option value="menunggu_pembayaran">Menunggu Pembayaran</option>
                                <option value="dibayar">Dibayar</option>
                            </select>
                        </div>
                        <button type="submit" class="px-6 py-2.5 bg-amber-700 text-white rounded-lg text-sm font-bold hover:bg-amber-800 transition-colors shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
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

    function showDetail(orderId) {
        const modal = document.getElementById('detailModal');
        
        // Fetch order details via AJAX
        fetch(`/owner/orders/${orderId}`)
            .then(response => response.json())
            .then(order => {
                document.getElementById('modalOrderCode').innerText = order.order_code;
                document.getElementById('modalUserName').innerText = order.user ? order.user.name : 'Guest';
                document.getElementById('modalUserPhone').innerText = order.user ? order.user.phone : '-';
                document.getElementById('modalOrderDate').innerText = new Date(order.created_at).toLocaleString('id-ID', { dateStyle: 'long', timeStyle: 'short' });
                document.getElementById('modalAddress').innerText = order.shipping_address;
                
                const tableBody = document.getElementById('modalOrderItems');
                tableBody.innerHTML = '';
                
                let subtotalSum = 0;
                order.items.forEach(item => {
                    subtotalSum += parseFloat(item.subtotal);
                    const row = `
                        <tr>
                            <td class="px-4 py-3">
                                <p class="font-bold text-gray-900">${item.product ? item.product.name : 'Produk Tidak Ditemukan'}</p>
                                <p class="text-[10px] text-gray-500 uppercase tracking-widest">${item.variant}</p>
                            </td>
                            <td class="px-4 py-3 text-center text-gray-600">${item.quantity}</td>
                            <td class="px-4 py-3 text-right text-gray-600">${formatRupiah(item.price)}</td>
                            <td class="px-4 py-3 text-right font-bold text-gray-900">${formatRupiah(item.subtotal)}</td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });

                document.getElementById('modalSubtotal').innerText = formatRupiah(subtotalSum);
                document.getElementById('modalDiscount').innerText = '- ' + formatRupiah(order.discount);
                document.getElementById('modalTotal').innerText = formatRupiah(order.total_price);
                
                document.getElementById('modalStatusSelect').value = order.status;
                document.getElementById('statusForm').action = `/owner/orders/${order.orders_id}/status`;

                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
    }

    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
@endsection
