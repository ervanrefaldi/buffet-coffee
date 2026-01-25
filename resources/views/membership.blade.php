<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership - Bufet Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
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

@php
    $navDark = true;
@endphp

@include('partials.navbar')

<!-- Hero Section -->
<header class="relative h-screen flex items-center justify-center overflow-hidden">
    <img src="{{ asset('images/kopi2.jpeg') }}" class="absolute inset-0 w-full h-full object-cover brightness-50 scale-105">
    <div class="absolute inset-0 bg-gradient-to-b from-brown-dark/60 via-transparent to-cream"></div>
    
    <div class="relative z-10 text-center px-6">
        @if(session('user_role') === 'membership')
            <span class="text-gold font-bold tracking-[0.5em] text-xs uppercase animate-fade-in block mb-2">Selamat Datang, {{ session('user_name') }}!</span>
            <h1 class="text-6xl md:text-8xl font-serif font-bold text-white uppercase mt-4 mb-6 tracking-tighter drop-shadow-2xl">Member Eksklusif</h1>
        @else
            <span class="text-gold font-bold tracking-[0.5em] text-xs uppercase animate-fade-in">Exclusive Program</span>
            <h1 class="text-6xl md:text-8xl font-serif font-bold text-white uppercase mt-4 mb-6 tracking-tighter drop-shadow-2xl">Membership</h1>
        @endif
        <div class="h-1.5 w-32 bg-gold mx-auto mb-8 rounded-full"></div>
        <p class="text-white/80 text-lg md:text-xl max-w-2xl mx-auto font-light leading-relaxed">
            @if(session('user_role') === 'membership')
                Terima kasih telah menjadi bagian dari komunitas eksklusif Bufet Coffee. Nikmati seluruh previlese dan keuntungan yang telah kami siapkan khusus untuk Anda.
            @else
                Bergabunglah dengan komunitas eksklusif Bufet Coffee dan nikmati previlese serta keuntungan yang dirancang khusus untuk Anda.
            @endif
        </p>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7-7-7m14-8l-7 7-7-7"></path></svg>
    </div>
</header>

<main class="py-24 bg-cream relative">
    <div class="max-w-6xl mx-auto px-6">
        
        <!-- Regulation Section -->
        <section class="mb-32">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-serif font-bold text-brown uppercase mb-4">Regulasi Membership</h2>
                <p class="text-gold font-bold tracking-widest text-xs uppercase">Ketentuan & Persyaratan</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Card 1 -->
                <div class="bg-white rounded-[3rem] p-10 shadow-xl shadow-brown/5 border border-brown/5 hover:translate-y-[-10px] transition-all duration-500 group">
                    <div class="w-16 h-16 bg-gold/10 rounded-2xl flex items-center justify-center text-gold mb-8 group-hover:bg-gold group-hover:text-white transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-serif font-bold text-brown mb-4 uppercase">Minimal Pemesanan</h3>
                    <p class="text-brown/70 leading-relaxed text-lg">
                        Untuk menjadi member, Anda harus melakukan pemesanan minimal <strong class="text-gold">100kg kopi</strong> dalam satu kali transaksi.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-[3rem] p-10 shadow-xl shadow-brown/5 border border-brown/5 hover:translate-y-[-10px] transition-all duration-500 group">
                    <div class="w-16 h-16 bg-gold/10 rounded-2xl flex items-center justify-center text-gold mb-8 group-hover:bg-gold group-hover:text-white transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-2xl font-serif font-bold text-brown mb-4 uppercase">Benefit Eksklusif</h3>
                    <p class="text-brown/70 leading-relaxed text-lg">
                        Sebagai member, Anda berhak mendapatkan <strong class="text-gold">harga khusus</strong> dan diskon pada setiap pembelian kopi di Bufet Coffee Roastery.
                    </p>
                </div>
            </div>
        </section>

        <!-- Benefits Grid -->
        <section class="mb-32 bg-brown-dark rounded-[4rem] p-12 md:p-20 text-white relative overflow-hidden shadow-2xl">
            <div class="absolute top-0 right-0 w-64 h-64 bg-gold opacity-10 rounded-full -mr-32 -mt-32"></div>
            
            <div class="relative z-10">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-serif font-bold mb-4 uppercase">Keuntungan Member</h2>
                    <div class="h-1 w-20 bg-gold mx-auto"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="text-center group">
                        <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-gold transition-colors">
                            <svg class="w-6 h-6 text-gold group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="font-bold mb-2 uppercase text-sm tracking-widest text-gold text-center">Diskon 15%</h4>
                        <p class="text-white/60 text-xs">Potongan harga untuk semua varian produk kopi kami.</p>
                    </div>

                    <div class="text-center group">
                        <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-gold transition-colors">
                            <svg class="w-6 h-6 text-gold group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h4 class="font-bold mb-2 uppercase text-sm tracking-widest text-gold text-center">Prioritas</h4>
                        <p class="text-white/60 text-xs">Pengiriman dan layanan pelanggan yang lebih cepat.</p>
                    </div>

                    <div class="text-center group">
                        <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-gold transition-colors">
                            <svg class="w-6 h-6 text-gold group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        </div>
                        <h4 class="font-bold mb-2 uppercase text-sm tracking-widest text-gold text-center">Eksklusif</h4>
                        <p class="text-white/60 text-xs">Akses pertama untuk rilisan produk terbatas & musiman.</p>
                    </div>

                    <div class="text-center group">
                        <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-gold transition-colors">
                            <svg class="w-6 h-6 text-gold group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </div>
                        <h4 class="font-bold mb-2 uppercase text-sm tracking-widest text-gold text-center">Update</h4>
                        <p class="text-white/60 text-xs">Informasi tercepat mengenai promo dan event khusus.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="text-center">
            @if(session('user_role') === 'membership')
                <h2 class="text-3xl font-serif font-bold text-brown mb-8 uppercase">Selamat Berbelanja, Member!</h2>
            @else
                <h2 class="text-3xl font-serif font-bold text-brown mb-8 uppercase">Siap Menjadi Bagian Dari Kami?</h2>
            @endif
            <a href="{{ url('/menu') }}" class="inline-block bg-brown text-white px-16 py-5 rounded-full font-black uppercase text-sm tracking-[0.3em] hover:bg-gold transition-all duration-300 shadow-2xl shadow-brown/30 hover:scale-105 active:scale-95">
                Katalog Produk
            </a>
            <p class="text-brown/40 text-[10px] uppercase font-bold tracking-[0.2em] mt-8 italic">
                Sarat dan Ketentuan Berlaku &bull; Bufet Coffee Roastery
            </p>
        </section>

    </div>
</main>

@include('partials.footer')
</body>
</html>