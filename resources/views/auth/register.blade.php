<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Bufet Coffee</title>
    
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
</head>
<body class="bg-cream font-sans text-brown">

    <div class="min-h-screen flex flex-col md:flex-row-reverse">
        
        <div class="hidden md:flex md:w-1/2 bg-brown relative overflow-hidden items-center justify-center">
            <img src="{{ asset('images/kopi2.jpeg') }}" alt="Coffee Roastery" class="absolute inset-0 w-full h-full object-cover opacity-40 blur-sm scale-110">
            <div class="relative z-10 text-center px-12">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-24 mx-auto mb-8 brightness-0 invert">
                <h2 class="text-4xl font-serif font-bold text-white mb-4 italic uppercase tracking-tighter">Bergabunglah</h2>
                <p class="text-cream/70 leading-relaxed font-light italic">"Menjadi bagian dari perjalanan rasa dari kebun Kubangsari ke cangkir Anda."</p>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center p-8 md:p-16 bg-white">
            <div class="max-w-md w-full">
                <div class="mb-10 text-center md:text-left">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 mb-6 md:hidden mx-auto">
                    <h1 class="text-4xl font-serif font-bold text-brown mb-2 uppercase tracking-tighter">Daftar Member</h1>
                    <p class="text-brown/50 text-sm font-medium uppercase tracking-widest">Buat akun untuk mulai memesan</p>
                </div>

                <form method="POST" action="/register" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] mb-2 text-brown/60">Nama Lengkap</label>
                        <input 
                            type="text" 
                            name="name"
                            placeholder="username"
                            value="{{ old('name') }}"
                            required
                            pattern="[A-Za-z\s]+"
                            title="Nama hanya boleh berisi huruf and spasi"
                            class="w-full px-6 py-4 bg-cream border-transparent focus:border-gold focus:bg-white focus:ring-0 rounded-2xl transition-all duration-300 text-sm font-medium outline-none"
                        >
                        @error('name')
                            <small class="text-red-500 text-[10px] font-bold mt-1 block uppercase">{{ $message }}</small>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] mb-2 text-brown/60">Email</label>
                        <input 
                            type="email" 
                            name="email"
                            placeholder="Contoh: nama@email.com"
                            value="{{ old('email') }}"
                            required
                            title="Masukkan email dengan format yang benar"
                            class="w-full px-6 py-4 bg-cream border-transparent focus:border-gold focus:bg-white focus:ring-0 rounded-2xl transition-all duration-300 text-sm font-medium outline-none"
                        >
                        @error('email')
                            <small class="text-red-500 text-[10px] font-bold mt-1 block uppercase">{{ $message }}</small>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] mb-2 text-brown/60">No Telepon</label>
                        <input 
                            type="text" 
                            name="phone"
                            placeholder="08xxxxxxxxxx"
                            value="{{ old('phone') }}"
                            required
                            pattern="[0-9]+"
                            title="Nomor telepon hanya boleh angka"
                            class="w-full px-6 py-4 bg-cream border-transparent focus:border-gold focus:bg-white focus:ring-0 rounded-2xl transition-all duration-300 text-sm font-medium outline-none"
                        >
                        @error('phone')
                            <small class="text-red-500 text-[10px] font-bold mt-1 block uppercase">{{ $message }}</small>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] mb-2 text-brown/60">Password</label>
                        <input 
                            type="password" 
                            name="password"
                            placeholder="Minimal 8 karakter"
                            required
                            minlength="8"
                            title="Password minimal 8 karakter"
                            class="w-full px-6 py-4 bg-cream border-transparent focus:border-gold focus:bg-white focus:ring-0 rounded-2xl transition-all duration-300 text-sm font-medium outline-none"
                        >
                        @error('password')
                            <small class="text-red-500 text-[10px] font-bold mt-1 block uppercase">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="w-full py-5 bg-brown text-white rounded-2xl font-black uppercase text-xs tracking-[0.3em] hover:bg-gold transition-all duration-500 shadow-xl shadow-brown/10 mt-4">
                        Daftar Akun
                    </button>
                </form>

                <p class="mt-8 text-center text-sm text-brown/60">
                    Sudah punya akun? 
                    <a href="/login" class="font-bold text-brown border-b-2 border-gold pb-0.5 hover:text-gold transition">Login di sini</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>
