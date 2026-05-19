<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Pariwisata')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-balente.png') }}" />
    <meta name="theme-color" content="#F4F7FE" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #F4F7FE; 
        }
        
        .card-shadow {
            box-shadow: 0px 10px 30px rgba(112, 144, 176, 0.05);
        }
        
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="min-h-screen text-slate-600 relative flex" x-data="{ sidebarOpen: false }">

    <!-- Overlay Sidebar Mobile -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 shrink-0 transform sidebar-bg shadow-xl transition-transform duration-300 lg:sticky lg:top-0 lg:h-screen lg:translate-x-0 flex flex-col border-r border-slate-100">
        
        <div class="px-6 py-8 flex items-center justify-between border-b border-slate-50">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-4 group">
                <div class="h-12 w-12 rounded-xl overflow-hidden bg-gradient-to-br from-amber-500 to-orange-600 p-0.5 shadow-lg shadow-amber-500/30">
                    <div class="h-full w-full rounded-[10px] bg-white flex items-center justify-center p-1">
                        <img src="{{ asset('images/logo-balente.png') }}" onerror="this.src='https://ui-avatars.com/api/?name=Balente&background=fff&color=d97706'" alt="Logo" class="h-full w-full object-cover" />
                    </div>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-slate-800">Balente</p>
                    <p class="text-xs text-amber-600 font-bold tracking-wider">WORKSPACE</p>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-slate-800 bg-slate-100 p-2 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <nav class="flex-1 space-y-1.5 px-4 pb-6 overflow-y-auto mt-6">
            <p class="px-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">General</p>
            
            <a href="{{ route('dashboard') }}" class="group relative flex items-center gap-3.5 rounded-xl px-4 py-3 transition-colors {{ request()->routeIs('dashboard') ? 'bg-amber-50 text-amber-700 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800 font-medium' }}">
                <span class="{{ request()->routeIs('dashboard') ? 'text-amber-600' : 'text-slate-400 group-hover:text-slate-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                </span>
                <span>Dashboard</span>
            </a>
            
            <p class="px-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2 mt-6">Manajemen Data</p>
            
            <a href="{{ route('kategori.index') }}" class="group relative flex items-center gap-3.5 rounded-xl px-4 py-3 transition-colors {{ request()->routeIs('kategori.*') ? 'bg-amber-50 text-amber-700 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800 font-medium' }}">
                <span class="{{ request()->routeIs('kategori.*') ? 'text-amber-500' : 'text-slate-400 group-hover:text-slate-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                </span>
                <span>Kategori Wisata</span>
            </a>
            
            <a href="{{ route('destinasi.index') }}" class="group relative flex items-center gap-3.5 rounded-xl px-4 py-3 transition-colors {{ request()->routeIs('destinasi.*') ? 'bg-sky-50 text-sky-700 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800 font-medium' }}">
                <span class="{{ request()->routeIs('destinasi.*') ? 'text-sky-500' : 'text-slate-400 group-hover:text-slate-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </span>
                <span>Data Destinasi</span>
            </a>
            
            <a href="{{ route('kuliner.index') }}" class="group relative flex items-center gap-3.5 rounded-xl px-4 py-3 transition-colors {{ request()->routeIs('kuliner.*') ? 'bg-rose-50 text-rose-700 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800 font-medium' }}">
                <span class="{{ request()->routeIs('kuliner.*') ? 'text-rose-500' : 'text-slate-400 group-hover:text-slate-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"></path></svg>
                </span>
                <span>Data Kuliner</span>
            </a>

            <p class="px-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2 mt-6">Sistem Cerdas</p>
            
            <a href="{{ route('riwayat.index') }}" class="group relative flex items-center gap-3.5 rounded-xl px-4 py-3 transition-colors {{ request()->routeIs('riwayat.*') ? 'bg-purple-50 text-purple-700 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800 font-medium' }}">
                <span class="{{ request()->routeIs('riwayat.*') ? 'text-purple-500' : 'text-slate-400 group-hover:text-slate-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </span>
                <span>Interaksi AI</span>
            </a>
            
            <a href="{{ route('bobot.index') }}" class="group relative flex items-center gap-3.5 rounded-xl px-4 py-3 transition-colors {{ request()->routeIs('bobot.*') ? 'bg-teal-50 text-teal-700 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800 font-medium' }}">
                <span class="{{ request()->routeIs('bobot.*') ? 'text-teal-500' : 'text-slate-400 group-hover:text-slate-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                </span>
                <span>Konfigurasi SPK</span>
            </a>
        </nav>
        
        <div class="p-5 border-t border-slate-50">
            <div class="rounded-2xl bg-amber-50 p-4 border border-amber-100 flex items-center gap-3">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                </span>
                <div>
                    <p class="text-sm font-bold text-amber-900">Sistem Online</p>
                    <p class="text-xs font-medium text-amber-700">All services running</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        <!-- Header Global -->
        <header class="header-bg sticky top-0 z-30 flex items-center justify-between px-6 py-4 lg:px-8 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-500 bg-white border border-slate-200 rounded-lg hover:bg-slate-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="hidden md:block">
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">@yield('page-title')</h1>
                </div>
            </div>
            
            <div class="flex items-center gap-4 lg:gap-6">
                <!-- Search -->
                <div class="relative hidden md:block w-64 lg:w-80">
                    <input type="text" placeholder="Search data..." class="w-full rounded-full border-0 bg-slate-100 px-5 py-2.5 pl-11 text-sm text-slate-700 outline-none focus:bg-white focus:ring-2 focus:ring-amber-500 transition-all shadow-sm" />
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                </div>

                <!-- Notifications -->
                <button class="relative p-2 text-slate-400 hover:text-amber-600 transition-colors">
                    <span class="absolute top-1.5 right-2 h-2 w-2 rounded-full bg-rose-500 border-2 border-white"></span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </button>

                <!-- Profile -->
                <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-bold text-slate-800">Admin User</p>
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Superadmin</p>
                    </div>
                        <img src="{{ asset('images/admin-avatar.png') }}" onerror="this.src='https://ui-avatars.com/api/?name=Admin&background=fff&color=d97706'" alt="Avatar" class="h-10 w-10 rounded-full object-cover">
                    <div class="h-10 w-10 rounded-full bg-amber-100 overflow-hidden border border-amber-200">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=fef3c7&color=d97706" alt="Admin">
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Workspace -->
        <main class="flex-1 p-6 lg:p-8 max-w-[1400px] w-full mx-auto relative z-0">
            <div class="mb-6 block md:hidden">
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">@yield('page-title')</h1>
                <p class="mt-1 text-sm text-slate-500">@yield('page-description')</p>
            </div>
            <div class="hidden md:block mb-8">
                <p class="text-sm font-medium text-slate-500">@yield('page-description')</p>
            </div>
            
            @yield('content')
        </main>
    </div>
</body>
</html>
