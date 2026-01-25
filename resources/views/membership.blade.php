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
<body class="bg-luxury font-sans text-cream overflow-x-hidden">

@php
    $navDark = false; // We want the transparent navbar on top of the dark hero
@endphp

@include('partials.navbar')

<!-- Cinematic Hero Section -->
<header class="relative h-screen flex items-center justify-center overflow-hidden">
    <!-- Immersive Background -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/kopi2.jpeg') }}" class="w-full h-full object-cover brightness-[0.3] parallax-zoom">
        <div class="absolute inset-0 bg-gradient-to-b from-luxury via-transparent to-luxury"></div>
    </div>
    
    <div class="relative z-10 text-center px-6 max-w-4xl">
        <div class="mb-6 opacity-0 animate-[fadeIn_1.5s_ease-out_forwards]">
            <span class="text-gold font-light tracking-[0.8em] text-[10px] uppercase block mb-4">The Inner Circle</span>
            <div class="w-12 h-px bg-gold mx-auto"></div>
        </div>

        @if(session('user_role') === 'membership')
            <h1 class="text-6xl md:text-9xl font-serif italic text-white mb-8 tracking-tighter opacity-0 animate-[fadeInUp_1.2s_ease-out_0.3s_forwards]">
                Welcome Back, <span class="text-gold">{{ session('user_name') }}</span>
            </h1>
            <p class="text-gold/60 text-lg md:text-xl font-light leading-relaxed tracking-wide opacity-0 animate-[fadeIn_1.5s_ease-out_0.8s_forwards]">
                Your presence in our community defines the art of exceptional taste.
            </p>
        @else
            <h1 class="text-7xl md:text-9xl font-serif font-bold text-white uppercase mb-8 tracking-tighter opacity-0 animate-[fadeInUp_1.2s_ease-out_0.3s_forwards]">
                Bufet <span class="text-gold italic font-normal">Private</span>
            </h1>
            <p class="text-white/60 text-lg md:text-xl font-light leading-relaxed tracking-wide mb-12 opacity-0 animate-[fadeIn_1.5s_ease-out_0.8s_forwards]">
                An invitation to the extraordinary. Reserved for those who appreciate the silence behind the perfect roast.
            </p>
             <div class="opacity-0 animate-[fadeIn_1.5s_ease-out_1.2s_forwards]">
                <a href="{{ url('/menu') }}" class="inline-block border border-gold/40 text-gold px-12 py-4 rounded-full font-light uppercase text-xs tracking-[0.4em] hover:bg-gold hover:text-luxury transition-all duration-700 shadow-[0_0_30px_rgba(197,163,88,0.1)]">
                    Explore Collection
                </a>
            </div>
        @endif
    </div>

    <!-- Scroll Decor -->
    <div class="absolute bottom-12 left-1/2 -translate-x-1/2 flex flex-col items-center gap-4 opacity-40">
        <span class="text-[8px] uppercase tracking-[0.6em] text-white">Scroll</span>
        <div class="w-px h-16 bg-gradient-to-b from-gold to-transparent"></div>
    </div>
</header>

<main class="relative bg-luxury">
    
    <!-- Exclusivity Visual Section -->
    <section class="py-40 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-24 items-center">
                <div class="relative">
                    <div class="absolute -inset-10 bg-gold/5 blur-[100px] rounded-full"></div>
                    <img src="{{ asset('images/kopi1.jpeg') }}" class="relative rounded-2xl w-full h-[600px] object-cover grayscale brightness-75 hover:grayscale-0 transition-all duration-1000">
                    <!-- Elegant Label -->
                    <div class="absolute bottom-10 -right-10 bg- luxury/80 backdrop-blur-xl border border-gold/20 p-8 rounded-2xl hidden lg:block">
                        <p class="text-gold font-serif italic text-2xl mb-1">Estate Reserve</p>
                        <p class="text-white/40 text-[9px] uppercase tracking-[0.3em]">Kubangsari Selection</p>
                    </div>
                </div>
                
                <div class="space-y-12">
                    <div>
                        <span class="text-gold font-bold tracking-[0.3em] uppercase text-[10px] mb-6 block">Legacy & Craft</span>
                        <h2 class="text-5xl md:text-7xl font-serif text-white leading-none mb-8 italic">More than a <br> Membership.</h2>
                        <p class="text-white/40 text-lg md:text-xl font-light leading-relaxed max-w-lg">
                            We don't just offer coffee; we offer an identity. Being a part of Bufet Private means standing at the source of every bean, every story, and every morning ritual.
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-12 pt-12 border-t border-white/5">
                        <div>
                            <p class="text-2xl font-serif text-gold italic">Exclusivity</p>
                            <p class="text-white/30 text-xs mt-2">Unparalleled access to heritage crops.</p>
                        </div>
                        <div>
                            <p class="text-2xl font-serif text-gold italic">Elegance</p>
                            <p class="text-white/30 text-xs mt-2">Designed for the sophisticated palate.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-60 text-center relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute inset-0 z-0 opacity-10">
             <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-gold rounded-full blur-[200px]"></div>
        </div>

        <div class="relative z-10 max-w-3xl mx-auto px-6">
            @if(session('user_role') === 'membership')
                <h2 class="text-5xl font-serif italic text-white mb-12">Fine coffee for a fine member.</h2>
                <a href="{{ url('/menu') }}" class="inline-block bg-gold text-luxury px-16 py-6 rounded-full font-bold uppercase text-xs tracking-[0.4em] hover:scale-105 transition-all duration-500 shadow-2xl shadow-gold/20">
                    Return to Catalog
                </a>
            @else
                <h2 class="text-5xl font-serif italic text-white mb-12">Begin your journey.</h2>
                <a href="{{ url('/menu') }}" class="inline-block bg-gold text-luxury px-16 py-6 rounded-full font-bold uppercase text-xs tracking-[0.4em] hover:scale-105 transition-all duration-500 shadow-2xl shadow-gold/20">
                    Shop Premium Menu
                </a>
            @endif
            
            <p class="text-white/20 text-[9px] uppercase font-bold tracking-[0.5em] mt-16 italic">
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