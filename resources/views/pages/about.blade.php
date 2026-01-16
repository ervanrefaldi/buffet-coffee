<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Bufet Coffee</title>
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
<body class="bg-cream font-sans text-brown leading-relaxed">

    <nav id="navbar" class="fixed w-full z-50 transition-all duration-500 py-6">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
            <a href="{{ url('/#hero') }}" class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Bufet Coffee" id="nav-logo" class="h-12 w-auto brightness-0 invert transition-all duration-500">
            </a>
            
            <div class="hidden md:flex space-x-10 text-white font-medium" id="nav-links">
                <a href="{{ url('/') }}" class="hover:text-gold transition text-sm uppercase tracking-widest">Home</a>
                <a href="{{ url('/tentang') }}" class="text-gold border-b-2 border-gold pb-1 text-sm uppercase tracking-widest">Tentang</a>
                <a href="{{ url('/produk') }}" class="hover:text-gold transition text-sm uppercase tracking-widest">Menu</a>
                <a href="{{ url('/event') }}" class="hover:text-gold transition text-sm uppercase tracking-widest">Event</a>
                <a href="{{ url('/membership') }}" class="hover:text-gold transition text-sm uppercase tracking-widest">Membership</a>
            </div>

            <a href="{{ url('/') }}" class="bg-gold text-white px-8 py-2.5 rounded-full font-bold hover:bg-white hover:text-brown transition duration-300 shadow-lg text-xs uppercase tracking-widest text-center">
                ← Kembali
            </a>
        </div>
    </nav>
    <header class="relative h-80 flex items-center justify-center overflow-hidden">
        <img src="{{ asset('images/kopi1.jpeg') }}" class="absolute inset-0 w-full h-full object-cover blur-sm brightness-50 scale-110">
        <div class="relative z-10 text-center">
            <span class="text-gold font-bold tracking-[0.5em] text-xs uppercase">Heritage</span>
            <h1 class="text-5xl font-serif font-bold text-white uppercase mt-2">Tentang Kami</h1>
            <div class="h-1 w-20 bg-gold mx-auto mt-4"></div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-20">
        
        <section class="mb-24">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center mb-20">
                <div>
                    <h2 class="text-4xl font-serif font-bold mb-8 text-brown leading-tight uppercase">Filosofi <br><span class="text-gold italic">Bufet Coffee</span></h2>
                    <p class="text-lg text-brown/80 mb-6 text-justify">
                        Bufet Coffee lahir dari filosofi budaya Sunda tempo dulu. Dalam tradisi Sunda, bufet adalah tempat penyimpanan di rumah yang digunakan oleh para sesepuh untuk menyimpan berbagai kebutuhan berharga. Dari situlah nama Bufet Coffee diambil—sebuah simbol ruang yang menyimpan keberagaman dan nilai.
                    </p>
                    <p class="text-lg text-brown/80 text-justify">
                        Berangkat dari filosofi tersebut, Bufet Coffee mengelola kopi yang berasal dari kebun sendiri di <strong>Kubangsari</strong>, sekaligus bekerja sama dengan petani lokal di sekitarnya.
                    </p>
                </div>
                <div>
                    <img src="{{ asset('images/kbs.jpeg') }}" class="rounded-[3rem] shadow-2xl h-[400px] w-full object-cover">
                    <p class="text-xs text-gold font-bold uppercase tracking-widest mt-4 text-center">Kebun Kopi Kubangsari</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-start">
                <div class="grid grid-cols-2 gap-4">
                    <img src="{{ asset('images/kopi2.jpeg') }}" class="rounded-2xl h-64 w-full object-cover">
                    <img src="{{ asset('images/kopi3.jpeg') }}" class="rounded-2xl h-64 w-full object-cover mt-8">
                </div>
                <div>
                    <p class="text-lg text-brown/80 mb-8 text-justify">
                        Dari kebun inilah perjalanan kopi dimulai, mulai dari perawatan tanaman, panen, hingga proses pasca panen yang membentuk karakter rasa di setiap biji kopi. Mengusung konsep sebagai sebuah “wadah”, kami menghadirkan berbagai macam proses pasca panen sehingga setiap pecinta kopi dapat menikmati karakter rasa yang berbeda.
                    </p>
                    <p class="text-lg text-brown/80 text-justify font-serif italic text-gold">
                        "Kami percaya bahwa setiap proses memiliki cerita, dan setiap cangkir kopi membawa pengalaman yang unik."
                    </p>
                </div>
            </div>
        </section>

        <section class="mb-24 py-16 border-y border-brown/10">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-serif font-bold uppercase tracking-widest text-brown">Jejak Langkah & Kolaborasi</h2>
                <div class="h-1 w-20 bg-gold mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="group">
                    <div class="relative overflow-hidden rounded-3xl h-80 mb-6 shadow-lg">
                        <img src="{{ asset('images/k2.jpeg') }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-black/40 flex items-end p-6">
                            <p class="text-white text-xs font-bold uppercase tracking-widest">7 Mei 2023</p>
                        </div>
                    </div>
                    <h4 class="font-serif font-bold text-xl text-brown uppercase">Farmers Village</h4>
                    <p class="text-gold font-bold text-xs uppercase mt-1">Indonesia Coffee Festival</p>
                </div>

                <div class="group">
                    <div class="relative overflow-hidden rounded-3xl h-80 mb-6 shadow-lg">
                        <img src="{{ asset('images/k1.jpeg') }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-black/40 flex items-end p-6">
                            <p class="text-white text-xs font-bold uppercase tracking-widest">3-5 Nov 2023</p>
                        </div>
                    </div>
                    <h4 class="font-serif font-bold text-xl text-brown uppercase">Jakarta Coffee Week</h4>
                    <p class="text-gold font-bold text-xs uppercase mt-1">ICE BSD City</p>
                </div>

                <div class="group">
                    <div class="relative overflow-hidden rounded-3xl h-80 mb-6 shadow-lg">
                        <img src="{{ asset('images/k3.jpeg') }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-black/40 flex items-end p-6">
                            <p class="text-white text-xs font-bold uppercase tracking-widest">1-2 Nov 2025</p>
                        </div>
                    </div>
                    <h4 class="font-serif font-bold text-xl text-brown uppercase">Jakarta Coffee Week</h4>
                    <p class="text-gold font-bold text-xs uppercase mt-1">Annual Event</p>
                </div>
            </div>
        </section>

        <section class="max-w-4xl mx-auto text-center">
            <p class="text-xl text-brown/80 leading-relaxed italic font-serif">
                "Bufet Coffee memulai perjalanannya pada 12 Agustus 2018. Sejak awal berdiri, kami berkomitmen menghadirkan kopi dengan beragam proses pasca panen—mulai dari Natural, Honey, Full Washed, hingga Wine Process—serta terus berkembang dengan tetap menjaga kualitas, konsistensi, dan identitas rasa dari kebun hingga ke cangkir."
            </p>
        </section>

        <section class="py-20 bg-cream">
    <div class="max-w-7xl mx-auto px-6 flex justify-center">
        
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm w-full max-w-[400px] overflow-hidden">
            
            <div class="p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 rounded-full p-[2px] bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-600">
                        <div class="w-full h-full rounded-full border-2 border-white overflow-hidden bg-black flex items-center justify-center">
                            <img src="{{ asset('images/logo.png') }}" class="w-10 h-auto object-contain">
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex items-center gap-1">
                            <span class="font-bold text-sm">bufet.coffee</span>
                            <svg class="w-4 h-4 text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M10.995 2.05a1 1 0 0 1 2.01 0l.001.05a1 1 0 0 1-2.01 0l-.001-.05zm4.683 1.239a1 1 0 0 1 1.05 1.713l-.042.026a1 1 0 1 1-1.05-1.713l.042-.026zM19.47 6.27a1 1 0 0 1 .31 1.986l-.049.008a1 1 0 1 1-.31-1.986l.049-.008zm2.48 4.683a1 1 0 0 1-.05 2.01l-.05.001a1 1 0 1 1 .05-2.01l.05-.001zm-1.239 4.683a1 1 0 0 1-1.713 1.05l-.026-.042a1 1 0 1 1 1.713-1.05l.026.042zm-4.322 3.824a1 1 0 0 1-1.127.842l-.049-.008a1 1 0 1 1 1.127-.842l.049.008zm-5.388.001a1 1 0 0 1-1.127-.842l-.049-.008a1 1 0 1 1 1.127.842l.049.008zm-4.322-3.824a1 1 0 0 1-.026 1.713l-.042.026a1 1 0 1 1 .026-1.713l.042-.026zm-2.48-4.683a1 1 0 0 1 .05-2.01l.05-.001a1 1 0 1 1-.05 2.01l-.05-.001zm1.239-4.683a1 1 0 0 1 1.713-1.05l.026.042a1 1 0 1 1-1.713 1.05l-.026-.042zm3.824-4.322a1 1 0 0 1 .842-1.127l.008-.049a1 1 0 1 1-.842 1.127l-.008.049z" />
                            </svg>
                        </div>
                        <p class="text-[10px] text-gray-500 font-bold">BUFET COFFEE</p>
                        <p class="text-[10px] text-gray-400">1,652 followers</p>
                    </div>
                </div>
                <a href="https://instagram.com/bufet.coffee" target="_blank">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/e7/Instagram_logo_2016.svg" class="w-5 h-5">
                </a>
            </div>

            <div class="px-4 pb-3">
                <p class="text-[9px] text-gray-400 uppercase font-black tracking-widest mb-1 text-right">56 posts</p>
                <div class="text-[11px] leading-tight text-gray-600">
                    <p class="font-bold">Product/service</p>
                    <p>sedia kopi yaaa</p>
                    <p class="text-gray-400 mt-0.5">Kp. Pasirmulya No.27 RT04/17 Desa Margamulya...</p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-[1px] bg-gray-100">
                <div class="aspect-square bg-white overflow-hidden">
                    <img src="{{ asset('images/kopi1.jpeg') }}" class="w-full h-full object-cover">
                </div>
                <div class="aspect-square bg-white overflow-hidden relative">
                    <img src="{{ asset('images/kopi2.jpeg') }}" class="w-full h-full object-cover">
                    <div class="absolute top-1 right-1 text-white"><svg class="w-3 h-3 shadow-sm" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg></div>
                </div>
                <div class="aspect-square bg-white overflow-hidden">
                    <img src="{{ asset('images/kopi3.jpeg') }}" class="w-full h-full object-cover">
                </div>
                <div class="aspect-square bg-white overflow-hidden">
                    <img src="{{ asset('images/k1.jpeg') }}" class="w-full h-full object-cover">
                </div>
                <div class="aspect-square bg-white overflow-hidden relative">
                    <img src="{{ asset('images/k2.jpeg') }}" class="w-full h-full object-cover">
                    <div class="absolute top-1 right-1 text-white"><svg class="w-3 h-3 shadow-sm" fill="currentColor" viewBox="0 0 24 24"><path d="M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H3V5h18v14zM5 15h14V7H5v8z"/></svg></div>
                </div>
                <div class="aspect-square bg-white overflow-hidden">
                    <img src="{{ asset('images/k3.jpeg') }}" class="w-full h-full object-cover">
                </div>
            </div>

            <div class="p-3">
                <a href="https://instagram.com/bufet.coffee" target="_blank" class="block w-full text-center py-2 text-xs font-bold text-blue-500 hover:bg-blue-50 border border-blue-50 rounded-lg transition">
                    View on Instagram
                </a>
            </div>
        </div>

    </div>
    </section>

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