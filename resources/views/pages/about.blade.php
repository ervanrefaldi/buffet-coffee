<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Bufet Coffee</title>
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

@php
    $navDark = true;
@endphp

@include('partials.navbar')
    <header class="relative h-80 flex items-center justify-center overflow-hidden">
        <img src="{{ asset('images/kopi1.jpeg') }}" class="absolute inset-0 w-full h-full object-cover blur-sm brightness-50 scale-110">
        <div class="relative z-10 text-center">
            <span class="text-gold font-bold tracking-[0.5em] text-xs uppercase">Heritage</span>
            <h1 class="text-5xl font-serif font-bold text-white uppercase mt-2">About Us</h1>
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
                        "Kami percaya bahwa setiap proses memiliki cerita, and setiap cangkir kopi membawa pengalaman yang unik."
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
                    <a href="https://www.instagram.com/reel/Cr85eN8rQjs/?igsh=MWdrcWpic2thMHc3dQ==" target="_blank" class="block relative overflow-hidden rounded-3xl h-80 mb-6 shadow-lg">
                        <img src="{{ asset('images/k2.jpeg') }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-black/40 flex items-end p-6">
                            <p class="text-white text-xs font-bold uppercase tracking-widest">7 Mei 2023</p>
                        </div>
                        {{-- Instagram Overlay Icon --}}
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <div class="bg-white/20 backdrop-blur-md p-4 rounded-full border border-white/30 transform scale-50 group-hover:scale-100 transition-transform duration-500">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </div>
                        </div>
                    </a>
                    <h4 class="font-serif font-bold text-xl text-brown uppercase">Farmers Village</h4>
                    <p class="text-gold font-bold text-xs uppercase mt-1">Indonesia Coffee Festival</p>
                </div>

                <div class="group">
                    <a href="https://www.instagram.com/p/CzTY5Lupy7L/?igsh=eTYzMjB2MzI0Mndl" target="_blank" class="block relative overflow-hidden rounded-3xl h-80 mb-6 shadow-lg">
                        <img src="{{ asset('images/k1.jpeg') }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-black/40 flex items-end p-6">
                            <p class="text-white text-xs font-bold uppercase tracking-widest">3-5 Nov 2023</p>
                        </div>
                        {{-- Instagram Overlay Icon --}}
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <div class="bg-white/20 backdrop-blur-md p-4 rounded-full border border-white/30 transform scale-50 group-hover:scale-100 transition-transform duration-500">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </div>
                        </div>
                    </a>
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
                "Bufet Coffee memulai perjalanannya pada 12 Agustus 2018. Sejak awal berdiri, kami berkomitmen menghadirkan kopi dengan beragam proses pasca panen—mulai dari Natural, Honey, Full Washed, hingga Wine Process—serta terus berkembang dengan tetap menjaga kualitas, konsistensi, and identitas rasa dari kebun hingga ke cangkir."
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
                <p class="text-[9px] text-gray-400 uppercase font-black tracking-widest mb-1 text-right">5 post</p>
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

    @include('partials.footer')
</body>
</html>
