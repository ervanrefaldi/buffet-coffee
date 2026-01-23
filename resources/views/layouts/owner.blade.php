<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard - Bufet Coffee</title>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col">
        <div class="h-16 flex items-center px-6 border-b border-gray-200">
            <span class="text-xl font-bold text-amber-700 tracking-wider">BUFET <span class="text-gray-600">OWNER</span></span>
        </div>

        <nav class="flex-1 overflow-y-auto py-4">
            <ul class="space-y-1 px-3">
                <li>
                    <a href="/owner/dashboard" class="flex items-center px-3 py-2.5 {{ request()->is('owner/dashboard') ? 'bg-amber-50 text-amber-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="/owner/event" class="flex items-center px-3 py-2.5 {{ request()->is('owner/event*') ? 'bg-amber-50 text-amber-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Kelola Event
                    </a>
                </li>
                <li>
                    <a href="/owner/menu" class="flex items-center px-3 py-2.5 {{ request()->is('owner/menu*') ? 'bg-amber-50 text-amber-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Kelola Menu
                    </a>
                </li>
                <li>
                    <a href="/owner/orders" class="flex items-center px-3 py-2.5 {{ request()->is('owner/orders*') ? 'bg-amber-50 text-amber-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Kelola Pemesanan
                    </a>
                </li>
                <li>
                    <a href="/owner/transactions" class="flex items-center px-3 py-2.5 {{ request()->is('owner/transactions*') ? 'bg-amber-50 text-amber-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        Kelola Transaksi
                    </a>
                </li>
                <li>
                    <a href="/owner/laporan" class="flex items-center px-3 py-2.5 {{ request()->is('owner/laporan*') ? 'bg-amber-50 text-amber-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Laporan
                    </a>
                </li>
                @if(session('user_email') === 'owner@bufet.com')
                <li>
                    <a href="/owner/admin" class="flex items-center px-3 py-2.5 {{ request()->is('owner/admin*') ? 'bg-amber-50 text-amber-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Kelola Akun Owner
                    </a>
                </li>
                @endif
            </ul>
        </nav>

        <div class="p-4 border-t border-gray-200">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="flex items-center w-full px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Content -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50">
        <!-- Header Mobile (only visible on small screens) -->
        <header class="md:hidden h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4">
            <span class="font-bold text-lg text-amber-700">BUFET OWNER</span>
            <button class="text-gray-600 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </header>

        <!-- Main Content Area -->
        <div class="flex-1 overflow-auto p-6 md:p-8">
            <header class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">@yield('title', 'Dashboard')</h1>
                    <p class="text-gray-500 text-sm mt-1">@yield('subtitle', 'Selamat datang di panel admin.')</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <div class="text-sm font-medium text-gray-900">{{ session('user_name') }}</div>
                        <div class="text-xs text-gray-500 capitalize">{{ session('user_role') }}</div>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 font-bold">
                        {{ substr(session('user_name', 'O'), 0, 1) }}
                    </div>
                </div>
            </header>

            @include('partials.flash_message')

            @yield('content')
        </div>
    </main>
</div>

    @yield('scripts')
</body>
</html>
