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

    @include('partials.navbar')

    <header class="relative h-[40vh] flex items-center justify-center overflow-hidden">
        <img src="{{ asset('images/kopi1.jpeg') }}" class="absolute inset-0 w-full h-full object-cover brightness-50">
        <div class="relative z-10 text-center">
            <h1 class="text-5xl font-serif font-bold text-white uppercase tracking-tighter">Profil Saya</h1>
            <p class="text-gold font-bold tracking-[0.4em] text-xs mt-2 uppercase">Pengaturan Akun & Member</p>
        </div>
    </header>

    <main class="flex-grow max-w-4xl mx-auto w-full px-6 -mt-20 relative z-20 pb-20">
        <div class="bg-white rounded-[2.5rem] shadow-2xl p-8 md:p-12 border border-brown/5">
            
            {{-- Logout Form --}}
            <div class="mb-8 text-right">
                <form id="logout-form" action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="px-8 py-4 bg-red-500 text-white border border-red-500 rounded-full font-bold uppercase text-xs tracking-[0.2em] hover:bg-red-600 hover:border-red-600 transition-all duration-300 shadow-lg hover:scale-105 active:scale-95">
                        Logout
                    </button>
                </form>
            </div>
            
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

            <form method="POST" action="/profile/update" id="profile-form" class="space-y-8">
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
                        <input type="text" value="{{ $user->membership === 'membership' ? 'MEMBER' : 'PELANGGAN' }}" readonly
                               class="w-full bg-brown/5 border border-brown/5 rounded-2xl px-6 py-4 font-black text-gold uppercase tracking-widest cursor-not-allowed">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-brown/40 ml-1">Bio / Catatan Alamat</label>
                    <textarea name="bio" rows="4" maxlength="50" placeholder="Tulis bio atau detail alamat pengiriman kamu di sini..."
                              class="w-full bg-cream/50 border border-brown/10 rounded-2xl px-6 py-4 outline-none focus:border-gold focus:ring-1 focus:ring-gold transition duration-300 font-medium">{{ old('bio', $user->bio) }}</textarea>
                </div>

                <div class="pt-4 flex justify-center">
                    <div class="flex flex-col items-center space-y-6">
                        <button type="submit"
                                class="px-12 py-4 bg-brown text-white rounded-full font-black uppercase text-xs tracking-[0.2em] hover:bg-gold transition-all duration-300 shadow-xl shadow-brown/20 hover:scale-105 active:scale-95">
                            Simpan Perubahan
                        </button>

                        <div class="flex items-center justify-center pt-6">
                            <a href="/orders" class="group flex flex-col items-center gap-2">
                                <div class="h-14 w-14 bg-cream border border-brown/10 rounded-2xl flex items-center justify-center shadow-lg group-hover:bg-gold group-hover:border-gold group-hover:text-white transition-all duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                </div>
                                <span class="text-[9px] font-black uppercase tracking-[0.2em] text-brown/60 group-hover:text-gold transition-colors">Riwayat Pesanan</span>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
