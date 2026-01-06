<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl" class="{{ Auth::user() && Auth::user()->theme === 'dark' ? 'dark' : '' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

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
            .sidebar.collapsed .menu-item i { margin-left: 0;}
            .sidebar.collapsed .menu-item i { margin-left: 0 !important;}
            .sidebar.collapsed #toggleSidebar {
                justify-content: center;
                width: 100%;
                display: flex;
                align-items: center;
            }
            .sidebar.collapsed #toggleSidebarIcon {
                margin: 0 !important;
            }
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
            [x-cloak] { display: none !important; }
        </style>
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-[#f4f6f9] dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">
        <div class="flex h-screen overflow-hidden">
            <aside id="sidebar" class="sidebar bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 w-72 shadow-lg flex flex-col flex-shrink-0 border-l dark:border-gray-700 transition-colors duration-300">
                
                <div class="p-4 flex items-center justify-between border-b dark:border-gray-700 h-16 transition-colors duration-300">
                    <div class="flex items-center sidebar-text">
                        <a href="{{ route('dashboard') }}" class="flex items-center">
                            <img src="{{ asset('images/company-logo.png') }}" alt="Logo" class="h-10 w-10 object-contain">
                            <span class="logo-text font-bold text-xl mr-3 text-gray-800 dark:text-gray-100">مرکز انفورماتیک</span>
                        </a>
                    </div>
                    <button id="toggleSidebar" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hidden md:block">
                        <i id="toggleSidebarIcon" class="fas fa-bars"></i>
                    </button>
                </div>
                
                <div class="p-4 border-b dark:border-gray-700 transition-colors duration-300">
                    <div class="flex items-center user-info-container">
                        <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=3B82F6&background=DBEAFE' }}" alt="User" class="w-12 h-12 rounded-full object-cover shadow-sm">
                        <div class="mr-3 sidebar-text">
                            <div class="font-medium text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 user-role">{{ __(ucfirst(Auth::user()->role)) }}</div>
                        </div>
                    </div>
                </div>

                <nav class="flex-1 overflow-y-auto">
                    @include('layouts.navigation')
                </nav>

                <div class="p-4 border-t dark:border-gray-700 transition-colors duration-300">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="menu-item flex items-center w-full px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-red-50 dark:hover:bg-red-900/30 hover:text-red-600 dark:hover:text-red-400 rounded-lg transition-colors">
                            <i class="fas fa-sign-out-alt ml-3"></i>
                            <span class="sidebar-text">خروج از سیستم</span>
                        </a>
                    </form>
                </div>
            </aside>

            <div id="sidebar-overlay" class="sidebar-overlay md:hidden"></div>

            <div id="mainContent" class="main-content flex-1 flex flex-col overflow-auto">
                
<header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-20 transition-colors duration-300 h-16">
                    <div class="w-full h-full px-4 sm:px-6 lg:px-8 flex items-center">
                        
                        <div class="flex items-center">
                            <button id="mobileToggleSidebar" class="md:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 ml-4">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            @if (isset($header))
                                <div class="font-semibold text-gray-800 dark:text-gray-200">
                                    {{ $header }}
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-3 mr-auto">
                            
                            <form method="POST" action="{{ route('profile.theme.update') }}" class="flex items-center">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="theme" value="{{ Auth::user()->theme === 'dark' ? 'light' : 'dark' }}">
                                <button type="submit" class="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 transition focus:outline-none" title="تغییر پوسته">
                                    @if(Auth::user()->theme === 'dark')
                                        <i class="fas fa-sun text-lg text-yellow-400"></i>
                                    @else
                                        <i class="fas fa-moon text-lg text-gray-600"></i>
                                    @endif
                                </button>
                            </form>

                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="relative p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 transition focus:outline-none">
                                    <i class="fas fa-bell text-lg"></i>
                                    @if(auth()->check() && auth()->user()->unreadNotifications && auth()->user()->unreadNotifications->count() > 0)
                                        <span class="absolute top-1.5 right-1.5 h-2.5 w-2.5 rounded-full bg-red-500 border-2 border-white dark:border-gray-800"></span>
                                    @endif
                                </button>

                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     class="absolute left-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-xl ring-1 ring-black ring-opacity-5 overflow-hidden z-50 origin-top-left"
                                     style="display: none;">
                                    
                                    <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-700/50">
                                        <span class="text-sm font-bold text-gray-700 dark:text-gray-200">اعلان‌ها</span>
                                        @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                                            <form action="{{ route('notifications.readAll') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">خوانden همه</button>
                                            </form>
                                        @endif
                                    </div>

                                    <div class="max-h-80 overflow-y-auto">
                                        @forelse(auth()->check() ? auth()->user()->unreadNotifications : [] as $notification)
                                            <a href="{{ route('notifications.read', $notification->id) }}" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700 transition">
                                                <div class="flex items-start">
                                                    <div class="flex-shrink-0 mt-1">
                                                        <i class="fas fa-bell text-gray-400"></i>
                                                    </div>
                                                    <div class="mr-3 flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate">{{ $notification->data['title'] ?? 'اعلان' }}</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">{{ \Illuminate\Support\Str::limit($notification->data['message'] ?? '', 50) }}</p>
                                                        <p class="text-[10px] text-gray-400 mt-1 text-left dir-ltr">{{ $notification->created_at->diffForHumans() }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        @empty
                                            <div class="px-4 py-8 text-center text-gray-500 dark:text-gray-400 text-sm">
                                                اعلان جدیدی ندارید.
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </header>
                
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
                        mainContent.style.marginRight = sidebar.classList.contains('collapsed');
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
        
        @stack('scripts')
    </body>
</html>