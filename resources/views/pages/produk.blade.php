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

    <nav id="navbar" class="fixed w-full z-50 transition-all duration-500 py-6">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
            <a href="{{ url('/#hero') }}" class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" id="nav-logo" class="h-12 w-auto brightness-0 invert transition-all duration-500">
            </a>
            
            <div class="hidden md:flex space-x-10 text-white font-medium" id="nav-links">
                <a href="{{ url('/#hero') }}" class="hover:text-gold transition text-sm uppercase tracking-widest">Home</a>
                <a href="{{ url('/about') }}" class="hover:text-gold transition text-sm uppercase tracking-widest">About</a>
                <a href="{{ url('/produk') }}" class="text-gold border-b-2 border-gold pb-1 text-sm uppercase tracking-widest">Produk</a>
                <a href="{{ url('/#event') }}" class="hover:text-gold transition text-sm uppercase tracking-widest">Event</a>
            </div>

            <div class="flex items-center">
                @if(session()->has('user_id'))
                    <a href="{{ url('/profile') }}" class="bg-gold text-white px-8 py-2.5 rounded-full font-bold hover:bg-white hover:text-brown transition duration-300 shadow-lg text-xs uppercase tracking-widest">
                        Profile
                    </a>
                @else
                    <div class="flex items-center gap-6">
                        <a href="{{ url('/login') }}" class="text-white hover:text-gold transition text-xs font-bold uppercase tracking-widest">Login</a>
                        <a href="{{ url('/register') }}" class="bg-gold text-white px-8 py-2.5 rounded-full font-bold hover:bg-white hover:text-brown transition duration-300 shadow-lg text-xs uppercase tracking-widest">Register</a>
                    </div>
                @endif
            </div>
        </div>
    </nav>
    <header class="relative h-80 flex items-center justify-center overflow-hidden">
        <img src="{{ asset('images/kopi1.jpeg') }}" class="absolute inset-0 w-full h-full object-cover blur-sm brightness-50">
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

    $sections = [
        'Bubuk Kopi' => [
            ['id' => 'bubuk_wine', 'name' => 'WINE (Bubuk)', 'img' => 'p1.png', 'type' => 'contain', 'prices' => [['s' => '200gr', 'p' => '120.000'], ['s' => '500gr', 'p' => '200.000'], ['s' => '1kg', 'p' => '350.000']]],
            ['id' => 'bubuk_natural', 'name' => 'NATURAL (Bubuk)', 'img' => 'p2.png', 'type' => 'contain', 'prices' => [['s' => '200gr', 'p' => '100.000'], ['s' => '500gr', 'p' => '180.000'], ['s' => '1kg', 'p' => '300.000']]],
            ['id' => 'bubuk_honey', 'name' => 'HONEY (Bubuk)', 'img' => 'p3.png', 'type' => 'contain', 'prices' => [['s' => '200gr', 'p' => '95.000'], ['s' => '500gr', 'p' => '170.000'], ['s' => '1kg', 'p' => '300.000']]],
            ['id' => 'bubuk_washed', 'name' => 'FULL WASHED (Bubuk)', 'img' => 'p4.png', 'type' => 'contain', 'prices' => [['s' => '200gr', 'p' => '90.000'], ['s' => '500gr', 'p' => '170.000'], ['s' => '1kg', 'p' => '300.000']]],
        ],
        'Biji Kopi' => [
            ['id' => 'biji_wine', 'name' => 'WINE (Biji)', 'img' => 'kopi8.jpeg', 'type' => 'cover', 'prices' => [['s' => '200gr', 'p' => '120.000'], ['s' => '500gr', 'p' => '200.000'], ['s' => '1kg', 'p' => '350.000']]],
            ['id' => 'biji_natural', 'name' => 'NATURAL (Biji)', 'img' => 'kopi9.jpeg', 'type' => 'cover', 'prices' => [['s' => '200gr', 'p' => '100.000'], ['s' => '500gr', 'p' => '180.000'], ['s' => '1kg', 'p' => '300.000']]],
            ['id' => 'biji_honey', 'name' => 'HONEY (Biji)', 'img' => 'kopi10.jpeg', 'type' => 'cover', 'prices' => [['s' => '200gr', 'p' => '95.000'], ['s' => '500gr', 'p' => '170.000'], ['s' => '1kg', 'p' => '300.000']]],
            ['id' => 'biji_washed', 'name' => 'FULL WASHED (Biji)', 'img' => 'kopi7.jpeg', 'type' => 'cover', 'prices' => [['s' => '200gr', 'p' => '90.000'], ['s' => '500gr', 'p' => '170.000'], ['s' => '1kg', 'p' => '300.000']]],
        ]
    ];
    @endphp

    <main class="max-w-7xl mx-auto px-6 py-20">
        @foreach($sections as $title => $items)
        <section class="mb-24">
            <div class="flex items-center gap-6 mb-12">
                <h2 class="text-3xl font-serif font-bold text-brown uppercase whitespace-nowrap">{{ $title }}</h2>
                <div class="h-px w-full bg-gold/20"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($items as $item)
                <div class="group bg-white rounded-[2.5rem] p-8 shadow-sm border border-brown/5 flex flex-col items-center">
                    <div class="h-52 w-full flex items-center justify-center mb-6 overflow-hidden rounded-2xl bg-cream/30">
                        <img src="{{ asset('images/' . $item['img']) }}" 
                             class="{{ $item['type'] == 'cover' ? 'w-full h-full object-cover' : 'max-h-[80%] object-contain' }} group-hover:scale-110 transition duration-500">
                    </div>
                    
                    <h3 class="text-xl font-serif font-bold mb-4 text-center">{{ $item['name'] }}</h3>
                    
                    <div class="w-full mb-4">
                        <label class="text-[9px] uppercase font-bold text-brown/40 block mb-2 text-center">Pilih Gramasi</label>
                        <select onchange="updatePrice('{{ $item['id'] }}', this, '{{ $userName }}')" 
                                class="w-full bg-cream border border-brown/10 rounded-xl px-4 py-2.5 text-xs font-bold text-brown outline-none focus:border-gold transition">
                            @foreach($item['prices'] as $opt)
                                <option value="{{ $opt['p'] }}" data-size="{{ $opt['s'] }}">{{ $opt['s'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-8 text-center">
                        <span id="price-{{ $item['id'] }}" class="text-2xl font-black text-gold">Rp {{ $item['prices'][0]['p'] }}</span>
                    </div>

                    @if(session()->has('user_id'))
                        @php
                            $initialMsg = "Halo Bufet Coffee, saya ingin memesan\nNama: {$userName}\nProduk: {$item['name']}\nJumlah: {$item['prices'][0]['s']}";
                        @endphp
                        <a id="link-{{ $item['id'] }}" 
                           href="https://wa.me/{{ $waNumber }}?text={{ rawurlencode($initialMsg) }}" 
                           target="_blank" 
                           class="w-full py-4 bg-brown text-white text-center rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-gold transition-all shadow-lg">
                           Pesan Sekarang
                        </a>
                    @else
                        <a href="{{ url('/login') }}" class="w-full py-4 border-2 border-brown text-brown text-center rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-brown hover:text-white transition-all">
                             Login Untuk Memesan
                        </a>
                    @endif
                </div>
                @endforeach
            </div>
        </section>
        @endforeach
    </main>

    <footer class="bg-[#2C1E17] text-cream pt-20 pb-12 mt-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-16 mb-16 border-b border-cream/10 pb-16">
            
            <div class="text-left">
                <h4 class="font-serif font-bold text-xl mb-6 text-gold uppercase tracking-wider">Roastery</h4>
                <p class="text-sm leading-relaxed opacity-80 italic mb-4">
                    Kp. Pasirmulya No.27 RT04/17 Desa Margamulya,<br>
                    Pangalengan, Kabupaten Bandung Selatan, Jawa Barat 40378
                </p>
                <a href="https://maps.google.com/?cid=16583891243001731647&g_mp=CiVnb29nbGUubWFwcy5wbGFjZXMudjEuUGxhY2VzLkdldFBsYWNl" target="_blank" class="text-[10px] font-black uppercase tracking-widest border-b border-gold/50 pb-1 hover:text-gold transition">
                    Lihat di Google Maps
                </a>
            </div>

            <div class="text-center">
                <img src="{{ asset('images/logo.png') }}" class="h-12 w-auto mx-auto mb-6 brightness-0 invert opacity-50">
                <div class="flex justify-center gap-8">
                    <a href="https://instagram.com/bufet.coffee" target="_blank" class="group flex flex-col items-center">
                        <span class="text-xs font-bold uppercase tracking-widest group-hover:text-gold transition">Instagram</span>
                        <span class="text-[10px] opacity-40 group-hover:opacity-100 transition">@bufet.coffee</span>
                    </a>
                    <a href="https://wa.me/6282118189789" target="_blank" class="group flex flex-col items-center">
                        <span class="text-xs font-bold uppercase tracking-widest group-hover:text-gold transition">WhatsApp</span>
                        <span class="text-[10px] opacity-40 group-hover:opacity-100 transition">+62 821 1818 9789</span>
                    </a>
                </div>
            </div>

            <div class="text-right">
                <h4 class="font-serif font-bold text-xl mb-6 text-gold uppercase tracking-wider">Navigasi</h4>
                <div class="flex flex-col gap-3 text-xs font-bold uppercase tracking-widest">
                    <a href="{{ url('/#hero') }}" class="opacity-60 hover:opacity-100 hover:text-gold transition">Home</a>
                    <a href="{{ url('/about') }}" class="opacity-60 hover:opacity-100 hover:text-gold transition">About Us</a>
                    <a href="{{ url('/#produk') }}" class="opacity-60 hover:opacity-100 hover:text-gold transition">Katalog Produk</a>
                    <a href="{{ url('/#event') }}" class="opacity-60 hover:opacity-100 hover:text-gold transition">Event & Promo</a>
                </div>
            </div>

        </div>

        <div class="text-center">
            <p class="text-[10px] uppercase tracking-[0.5em] opacity-40">© 2026 BUFET COFFEE ROASTERY</p>
        </div>
    </div>
    </footer>


    <script>
        function updatePrice(id, el, userName) {
            const price = el.value;
            const size = el.options[el.selectedIndex].getAttribute('data-size');
            const name = el.closest('div.group').querySelector('h3').innerText;
            
            document.getElementById('price-' + id).innerText = 'Rp ' + price;
            
            const btn = document.getElementById('link-' + id);
            if(btn) {
                const message = `Halo Bufet Coffee, saya ingin memesan\nNama: ${userName}\nProduk: ${name}\nJumlah: ${size}`;
                btn.href = `https://wa.me/{{ $waNumber }}?text=${encodeURIComponent(message)}`;
            }
        }

        // SCRIPT NAVBAR SCROLL
        window.onscroll = function() {
            const nav = document.getElementById('navbar');
            const logo = document.getElementById('nav-logo');
            const links = document.getElementById('nav-links');
            
            if (window.pageYOffset > 50) {
                nav.classList.add('bg-white', 'shadow-md', 'py-4');
                nav.classList.remove('py-6');
                logo.classList.remove('brightness-0', 'invert');
                links.classList.replace('text-white', 'text-brown');
            } else {
                nav.classList.remove('bg-white', 'shadow-md', 'py-4');
                nav.classList.add('py-6');
                logo.classList.add('brightness-0', 'invert');
                links.classList.replace('text-brown', 'text-white');
            }
        };
    </script>
</body>
</html>