<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts & Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Custom Styles for the New Layout -->
        <style>
            body { font-family: 'Vazirmatn', sans-serif !important; }
            .sidebar { transition: all 0.3s ease-in-out; }
            .main-content { transition: margin-right 0.3s ease-in-out; }
            .sidebar.collapsed { width: 5.5rem; }
            .sidebar.collapsed .sidebar-text, .sidebar.collapsed .logo-text, .sidebar.collapsed .user-role { display: none; }
            .sidebar.collapsed .menu-item { justify-content: center; }
            .sidebar.collapsed .menu-item .ml-auto { display: none; }
            .sidebar.collapsed .user-info-container > div { margin-right: 0; }
            .sidebar.collapsed .user-info-container { justify-content: center; }

            @media (max-width: 768px) {
                .sidebar { position: fixed; right: -288px; z-index: 40; }
                .sidebar.open { right: 0; }
                .main-content { margin-right: 0 !important; }
                .sidebar-overlay {
                    position: fixed; inset: 0; background-color: rgba(0,0,0,0.5);
                    z-index: 30; opacity: 0; visibility: hidden; transition: opacity 0.3s ease-in-out;
                }
                .sidebar-overlay.open { opacity: 1; visibility: visible; }
            }
        </style>
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            <aside id="sidebar" class="sidebar bg-white text-gray-800 w-72 shadow-lg flex flex-col flex-shrink-0 dark:bg-gray-800 dark:text-gray-200">
                <div class="p-4 flex items-center justify-between border-b border-gray-200 dark:border-gray-700">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <img src="{{ asset('images/company-logo.png') }}" alt="Company Logo" class="h-10 w-10">
                        <span class="logo-text font-bold text-xl mr-3">مرکز انفورماتیک</span>
                    </a>
                    <button id="toggleSidebar" class="text-gray-500 hover:text-gray-700 hidden md:block">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center user-info-container">
                        <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=3B82F6&background=DBEAFE' }}" alt="User" class="w-12 h-12 rounded-full object-cover">
                        <div class="mr-3 sidebar-text">
                            <div class="font-medium dark:text-white">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 user-role">{{ __(ucfirst(Auth::user()->role)) }}</div>
                        </div>
                    </div>
                </div>

                <nav class="flex-1 overflow-y-auto">
                    @include('layouts.navigation')
                </nav>

                 <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="menu-item flex items-center w-full px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-600 rounded-lg dark:text-gray-400 dark:hover:bg-red-900/50 dark:hover:text-red-400">
                            <i class="fas fa-sign-out-alt ml-3"></i>
                            <span class="sidebar-text">خروج از سیستم</span>
                        </a>
                    </form>
                </div>
            </aside>

            <div id="sidebar-overlay" class="sidebar-overlay md:hidden"></div>

            <!-- Main Content -->
            <div id="mainContent" class="main-content flex-1 flex flex-col overflow-auto" style="margin-right: 18rem;">
                <!-- Header (The part that was causing the black space is now fixed) -->
                @if (isset($header))
                    <header class="bg-white dark:bg-gray-800 shadow sticky top-0 z-10">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                            {{-- Mobile Toggle --}}
                            <button id="mobileToggleSidebar" class="md:hidden text-gray-500 hover:text-gray-700 mr-4">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            {{ $header }}
                             <div class="w-8 md:hidden"></div> <!-- Spacer for mobile header alignment -->
                        </div>
                    </header>
                @endif
                
                <!-- Page Content -->
                <main class="flex-grow p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const toggleSidebar = document.getElementById('toggleSidebar');
                const mobileToggleSidebar = document.getElementById('mobileToggleSidebar');
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.getElementById('mainContent');
                const sidebarOverlay = document.getElementById('sidebar-overlay');

                if (toggleSidebar) {
                    toggleSidebar.addEventListener('click', () => {
                        sidebar.classList.toggle('collapsed');
                        mainContent.style.marginRight = sidebar.classList.contains('collapsed') ? '5.5rem' : '18rem';
                    });
                }
                if (mobileToggleSidebar) mobileToggleSidebar.addEventListener('click', () => {
                    sidebar.classList.add('open');
                    sidebarOverlay.classList.add('open');
                });
                if (sidebarOverlay) sidebarOverlay.addEventListener('click', () => {
                    sidebar.classList.remove('open');
                    sidebarOverlay.classList.remove('open');
                });
            });
        </script>
    </body>
</html>