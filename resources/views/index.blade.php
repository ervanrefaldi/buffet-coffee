<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bufet Coffee Roastery</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#FDF8F5',
                        brown: {
                            DEFAULT: '#4A3427',
                            dark: '#2C1E17',
                            light: '#705446',
                        },
                        gold: '#C5A358'
                    },
                    fontFamily: {
                        serif: ['Playfair Display', 'serif'],
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-up { animation: fadeUp 1s ease-out forwards; }
        #nav-logo { transition: all 0.5s ease; }
    </style>
</head>
<body class="bg-cream font-sans text-brown">

    <nav id="navbar" class="fixed w-full z-50 transition-all duration-500 py-6">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
            <a href="/" class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Bufet Coffee" id="nav-logo" class="h-12 w-auto brightness-0 invert transition-all duration-500">
            </a>
            <div class="hidden md:flex space-x-10 text-white font-medium" id="nav-links">
                <a href="#hero" class="hover:text-gold transition text-sm uppercase tracking-widest">Home</a>
                <a href="#about" class="hover:text-gold transition text-sm uppercase tracking-widest">About</a>
                <a href="#produk" class="hover:text-gold transition text-sm uppercase tracking-widest">Produk</a>
                <a href="#event" class="hover:text-gold transition text-sm uppercase tracking-widest">Event</a>
            </div>

            {{-- LOGIKA NAVBAR: Pesan Sekarang --}}
            @if(session()->has('user_id'))
                <a href="{{ url('/produk') }}" class="bg-gold text-white px-8 py-2.5 rounded-full font-bold hover:bg-white hover:text-brown transition duration-300 shadow-lg text-xs uppercase tracking-widest text-center">
                    Pesan Sekarang
                </a>
            @else
                <a href="{{ url('/login') }}" class="bg-gold text-white px-8 py-2.5 rounded-full font-bold hover:bg-white hover:text-brown transition duration-300 shadow-lg text-xs uppercase tracking-widest text-center">
                    Pesan Sekarang
                </a>
            @endif
        </div>
    </nav>

    <section id="hero" class="relative h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/kopi1.jpeg') }}" alt="Hero Background" class="w-full h-full object-cover blur-md scale-110 brightness-50">
            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-brown/20 to-cream"></div>
        </div>

        <div class="relative z-10 text-center text-white px-4">
            <h1 class="text-6xl md:text-8xl font-serif font-black mb-6 animate-fade-up tracking-tighter">
                BUFET <span class="text-gold italic">COFFEE</span> <br> ROASTERY
            </h1>
            
            <p class="text-xl md:text-2xl max-w-2xl mx-auto opacity-0 animate-fade-up font-light tracking-wide text-cream/90" style="animation-delay: 0.3s; animation-fill-mode: forwards;">
                Menyajikan cita rasa kopi premium yang diproses dari kebun terbaik di seluruh Indonesia.
            </p>
            
            <div class="mt-12 animate-fade-up opacity-0" style="animation-delay: 0.6s; animation-fill-mode: forwards;">
                <a href="#produk" class="bg-gold text-white px-10 py-4 rounded-full hover:bg-white hover:text-brown transition-all font-bold uppercase text-xs tracking-[0.2em] shadow-2xl">
                    Lihat Koleksi Menu
                </a>
            </div>
        </div>

        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-10 animate-bounce opacity-50">
            <div class="w-1 h-12 bg-gradient-to-b from-gold to-transparent rounded-full"></div>
        </div>
    </section>

   <section id="about" class="py-28 bg-cream overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row items-center gap-20">
                <div class="lg:w-1/2 flex gap-4 relative">
                    <div class="w-2/3 mt-12">
                        <img src="{{ asset('images/kopi2.jpeg') }}" alt="Kopi 2" class="rounded-3xl shadow-2xl w-full h-[450px] object-cover transform -rotate-2 hover:rotate-0 transition duration-500">
                    </div>
                    <div class="w-1/2">
                        <img src="{{ asset('images/kopi3.jpeg') }}" alt="Kopi 3" class="rounded-3xl shadow-2xl w-full h-[350px] object-cover transform rotate-3 hover:rotate-0 transition duration-500">
                        <div class="mt-6 p-6 bg-brown text-cream rounded-2xl shadow-xl hidden md:block">
                            <p class="text-xs uppercase tracking-[0.2em] opacity-60 mb-2">Since 2018</p>
                            <p class="font-serif italic text-lg text-gold">"#KubangSeries"</p>
                        </div>
                    </div>
                    <div class="absolute -z-10 -top-10 -left-10 w-40 h-40 bg-gold/10 rounded-full blur-2xl"></div>
                </div>

                <div class="lg:w-1/2">
                    <div class="inline-block px-4 py-1 border border-gold/30 rounded-full mb-4">
                        <span class="text-gold font-bold tracking-[0.3em] uppercase text-[10px]">Story of Our Beans</span>
                    </div>
                    <h2 class="text-5xl font-serif font-bold mb-8 text-brown leading-[1.1]">Menjelajahi Rasa Dari Setiap Biji Kopi</h2>
                    <p class="text-lg text-brown/80 leading-relaxed mb-6">
                        <strong>Bufet Coffee</strong> adalah wadah keberagaman rasa kopi yang berakar dari kebun sendiri, Kubangsari, yang kami sebut sebagai Kubangseries. Terinspirasi dari filosofi bufet dalam budaya Sunda sebagai tempat menyimpan hal-hal berharga, Bufet Coffee menghadirkan kopi Arabika dan Robusta berkualitas dengan berbagai proses pasca panen.
                    </p>
                    <div class="flex gap-8 border-t border-brown/10 pt-8">
                        <div>
                            <p class="text-3xl font-bold text-brown">100%</p>
                            <p class="text-xs text-gold font-black uppercase tracking-widest mt-1">Arabica & Robusta</p>
                        </div>
                        <div class="w-px h-12 bg-brown/10"></div>
                        <div>
                            <p class="text-3xl font-bold text-brown">Fresh</p>
                            <p class="text-xs text-gold font-black uppercase tracking-widest mt-1">Daily Roasted</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-16 text-center w-full flex justify-center">
            <a href="{{ url('/about') }}" class="inline-block bg-white text-brown border-2 border-brown px-12 py-4 rounded-full font-black uppercase text-xs tracking-[0.3em] hover:bg-brown hover:text-white transition-all duration-300 shadow-xl shadow-brown/10">
                Selengkapnya
            </a>
        </div>
    </section>

    <section id="produk" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <span class="text-gold font-bold tracking-widest uppercase text-sm">Signature Beans</span>
            <h2 class="text-5xl font-serif font-bold mt-2 mb-16 text-brown">Produk Kami</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                @php 
                $products = [
                    ['name' => 'WINE', 'desc' => 'Bubuk Kopi', 'img' => 'p1.png', 'prices' => [['size' => '200gr', 'price' => '120.000'], ['size' => '1kg', 'price' => '350.000']]],
                    ['name' => 'NATURAL', 'desc' => 'Bubuk Kopi', 'img' => 'p2.png', 'prices' => [['size' => '200gr', 'price' => '100.000'], ['size' => '1kg', 'price' => '300.000']]],
                    ['name' => 'HONEY', 'desc' => 'Bubuk Kopi', 'img' => 'p3.png', 'prices' => [['size' => '200gr', 'price' => '95.000'], ['size' => '1kg', 'price' => '300.000']]]
                ]; 
                @endphp

                @foreach($products as $product)
                <div class="group bg-cream rounded-[2.5rem] p-8 shadow-xl border border-transparent hover:border-gold/20 transition-all duration-500">
                    <div class="rounded-[2rem] overflow-hidden mb-8 h-72 bg-white flex items-center justify-center p-6 shadow-inner">
                        <img src="{{ asset('images/' . $product['img']) }}" alt="{{ $product['name'] }}" class="max-w-full max-h-full object-contain group-hover:scale-105 transition duration-700">
                    </div>

                    <div class="text-center mb-6">
                        <span class="text-gold font-bold text-[10px] uppercase tracking-[0.3em]">{{ $product['desc'] }}</span>
                        <h3 class="text-4xl font-serif font-bold mt-1 text-brown uppercase leading-none">{{ $product['name'] }}</h3>
                    </div>

                    <div class="space-y-3 mb-8 text-left">
                        @foreach($product['prices'] as $p)
                        <div class="flex justify-between items-center bg-white/50 px-4 py-2 rounded-xl border border-brown/5">
                            <span class="text-xs font-bold text-brown-light uppercase tracking-widest">{{ $p['size'] }}</span>
                            <span class="text-sm font-black text-brown italic">Rp {{ $p['price'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    
                    {{-- LOGIKA PRODUK: Tombol Pesan --}}
                    @if(session()->has('user_id'))
                        <a href="https://wa.me/+6282118189789" target="_blank" class="block w-full py-4 bg-brown text-white rounded-2xl font-bold uppercase text-[10px] tracking-widest hover:bg-gold transition-colors duration-300 shadow-lg text-center">
                            Pesan Sekarang
                        </a>
                    @else
                        <a href="{{ url('/login') }}" class="block w-full py-4 bg-brown text-white rounded-2xl font-bold uppercase text-[10px] tracking-widest hover:bg-gold transition-colors duration-300 shadow-lg text-center">
                            Pesan Sekarang
                        </a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        <div class="mt-16 text-center w-full flex justify-center">
            <a href="{{ url('/produk') }}" class="inline-block bg-white text-brown border-2 border-brown px-12 py-4 rounded-full font-black uppercase text-xs tracking-[0.3em] hover:bg-brown hover:text-white transition-all duration-300 shadow-xl shadow-brown/10">
                Selengkapnya
            </a>
        </div>
    </section>

    <section id="event" class="py-24 bg-cream px-6">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center gap-16">
            <div class="lg:w-1/2 w-full">
                <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl group">
                    <img src="{{ asset('images/event.jpeg') }}" alt="Event Bufet Coffee" class="w-full h-[450px] object-cover filter grayscale hover:grayscale-0 transition-all duration-700">
                    <div class="absolute inset-0 bg-black/50 flex flex-col justify-center items-center p-6 text-center hover:bg-black/40 transition-colors">
                        <span class="bg-red-600 text-white px-4 py-2 rounded-full font-bold text-xs uppercase tracking-wider mb-4 shadow-lg transform rotate-[-5deg]">Telah Dilaksanakan</span>
                        <h3 class="text-2xl md:text-4xl font-serif font-bold text-white uppercase leading-tight">Manual Brew Competition 2024</h3>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/2">
                <h2 class="text-4xl font-serif font-bold text-brown mb-6 leading-tight">Nikmati Event Spesial di Bufet Coffee</h2>
                <p class="text-lg text-brown/70 leading-relaxed mb-8">Ikuti berbagai event menarik mulai dari workshop barista hingga promo akhir pekan yang seru.</p>
                <a href="{{ url('/event') }}" class="inline-block bg-brown text-white px-10 py-4 rounded-full hover:bg-gold transition shadow-xl font-black uppercase text-xs tracking-widest">
                    Lihat Event
                </a>
            </div>
        </div>
    </section>

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
        const navbar = document.getElementById('navbar');
        const navLogo = document.getElementById('nav-logo');
        const links = document.getElementById('nav-links');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                navbar.classList.add('bg-white', 'shadow-2xl', 'py-4');
                navbar.classList.remove('bg-transparent', 'py-6');
                navLogo.classList.remove('brightness-0', 'invert');
                navLogo.classList.add('h-10'); 
                links.classList.replace('text-white', 'text-brown');
            } else {
                navbar.classList.add('bg-transparent', 'py-6');
                navbar.classList.remove('bg-white', 'shadow-2xl', 'py-4');
                navLogo.classList.add('brightness-0', 'invert');
                navLogo.classList.remove('h-10');
                links.classList.replace('text-brown', 'text-white');
            }
        });
    </script>
</body>
</html> 