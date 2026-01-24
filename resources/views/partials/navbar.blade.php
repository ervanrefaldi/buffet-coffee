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

            <!-- Mobile Menu Toggle -->
            <button class="md:hidden text-white relative z-50 transition-colors duration-300 focus:outline-none" id="mobile-menu-toggle">
                <svg id="menu-icon-open" class="w-8 h-8 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg id="menu-icon-close" class="w-8 h-8 hidden drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu Container -->
    <div id="mobile-menu-container" class="fixed inset-0 z-40 hidden md:hidden">
        <!-- Overlay (Click to close) -->
        <div id="mobile-menu-overlay" class="absolute inset-0 bg-black/60 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
        
        <!-- Sidebar Panel -->
        <div id="mobile-menu-panel" class="absolute top-0 right-0 w-72 h-full bg-[#4A3427] shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
            <!-- Decorative Pattern -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-[#C5A358]/10 rounded-full blur-3xl -mr-10 -mt-10 pointer-events-none"></div>

            <div class="p-8 flex flex-col h-full relative z-10">
                <!-- Header inside Menu -->
                <div class="flex items-center justify-between mb-12">
                     <span class="text-white font-serif font-bold text-xl tracking-wider">MENU</span>
                     <!-- Close button is handled by the toggle outside, but we can add one here if needed, 
                          but typically the toggle button z-index is high enough. 
                          However, for this design, the toggle button is in the navbar. 
                          Let's ensure the toggle button changes color or we add a close button here.
                     -->
                </div>

                <!-- Links -->
                <div class="flex flex-col space-y-6">
                    <a href="{{ url('/') }}" class="mobile-link text-xl font-serif font-bold text-white/80 hover:text-[#C5A358] hover:pl-2 transition-all duration-300 border-b border-white/5 pb-4">Home</a>
                    <a href="{{ url('/tentang') }}" class="mobile-link text-xl font-serif font-bold text-white/80 hover:text-[#C5A358] hover:pl-2 transition-all duration-300 border-b border-white/5 pb-4">About</a>
                    <a href="{{ url('/menu') }}" class="mobile-link text-xl font-serif font-bold text-white/80 hover:text-[#C5A358] hover:pl-2 transition-all duration-300 border-b border-white/5 pb-4">Menu</a>
                    <a href="{{ url('/event') }}" class="mobile-link text-xl font-serif font-bold text-white/80 hover:text-[#C5A358] hover:pl-2 transition-all duration-300 border-b border-white/5 pb-4">Event</a>
                    <a href="{{ url('/membership') }}" class="mobile-link text-xl font-serif font-bold text-white/80 hover:text-[#C5A358] hover:pl-2 transition-all duration-300 border-b border-white/5 pb-4">Membership</a>
                </div>

                <!-- Auth / Profile -->
                <div class="mt-auto pt-8">
                    @if(!session()->has('user_id'))
                        <a href="{{ url('/login') }}" class="block w-full text-center bg-[#C5A358] text-white py-3 rounded-full font-bold uppercase tracking-widest text-xs hover:bg-white hover:text-[#4A3427] transition-all shadow-lg">
                            Login
                        </a>
                    @else
                        <div class="flex items-center gap-4 p-4 bg-white/5 rounded-2xl border border-white/10">
                            <div class="w-10 h-10 rounded-full bg-[#C5A358] flex items-center justify-center text-white font-bold">
                                {{ substr(session('user_name'), 0, 1) }}
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-white text-sm font-bold truncate">{{ session('user_name') }}</p>
                                <a href="{{ url('/profile') }}" class="text-[#C5A358] text-[10px] uppercase font-bold tracking-widest hover:text-white transition-colors">View Profile</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const nav = document.getElementById('navbar');
        const logo = document.getElementById('nav-logo');
        const links = document.getElementById('nav-links');
        const profileName = document.getElementById('nav-profile-name');
        const cartBtn = document.getElementById('nav-cart-btn');
        
        // Mobile Menu Elements
        const mobileToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenuContainer = document.getElementById('mobile-menu-container');
        const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
        const mobileMenuPanel = document.getElementById('mobile-menu-panel');
        const menuIconOpen = document.getElementById('menu-icon-open');
        const menuIconClose = document.getElementById('menu-icon-close');
        
        let isMenuOpen = false;

        function toggleMenu() {
            isMenuOpen = !isMenuOpen;
            
            if (isMenuOpen) {
                // Open Menu
                mobileMenuContainer.classList.remove('hidden');
                
                // Animate In
                setTimeout(() => {
                    mobileMenuOverlay.classList.remove('opacity-0');
                    mobileMenuPanel.classList.remove('translate-x-full');
                }, 10);

                // Icon State
                menuIconOpen.classList.add('hidden');
                menuIconClose.classList.remove('hidden');
                
                // Button Color (Always white when open on dark bg)
                mobileToggle.classList.remove('text-[#4A3427]'); // remove brown
                mobileToggle.classList.add('text-white');
                
                document.body.style.overflow = 'hidden';
            } else {
                // Close Menu
                mobileMenuOverlay.classList.add('opacity-0');
                mobileMenuPanel.classList.add('translate-x-full');
                
                // Wait for animation
                setTimeout(() => {
                    mobileMenuContainer.classList.add('hidden');
                }, 300);

                // Icon State
                menuIconOpen.classList.remove('hidden');
                menuIconClose.classList.add('hidden');
                
                document.body.style.overflow = '';
                
                // Restore Button Color based on scroll
                checkScroll();
            }
        }

        mobileToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleMenu();
        });

        mobileMenuOverlay.addEventListener('click', () => {
            toggleMenu();
        });

        // Close when clicking a link
        document.querySelectorAll('.mobile-link').forEach(link => {
            link.addEventListener('click', () => {
                if(isMenuOpen) toggleMenu();
            });
        });

        // Scroll Effect
        function checkScroll() {
            if (window.pageYOffset > 50) {
                nav.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-lg', 'py-4');
                nav.classList.remove('py-6');
                logo.classList.remove('brightness-0', 'invert');
                
                if(links) {
                    links.classList.remove('text-white');
                    links.classList.add('text-[#4A3427]');
                }
                if(profileName) {
                    profileName.classList.remove('text-white/40');
                    profileName.classList.add('text-[#4A3427]/40');
                }
                if(cartBtn) {
                    cartBtn.classList.remove('text-white');
                    cartBtn.classList.add('text-[#4A3427]');
                }
                
                // Toggle Button Color (only if menu is CLOSED)
                if (mobileToggle && !isMenuOpen) {
                    mobileToggle.classList.remove('text-white');
                    mobileToggle.classList.add('text-[#4A3427]');
                    // If using drop-shadow on white bg, maybe reduce it or keep it
                }

            } else {
                nav.classList.remove('bg-white/95', 'backdrop-blur-md', 'shadow-lg', 'py-4');
                nav.classList.add('py-6');
                
                @if(isset($navDark) && $navDark)
                    // Page forces dark mode (like About Us)
                    logo.classList.remove('brightness-0', 'invert');
                    // Ensure text is brown/dark
                    if(links) { links.classList.remove('text-white'); links.classList.add('text-[#4A3427]'); }
                     if (mobileToggle && !isMenuOpen) {
                        mobileToggle.classList.remove('text-white');
                        mobileToggle.classList.add('text-[#4A3427]');
                    }
                @else
                    // Transparent/Hero mode
                    logo.classList.add('brightness-0', 'invert');
                    if(links) { links.classList.add('text-white'); links.classList.remove('text-[#4A3427]'); }
                    if(profileName) { profileName.classList.add('text-white/40'); profileName.classList.remove('text-[#4A3427]/40'); }
                    if(cartBtn) { cartBtn.classList.add('text-white'); cartBtn.classList.remove('text-[#4A3427]'); }
                    
                    if (mobileToggle && !isMenuOpen) {
                        mobileToggle.classList.add('text-white');
                        mobileToggle.classList.remove('text-[#4A3427]');
                    }
                @endif
            }
        }

        window.addEventListener('scroll', checkScroll);
        // Initial check
        checkScroll();
    });
</script>
