<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan - Bufet Coffee</title>
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
<body class="bg-cream font-sans text-brown">

    @include('partials.navbar')

    <header class="relative h-48 md:h-64 flex items-center justify-center overflow-hidden">
        <img src="/{{ ('images/kopi1.jpeg') }}" class="absolute inset-0 w-full h-full object-cover blur-sm brightness-50">
        <div class="relative z-10 text-center text-white px-4">
            <h1 class="text-4xl md:text-5xl font-serif font-bold uppercase tracking-tighter">Konfirmasi Pesanan</h1>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-20">
        <form action="{{ route('checkout.cart.process') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-16" target="_blank" onsubmit="setTimeout(() => window.location.href='/orders', 1000)">
            @csrf
            
            <!-- Left Side: Items & Form -->
            <div class="lg:col-span-2 space-y-12">
                <!-- Order Details -->
                <div class="bg-white rounded-[2rem] md:rounded-[3rem] p-6 md:p-10 shadow-sm border border-brown/5">
                    <h2 class="text-2xl font-serif font-bold text-brown mb-8 uppercase tracking-tighter">Detail Item</h2>
                    <div class="space-y-6">
                        @php $grandTotal = 0; @endphp
                        @foreach($cartItems as $item)
                        @php 
                            $price = $item->product->getPriceByVariant($item->variant);
                            $subtotal = $price * $item->quantity;
                            $grandTotal += $subtotal;
                        @endphp
                        <div class="flex items-center gap-6 pb-6 border-b border-brown/5 last:border-0 last:pb-0">
                            <div class="h-16 w-16 bg-cream/50 rounded-xl flex items-center justify-center overflow-hidden shrink-0">
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="max-h-[85%] object-contain"
                                     onerror="this.onerror=null; this.src='/images/logo.png'; this.classList.add('opacity-10','grayscale');">
                            </div>
                            <div class="flex-grow">
                                <h4 class="font-bold text-brown uppercase text-sm">{{ $item->product->name }}</h4>
                                <p class="text-[10px] font-bold text-brown/40 uppercase tracking-widest">{{ $item->variant }} x {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right font-black text-brown text-sm">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-white rounded-[2rem] md:rounded-[3rem] p-6 md:p-10 shadow-sm border border-brown/5">
                    <h2 class="text-2xl font-serif font-bold text-brown mb-8 uppercase tracking-tighter">Alamat Pengiriman</h2>
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-brown/40 ml-2">Username</label>
                                <input type="text" value="{{ $user->name }}" class="w-full px-6 py-4 bg-cream/50 border border-brown/10 rounded-2xl text-sm font-bold opacity-60 cursor-not-allowed" disabled>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-brown/40 ml-2">Nomor WhatsApp</label>
                                <input type="text" name="phone" value="{{ $user->phone }}" class="w-full px-6 py-4 bg-cream/50 border border-brown/10 rounded-2xl text-sm font-bold focus:ring-2 focus:ring-gold focus:border-gold outline-none transition-all" required>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-brown/40 ml-2">Alamat Lengkap</label>
                            <textarea name="address" rows="3" class="w-full px-6 py-4 bg-cream/50 border border-brown/10 rounded-3xl text-sm font-bold focus:ring-2 focus:ring-gold focus:border-gold outline-none transition-all" placeholder="Masukkan alamat pengiriman selengkap mungkin..." required>{{ old('address') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Total & Submit -->
            <div class="lg:col-span-1">
                <div class="bg-brown dark:bg-[#2C1E17] text-cream rounded-[2.5rem] md:rounded-[3rem] p-8 md:p-10 shadow-2xl sticky top-32">
                    <h2 class="text-2xl font-serif font-bold mb-8 uppercase tracking-tighter">Total Bayar</h2>
                    <div class="space-y-6 mb-10 pb-10 border-b border-white/10">
                        <div class="flex justify-between items-center text-sm">
                            <span class="uppercase tracking-widest opacity-60">Subtotal</span>
                            <span class="font-black">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="uppercase tracking-widest opacity-60">Ongkos Kirim</span>
                            <span class="font-black text-gold uppercase tracking-widest text-[10px]">Bayar di Tujuan</span>
                        </div>
                        @if($isMember)
                        <div class="flex justify-between items-center text-sm text-gold">
                            <span class="uppercase tracking-widest">Diskon Member (3%)</span>
                            <span class="font-black">- Rp {{ number_format($grandTotal * 0.03, 0, ',', '.') }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="flex justify-between items-center mb-12">
                        <div class="uppercase tracking-widest text-[10px] font-black opacity-40">Total Akhir</div>
                        <div class="text-4xl font-black text-gold tracking-tighter">
                            Rp @php 
                                $finalTotal = ($isMember) ? ($grandTotal * 0.97) : $grandTotal;
                                echo number_format($finalTotal, 0, ',', '.');
                            @endphp
                        </div>
                    </div>

                    <button type="submit" class="w-full py-5 bg-gold text-white rounded-full font-black uppercase text-xs tracking-[0.2em] hover:bg-white hover:text-brown transition-all duration-500 shadow-2xl shadow-gold/20 hover:scale-[1.02] active:scale-95">
                        Pesan via WhatsApp
                    </button>

                    <div class="mt-8 p-6 bg-white/5 rounded-3xl border border-white/5">
                        <div class="flex gap-4 items-start">
                            <div class="text-gold mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-[10px] leading-relaxed opacity-60 uppercase tracking-widest font-bold">
                                Pesanan akan otomatis terekam dalam sistem dan Admin akan segera menghubungi via WhatsApp untuk konfirmasi stok & pembayaran.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>

    @include('partials.footer')

</body>
</html>
