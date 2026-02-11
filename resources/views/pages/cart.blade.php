<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Bufet Coffee</title>
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
            <p class="text-[10px] font-black uppercase tracking-[0.5em] mb-2 opacity-80">Pesanan Anda</p>
            <h1 class="text-5xl md:text-6xl font-serif font-bold uppercase tracking-tighter">Keranjang Belanja</h1>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-20">
        @if($cartItems->isEmpty())
            <div class="text-center py-32 bg-white rounded-[3rem] border border-brown/5 shadow-sm">
                <div class="text-6xl mb-6">🛒</div>
                <h3 class="text-2xl font-serif font-bold text-brown mb-2 uppercase">Keranjang Anda Kosong</h3>
                <p class="text-sm text-brown/60 mb-8 uppercase tracking-widest font-medium">Sepertinya Anda belum menambahkan produk apapun.</p>
                <a href="{{ url('/menu') }}" class="inline-block bg-brown text-white px-12 py-4 rounded-full font-black uppercase text-xs tracking-[0.2em] hover:bg-gold transition-all duration-300 shadow-xl shadow-brown/20 hover:scale-105 active:scale-95">
                    Mulai Belanja Sekarang
                </a>
            </div>
        @else
            <div class="max-w-4xl mx-auto space-y-8">
                <!-- Item List -->
                @php $grandTotal = 0; @endphp
                @foreach($cartItems as $item)
                    @php 
                        $price = $item->product->getPriceByVariant($item->variant);
                        $subtotal = $price * $item->quantity;
                        $grandTotal += $subtotal;
                    @endphp
                    <div class="group bg-white rounded-[2rem] md:rounded-[2.5rem] p-4 md:p-8 shadow-sm border border-brown/5 hover:shadow-xl transition-all duration-500 flex flex-col md:flex-row items-center gap-6 md:gap-8 relative overflow-hidden" id="cart-item-{{ $item->carts_id }}">
                        <!-- Image -->
                        <div class="h-24 w-24 md:h-32 md:w-32 bg-cream/30 rounded-2xl flex items-center justify-center overflow-hidden group-hover:bg-cream/50 transition-colors shrink-0">
                            <img src="{{ $item->product->image_url }}" class="max-h-[80%] object-contain drop-shadow-lg group-hover:scale-110 transition duration-500" 
                                 onerror="this.onerror=null; this.src='/images/logo.png'; this.classList.add('opacity-10','grayscale');">
                        </div>

                        <!-- Details -->
                        <div class="flex-grow text-center md:text-left">
                            <div class="flex items-center justify-center md:justify-start gap-2 mb-1">
                                <p class="text-[10px] font-black uppercase tracking-widest text-gold">{{ str_replace('_', ' ', $item->product->category) }}</p>
                                <div class="w-1 h-1 rounded-full bg-gold/30"></div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-brown/40">ID: {{ $item->carts_id }}</p>
                            </div>
                            <h3 class="text-xl font-serif font-bold text-brown mb-1 uppercase tracking-tight">{{ $item->product->name }}</h3>
                            <p class="text-xs font-bold text-brown/40 uppercase tracking-widest mb-4">Ukuran: {{ $item->variant }}</p>
                            
                            <!-- Action Buttons like in Menu -->
                            <div class="flex items-center justify-center md:justify-start gap-3">
                                <a href="{{ route('menu.checkout', ['id' => $item->product->products_id]) }}?variant={{ $item->variant }}" 
                                   class="bg-brown text-white px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-gold transition-all">
                                    Pesan Sekarang
                                </a>
                                <button class="p-2 border-2 border-brown/10 text-brown/40 rounded-xl hover:bg-brown hover:text-white transition-all" title="Detail Produk">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                                <form action="{{ route('cart.destroy', $item->carts_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 border-2 border-red-500/10 text-red-500/40 rounded-xl hover:bg-red-500 hover:text-white transition-all" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Quantity & Subtotal -->
                        <div class="flex flex-col items-center md:items-end gap-4 min-w-[150px]">
                            <div class="flex items-center bg-cream/50 rounded-full p-1 border border-brown/5">
                                <button onclick="updateQty('{{ $item->carts_id }}', -1)" class="w-8 h-8 rounded-full flex items-center justify-center text-brown hover:bg-white hover:shadow-sm transition-all font-black">-</button>
                                <span class="w-10 text-center text-xs font-black" id="qty-val-{{ $item->carts_id }}">{{ $item->quantity }}</span>
                                <button onclick="updateQty('{{ $item->carts_id }}', 1)" class="w-8 h-8 rounded-full flex items-center justify-center text-brown hover:bg-white hover:shadow-sm transition-all font-black">+</button>
                            </div>
                            <div class="text-center md:text-right">
                                <p class="text-[9px] font-black uppercase tracking-widest text-brown/30 mb-0.5">Subtotal</p>
                                <p class="font-black text-brown text-lg" id="subtotal-{{ $item->carts_id }}">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        @endif
    </main>

    @include('partials.footer')

    <script>
        async function updateQty(cartId, change) {
            const qtyEl = document.getElementById(`qty-val-${cartId}`);
            let currentQty = parseInt(qtyEl.innerText);
            let nextQty = currentQty + change;

            if (nextQty < 1) return;

            try {
                const response = await fetch(`/cart/update/${cartId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ quantity: nextQty })
                });

                if (response.ok) {
            location.reload();
        } else {
            const data = await response.json();
            alert(data.error || 'Terjadi kesalahan saat memperbarui jumlah.');
        }
            } catch (err) {
                console.error(err);
                alert('Kesalahan koneksi.');
            }
        }
    </script>
</body>
</html>
