@php
    $cartCount = 0;
    if(session()->has('user_id')) {
        $cartCount = \App\Models\Cart::where('user_id', session('user_id'))->sum('quantity');
    }
@endphp

@php
    $navTextClass = isset($navDark) && $navDark ? 'text-brown' : 'text-white';
    $navLogoClass = isset($navDark) && $navDark ? '' : 'brightness-0 invert';
@endphp

<nav id="navbar" class="fixed w-full z-50 transition-all duration-500 py-6 {{ isset($navDark) && $navDark ? 'bg-white/50 backdrop-blur-md border-b border-brown/5' : '' }}">
    <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
        <a href="{{ url('/#hero') }}" class="flex items-center">
            <img src="{{ asset('images/logo.png') }}" id="nav-logo" class="h-12 w-auto {{ $navLogoClass }} transition-all duration-500">
        </a>
        
        <div class="hidden md:flex space-x-10 {{ $navTextClass }} font-medium items-center transition-colors duration-500" id="nav-links">
            <a href="{{ url('/') }}" class="hover:text-gold transition text-sm uppercase tracking-widest {{ Request::is('/') ? 'text-gold border-b-2 border-gold pb-1' : '' }}">Home</a>
            <a href="{{ url('/tentang') }}" class="hover:text-gold transition text-sm uppercase tracking-widest {{ Request::is('tentang') ? 'text-gold border-b-2 border-gold pb-1' : '' }}">About</a>
            <a href="{{ url('/menu') }}" class="hover:text-gold transition text-sm uppercase tracking-widest {{ Request::is('menu*') ? 'text-gold border-b-2 border-gold pb-1' : '' }}">Menu</a>
            <a href="{{ url('/event') }}" class="hover:text-gold transition text-sm uppercase tracking-widest {{ Request::is('event') ? 'text-gold border-b-2 border-gold pb-1' : '' }}">Event</a>
            <a href="{{ url('/membership') }}" class="hover:text-gold transition text-sm uppercase tracking-widest {{ Request::is('membership') ? 'text-gold border-b-2 border-gold pb-1' : '' }}">Membership</a>
        </div>

        <div class="flex items-center gap-6">
            @if(session()->has('user_id'))
                <!-- Cart Icon -->
                <a href="{{ url('/cart') }}" class="relative group p-2 text-white transition-colors" id="nav-cart-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:text-gold transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    @if($cartCount > 0)
                        <span id="cart-badge" class="absolute -top-1 -right-1 bg-gold text-white text-[10px] font-black w-5 h-5 flex items-center justify-center rounded-full shadow-lg border-2 border-brown animate-pulse">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <!-- Profile Link -->
                <a href="{{ url('/profile') }}" class="flex items-center gap-3 group">
                    <div class="text-right hidden md:block">
                        <p class="text-[10px] font-black uppercase tracking-widest text-white/40 group-hover:text-gold transition mb-0.5" id="nav-profile-name">
                            {{ session('user_name') }}
                        </p>
                        <p class="text-[8px] font-bold uppercase tracking-[0.2em] text-gold" id="nav-profile-role">
                            {{ session('user_role') }}
                        </p>
                    </div>
                    <div class="p-2 bg-white/5 rounded-full border border-white/10 group-hover:border-gold transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white group-hover:text-gold transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </a>
            @else
                <a href="{{ url('/login') }}" class="bg-gold text-white px-8 py-2.5 rounded-full font-bold hover:bg-white hover:text-brown transition duration-300 shadow-lg text-xs uppercase tracking-widest">
                    Login
                </a>
            @endif

            <!-- Mobile Menu Toggle (Simplified) -->
            <button class="md:hidden text-white" id="mobile-menu-toggle">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
    </div>
</nav>

<script>
    window.addEventListener('scroll', function() {
        const nav = document.getElementById('navbar');
        const logo = document.getElementById('nav-logo');
        const links = document.getElementById('nav-links');
        const profileName = document.getElementById('nav-profile-name');
        const cartBtn = document.getElementById('nav-cart-btn');
        const mobileToggle = document.getElementById('mobile-menu-toggle');
        
        if (window.pageYOffset > 50) {
            nav.classList.add('bg-white/90', 'backdrop-blur-xl', 'shadow-2xl', 'py-4', 'border-b', 'border-brown/5');
            nav.classList.remove('py-6');
            logo.classList.remove('brightness-0', 'invert');
            if(links) {
                links.classList.remove('text-white');
                links.classList.add('text-brown');
            }
            if(profileName) {
                profileName.classList.remove('text-white/40');
                profileName.classList.add('text-brown/40');
            }
            if(cartBtn) {
                cartBtn.classList.remove('text-white');
                cartBtn.classList.add('text-brown');
            }
            if(mobileToggle) {
                mobileToggle.classList.remove('text-white');
                mobileToggle.classList.add('text-brown');
            }
        } else {
            nav.classList.remove('bg-white/90', 'backdrop-blur-xl', 'shadow-2xl', 'py-4', 'border-b', 'border-brown/5');
            nav.classList.add('py-6');
            
            @if(isset($navDark) && $navDark)
                // Maintain dark state if navDark is true
                logo.classList.remove('brightness-0', 'invert');
                if(links) {
                    links.classList.remove('text-white');
                    links.classList.add('text-brown');
                }
            @else
                logo.classList.add('brightness-0', 'invert');
                if(links) {
                    links.classList.add('text-white');
                    links.classList.remove('text-brown');
                }
                if(profileName) {
                    profileName.classList.add('text-white/40');
                    profileName.classList.remove('text-brown/40');
                }
                if(cartBtn) {
                    cartBtn.classList.add('text-white');
                    cartBtn.classList.remove('text-brown');
                }
                if(mobileToggle) {
                    mobileToggle.classList.add('text-white');
                    mobileToggle.classList.remove('text-brown');
                }
            @endif
        }
    });
</script>
