<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <title>{{ config('app.name', 'Cutietyha POS') }} - @yield('title', 'Dashboard')</title>

           <!-- Favicon -->
           @php
               $logoPath = public_path('build/assets/logo.png');
               $logoExists = file_exists($logoPath);
           @endphp
           @if($logoExists)
               <link rel="icon" type="image/png" href="{{ asset('build/assets/logo.png') }}">
               <link rel="shortcut icon" type="image/png" href="{{ asset('build/assets/logo.png') }}">
           @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-blue-50/20 to-slate-50" style="font-family: 'Inter', sans-serif;">
    <div class="min-h-screen flex">
        <!-- Mobile Menu Overlay -->
        @auth
        <div id="mobile-menu-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden hidden transition-opacity duration-300" style="touch-action: manipulation;"></div>
        
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-[280px] sm:w-72 lg:w-72 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white h-screen shadow-2xl border-r border-slate-700/50 backdrop-blur-xl relative overflow-hidden transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out" style="touch-action: pan-y;">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-husk/5 via-brand-teak/5 to-brand-indian-khaki/5 pointer-events-none"></div>
            <div class="relative z-10 h-full flex flex-col">
            <!-- Mobile Close Button -->
            <button id="mobile-menu-close" onclick="toggleMobileMenu(event); return false;" class="lg:hidden absolute top-3 right-3 sm:top-4 sm:right-4 p-2 text-slate-400 hover:text-white active:text-white hover:bg-slate-800 active:bg-slate-700 rounded-lg transition-all touch-manipulation z-20 min-w-[44px] min-h-[44px] flex items-center justify-center cursor-pointer" type="button" aria-label="Close menu" style="cursor: pointer;">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <div class="p-4 sm:p-6 border-b border-slate-700/50">
                <div class="flex items-center space-x-2 sm:space-x-3 mb-3 sm:mb-4">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg flex-shrink-0 overflow-hidden bg-white/10 border border-white/10">
                        @php
                            $logoPath = public_path('build/assets/logo.png');
                            $logoExists = file_exists($logoPath);
                        @endphp
                        @if($logoExists)
                            <img src="{{ asset('build/assets/logo.png') }}" alt="Cutietyha POS" class="w-full h-full object-contain p-1">
                        @else
                            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-base sm:text-xl font-bold bg-gradient-to-r from-brand-husk via-brand-teak to-brand-indian-khaki bg-clip-text text-transparent truncate">Cutietyha POS</h1>
                        <p class="text-[10px] sm:text-xs text-slate-400 truncate">Point of Sale</p>
                    </div>
                </div>
                @if(auth()->user()->branch)
                    <div class="flex items-center space-x-2 px-2 sm:px-3 py-1.5 sm:py-2 bg-slate-800/50 rounded-lg border border-slate-700/50">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-xs sm:text-sm text-slate-300 font-medium truncate">{{ auth()->user()->branch->name }}</span>
                    </div>
                @endif
                <!-- Mobile Logout Button - Higher up on mobile -->
                <div class="lg:hidden px-2 sm:px-3 py-3 sm:py-4 border-t border-slate-700/50">
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center space-x-2 px-4 py-2.5 sm:py-3 text-white bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 rounded-lg transition-all duration-300 touch-manipulation shadow-md hover:shadow-lg min-h-[44px]" title="Logout">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="text-sm font-semibold">Logout</span>
                        </button>
                    </form>
                </div>
                <div class="hidden lg:block mt-4">
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center space-x-2 px-4 py-2.5 sm:py-3 text-white bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 rounded-lg transition-all duration-300 touch-manipulation shadow-md hover:shadow-lg min-h-[44px]" title="Logout">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="text-sm font-semibold">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
            <nav class="mt-6 px-2 sm:px-3 space-y-1.5 sm:space-y-2 overflow-y-auto flex-1">
                @if(auth()->user()->hasRole('super_admin'))
                    <a href="{{ route('dashboard.super-admin') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl transition-all duration-300 text-sm sm:text-base {{ request()->routeIs('dashboard.super-admin') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white hover:scale-[1.01] hover:shadow-md' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard.super-admin') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('businesses.index') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl transition-all duration-300 text-sm sm:text-base {{ request()->routeIs('businesses.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white hover:scale-[1.01] hover:shadow-md' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('businesses.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span class="font-medium">Businesses</span>
                    </a>
                    <a href="{{ route('branches.index') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl transition-all duration-300 text-sm sm:text-base {{ request()->routeIs('branches.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white hover:scale-[1.01] hover:shadow-md' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('branches.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-medium">Branches</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('admin.users') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.users') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="font-medium">Users</span>
                    </a>
                    <a href="{{ route('admin.roles.index') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white hover:scale-[1.01] hover:shadow-md' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span class="font-medium">Roles & Permissions</span>
                    </a>
                    <a href="{{ route('settings.index') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('settings.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white hover:scale-[1.01] hover:shadow-md' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('settings.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-medium">Settings</span>
                    </a>
                @elseif(auth()->user()->hasRole('admin'))
                    <a href="{{ route('dashboard.admin') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('dashboard.admin') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard.admin') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('pos.index') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('pos.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('pos.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span class="font-medium">POS Terminal</span>
                    </a>
                    <a href="{{ route('admin.products') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('admin.products') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.products') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span class="font-medium">Products</span>
                    </a>
                    <a href="{{ route('customers.index') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('customers.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('customers.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="font-medium">Customers</span>
                    </a>
                    <a href="{{ route('inventory.index') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('inventory.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('inventory.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span class="font-medium">Inventory</span>
                    </a>
                    <a href="{{ route('orders.index') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('orders.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('orders.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="font-medium">Orders</span>
                    </a>
                    <a href="{{ route('accounting.expenses') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('accounting.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('accounting.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-medium">Accounting</span>
                    </a>
                    <a href="{{ route('reports.sales') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('reports.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white hover:scale-[1.01] hover:shadow-md' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('reports.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="font-medium">Reports</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('admin.users') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white hover:scale-[1.01] hover:shadow-md' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.users') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="font-medium">Users</span>
                    </a>
                    <a href="{{ route('admin.roles.index') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white hover:scale-[1.01] hover:shadow-md' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span class="font-medium">Roles & Permissions</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('admin.categories.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white hover:scale-[1.01] hover:shadow-md' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.categories.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <span class="font-medium">Categories</span>
                    </a>
                    <a href="{{ route('attendance.index') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('attendance.*') || request()->routeIs('shifts.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white hover:scale-[1.01] hover:shadow-md' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('attendance.*') || request()->routeIs('shifts.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">Attendance</span>
                    </a>
                    <a href="{{ route('settings.index') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('settings.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white hover:scale-[1.01] hover:shadow-md' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('settings.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-medium">Settings</span>
                    </a>
                @elseif(auth()->user()->hasRole('sales'))
                    <a href="{{ route('dashboard.sales') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('dashboard.sales') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard.sales') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('pos.index') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('pos.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('pos.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span class="font-medium">POS Terminal</span>
                    </a>
                    <a href="{{ route('customers.index') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('customers.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('customers.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="font-medium">Customers</span>
                    </a>
                    <a href="{{ route('attendance.index') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('attendance.*') || request()->routeIs('shifts.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white hover:scale-[1.01] hover:shadow-md' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('attendance.*') || request()->routeIs('shifts.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">Attendance</span>
                    </a>
                    <a href="{{ route('settings.index') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('settings.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white hover:scale-[1.01] hover:shadow-md' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('settings.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-medium">Settings</span>
                    </a>
                @elseif(auth()->user()->hasRole('accounting'))
                    <a href="{{ route('dashboard.accounting') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('dashboard.accounting') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard.accounting') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('accounting.expenses') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('accounting.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('accounting.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-medium">Expenses</span>
                    </a>
                    <a href="{{ route('reports.sales') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('reports.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white hover:scale-[1.01] hover:shadow-md' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('reports.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="font-medium">Reports</span>
                    </a>
                    <a href="{{ route('exports.index') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('exports.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white hover:scale-[1.01] hover:shadow-md' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('exports.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="font-medium">Exports</span>
                    </a>
                    <a href="{{ route('settings.index') }}" class="group flex items-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 {{ request()->routeIs('settings.*') ? 'bg-gradient-to-r from-brand-husk to-brand-teak text-white shadow-lg shadow-brand-husk/30 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white hover:scale-[1.01] hover:shadow-md' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('settings.*') ? '' : 'group-hover:text-brand-husk' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-medium">Settings</span>
                    </a>
                @endif
            </nav>
            <!-- Desktop User Info - kept at bottom; logout is above to ensure visibility -->
            <!-- Mobile logout moved to top of sidebar -->
            <!-- Desktop User Info & Logout - Bottom on desktop -->
            <div class="hidden lg:flex mt-auto p-3 sm:p-4 border-t border-slate-700/50 bg-slate-900/50 backdrop-blur-sm">
                <div class="flex items-center justify-between gap-2 sm:gap-3 w-full">
                    <div class="flex items-center space-x-2 sm:space-x-3 min-w-0 flex-1">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-brand-husk to-brand-teak rounded-lg sm:rounded-xl flex items-center justify-center text-white font-bold shadow-lg flex-shrink-0 text-sm sm:text-base">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs sm:text-sm font-semibold text-white truncate">{{ auth()->user()->display_name ?? auth()->user()->name }}</p>
                            <p class="text-[10px] sm:text-xs text-slate-400 truncate">{{ auth()->user()->roles->first()->name ?? 'User' }}</p>
                        </div>
                    </div>
                    <!-- Desktop logout (restored) -->
                    <div class="ml-3 flex-shrink-0">
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="flex items-center justify-center space-x-2 px-3 py-2 text-white bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 rounded-lg transition-all duration-300 touch-manipulation shadow-sm hover:shadow-md" title="Logout">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span class="text-sm font-medium">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>
        @endauth

        <!-- Main Content -->
        <main class="flex-1 bg-gradient-to-br from-slate-50 via-white to-slate-50 min-h-screen w-full lg:w-auto overflow-x-hidden">
            <!-- Mobile Header -->
            @auth
            <div class="lg:hidden sticky top-0 z-50 bg-white/95 backdrop-blur-lg border-b border-slate-200 shadow-sm px-3 sm:px-4 py-2.5 sm:py-3 flex items-center justify-between">
                <button id="mobile-menu-toggle" onclick="toggleMobileMenu(event); return false;" class="p-2 text-slate-700 hover:bg-slate-100 active:bg-slate-200 rounded-lg transition-all touch-manipulation min-w-[44px] min-h-[44px] flex items-center justify-center relative z-50 cursor-pointer" type="button" aria-label="Toggle menu" style="cursor: pointer;">
                    <svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h1 class="text-base sm:text-lg font-bold bg-gradient-to-r from-brand-husk via-brand-teak to-brand-indian-khaki bg-clip-text text-transparent flex-1 text-center px-2">Cutietyha POS</h1>
                <div class="w-10 min-w-[44px]"></div>
            </div>
            @endauth
            @if(session('success'))
                <div class="fixed top-16 lg:top-4 left-4 right-4 lg:left-auto lg:right-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 py-3 lg:px-6 lg:py-4 rounded-xl shadow-2xl shadow-green-500/25 z-50 flex items-center space-x-3 animate-slide-in border border-green-400/20 backdrop-blur-sm max-w-sm lg:max-w-md mx-auto lg:mx-0" role="alert">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="font-medium text-sm lg:text-base">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="fixed top-16 lg:top-4 left-4 right-4 lg:left-auto lg:right-4 bg-gradient-to-r from-red-500 to-rose-600 text-white px-4 py-3 lg:px-6 lg:py-4 rounded-xl shadow-2xl shadow-red-500/25 z-50 flex items-center space-x-3 animate-slide-in border border-red-400/20 backdrop-blur-sm max-w-sm lg:max-w-md mx-auto lg:mx-0" role="alert">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <span class="font-medium text-sm lg:text-base">{{ session('error') }}</span>
                </div>
            @endif

            <div class="p-3 sm:p-4 lg:p-6 xl:p-8">
                @yield('content')
            </div>
        </main>
    </div>
    
    <script>
        // Simple, direct toggle function - available immediately
        function toggleMobileMenu(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-menu-overlay');
            
            if (!sidebar || !overlay) {
                console.error('Menu elements not found:', {
                    sidebar: !!sidebar,
                    overlay: !!overlay
                });
                alert('Menu elements not found. Please refresh the page.');
                return false;
            }
            
            // Simple check: if sidebar has -translate-x-full class, it's hidden
            const isHidden = sidebar.classList.contains('-translate-x-full');
            
            console.log('🔄 Toggling menu. Currently hidden:', isHidden);
            
            if (isHidden) {
                // SHOW MENU - Remove hidden class, show overlay
                sidebar.classList.remove('-translate-x-full');
                sidebar.style.transform = 'translateX(0)';
                sidebar.style.visibility = 'visible';
                sidebar.style.opacity = '1';
                overlay.classList.remove('hidden');
                overlay.style.display = 'block';
                overlay.style.opacity = '1';
                overlay.style.visibility = 'visible';
                document.body.style.overflow = 'hidden';
                document.body.style.position = 'fixed';
                document.body.style.width = '100%';
                document.body.style.top = '0';
                document.body.style.left = '0';
                document.body.classList.add('menu-open');
                console.log('✅ Menu OPENED');
            } else {
                // HIDE MENU - Add hidden class, hide overlay
                sidebar.classList.add('-translate-x-full');
                sidebar.style.transform = '';
                overlay.classList.add('hidden');
                overlay.style.display = 'none';
                document.body.style.overflow = '';
                document.body.style.position = '';
                document.body.style.width = '';
                document.body.style.top = '';
                document.body.style.left = '';
                document.body.classList.remove('menu-open');
                console.log('✅ Menu CLOSED');
            }
            
            return false;
        }
        
        // Make it globally available
        window.toggleMobileMenu = toggleMobileMenu;
        
        // Test function - can be called from console: testMobileMenu()
        window.testMobileMenu = function() {
            console.log('🧪 Testing mobile menu...');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-menu-overlay');
            const hamburger = document.getElementById('mobile-menu-toggle');
            const closeBtn = document.getElementById('mobile-menu-close');
            
            const testResults = {
                sidebar: {
                    exists: !!sidebar,
                    hasHiddenClass: sidebar ? sidebar.classList.contains('-translate-x-full') : null,
                    computedTransform: sidebar ? window.getComputedStyle(sidebar).transform : null,
                    zIndex: sidebar ? window.getComputedStyle(sidebar).zIndex : null
                },
                overlay: {
                    exists: !!overlay,
                    hasHiddenClass: overlay ? overlay.classList.contains('hidden') : null,
                    display: overlay ? window.getComputedStyle(overlay).display : null
                },
                hamburger: {
                    exists: !!hamburger,
                    onclick: hamburger ? hamburger.getAttribute('onclick') : null
                },
                closeBtn: {
                    exists: !!closeBtn,
                    onclick: closeBtn ? closeBtn.getAttribute('onclick') : null
                },
                windowWidth: window.innerWidth,
                isMobile: window.innerWidth < 1024,
                functionAvailable: typeof window.toggleMobileMenu === 'function'
            };
            
            console.table(testResults);
            
            if (testResults.functionAvailable && testResults.hamburger.exists) {
                console.log('✅ All elements found! Try clicking the hamburger button.');
                console.log('💡 Tip: Call toggleMobileMenu() directly from console to test');
            } else {
                console.error('❌ Some elements are missing!');
            }
            
            return testResults;
        };
        
        // Simple initialization - only run if elements exist (user is authenticated)
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-menu-overlay');
            const hamburger = document.getElementById('mobile-menu-toggle');
            
            // Only initialize if menu elements exist (user is logged in)
            if (!sidebar || !overlay || !hamburger) {
                // User not logged in, menu elements don't exist - this is normal
                return;
            }
            
            // Auto-test on load (only in development)
            if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
                setTimeout(() => {
                    console.log('🔍 Mobile menu ready. Type testMobileMenu() in console to test.');
                }, 500);
            }
            
            // Close menu when clicking on a link (mobile)
            const sidebarLinks = document.querySelectorAll('#sidebar nav a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Only close on mobile
                    if (window.innerWidth < 1024) {
                        setTimeout(() => {
                            toggleMobileMenu(e);
                        }, 150);
                    }
                });
            });
            
            // Close menu when clicking overlay
            overlay.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleMobileMenu(e);
            }, { passive: false });
            
            overlay.addEventListener('touchend', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleMobileMenu(e);
            }, { passive: false });
            
            // Close menu on window resize if it becomes desktop
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (window.innerWidth >= 1024) {
                        const sidebar = document.getElementById('sidebar');
                        const overlay = document.getElementById('mobile-menu-overlay');
                        if (sidebar && overlay) {
                            sidebar.classList.add('-translate-x-full');
                            overlay.classList.add('hidden');
                            document.body.style.overflow = '';
                            document.body.style.position = '';
                            document.body.style.width = '';
                            document.body.classList.remove('menu-open');
                        }
                    }
                }, 250);
            });
            
            // Prevent body scroll when menu is open on mobile
            sidebar.addEventListener('touchmove', function(e) {
                // Allow scrolling within sidebar
                if (e.target.closest('nav')) {
                    return;
                }
            }, { passive: true });
            
            // Debug: Log menu state (only in development)
            if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
                console.log('✅ Mobile menu initialized', {
                    sidebar: true,
                    overlay: true,
                    hamburger: true,
                    closeBtn: !!document.getElementById('mobile-menu-close'),
                    windowWidth: window.innerWidth,
                    isMobile: window.innerWidth < 1024
                });
            }
        });
    </script>
</body>
</html>

