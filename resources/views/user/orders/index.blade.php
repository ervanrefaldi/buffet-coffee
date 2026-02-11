<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Bufet Coffee</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600;900&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#FDF8F5',
                        brown: { DEFAULT: '#4A3427', dark: '#2C1E17', light: '#705446' },
                        gold: '#C5A358'
                    },
                    fontFamily: { serif: ['Playfair Display', 'serif'], sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-cream font-sans text-brown min-h-screen flex flex-col">

    @include('partials.navbar')

    <header class="relative h-[30vh] flex items-center justify-center overflow-hidden">
        <img src="{{ asset('images/kopi1.jpeg') }}" class="absolute inset-0 w-full h-full object-cover brightness-50">
        <div class="relative z-10 text-center">
            <h1 class="text-5xl font-serif font-bold text-white uppercase tracking-tighter">Riwayat Pesanan</h1>
            <p class="text-gold font-bold tracking-[0.4em] text-xs mt-2 uppercase">Lacak & Kelola Pesanan Kamu</p>
        </div>
    </header>

    <main class="flex-grow max-w-5xl mx-auto w-full px-6 py-12 relative z-20">
        <div class="mb-8">
            <a href="/profile" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-brown/40 hover:text-gold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Kembali ke Profil
            </a>
        </div>

        @if (session('success'))
            <div class="mb-8 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl">
                <p class="text-green-700 text-sm font-bold uppercase tracking-tight">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl">
                <p class="text-red-700 text-sm font-bold uppercase tracking-tight">{{ session('error') }}</p>
            </div>
        @endif

        <div class="space-y-6">
            @forelse($orders as $order)
                <div class="group bg-white rounded-[2.5rem] shadow-xl shadow-brown/5 border border-brown/5 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-1">
                    <div class="p-8 md:p-10">
                        <div class="flex flex-col md:flex-row justify-between gap-8">
                            {{-- Order Info --}}
                            <div class="flex gap-8">
                                <div class="h-20 w-20 bg-cream rounded-[1.5rem] overflow-hidden flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-500 flex-shrink-0 border border-brown/5">
                                    @php
                                        $firstItem = $order->items->first();
                                    @endphp
                                    @if($firstItem && $firstItem->product->image)
                                        <img src="{{ $firstItem->product->image_url }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-8 h-8 text-brown/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-2xl font-black text-brown uppercase tracking-tighter">{{ $order->order_code }}</h3>
                                        <div class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest
                                            @if($order->status == 'menunggu_pembayaran') bg-amber-100 text-amber-700
                                            @elseif($order->status == 'dibayar') bg-blue-100 text-blue-700
                                            @elseif($order->status == 'diproses') bg-indigo-100 text-indigo-700
                                            @elseif($order->status == 'selesai') bg-green-100 text-green-700
                                            @else bg-gray-100 text-gray-700
                                            @endif">
                                            {{ str_replace('_', ' ', $order->status) }}
                                        </div>
                                    </div>
                                    <p class="text-xs text-brown/40 font-bold uppercase tracking-widest mb-4">
                                        Dipesan pada {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}
                                    </p>
                                    
                                    <div class="flex flex-wrap gap-4">
                                        @foreach($order->items as $item)
                                            <div class="flex items-center gap-3 bg-cream/50 rounded-xl px-4 py-2 border border-brown/5">
                                                @if($item->product->image)
                                                    <img src="{{ $item->product->image_url }}" class="w-8 h-8 object-contain">
                                                @endif
                                                <span class="text-[10px] font-bold text-brown">{{ $item->quantity }}x {{ $item->product->name }} ({{ $item->variant }})</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Details --}}
                            <div class="flex flex-col items-end justify-center text-right">
                                <p class="text-[10px] font-black uppercase tracking-widest text-brown/40 mb-1">Total Pembayaran</p>
                                <p class="text-3xl font-black text-brown tracking-tighter mb-4">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                
                                <div class="flex gap-4">
                                    @if(in_array($order->status, ['dibayar', 'diproses', 'dikirim', 'selesai']))
                                        <a href="{{ route('user.orders.invoice', $order->orders_id) }}" target="_blank" class="px-6 py-2 bg-blue-50 text-blue-700 rounded-full text-[9px] font-black uppercase tracking-widest border border-blue-100 hover:bg-blue-100 transition-colors">
                                            Invoice
                                        </a>
                                    @endif
                                    
                                    @if($order->status == 'menunggu_pembayaran')
                                        <div class="flex gap-2">
                                            <form action="{{ route('user.orders.destroy', $order->orders_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Data akan dihapus permanen.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-6 py-2 bg-red-50 text-red-700 rounded-full text-[9px] font-black uppercase tracking-widest border border-red-100 hover:bg-red-100 transition-colors">
                                                    Batalkan
                                                </button>
                                            </form>
                                            
                                            <a href="https://wa.me/6282118189789" target="_blank" class="px-6 py-2 bg-amber-50 text-amber-700 rounded-full text-[9px] font-black uppercase tracking-widest border border-amber-100 hover:bg-amber-100 transition-colors">
                                                Bayar Sekarang
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-32 bg-white rounded-[3rem] border-2 border-dashed border-brown/10 shadow-xl shadow-brown/5">
                    <span class="text-6xl mb-6 block opacity-20">☕</span>
                    <h3 class="text-2xl font-serif font-bold text-brown/40 uppercase tracking-tighter">Belum Ada Pesanan</h3>
                    <p class="text-sm font-medium text-brown/30 mt-2">Yuk, mulai jelajahi menu kopi terbaik kami!</p>
                    <a href="/menu" class="mt-8 inline-block px-12 py-4 bg-gold text-white rounded-full font-black uppercase text-xs tracking-[0.2em] hover:bg-brown transition-all duration-300 shadow-xl shadow-gold/20">
                        Cek Menu Sekarang
                    </a>
                </div>
            @endforelse
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
