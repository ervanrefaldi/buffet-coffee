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

    @include('partials.navbar')
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
                            <img src="{{ asset($event->image) }}?v={{ strtotime($event->updated_at ?? $event->created_at) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
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
                        
                        <div class="flex items-center justify-between pt-6 border-t border-brown/5 mt-auto">
                            <div class="flex items-center gap-4">
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
                            
                            @if($event->instagram_link)
                                <a href="{{ $event->instagram_link }}" target="_blank" class="bg-brown text-white p-3 rounded-2xl hover:bg-brown-dark transition-colors" title="Lihat di Instagram">
                                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </main>

    @include('partials.footer')
</body>
</html>
