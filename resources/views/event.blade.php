<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event - Bufet Coffee</title>
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
                <a href="{{ url('/') }}" class="hover:text-gold transition text-sm uppercase tracking-widest">Home</a>
                <a href="{{ url('/tentang') }}" class="hover:text-gold transition text-sm uppercase tracking-widest">Tentang</a>
                <a href="{{ url('/produk') }}" class="hover:text-gold transition text-sm uppercase tracking-widest">Menu</a>
                <a href="{{ url('/event') }}" class="text-gold border-b-2 border-gold pb-1 text-sm uppercase tracking-widest">Event</a>
                <a href="{{ url('/membership') }}" class="hover:text-gold transition text-sm uppercase tracking-widest">Membership</a>
            </div>

            <div class="flex items-center">
                <a href="{{ url('/') }}" class="bg-gold text-white px-8 py-2.5 rounded-full font-bold hover:bg-white hover:text-brown transition duration-300 shadow-lg text-xs uppercase tracking-widest">
                    ← Kembali
                </a>
            </div>
        </div>
    </nav>
    <header class="relative h-80 flex items-center justify-center overflow-hidden">
        <img src="{{ asset('images/kopi1.jpeg') }}" class="absolute inset-0 w-full h-full object-cover blur-sm brightness-50">
        <div class="relative z-10 text-center text-white px-4">
            <h1 class="text-5xl md:text-6xl font-serif font-bold uppercase mt-2 tracking-tighter">Event & Promo</h1>
            <p class="text-gold font-bold tracking-[0.4em] text-xs mt-2 uppercase">Bufet Coffee Experience</p>
            <div class="h-1 w-20 bg-gold mx-auto mt-4"></div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-20">
        @if($events->count() == 0)
            <div class="text-center py-20 bg-white rounded-[3rem] shadow-xl shadow-brown/5 border border-brown/5">
                <p class="text-lg text-brown/50 italic">Saat ini tidak ada event yang sedang berlangsung.</p>
                <a href="{{ url('/') }}" class="mt-6 inline-block text-gold font-bold uppercase text-xs tracking-widest border-b border-gold">Kembali ke Beranda</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                @foreach($events as $event)
                <div class="bg-white rounded-[3rem] overflow-hidden shadow-xl shadow-brown/5 border border-brown/5 group flex flex-col transition-all duration-500 hover:shadow-2xl">
                    <div class="h-80 overflow-hidden relative">
                        @if($event->image)
                            <img src="{{ asset($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                        @else
                            <div class="w-full h-full bg-brown/5 flex items-center justify-center">
                                <span class="text-brown/20 font-serif text-4xl italic">Bufet Event</span>
                            </div>
                        @endif
                        <div class="absolute top-6 left-6">
                            <span class="bg-gold text-white px-4 py-2 rounded-full font-black text-[10px] uppercase tracking-widest shadow-lg">
                                Active Event
                            </span>
                        </div>
                    </div>

                    <div class="p-10 flex flex-col flex-grow">
                        <h2 class="text-3xl font-serif font-bold text-brown mb-4 uppercase leading-tight">{{ $event->title }}</h2>
                        <p class="text-brown/70 leading-relaxed mb-8 flex-grow">
                            {{ $event->description }}
                        </p>
                        
                        <div class="flex items-center gap-4 pt-6 border-t border-brown/5 mt-auto">
                            <div class="bg-cream p-3 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase font-black text-brown/40 tracking-widest">Periode Event</p>
                                <p class="font-bold text-sm text-brown">{{ date('d M Y', strtotime($event->start_date)) }} — {{ date('d M Y', strtotime($event->end_date)) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
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