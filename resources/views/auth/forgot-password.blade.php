<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Bufet Coffee</title>

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

    <div class="min-h-screen flex flex-col md:flex-row">

        <div class="hidden md:flex md:w-1/2 bg-brown relative overflow-hidden items-center justify-center">
            <img src="{{ asset('images/kopi1.jpeg') }}" alt="Coffee" class="absolute inset-0 w-full h-full object-cover opacity-40 blur-sm scale-110">
            <div class="relative z-10 text-center px-12">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-24 mx-auto mb-8 brightness-0 invert">
                <h2 class="text-4xl font-serif font-bold text-white mb-4 italic uppercase tracking-tighter">Lupa Password</h2>
                <p class="text-cream/70 leading-relaxed font-light">Masukkan email Anda untuk menerima kode reset password.</p>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center p-8 md:p-16 bg-white">
            <div class="max-w-md w-full">
                <div class="mb-10 text-center md:text-left">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 mb-6 md:hidden mx-auto">
                    <h1 class="text-4xl font-serif font-bold text-brown mb-2 uppercase tracking-tighter">Lupa Password</h1>
                    <p class="text-brown/50 text-sm font-medium uppercase tracking-widest">Masukkan email Anda</p>
                </div>

                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-xl">
                        <p class="text-green-700 text-xs font-bold">{{ session('success') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-xl">
                        <p class="text-red-700 text-xs font-bold">{{ $errors->first() }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('send-code') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] mb-2 text-brown/60">Alamat Email</label>
                        <input
                            type="email"
                            name="email"
                            placeholder="nama@email.com"
                            required
                            value="{{ old('email') }}"
                            class="w-full px-6 py-4 bg-cream border-transparent focus:border-gold focus:bg-white focus:ring-0 rounded-2xl transition-all duration-300 text-sm font-medium outline-none"
                        >
                    </div>

                    <button type="submit" class="w-full py-5 bg-brown text-white rounded-2xl font-black uppercase text-xs tracking-[0.3em] hover:bg-gold transition-all duration-500 shadow-xl shadow-brown/10 mt-4">
                        Kirim Kode
                    </button>
                </form>

                <p class="mt-10 text-center text-sm text-brown/60">
                    <a href="/login" class="font-bold text-brown border-b-2 border-gold pb-0.5 hover:text-gold transition">Kembali ke Login</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>