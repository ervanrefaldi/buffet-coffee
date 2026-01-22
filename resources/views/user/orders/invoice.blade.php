<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_code }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @media print {
            .no-print { display: none; }
            body { background: white; }
            .print-shadow-none { box-shadow: none !important; }
        }
    </style>
</head>
<body class="bg-gray-50 py-12 px-4">

    <div class="max-w-3xl mx-auto bg-white p-10 rounded-2xl shadow-xl border border-gray-100 print-shadow-none">
        
        {{-- Header --}}
        <div class="flex justify-between items-start border-b-2 border-gray-100 pb-10 mb-10">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tighter uppercase mb-2">Invoice</h1>
                <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Bufet Coffee Roastery</p>
                <div class="mt-4 text-sm text-gray-500 space-y-1">
                    <p>Kp. Pasirmulya No.27 RT04/17</p>
                    <p>Desa Margamulya, Bandung</p>
                    <p>6282118189789</p>
                </div>
            </div>
            <div class="text-right">
                <div class="bg-blue-50 text-blue-700 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest inline-block mb-4">
                    {{ str_replace('_', ' ', $order->status) }}
                </div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">Kode Pemesanan</p>
                <p class="text-xl font-black text-gray-900 uppercase tracking-tighter">{{ $order->order_code }}</p>
            </div>
        </div>

        {{-- Info Grid --}}
        <div class="grid grid-cols-2 gap-12 mb-12">
            <div>
                <h3 class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4">Ditujukan Untuk</h3>
                <div class="space-y-1">
                    <p class="text-lg font-bold text-gray-900">{{ $order->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                    <p class="text-sm text-gray-500">{{ $order->user->phone }}</p>
                    <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                        {{ $order->shipping_address }}
                    </p>
                </div>
            </div>
            <div class="text-right">
                <h3 class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4">Detail Waktu</h3>
                <div class="space-y-2">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Tanggal Pesan</p>
                        <p class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($order->created_at)->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Waktu</p>
                        <p class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($order->created_at)->format('H:i') }} WIB</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="mb-12">
            <h3 class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4">Daftar Produk</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-100 italic text-gray-400 text-xs">
                            <th class="py-4 font-normal">Deskripsi Produk</th>
                            <th class="py-4 font-normal text-right">Harga</th>
                            <th class="py-4 font-normal text-center">Qty</th>
                            <th class="py-4 font-normal text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="py-6">
                                <p class="font-bold text-gray-900">{{ $item->product->name }}</p>
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">{{ $item->variant }}</p>
                            </td>
                            <td class="py-6 text-right text-sm text-gray-600">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </td>
                            <td class="py-6 text-center text-sm text-gray-600">
                                {{ $item->quantity }}
                            </td>
                            <td class="py-6 text-right font-bold text-gray-900">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Totals --}}
        <div class="flex justify-end pt-10 border-t-2 border-gray-100">
            <div class="w-full max-w-xs space-y-4">
                @php
                    $subtotal = $order->items->sum('subtotal');
                @endphp
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400 font-bold uppercase tracking-widest text-[10px]">Subtotal</span>
                    <span class="text-gray-900 font-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                @if($order->discount > 0)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400 font-bold uppercase tracking-widest text-[10px]">Diskon Member</span>
                    <span class="text-blue-600 font-bold">- Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="flex justify-between items-center pt-4 border-t border-gray-50">
                    <span class="text-gray-900 font-black uppercase tracking-widest text-xs">Total</span>
                    <span class="text-2xl font-black text-gray-900 tracking-tighter">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- Footer Note --}}
        <div class="mt-20 text-center">
            <p class="text-xs text-gray-400 italic">Terima kasih telah mempercayakan kebutuhan kopi Anda kepada Bufet Coffee.</p>
            <div class="mt-8 no-print pb-6">
                <button onclick="window.print()" class="bg-gray-900 text-white px-8 py-3 rounded-full text-[10px] font-black uppercase tracking-[0.2em] hover:bg-gray-800 transition-all shadow-xl shadow-gray-200">
                    Cetak Invoice
                </button>
                <a href="/orders" class="ml-4 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-gray-900 transition-colors">
                    Kembali
                </a>
            </div>
        </div>

    </div>

</body>
</html>
