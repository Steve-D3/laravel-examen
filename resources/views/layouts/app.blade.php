<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Canada Trips Admin') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-blue-600 text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center">
                            <i class="fas fa-map-marked-alt text-2xl mr-2"></i>
                            <span class="text-xl font-semibold">Canada Trips Admin</span>
                        </div>
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="{{ route('admin.trips.index') }}" class="border-transparent text-white hover:bg-blue-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('admin.trips.*') ? 'border-white' : '' }}">
                                Trips
                            </a>
                            <a href="{{ route('admin.bookings.index') }}" class="border-transparent text-white hover:bg-blue-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('admin.bookings.*') ? 'border-white' : '' }}">
                                Bookings
                            </a>
                        </div>
                    </div>
                    <!-- Mobile menu button -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-blue-200 hover:text-white hover:bg-blue-700 focus:outline-none" @click="open = !open">
                            <span class="sr-only">Open main menu</span>
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="sm:hidden" x-show="open" @click.away="open = false">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('admin.trips.index') }}" class="{{ request()->routeIs('admin.trips.*') ? 'bg-blue-700 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('admin.trips.*') ? 'border-white' : 'border-transparent' }} text-base font-medium">
                        <i class="fas fa-map-marked-alt mr-2"></i> Trips
                    </a>
                    <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'bg-blue-700 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('admin.bookings.*') ? 'border-white' : 'border-transparent' }} text-base font-medium">
                        <i class="fas fa-calendar-check mr-2"></i> Bookings
                    </a>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>
    
    @stack('scripts')
</body>
</html>
