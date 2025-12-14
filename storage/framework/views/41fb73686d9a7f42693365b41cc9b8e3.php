<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Page Not Found | <?php echo e(config('app.name', 'Cutietyha POS')); ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
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
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(url('/dashboard')); ?>" 
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors shadow-lg">
                        Go to Dashboard
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(url('/login')); ?>" 
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors shadow-lg">
                        Go to Login
                    </a>
                <?php endif; ?>
                
                <button onclick="window.history.back()" 
                        class="block w-full mt-4 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-3 rounded-lg transition-colors">
                    Go Back
                </button>
            </div>
        </div>
    </div>
</body>
</html>

<?php /**PATH C:\Users\USER\Documents\pos\resources\views/errors/404.blade.php ENDPATH**/ ?>