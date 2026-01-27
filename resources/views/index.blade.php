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
<body class="bg-cream font-sans text-brown overflow-x-hidden">

    @include('partials.navbar')
    @include('partials.flash_message')

    <section id="hero" class="relative h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/kopi1.jpeg') }}" alt="Hero Background" class="w-full h-full object-cover blur-md scale-110 brightness-50">
            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-brown/20 to-cream"></div>
        </div>

        <div class="relative z-10 text-center text-white px-4 pt-32 md:pt-40">
            <p class="font-serif italic text-gold text-2xl md:text-5xl lg:text-6xl mb-8 animate-fade-up opacity-0 leading-[1.1]" style="animation-fill-mode: forwards;">
                Sedang mencari biji kopi dan bubuk kopi premium dengan rasa khas Indonesia?
            </p>
            <p class="text-white/95 text-xl md:text-3xl font-medium tracking-wide mb-14 max-w-4xl mx-auto animate-fade-up opacity-0 leading-relaxed" style="animation-delay: 0.2s; animation-fill-mode: forwards;">
                Bufet Coffee menghadirkan solusi kopi premium dengan cita rasa terbaik Nusantara.
            </p>

            @if(session()->has('user_id'))
                <div class="mb-10 animate-fade-up opacity-0 text-gold font-serif italic text-xl md:text-2xl" style="animation-delay: 0.4s; animation-fill-mode: forwards;">
                    Halo, {{ session('user_name') }}!
                </div>
            @endif
            
            <div class="animate-fade-up opacity-0" style="animation-delay: 0.6s; animation-fill-mode: forwards;">
                <a href="#produk" class="inline-block bg-gold text-white px-12 py-5 rounded-full hover:bg-white hover:text-brown transition-all font-bold uppercase text-xs tracking-[0.3em] shadow-2xl hover:-translate-y-1 transform duration-300">
                    Lihat Koleksi Menu
                </a>
            </div>
        </div>

        <div class="absolute bottom-20 left-1/2 -translate-x-1/2 z-10 animate-bounce opacity-50">
            <div class="w-1 h-12 bg-gradient-to-b from-gold to-transparent rounded-full"></div>
        </div>
    </section>

    <div class="bg-gradient-to-b from-cream via-[#f8f1eb] to-cream pt-48 pb-32 text-center relative overflow-hidden">
        {{-- Elegant subtle background decoration --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-gold/5 rounded-full blur-[100px] pointer-events-none"></div>
        
        {{-- Elegant separator element --}}
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-px h-32 bg-gradient-to-b from-gold/50 to-transparent"></div>
        
        <div class="relative z-10">
            <span class="inline-block text-[10px] md:text-xs font-black uppercase tracking-[0.8em] text-brown/40 mb-10 animate-fade-up">The Roastery Experience</span>
            
            <h1 class="relative font-serif font-black tracking-tighter leading-[0.85]">
                {{-- Top Line --}}
                <div class="block text-6xl md:text-9xl mb-2 md:mb-4 animate-fade-up" style="animation-delay: 0.2s;">
                    <span class="text-[#2C1E17]">BUFET</span> 
                    <span class="italic text-transparent bg-clip-text bg-gradient-to-r from-[#C5A358] via-[#E5C578] to-[#C5A358] animate-shimmer bg-[length:200%_auto]">COFFEE</span>
                </div>
                
                {{-- Bottom Line --}}
                <div class="block text-[4rem] md:text-[8rem] lg:text-[10rem] animate-fade-up" style="animation-delay: 0.4s;">
                    <span class="relative inline-block text-transparent bg-clip-text bg-gradient-to-b from-brown/20 to-brown/5 hover:from-gold/40 hover:to-gold/10 transition-all duration-700 cursor-default select-none" style="-webkit-text-stroke: 1px rgba(197, 163, 88, 0.3);">
                        ROASTERY
                        {{-- Reflection effect --}}
                        <span class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-transparent via-white/20 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-700 mask-image-text"></span>
                    </span>
                </div>
            </h1>
        </div>
        
        <style>
            @keyframes shimmer {
                0% { background-position: 0% 50%; }
                100% { background-position: 200% 50%; }
            }
            .animate-shimmer {
                animation: shimmer 3s linear infinite;
            }
        </style>
    </div>

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
                        Berakar dari kebun sendiri di Pangalengan, Kubangsari (Kubangseries), <strong>Bufet Coffee</strong> secara khusus menghadirkan biji kopi dan bubuk kopi Arabika serta Robusta pilihan. Terinspirasi dari filosofi bufet dalam budaya Sunda sebagai tempat menyimpan hal berharga, setiap kopi kami diproses dengan penuh perhatian untuk menjaga kualitas dan karakter rasa terbaik.
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

    <section id="produk" class="py-32 bg-[#FDF8F5] relative overflow-hidden">
        {{-- Elegant subtle bg decoration --}}
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-brown/5 rounded-full blur-[120px] -mr-48 -mt-48"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-28">
                <span class="text-brown font-black tracking-[0.6em] uppercase text-[10px] mb-4 block opacity-40">The Craftsmanship</span>
                <h2 class="text-5xl md:text-7xl font-serif font-bold text-brown tracking-tighter mb-8 leading-none">Produk Kami</h2>
                <div class="w-20 h-1 bg-brown mx-auto rounded-full opacity-10"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 lg:gap-16">
                @if($products->count() > 0)
                @foreach($products as $product)
                <div class="group h-full flex flex-col">
                    {{-- THE CARD: Dark Brown Primary Color --}}
                    <div class="relative bg-brown-dark rounded-[3rem] p-10 flex flex-col items-center flex-grow transition-all duration-700 hover:shadow-[0_50px_100px_-20px_rgba(44,30,23,0.3)] hover:-translate-y-3 overflow-hidden border border-brown-light/10">
                        
                        {{-- Glossy finish on hover --}}
                        <div class="absolute inset-0 bg-gradient-to-tr from-brown to-transparent opacity-0 group-hover:opacity-10 transition-opacity duration-700 pointer-events-none"></div>

                        {{-- Image Container: STRICT FIXED HEIGHT for Aligment --}}
                        <div class="w-full h-72 flex items-center justify-center mb-10 relative">
                            {{-- Image Glow --}}
                            <div class="absolute w-40 h-40 bg-gold/10 rounded-full blur-3xl scale-0 group-hover:scale-150 transition-transform duration-1000"></div>
                            
                            @if($product->image)
                                <img src="{{ asset($product->image) }}?v={{ strtotime($product->updated_at ?? $product->created_at) }}" alt="{{ $product->name }}" 
                                     class="relative z-10 max-w-full max-h-full object-contain filter drop-shadow-[0_20px_40px_rgba(0,0,0,0.4)] group-hover:scale-110 transition-transform duration-700"
                                     onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            @else
                                <div class="relative z-10 flex flex-col items-center justify-center text-gold/20">
                                    <span class="text-8xl opacity-10">☕</span>
                                </div>
                            @endif
                        </div>

                        {{-- Content Area: Strictly Aligned At Bottom --}}
                        <div class="w-full text-center mt-auto relative z-10">
                            <span class="text-gold font-bold text-[9px] uppercase tracking-[0.5em] mb-3 block opacity-60">{{ $product->category == 'biji' ? 'Signature Bean' : 'Premium Powder' }}</span>
                            <h3 class="text-2xl md:text-3xl font-serif font-black text-white uppercase tracking-tight mb-8 leading-tight">
                                {{ $product->name }}
                            </h3>
                            
                            <div class="pt-6 border-t border-white/10 w-full flex justify-center">
                                <a href="{{ url('/menu') }}" class="group/btn inline-flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.4em] text-gold hover:text-white transition-all duration-300">
                                    <span>Lihat Detail</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform transition-transform duration-300 group-hover/btn:translate-x-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                    <div class="col-span-full py-40 bg-brown/5 rounded-[3rem] border-2 border-dashed border-brown/10 flex flex-col items-center">
                        <span class="text-5xl mb-6 opacity-20">☕</span>
                        <p class="text-brown/40 font-serif italic text-2xl">Kopi terbaik sedang dipersiapkan...</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-32 text-center">
            <a href="{{ url('/menu') }}" class="group relative inline-flex items-center justify-center px-20 py-6 overflow-hidden font-black text-white rounded-full transition-all duration-500 bg-brown shadow-2xl hover:shadow-brown/40 transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-gold translate-y-full transition-transform duration-500 group-hover:translate-y-0"></div>
                <span class="relative z-10 uppercase text-[11px] tracking-[0.5em]">Katalog Selengkapnya</span>
            </a>
        </div>
    </section>

    {{-- Section: Menuai Langkah & Meracik Kolaborasi (Always Visible) --}}
    <section id="history" class="py-32 bg-[#FAF9F6] px-6 relative overflow-hidden">
        {{-- Artistic Decoration --}}
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-px h-24 bg-brown/10"></div>

        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-24 max-w-4xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-brown tracking-tighter mb-6 uppercase">Menuai Langkah & Meracik Kolaborasi</h2>
                <p class="text-brown/60 text-lg md:text-xl font-medium leading-relaxed italic">
                    Menuai Langkah dan Meracik Kolaborasi merekam perjalanan event kopi melalui langkah-langkah yang telah ditempuh dan kolaborasi yang terjalin dalam setiap momen.
                </p>
                <div class="w-20 h-1 bg-gold/40 mx-auto mt-8 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                {{-- Historical Item 1: Javaphile Cupping --}}
                <div class="group">
                    <a href="https://www.instagram.com/p/DKr9XctT0Q_/?igsh=NGV1cTVib3A0M3l3" target="_blank" class="block relative rounded-[2rem] overflow-hidden shadow-xl mb-8 aspect-[4/5] bg-white border border-brown/5">
                        <img src="{{ asset('images/event/javaphile-cupping.png') }}" alt="Javaphile Cupping Experience" class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110">
                        <div class="absolute top-6 left-6">
                            <span class="bg-white/90 backdrop-blur-md text-brown px-4 py-1.5 rounded-full font-black text-[9px] uppercase tracking-widest shadow-sm">10 Juni 2025</span>
                        </div>
                        {{-- Instagram Overlay Icon --}}
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <div class="bg-white/20 backdrop-blur-md p-4 rounded-full border border-white/30 transform scale-50 group-hover:scale-100 transition-transform duration-500">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </div>
                        </div>
                    </a>
                    <div class="text-center md:text-left px-4">
                        <h3 class="text-lg font-serif font-black text-brown uppercase mb-1 tracking-wider leading-none">Javaphile Cupping</h3>
                        <p class="text-[10px] font-bold text-brown/40 uppercase tracking-[0.2em]">Kawitan Coffee x Bufet Coffee</p>
                    </div>
                </div>

                {{-- Historical Item 2: Eskalasi x EMH --}}
                <div class="group">
                    <a href="https://www.instagram.com/p/DB0ciVYyDjI/?igsh=MXcxcHM3OTlmMWVrZQ==" target="_blank" class="block relative rounded-[2rem] overflow-hidden shadow-xl mb-8 aspect-[4/5] bg-white border border-brown/5">
                        <img src="{{ asset('images/event/eskalasi-emh.png') }}" alt="Eskalasi x EMH Bakeshop" class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110">
                        <div class="absolute top-6 left-6">
                            <span class="bg-white/90 backdrop-blur-md text-brown px-4 py-1.5 rounded-full font-black text-[9px] uppercase tracking-widest shadow-sm">2024</span>
                        </div>
                        {{-- Instagram Overlay Icon --}}
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <div class="bg-white/20 backdrop-blur-md p-4 rounded-full border border-white/30 transform scale-50 group-hover:scale-100 transition-transform duration-500">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </div>
                        </div>
                    </a>
                    <div class="text-center md:text-left px-4">
                        <h3 class="text-lg font-serif font-black text-brown uppercase mb-1 tracking-wider leading-none">Eskalasi x EMH</h3>
                        <p class="text-[10px] font-bold text-brown/40 uppercase tracking-[0.2em]">Filter & Espresso Based</p>
                    </div>
                </div>

                {{-- Historical Item 3: Javaphile Brewing --}}
                <div class="group">
                    <a href="https://www.instagram.com/reel/DO52XZREZUz/?igsh=MWE0ZXBkMzNkZnViMA==" target="_blank" class="block relative rounded-[2rem] overflow-hidden shadow-xl mb-8 aspect-[4/5] bg-white border border-brown/5">
                        <img src="{{ asset('images/event/javaphile-pangalengan.png') }}" alt="Javaphile Brewing Session" class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110">
                        <div class="absolute top-6 left-6">
                            <span class="bg-white/90 backdrop-blur-md text-brown px-4 py-1.5 rounded-full font-black text-[9px] uppercase tracking-widest shadow-sm">2024</span>
                        </div>
                        {{-- Instagram Overlay Icon --}}
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <div class="bg-white/20 backdrop-blur-md p-4 rounded-full border border-white/30 transform scale-50 group-hover:scale-100 transition-transform duration-500">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </div>
                        </div>
                    </a>
                    <div class="text-center md:text-left px-4">
                        <h3 class="text-lg font-serif font-black text-brown uppercase mb-1 tracking-wider leading-none">Javaphile x Pangalengan</h3>
                        <p class="text-[10px] font-bold text-brown/40 uppercase tracking-[0.2em]">Brewing & Quality Control</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section: Active Events (Conditional) --}}
    @if(isset($events) && count($events) > 0)
    <section id="event" class="py-32 bg-white px-6 relative overflow-hidden border-t border-brown/5">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col lg:flex-row items-center gap-20">
                <div class="lg:w-1/2 w-full">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach($events as $event)
                        @if($event->instagram_link)
                            <a href="{{ $event->instagram_link }}" target="_blank" class="relative group rounded-[2.5rem] overflow-hidden shadow-2xl h-80 block">
                        @else
                            <div class="relative group rounded-[2.5rem] overflow-hidden shadow-2xl h-80">
                        @endif
                            @if($event->image)
                                <img src="{{ asset($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-brown/5 flex items-center justify-center text-brown/20 italic text-sm">No Image</div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-8 transform transition-all duration-500 group-hover:via-black/40">
                                <span class="text-gold font-black uppercase text-[9px] tracking-[0.3em] mb-2">New Event</span>
                                <h3 class="text-white font-serif font-bold text-xl leading-tight">{{ $event->title }}</h3>
                                @if($event->instagram_link)
                                    <div class="mt-4 flex items-center gap-2 text-gold text-[10px] font-black uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span>Lihat di Instagram</span>
                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                    </div>
                                @endif
                            </div>
                        @if($event->instagram_link)
                            </a>
                        @else
                            </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="lg:w-1/2">
                    <span class="text-gold font-black tracking-[0.5em] uppercase text-[10px] mb-4 block">Be Part of It</span>
                    <h2 class="text-5xl md:text-6xl font-serif font-bold text-brown mb-8 leading-tight tracking-tighter">Event Spesial<br>Bersama Kami</h2>
                    <p class="text-lg text-brown/60 leading-relaxed mb-10 font-medium">Ikuti berbagai kegiatan seru mulai dari kompetisi barista, workshop seduh manual, hingga peluncuran varietas biji kopi terbaru.</p>
                    <a href="{{ url('/event') }}" class="group relative inline-flex items-center justify-center px-12 py-5 overflow-hidden font-black text-white rounded-full transition-all duration-500 bg-brown shadow-xl hover:shadow-brown/20">
                        <span class="relative z-10 uppercase text-[10px] tracking-[0.4em]">Lihat Detail Event</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    @include('partials.footer')
</body>
</html>
