<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership - Bufet Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#FDF8F5',
                        brown: { DEFAULT: '#4A3427', dark: '#1A120E', light: '#705446' },
                        gold: '#C5A358',
                        luxury: '#0F0B09'
                    },
                    fontFamily: { serif: ['Playfair Display', 'serif'], sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        .parallax-zoom { animation: slowZoom 30s infinite alternate; }
        @keyframes slowZoom { from { transform: scale(1); } to { transform: scale(1.15); } }
        .lux-border { border-image: linear-gradient(to right, transparent, #C5A358, transparent) 1; }
    </style>
</head>
<body class="bg-cream font-sans text-brown overflow-x-hidden">

@php
    $navDark = false; // We want the transparent navbar on top of the dark hero
@endphp

@include('partials.navbar')

<!-- Cinematic Hero Section -->
<header class="relative h-screen flex items-center justify-center overflow-hidden">
    <!-- Immersive Background -->
    <div class="absolute inset-0 z-0">
        {{-- Balanced image processing --}}
        <img src="{{ asset('images/kopi2.jpeg') }}" class="w-full h-full object-cover brightness-[0.9] parallax-zoom">
        {{-- Soft warm overlay instead of heavy white fog --}}
        <div class="absolute inset-0 bg-gradient-to-b from-cream/90 via-brown/10 to-cream"></div>
    </div>
    
    <div class="relative z-10 text-center px-6 max-w-4xl">
        <div class="mb-6 opacity-0 animate-[fadeIn_1.5s_ease-out_forwards]">
            <span class="text-brown/80 font-bold tracking-[0.4em] text-[10px] uppercase block mb-4">Keanggotaan Eksklusif</span>
            <div class="w-12 h-px bg-brown mx-auto"></div>
        </div>

        @if(session('user_role') === 'membership')
            <h1 class="text-6xl md:text-9xl font-serif italic text-brown mb-8 tracking-tighter opacity-0 animate-[fadeInUp_1.2s_ease-out_0.3s_forwards]">
                Selamat Datang, <span class="text-gold">{{ session('user_name') }}</span>
            </h1>
            <p class="text-brown/70 text-lg md:text-xl font-medium leading-relaxed tracking-wide opacity-0 animate-[fadeIn_1.5s_ease-out_0.8s_forwards]">
                Kehadiran Anda mendefinisikan seni dari cita rasa yang luar biasa.
            </p>
        @else
            <h1 class="text-7xl md:text-9xl font-serif font-bold text-brown uppercase mb-8 tracking-tighter opacity-0 animate-[fadeInUp_1.2s_ease-out_0.3s_forwards]">
                Bufet <span class="text-gold italic font-normal">Private</span>
            </h1>
            <p class="text-brown/80 text-lg md:text-xl font-medium leading-relaxed tracking-wide mb-12 opacity-0 animate-[fadeIn_1.5s_ease-out_0.8s_forwards]">
                Sebuah undangan menuju hal yang luar biasa. Dikhususkan bagi mereka yang menghargai ketenangan di balik sangraian sempurna.
            </p>
             <div class="opacity-0 animate-[fadeIn_1.5s_ease-out_1.2s_forwards]">
                <a href="{{ url('/menu') }}" class="inline-block bg-brown text-white px-12 py-4 rounded-full font-bold uppercase text-xs tracking-[0.4em] hover:bg-gold hover:text-white transition-all duration-700 shadow-xl hover:shadow-gold/30">
                    Jelajahi Koleksi
                </a>
            </div>
        @endif
    </div>

    <!-- Scroll Decor -->
    <div class="absolute bottom-12 left-1/2 -translate-x-1/2 flex flex-col items-center gap-4 opacity-60">
        <span class="text-[8px] uppercase tracking-[0.6em] text-brown font-bold">Gulir</span>
        <div class="w-px h-16 bg-gradient-to-b from-brown to-transparent"></div>
    </div>
</header>

<main class="relative bg-white">
    
    <!-- Exclusivity Visual Section -->
    <section class="py-40 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-24 items-center">
                <div class="relative">
                    <div class="absolute -inset-10 bg-gold/10 blur-[100px] rounded-full"></div>
                    <img src="{{ asset('images/kopi1.jpeg') }}" class="relative rounded-2xl w-full h-[600px] object-cover shadow-2xl transition-all duration-1000 transform hover:scale-[1.02]">
                    <!-- Elegant Label -->
                    <div class="absolute bottom-10 -right-10 bg-white/90 backdrop-blur-xl border border-brown/5 p-8 rounded-2xl hidden lg:block shadow-xl">
                        <p class="text-brown font-serif italic text-2xl mb-1">Estate Reserve</p>
                        <p class="text-brown/40 text-[9px] uppercase tracking-[0.3em] font-bold">Koleksi Kubangsari</p>
                    </div>
                </div>
                
                <div class="space-y-12">
                    <div>
                        <span class="text-gold font-bold tracking-[0.3em] uppercase text-[10px] mb-6 block">Warisan & Keahlian</span>
                        <h2 class="text-5xl md:text-7xl font-serif text-brown leading-none mb-8 italic">Lebih dari Sekadar <br> Keanggotaan.</h2>
                        <p class="text-brown/70 text-lg md:text-xl leading-relaxed max-w-lg">
                            Kami tidak hanya menawarkan kopi; kami menawarkan identitas. Menjadi bagian dari Bufet Private berarti berada di sumber dari setiap biji kopi, setiap cerita, dan setiap ritual pagi.
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-12 pt-12 border-t border-brown/10">
                        <div>
                            <p class="text-2xl font-serif text-gold italic">Eksklusivitas</p>
                            <p class="text-brown/60 text-xs mt-2">Akses tak tertandingi ke hasil panen terbaik.</p>
                        </div>
                        <div>
                            <p class="text-2xl font-serif text-gold italic">Elegan</p>
                            <p class="text-brown/60 text-xs mt-2">Dirancang khusus untuk selera yang berkelas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- NEW SECTION: Membership Path & Benefits (Visible only to non-members) --}}
    @if(session('user_role') !== 'membership')
    <section class="py-32 bg-cream text-brown relative overflow-hidden">
        {{-- Floating shapes for animation --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-gold/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-brown/5 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-20 animate-fade-up">
                <span class="text-gold font-bold tracking-[0.4em] uppercase text-xs mb-4 block">Langkah Menuju Prestise</span>
                <h2 class="text-5xl md:text-6xl font-serif font-black text-brown mb-6">Bergabunglah Dengan Kalangan Eksklusif</h2>
                <div class="w-20 h-1 bg-brown mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                {{-- Requirement Card --}}
                <div class="group relative bg-white p-10 rounded-[2.5rem] shadow-2xl hover:shadow-[0_20px_60px_-15px_rgba(197,163,88,0.3)] transition-all duration-500 hover:-translate-y-2 border border-brown/5">
                    <div class="absolute inset-0 bg-gradient-to-br from-white to-cream rounded-[2.5rem] -z-10"></div>
                    <div class="flex flex-col items-center text-center">
                        <div class="w-20 h-20 bg-brown text-gold flex items-center justify-center rounded-full text-3xl mb-8 group-hover:scale-110 transition-transform duration-500 shadow-lg">
                            ☕
                        </div>
                        <h3 class="text-3xl font-serif font-bold text-brown mb-4">Syarat Bergabung</h3>
                        <p class="text-brown/70 leading-relaxed mb-8">
                            Jadilah bagian dari keluarga eksklusif kami dengan melakukan transaksi pembelian kopi dalam jumlah besar.
                        </p>
                        <div class="bg-brown/5 py-4 px-8 rounded-2xl border border-brown/10">
                            <span class="block text-xs uppercase text-brown/50 tracking-widest mb-1">Minimal Pembelian</span>
                            <span class="text-4xl font-black text-brown">100<span class="text-xl align-top text-gold">kg</span></span>
                            <span class="block text-xs text-brown/50 mt-1 italic">dalam 1x transaksi</span>
                        </div>
                    </div>
                </div>

                {{-- Benefits Grid --}}
                <div class="space-y-8">
                    <h3 class="text-3xl font-serif font-bold text-brown mb-8 text-center lg:text-left">Keuntungan Member</h3>
                    
                    {{-- Benefit 1: Discount --}}
                    <div class="flex items-start gap-6 group p-6 rounded-3xl hover:bg-white hover:shadow-xl transition-all duration-300 border border-transparent hover:border-gold/20">
                        <div class="w-14 h-14 bg-gold/20 text-brown flex-shrink-0 flex items-center justify-center rounded-2xl group-hover:bg-gold group-hover:text-white transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-brown mb-2 group-hover:text-gold transition-colors">Diskon Eksklusif</h4>
                            <p class="text-brown/60 text-sm leading-relaxed">Nikmati harga spesial member untuk setiap pembelian produk kopi premium kami.</p>
                        </div>
                    </div>

                    {{-- Benefit 2: Lifetime --}}
                    <div class="flex items-start gap-6 group p-6 rounded-3xl hover:bg-white hover:shadow-xl transition-all duration-300 border border-transparent hover:border-gold/20">
                        <div class="w-14 h-14 bg-gold/20 text-brown flex-shrink-0 flex items-center justify-center rounded-2xl group-hover:bg-gold group-hover:text-white transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.131A8 8 0 008 8m0 0a8 8 0 00-8 8c0 2.472.345 4.865.99 7.131M8 8V4a4 4 0 118 0v4" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-brown mb-2 group-hover:text-gold transition-colors">Akses Seumur Hidup</h4>
                            <p class="text-brown/60 text-sm leading-relaxed">Status membership berlaku selamanya tanpa biaya perpanjangan tahunan.</p>
                        </div>
                    </div>

                    {{-- Benefit 3: Fast Shipping --}}
                    <div class="flex items-start gap-6 group p-6 rounded-3xl hover:bg-white hover:shadow-xl transition-all duration-300 border border-transparent hover:border-gold/20">
                        <div class="w-14 h-14 bg-gold/20 text-brown flex-shrink-0 flex items-center justify-center rounded-2xl group-hover:bg-gold group-hover:text-white transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-brown mb-2 group-hover:text-gold transition-colors">Pengiriman Prioritas</h4>
                            <p class="text-brown/60 text-sm leading-relaxed">Pengiriman paket Anda akan diprioritaskan untuk memastikan kesegaran kopi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Final CTA Section -->
    <section class="py-60 text-center relative overflow-hidden bg-cream">
        <!-- Decoration -->
        <div class="absolute inset-0 z-0 opacity-20">
             <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-gold rounded-full blur-[200px]"></div>
        </div>

        <div class="relative z-10 max-w-3xl mx-auto px-6">
            @if(session('user_role') === 'membership')
                <h2 class="text-5xl font-serif italic text-brown mb-12">Kopi terbaik untuk anggota terbaik.</h2>
                <a href="{{ url('/menu') }}" class="inline-block bg-brown text-white px-16 py-6 rounded-full font-bold uppercase text-xs tracking-[0.4em] hover:scale-105 transition-all duration-500 shadow-2xl shadow-brown/20 transform hover:-translate-y-1">
                    Kembali ke Katalog
                </a>
            @else
                <h2 class="text-5xl font-serif italic text-brown mb-12">Mulai perjalanan Anda.</h2>
                <a href="{{ url('/menu') }}" class="inline-block bg-brown text-white px-16 py-6 rounded-full font-bold uppercase text-xs tracking-[0.4em] hover:scale-105 transition-all duration-500 shadow-2xl shadow-brown/20 transform hover:-translate-y-1">
                    Belanja Menu Premium
                </a>
            @endif
            
            <p class="text-brown/30 text-[9px] uppercase font-bold tracking-[0.5em] mt-16 italic">
                Bufet Coffee Roastery &bull; Est. 2018
            </p>
        </div>
    </section>

</main>

@include('partials.footer')

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>

</body>
</html>