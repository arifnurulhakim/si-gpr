<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Kartu Keluarga')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/app.js'])
    @yield('styles')
</head>
<body class="bg-gray-50">
    @auth
        <!-- Mobile menu button -->
        <div class="lg:hidden fixed top-4 left-4 z-50">
            <button id="mobile-menu-button" class="p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Sidebar -->
        <div id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 bg-indigo-600">
                <h1 class="text-xl font-bold text-white">E-Kartu Keluarga</h1>
            </div>

            <!-- Navigation -->
            <nav class="mt-8">
                <div class="px-4 space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                        </svg>
                        Dashboard
                    </a>

                    @if(auth()->user()->isAdmin())
                    <!-- Data Penduduk Dropdown -->
                    <div class="relative">
                        <button id="data-penduduk-toggle" class="flex items-center justify-between w-full px-4 py-3 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors {{ request()->routeIs('families.*') || request()->routeIs('family-members.*') ? 'bg-indigo-50 text-indigo-700' : '' }}">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Data Penduduk
                            </div>
                            <svg class="w-4 h-4 transition-transform duration-200" id="data-penduduk-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div id="data-penduduk-menu" class="hidden mt-2 ml-8 space-y-1">
                            <a href="{{ route('families.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors {{ request()->routeIs('families.*') ? 'bg-indigo-50 text-indigo-700' : '' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Kartu Keluarga
                            </a>
                            <a href="{{ route('family-members.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors {{ request()->routeIs('family-members.*') ? 'bg-indigo-50 text-indigo-700' : '' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                Masyarakat
                            </a>
                        </div>
                    </div>
                    @else
                    <!-- User Menu -->
                    <a href="{{ route('my-family') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors {{ request()->routeIs('my-family') ? 'bg-indigo-50 text-indigo-700' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Data Keluarga Saya
                    </a>
                    @endif
                </div>
            </nav>

            <!-- User Menu -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ Auth::user()->isAdmin() ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ Auth::user()->isAdmin() ? 'Admin' : 'User' }}
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

        <!-- Overlay for mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-gray-600 bg-opacity-75 z-30 lg:hidden hidden"></div>

        <!-- Main Content -->
        <div class="lg:ml-64">
            <!-- Top Bar -->
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 py-4">
                    <div class="lg:ml-0 ml-16">
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900">@yield('title', 'Dashboard')</h2>
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>


            <!-- Page Content -->
            <main class="p-4 sm:p-6">
                @yield('content')
            </main>
        </div>


        <!-- Mobile sidebar toggle script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');

                function toggleSidebar() {
                    const isOpen = !sidebar.classList.contains('-translate-x-full');

                    if (isOpen) {
                        sidebar.classList.add('-translate-x-full');
                        overlay.classList.add('hidden');
                    } else {
                        sidebar.classList.remove('-translate-x-full');
                        overlay.classList.remove('hidden');
                    }
                }

                mobileMenuButton.addEventListener('click', toggleSidebar);
                overlay.addEventListener('click', toggleSidebar);

                // Data Penduduk dropdown toggle
                const dataPendudukToggle = document.getElementById('data-penduduk-toggle');
                const dataPendudukMenu = document.getElementById('data-penduduk-menu');
                const dataPendudukArrow = document.getElementById('data-penduduk-arrow');

                dataPendudukToggle.addEventListener('click', function() {
                    const isOpen = !dataPendudukMenu.classList.contains('hidden');

                    if (isOpen) {
                        dataPendudukMenu.classList.add('hidden');
                        dataPendudukArrow.style.transform = 'rotate(0deg)';
                    } else {
                        dataPendudukMenu.classList.remove('hidden');
                        dataPendudukArrow.style.transform = 'rotate(180deg)';
                    }
                });

                // Auto-open dropdown if on families or family-members route
                if (window.location.pathname.includes('/families') || window.location.pathname.includes('/family-members')) {
                    dataPendudukMenu.classList.remove('hidden');
                    dataPendudukArrow.style.transform = 'rotate(180deg)';
                }

                // Close sidebar on window resize if switching to desktop
                window.addEventListener('resize', function() {
                    if (window.innerWidth >= 1024) {
                        sidebar.classList.remove('-translate-x-full');
                        overlay.classList.add('hidden');
                    } else {
                        sidebar.classList.add('-translate-x-full');
                        overlay.classList.add('hidden');
                    }
                });

            });
        </script>
    @else
        <!-- Guest Layout -->
        <div class="min-h-screen bg-gray-50">
            <!-- Top Navigation for Guests -->
            <nav class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <h1 class="text-lg sm:text-xl font-bold text-gray-800">E-Kartu Keluarga</h1>
                        </div>
                        <div class="flex items-center space-x-2 sm:space-x-4">
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 px-2 sm:px-3 py-2 rounded-md text-sm font-medium">
                                    {{ __('Login') }}
                                </a>
                            @endif

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-gray-500 hover:text-gray-700 px-2 sm:px-3 py-2 rounded-md text-sm font-medium">
                                    {{ __('Register') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </nav>


            <!-- Guest Content -->
            <main class="max-w-7xl mx-auto py-4 sm:py-6 px-4 sm:px-6 lg:px-8">
                @yield('content')
            </main>
        </div>

    @endauth

    <!-- Notifications - Global -->
    @include('components.notification')

    @yield('scripts')
</body>
</html>
