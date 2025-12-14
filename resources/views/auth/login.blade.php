<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cutietyha POS') }} - Login</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('build/assets/logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('build/assets/logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="font-family: 'Inter', sans-serif;">
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-brand-old-lace via-brand-off-yellow to-brand-albescent-white py-8 sm:py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Animated background elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-brand-husk/10 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-brand-teak/10 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-brand-indian-khaki/10 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-blob animation-delay-4000"></div>
    </div>
    
    <div class="max-w-md w-full space-y-6 sm:space-y-8 relative z-10">
        <!-- Logo and Header -->
        <div class="text-center">
            <div class="mx-auto w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-brand-husk to-brand-teak rounded-2xl flex items-center justify-center shadow-2xl mb-4 sm:mb-6 overflow-hidden">
                @php
                    $logoPath = public_path('build/assets/logo.png');
                    $logoExists = file_exists($logoPath);
                @endphp
                @if($logoExists)
                    <img src="{{ asset('build/assets/logo.png') }}" alt="Cutietyha POS" class="w-full h-full object-contain p-2">
                @else
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                @endif
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold bg-gradient-to-r from-brand-husk via-brand-teak to-brand-indian-khaki bg-clip-text text-transparent mb-2">
                Welcome Back
            </h2>
            <p class="text-brand-akaroa font-medium text-sm sm:text-base">Sign in to Cutietyha POS</p>
        </div>
        
        <!-- Login Form -->
        <form class="mt-6 sm:mt-8 space-y-5 sm:space-y-6 bg-white/80 backdrop-blur-xl rounded-2xl sm:rounded-3xl p-6 sm:p-8 border border-brand-albescent-white shadow-2xl" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="space-y-4 sm:space-y-5">
                <div>
                    <label for="email" class="block text-sm font-semibold text-brand-husk mb-2">Email address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-brand-akaroa" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               class="block w-full pl-10 sm:pl-12 pr-4 py-3 sm:py-4 bg-white border-2 border-brand-albescent-white rounded-xl text-brand-husk placeholder-brand-akaroa focus:outline-none focus:ring-2 focus:ring-brand-husk/50 focus:border-brand-husk transition-all font-medium text-sm sm:text-base" 
                               placeholder="Enter your email" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-semibold text-brand-husk mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-brand-akaroa" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                               class="block w-full pl-10 sm:pl-12 pr-4 py-3 sm:py-4 bg-white border-2 border-brand-albescent-white rounded-xl text-brand-husk placeholder-brand-akaroa focus:outline-none focus:ring-2 focus:ring-brand-husk/50 focus:border-brand-husk transition-all font-medium text-sm sm:text-base" 
                               placeholder="Enter your password">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" 
                       class="h-4 w-4 text-brand-husk focus:ring-brand-husk border-brand-albescent-white rounded bg-white">
                <label for="remember" class="ml-2 block text-sm font-medium text-brand-husk">
                    Remember me
                </label>
            </div>

            @if (Route::has('password.request'))
            <div class="text-center">
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-brand-teak hover:text-brand-husk transition-colors">
                    Forgot your password?
                </a>
            </div>
            @endif

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center items-center py-3 sm:py-4 px-4 border border-transparent text-sm sm:text-base font-bold rounded-xl text-white bg-gradient-to-r from-brand-husk via-brand-teak to-brand-indian-khaki hover:from-brand-teak hover:via-brand-indian-khaki hover:to-brand-akaroa focus:outline-none focus:ring-2 focus:ring-brand-husk/50 shadow-xl hover:shadow-2xl transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                    <span>Sign in</span>
                    <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </button>
            </div>
        </form>

        <!-- Footer -->
        <div class="text-center">
            <p class="text-xs sm:text-sm text-black">
                © {{ date('Y') }} Cutietyha. All Rights Reserved - Built by PointSync Systems Limited
            </p>
        </div>
    </div>
</div>
</body>
</html>

