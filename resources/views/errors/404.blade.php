<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Page Not Found | {{ config('app.name', 'Cutietyha POS') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100" style="font-family: 'Inter', sans-serif;">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full text-center">
            <div class="mb-8">
                <h1 class="text-9xl font-bold text-gray-800 mb-4">404</h1>
                <h2 class="text-3xl font-semibold text-gray-700 mb-4">Page Not Found</h2>
                <p class="text-gray-600 mb-8">
                    The page you're looking for doesn't exist or has been moved.
                </p>
            </div>
            
            <div class="space-y-4">
                @auth
                    <a href="{{ url('/dashboard') }}" 
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors shadow-lg">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ url('/login') }}" 
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors shadow-lg">
                        Go to Login
                    </a>
                @endauth
                
                <button onclick="window.history.back()" 
                        class="block w-full mt-4 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-3 rounded-lg transition-colors">
                    Go Back
                </button>
            </div>
        </div>
    </div>
</body>
</html>

