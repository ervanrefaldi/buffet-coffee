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

    <nav id="navbar" class="fixed w-full z-50 transition-all duration-500 py-6 bg-brown">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" id="nav-logo" class="h-12 w-auto brightness-0 invert transition-all duration-500">
            </a>
            
            <div class="hidden md:flex space-x-10 text-white font-medium" id="nav-links">
                <a href="{{ url('/') }}" class="hover:text-gold transition text-sm uppercase tracking-widest">Home</a>
                <a href="{{ url('/tentang') }}" class="hover:text-gold transition text-sm uppercase tracking-widest">Tentang</a>
                <a href="{{ url('/produk') }}" class="hover:text-gold transition text-sm uppercase tracking-widest">Menu</a>
                <a href="{{ url('/event') }}" class="hover:text-gold transition text-sm uppercase tracking-widest">Event</a>
                <a href="{{ url('/membership') }}" class="text-gold border-b-2 border-gold pb-1 text-sm uppercase tracking-widest">Membership</a>
            </div>

            <div class="flex items-center">
                <a href="{{ url('/') }}" class="bg-gold text-white px-8 py-2.5 rounded-full font-bold hover:bg-white hover:text-brown transition duration-300 shadow-lg text-xs uppercase tracking-widest">
                    ← Kembali
                </a>
            </div>
        </div>
    </nav>

    <div class="min-h-screen flex items-center justify-center pt-24">
        <div class="max-w-4xl w-full px-6">
            <div class="text-center mb-12">
                <h1 class="text-5xl font-serif font-bold text-brown mb-4 uppercase tracking-tighter">Membership</h1>
                <p class="text-gold font-bold tracking-[0.4em] text-xs uppercase">Bergabunglah dengan Program Membership Kami</p>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-2xl p-8 md:p-12 border border-brown/5 mb-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-serif font-bold text-brown mb-4">Regulasi Membership</h2>
                    <div class="h-1 w-20 bg-gold mx-auto mb-6"></div>
                </div>

                <div class="space-y-6 mb-8">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-8 h-8 bg-gold rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm">1</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-brown mb-2">Minimal Pemesanan</h3>
                            <p class="text-brown/70 leading-relaxed">Untuk menjadi member, Anda harus melakukan pemesanan minimal <strong class="text-gold">100kg kopi</strong> dalam satu kali transaksi.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-8 h-8 bg-gold rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm">2</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-brown mb-2">Benefit Member</h3>
                            <p class="text-brown/70 leading-relaxed">Sebagai member, Anda akan mendapatkan <strong class="text-gold">diskon khusus</strong> pada setiap pembelian kopi di Bufet Coffee Roastery.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-cream/50 rounded-2xl p-6 border border-brown/10">
                    <h3 class="text-lg font-bold text-brown mb-4 text-center">Keuntungan Bergabung Membership</h3>
                    <ul class="space-y-3 text-brown/80">
                        <li class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-gold rounded-full"></span>
                            <span>Diskon hingga 15% pada setiap pembelian</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-gold rounded-full"></span>
                            <span>Prioritas pengiriman dan layanan</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-gold rounded-full"></span>
                            <span>Akses ke produk eksklusif member</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-gold rounded-full"></span>
                            <span>Informasi promo dan event terbaru</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ url('/produk') }}" class="inline-block bg-brown text-white px-12 py-4 rounded-full font-black uppercase text-xs tracking-[0.3em] hover:bg-gold transition-all duration-300 shadow-xl shadow-brown/20 hover:scale-105 active:scale-95">
                    Pesan Sekarang
                </a>
            </div>
        </div>
    </div>
</body>
</html>