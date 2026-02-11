<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - Bufet Coffee</title>
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
    <header class="relative h-64 md:h-80 flex items-center justify-center overflow-hidden">
        <img src="/{{ ('images/kopi1.jpeg') }}" class="absolute inset-0 w-full h-full object-cover blur-sm brightness-50">
        <div class="relative z-10 text-center text-white px-4">
            <h1 class="text-5xl md:text-6xl font-serif font-bold uppercase mt-2 tracking-tighter">Katalog Produk</h1>
        </div>
    </header>

    @php
    $waNumber = "6282118189789"; 
    
    // AMBIL DATA USER DARI SESSION LOGIN
    $userName = session('user_name') ?? 'Pelanggan'; 

    if(session()->has('user')) {
        $userName = session('user')->name;
    }

    // Group products by category
    $sections = $products->groupBy('category');
    @endphp

    <main class="max-w-7xl mx-auto px-6 py-32">
        @forelse($sections as $category => $items)
        <section class="mb-32">
            <div class="flex flex-col items-center mb-20">
                <span class="text-gold font-bold tracking-[0.4em] uppercase text-[10px] mb-2">Our Collection</span>
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-brown uppercase">{{ $category == 'biji' ? 'Biji Kopi' : 'Bubuk Kopi' }}</h2>
                <div class="h-1 w-20 bg-gold mt-6 rounded-full opacity-30"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-16 md:gap-x-12 md:gap-y-24">
                @foreach($items as $item)
                <div class="group relative">
                    {{-- Decorative Blur --}}
                    <div class="absolute -inset-4 bg-gold/5 rounded-[3rem] opacity-0 group-hover:opacity-100 transition-opacity duration-700 blur-2xl"></div>
                    
                    <div class="relative bg-white/40 backdrop-blur-sm rounded-[2.5rem] p-5 md:p-8 border border-brown/5 hover:border-gold/20 transition-all duration-500 flex flex-col h-full hover:shadow-2xl hover:shadow-gold/10">
                        
                        {{-- Stock Badge --}}
                        <div class="absolute top-4 right-4 md:top-6 md:right-8 z-10">
                            <span id="stock-{{ $item->products_id }}" class="px-3 py-1 bg-brown text-[#FDF8F5] text-[8px] md:text-[9px] font-black uppercase tracking-widest rounded-full shadow-lg">
                                {{ $item->stock_200g }} Packs Left
                            </span>
                        </div>

                        {{-- Elegant Image Presentation --}}
                        <div class="relative aspect-square w-full mb-6 md:mb-8 flex items-center justify-center p-4 md:p-6 bg-transparent rounded-3xl overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-cream to-transparent opacity-50"></div>
                            <img src="{{ $item->image_url }}" 
                                 alt="{{ $item->name }}"
                                 style="width:100%; height:100%; object-fit:cover;"
                                 referrerpolicy="no-referrer"
                                 class="relative z-10 w-full h-full object-cover transform transition duration-700 group-hover:scale-110 group-hover:-rotate-3 drop-shadow-[0_15px_35px_rgba(0,0,0,0.12)] group-hover:drop-shadow-[0_25px_45px_rgba(197,163,88,0.25)]">
                        </div>
                        
                        {{-- Product Content --}}
                        <div class="flex flex-col flex-grow text-center">
                            <h3 class="text-2xl md:text-3xl font-serif font-bold text-brown mb-3 group-hover:text-gold transition-colors duration-300 leading-tight">
                                {{ $item->name }}
                            </h3>
                            <p class="text-[10px] md:text-xs text-brown/50 leading-relaxed px-2 md:px-4 mb-6 md:mb-8 line-clamp-3 italic font-medium">
                                "{{ $item->description }}" <br>
                                <span class="text-[9px] not-italic text-gold mt-1 block font-bold uppercase tracking-wider">
                                    Variant: {{ ucfirst($item->coffee_variant) }}
                                </span>
                            </p>
                            
                            {{-- Interactive Area --}}
                            <div class="mt-auto pt-6 md:pt-8 border-t border-brown/5 space-y-6">
                                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-2">
                                    <div class="flex flex-col text-center sm:text-left w-full sm:w-auto">
                                        <span class="text-[8px] font-black uppercase tracking-widest text-brown/30 mb-2">Select Size</span>
                                        <select onchange="updateVariantInfo('{{ $item->products_id }}', this)" 
                                                class="text-xs font-black text-brown bg-transparent border-none p-0 focus:ring-0 cursor-pointer uppercase tracking-wider text-center sm:text-left">
                                            <option value="{{ $item->price_200g }}" data-size="200 Gram" data-stock="{{ $item->stock_200g }}">200 Gram</option>
                                            <option value="{{ $item->price_500g }}" data-size="500 Gram" data-stock="{{ $item->stock_500g }}">500 Gram</option>
                                            <option value="{{ $item->price_1kg }}" data-size="1 Kg" data-stock="{{ $item->stock_1kg }}">1 Kg</option>
                                        </select>
                                    </div>
                                    <div class="text-center sm:text-right w-full sm:w-auto">
                                        <span class="text-[8px] font-black uppercase tracking-widest text-brown/30 mb-2 block">Price</span>
                                        <div id="price-{{ $item->products_id }}" class="text-lg md:text-xl font-black text-gold italic">
                                            Rp {{ number_format($item->price_200g, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>

                                {{-- Buttons --}}
                                <div class="flex gap-3">
                                    @if(session()->has('user_id'))
                                        <a href="{{ route('menu.checkout', ['id' => $item->products_id]) }}?variant=200g" 
                                           id="link-{{ $item->products_id }}"
                                           class="flex-1 py-3 md:py-4 bg-brown text-white rounded-2xl text-[9px] md:text-[10px] font-black uppercase tracking-[0.2em] hover:bg-gold transition-all duration-300 shadow-xl shadow-brown/10 hover:shadow-gold/20 transform hover:-translate-y-1 text-center flex items-center justify-center">
                                           Order Now
                                        </a>
                                        <button onclick="addToCart('{{ $item->products_id }}')" 
                                                class="px-5 aspect-square flex items-center justify-center border-2 border-brown text-brown rounded-2xl hover:bg-brown hover:text-white transition-all transform hover:-translate-y-1 group/cart">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                        </button>
                                    @else
                                        <a href="{{ url('/login') }}" class="w-full py-3 md:py-4 border-2 border-brown/20 text-brown/60 text-center rounded-2xl text-[9px] md:text-[10px] font-black uppercase tracking-[0.2em] hover:bg-brown hover:text-white hover:border-brown transition-all duration-500">
                                             Login to Purchase
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @empty
        <section class="py-40 text-center">
            <div class="inline-block px-12 py-12 bg-white/40 backdrop-blur-md rounded-[3rem] border border-brown/5 shadow-2xl">
                <span class="text-6xl mb-6 block">🍂</span>
                <h3 class="text-2xl font-serif text-brown/40 italic">Currently exploring new beans...</h3>
                <p class="text-[10px] text-brown/30 uppercase tracking-[0.4em] mt-4 font-black">Coming Soon</p>
            </div>
        </section>
        @endforelse
    </main>


    @include('partials.footer')


    <!-- Toast Notification -->
    <div id="toast" class="fixed top-24 right-6 z-[60] transform translate-x-full opacity-0 transition-all duration-500">
        <div class="bg-white border-l-4 border-gold rounded-xl shadow-2xl p-4 flex items-center space-x-4 min-w-[300px]">
            <div class="flex-shrink-0 bg-gold/10 p-2 rounded-lg text-gold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="flex-grow">
                <p class="text-sm font-black text-brown uppercase tracking-wider">Berhasil!</p>
                <p class="text-xs text-brown/60">Produk ditambahkan ke keranjang</p>
            </div>
        </div>
    </div>

    <script>
        function showToast() {
            const toast = document.getElementById('toast');
            toast.classList.remove('translate-x-full', 'opacity-0');
            toast.classList.add('translate-x-0', 'opacity-100');
            
            setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
                toast.classList.remove('translate-x-0', 'opacity-100');
            }, 3000);
        }

        async function addToCart(productId) {
            const selectEl = document.querySelector(`select[onchange*="${productId}"]`);
            const priceValue = selectEl.value;
            const size = selectEl.options[selectEl.selectedIndex].getAttribute('data-size');
            
            let variantCode = '200g';
            if(size.includes('500')) variantCode = '500g';
            if(size.includes('1')) variantCode = '1kg';

            try {
                // Gunakan URL relatif untuk menghindari masalah origin (localhost vs 127.0.0.1)
                const response = await fetch("/cart/add", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        products_id: productId,
                        variant: variantCode,
                        quantity: 1
                    })
                });

                if (response.ok) {
                    showToast();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    const error = await response.json();
                    if (response.status === 401) {
                        window.location.href = '/login';
                    } else {
                        alert('Gagal: ' + (error.message || error.error || 'Terjadi kesalahan'));
                    }
                }
            } catch (err) {
                console.error('Fetch Error:', err);
                alert('Kesalahan koneksi: ' + err.message);
            }
        }

        function updateVariantInfo(id, el) {
            const price = el.value;
            const selectedOption = el.options[el.selectedIndex];
            const size = selectedOption.getAttribute('data-size');
            const stock = selectedOption.getAttribute('data-stock');
            
            // Update Price
            const formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(price);
            document.getElementById('price-' + id).innerText = formattedPrice;

            // Update Stock
            const stockEl = document.getElementById('stock-' + id);
            if(stockEl) {
                stockEl.innerText = stock + " Packs Left";
                // Optional: Change color if low stock
                if(parseInt(stock) === 0) {
                     stockEl.classList.remove('bg-brown');
                     stockEl.classList.add('bg-red-500');
                     stockEl.innerText = "Out of Stock";
                } else {
                     stockEl.classList.add('bg-brown');
                     stockEl.classList.remove('bg-red-500');
                }
            }
            
            // Update Link
            const btn = document.getElementById('link-' + id);
            if(btn) {
                let variantCode = '200g';
                if(size.includes('500')) variantCode = '500g';
                if(size.includes('1')) variantCode = '1kg';

                btn.href = `{{ url('/menu') }}/${id}/checkout?variant=${variantCode}`;
            }
        }
    </script>
</body>
</html>