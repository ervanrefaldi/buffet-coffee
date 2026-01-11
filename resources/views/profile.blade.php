<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Saya - Bufet Coffee</title>
    
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
<body class="bg-cream font-sans text-brown min-h-screen flex flex-col">

    <nav id="navbar" class="fixed w-full z-50 transition-all duration-500 py-6">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
            <a href="{{ url('/#hero') }}" class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Bufet Coffee" id="nav-logo" class="h-12 w-auto brightness-0 invert transition-all duration-500">
            </a>
            
            <div class="hidden md:flex space-x-10 text-white font-medium" id="nav-links">
                <a href="{{ url('/#hero') }}" class="hover:text-gold transition text-sm uppercase tracking-widest">Home</a>
                <a href="{{ url('/about') }}" class="hover:text-gold transition text-sm uppercase tracking-widest">About</a>
                <a href="{{ url('/produk') }}" class="hover:text-gold transition text-sm uppercase tracking-widest">Produk</a>
                <a href="{{ url('/#event') }}" class="hover:text-gold transition text-sm uppercase tracking-widest">Event</a>
            </div>

            <form action="{{ url('/logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-white/10 backdrop-blur-md border border-white/20 text-white px-8 py-2.5 rounded-full font-bold hover:bg-red-500 hover:border-red-500 transition duration-300 text-xs uppercase tracking-widest">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <header class="relative h-[40vh] flex items-center justify-center overflow-hidden">
        <img src="{{ asset('images/kopi1.jpeg') }}" class="absolute inset-0 w-full h-full object-cover brightness-50">
        <div class="relative z-10 text-center">
            <h1 class="text-5xl font-serif font-bold text-white uppercase tracking-tighter">Profil Saya</h1>
            <p class="text-gold font-bold tracking-[0.4em] text-xs mt-2 uppercase">Pengaturan Akun & Member</p>
        </div>
    </header>

    <main class="flex-grow max-w-4xl mx-auto w-full px-6 -mt-20 relative z-20 pb-20">
        <div class="bg-white rounded-[2.5rem] shadow-2xl p-8 md:p-12 border border-brown/5">
            
            {{-- Alert Success --}}
            @if (session('success'))
                <div class="mb-8 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl">
                    <p class="text-green-700 text-sm font-bold uppercase tracking-tight">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl">
                    <ul class="list-disc list-inside text-red-700 text-xs font-bold uppercase tracking-tight">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="/profile/update" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-brown/40 ml-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full bg-cream/50 border border-brown/10 rounded-2xl px-6 py-4 outline-none focus:border-gold focus:ring-1 focus:ring-gold transition duration-300 font-bold">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-brown/40 ml-1">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full bg-cream/50 border border-brown/10 rounded-2xl px-6 py-4 outline-none focus:border-gold focus:ring-1 focus:ring-gold transition duration-300 font-bold">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-brown/40 ml-1">Nomor Telepon (WhatsApp)</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                               class="w-full bg-cream/50 border border-brown/10 rounded-2xl px-6 py-4 outline-none focus:border-gold focus:ring-1 focus:ring-gold transition duration-300 font-bold">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-brown/40 ml-1">Status Member</label>
                        <input type="text" value="{{ ucfirst($user->role) }}" readonly
                               class="w-full bg-brown/5 border border-brown/5 rounded-2xl px-6 py-4 font-black text-gold uppercase tracking-widest cursor-not-allowed">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-brown/40 ml-1">Bio / Catatan Alamat</label>
                    <textarea name="bio" rows="4" placeholder="Tulis bio atau detail alamat pengiriman kamu di sini..."
                              class="w-full bg-cream/50 border border-brown/10 rounded-2xl px-6 py-4 outline-none focus:border-gold focus:ring-1 focus:ring-gold transition duration-300 font-medium">{{ old('bio', $user->bio) }}</textarea>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                            class="w-full md:w-auto px-12 py-4 bg-brown text-white rounded-full font-black uppercase text-xs tracking-[0.2em] hover:bg-gold transition-all duration-300 shadow-xl shadow-brown/20 hover:scale-105 active:scale-95">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
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