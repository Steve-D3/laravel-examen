<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Canada Trips Admin</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
                    mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Desktop Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-blue-700 text-white">
                <div class="flex items-center h-16 px-4 border-b border-blue-600">
                    <i class="fas fa-map-marked-alt text-2xl mr-2"></i>
                    <span class="text-xl font-semibold">Canada Trips</span>
                </div>
                <nav class="flex-1 px-2 py-4 space-y-1">
                    <a href="{{ route('admin.trips.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-blue-800">
                        <i class="fas fa-map mr-3"></i>
                        Trips Overview
                    </a>
                    <!-- Add more navigation items as needed -->
                </nav>
            </div>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Mobile header -->
            <header class="md:hidden bg-blue-600 text-white shadow">
                <div class="flex items-center justify-between h-16 px-4">
                    <div class="flex items-center">
                        <i class="fas fa-map-marked-alt text-2xl mr-2"></i>
                        <span class="text-xl font-semibold">Canada Trips</span>
                    </div>
                    <button id="mobile-menu-button" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-blue-200 hover:text-white hover:bg-blue-500 focus:outline-none" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
                <!-- Mobile menu -->
                <div class="hidden md:hidden bg-blue-700" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                        <a href="{{ route('admin.trips.index') }}" class="block px-3 py-2 text-base font-medium text-white rounded-md hover:bg-blue-600">
                            <i class="fas fa-map mr-2"></i>Trips Overview
                        </a>
                        <!-- Add more mobile menu items as needed -->
                    </div>
                </div>
            </header>

            <!-- Main content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
