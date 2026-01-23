@if ($message = Session::get('success'))
<div class="fixed top-24 right-5 z-[60] animate-fade-in-down" id="flash-message">
    <div class="bg-white border-l-4 border-gold shadow-2xl rounded-lg p-4 flex items-center pr-10 relative overflow-hidden backdrop-blur-md bg-opacity-95">
        <div class="text-gold mr-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="font-bold text-brown text-sm uppercase tracking-wider">Berhasil</p>
            <p class="text-brown/70 text-xs">{{ $message }}</p>
        </div>
        {{-- Close Button --}}
        <button onclick="document.getElementById('flash-message').remove()" class="absolute top-2 right-2 text-brown/30 hover:text-brown transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        {{-- Progress Bar Animation --}}
        <div class="absolute bottom-0 left-0 h-1 bg-gold animate-progress-bar w-full"></div>
    </div>
</div>

<style>
    @keyframes fadeInDown {
        0% { opacity: 0; transform: translateY(-20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down {
        animation: fadeInDown 0.5s ease-out forwards;
    }
    @keyframes progressBar {
        0% { width: 100%; }
        100% { width: 0%; }
    }
    .animate-progress-bar {
        animation: progressBar 3s linear forwards;
    }
</style>

<script>
    // Auto remove after 3 seconds matching the progress bar
    setTimeout(function() {
        const flash = document.getElementById('flash-message');
        if(flash) {
            flash.style.transition = 'all 0.5s ease';
            flash.style.opacity = '0';
            flash.style.transform = 'translateY(-20px)';
            setTimeout(() => flash.remove(), 500);
        }
    }, 3000);
</script>
@endif

@if ($message = Session::get('error'))
<div class="fixed top-24 right-5 z-[60] animate-fade-in-down" id="flash-error">
    <div class="bg-white border-l-4 border-red-500 shadow-2xl rounded-lg p-4 flex items-center pr-10 relative overflow-hidden backdrop-blur-md bg-opacity-95">
        <div class="text-red-500 mr-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="font-bold text-red-800 text-sm uppercase tracking-wider">Error</p>
            <p class="text-red-600/70 text-xs">{{ $message }}</p>
        </div>
        <button onclick="document.getElementById('flash-error').remove()" class="absolute top-2 right-2 text-red-300 hover:text-red-500 transition">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
@endif
