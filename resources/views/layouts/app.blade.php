<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl" class="{{ Auth::user() && Auth::user()->theme === 'dark' ? 'dark' : '' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@hasSection('title') @yield('title') - @endif مرکز انفورماتیک</title>
        <link rel="icon" type="image/png" href="{{ asset('images/company-logo.png') }}">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Vazirmatn', sans-serif !important; }
            
            /* Sidebar Transitions & Scrollbar Fix */
            .sidebar { transition: width 0.3s ease-in-out; overflow-x: hidden; }
            .main-content { transition: margin-right 0.3s ease-in-out; }
            
            /* Global Custom Premium Scrollbar */
            ::-webkit-scrollbar { width: 6px; height: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
            ::-webkit-scrollbar-thumb:hover { background-color: #94a3b8; }
            
            /* Dark Mode Scrollbar */
            .dark ::-webkit-scrollbar-thumb { background-color: #334155; }
            .dark ::-webkit-scrollbar-thumb:hover { background-color: #475569; }
            
            /* Aggressive Collapsed State */
            .sidebar.collapsed { width: 5.5rem; }
            .sidebar.collapsed .sidebar-text, 
            .sidebar.collapsed .logo-text, 
            .sidebar.collapsed .user-role,
            .sidebar.collapsed .admin-label { display: none !important; }
            
            .sidebar.collapsed .user-info-container { justify-content: center; padding: 0.5rem 0; }
            .sidebar.collapsed .user-info-container img { margin: 0; width: 2.5rem; height: 2.5rem; }
            
            .sidebar.collapsed nav a { justify-content: center; padding-left: 0; padding-right: 0; margin-left: 0.5rem; margin-right: 0.5rem; }
            .sidebar.collapsed nav a i { margin: 0 !important; font-size: 1.25rem; }
            
            /* Mobile Overlay */
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
    <body class="font-sans antialiased bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">
        <div class="flex h-screen overflow-hidden">
            
            {{-- SIDEBAR --}}
            <aside id="sidebar" class="sidebar bg-white dark:bg-slate-800 text-gray-800 dark:text-gray-200 w-72 shadow-lg flex flex-col flex-shrink-0 border-l border-gray-100 dark:border-slate-700 transition-colors duration-300 z-30">
                
                {{-- Logo Section (Fixed line break) --}}
                <div class="p-4 flex flex-row items-center justify-between border-b border-gray-100 dark:border-slate-700 h-20 transition-colors duration-300 shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center overflow-hidden sidebar-text group">
                        <img src="{{ asset('images/company-logo.png') }}" alt="Logo" class="h-11 w-11 object-contain shrink-0 group-hover:scale-105 transition-transform">
                        <span class="logo-text font-black text-lg whitespace-nowrap mr-3 text-gray-800 dark:text-gray-100 tracking-tight">مرکز انفورماتیک</span>
                    </a>
                    <button id="toggleSidebar" class="text-gray-400 hover:text-blue-600 dark:text-gray-500 dark:hover:text-blue-400 hidden md:flex items-center justify-center p-2 rounded-lg transition-colors shrink-0">
                        <i id="toggleSidebarIcon" class="fas fa-bars text-xl"></i>
                    </button>
                </div>
                
                {{-- User Info Section --}}
                <div class="p-4 border-b border-gray-100 dark:border-slate-700 transition-colors duration-300 shrink-0">
                    <div class="flex items-center user-info-container transition-all">
                        <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=3B82F6&background=DBEAFE' }}" alt="User" class="w-12 h-12 rounded-full object-cover shadow-sm ring-2 ring-gray-100 dark:ring-slate-700 shrink-0">
                        <div class="mr-3 sidebar-text overflow-hidden">
                            <div class="font-bold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</div>
                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 user-role mt-0.5 truncate">{{ __(ucfirst(Auth::user()->role)) }}</div>
                        </div>
                    </div>
                </div>

                {{-- Navigation Links --}}
                <nav class="flex-1 overflow-y-auto overflow-x-hidden sidebar-scroll py-2">
                    @include('layouts.navigation')
                </nav>

                {{-- Logout Button --}}
                <div class="p-4 border-t border-gray-100 dark:border-slate-700 transition-colors duration-300 shrink-0">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="group flex items-center justify-center md:justify-start w-full px-4 py-3 text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all duration-200">
                            <i class="fas fa-sign-out-alt md:ml-3 group-hover:-translate-x-1 transition-transform shrink-0"></i>
                            <span class="sidebar-text font-bold whitespace-nowrap">خروج از سیستم</span>
                        </a>
                    </form>
                </div>
            </aside>

            <div id="sidebar-overlay" class="sidebar-overlay md:hidden"></div>

            {{-- MAIN CONTENT WRAPPER --}}
            <div id="mainContent" class="main-content flex-1 flex flex-col overflow-auto bg-gray-50 dark:bg-slate-900 transition-colors duration-300">
                
                {{-- UNIFIED GLOBAL HEADER (Theme, Notifs, and Page Buttons in ONE line) --}}
                <header class="bg-white dark:bg-slate-800 shadow-sm border-b border-gray-100 dark:border-slate-700 sticky top-0 z-20 transition-colors duration-300 min-h-[5rem] flex items-center shrink-0">
                    <div class="w-full px-4 sm:px-6 lg:px-8 py-3 flex flex-wrap md:flex-nowrap items-center justify-between gap-4 md:gap-8">
                        
                        {{-- Left Side: Mobile Toggle + Page Header Content --}}
                        <div class="flex items-center flex-1 min-w-0 w-full">
                            <button id="mobileToggleSidebar" class="md:hidden shrink-0 ml-4 p-2 text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            
                            @if (isset($header))
                                <div class="flex-1 min-w-0 w-full">
                                    {{ $header }}
                                </div>
                            @endif
                        </div>

                        {{-- Right Side: Utilities (Theme & Notifications) --}}
                        <div class="flex items-center gap-2 sm:gap-3 shrink-0 mr-auto border-r border-gray-200 dark:border-slate-700 pr-4">
                            <form method="POST" action="{{ route('profile.theme.update') }}" class="flex items-center">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="theme" value="{{ Auth::user()->theme === 'dark' ? 'light' : 'dark' }}">
                                <button type="submit" class="p-2.5 rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-slate-700 transition-all focus:outline-none" title="تغییر پوسته">
                                    @if(Auth::user()->theme === 'dark')
                                        <i class="fas fa-sun text-lg text-yellow-400 hover:rotate-90 transition-transform"></i>
                                    @else
                                        <i class="fas fa-moon text-lg text-gray-600 hover:-rotate-12 transition-transform"></i>
                                    @endif
                                </button>
                            </form>

                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="relative p-2.5 rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-slate-700 transition-all focus:outline-none">
                                    <i class="fas fa-bell text-lg hover:rotate-12 transition-transform"></i>
                                    @if(auth()->check() && auth()->user()->unreadNotifications && auth()->user()->unreadNotifications->count() > 0)
                                        <span class="absolute top-2 right-2 h-2.5 w-2.5 rounded-full bg-red-500 border-2 border-white dark:border-slate-800"></span>
                                    @endif
                                </button>
                                
                                {{-- Dropdown Notifications --}}
                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     class="absolute left-0 mt-2 w-80 bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-100 dark:border-slate-700 overflow-hidden z-50 origin-top-left"
                                     style="display: none;">
                                    
                                    <div class="px-4 py-3 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-800/80">
                                        <span class="text-sm font-bold text-gray-800 dark:text-white">اعلان‌ها</span>
                                        @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                                            <form action="{{ route('notifications.readAll') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">خواندن همه</button>
                                            </form>
                                        @endif
                                    </div>

                                    <div class="max-h-80 overflow-y-auto">
                                        @forelse(auth()->check() ? auth()->user()->unreadNotifications : [] as $notification)
                                            <a href="{{ route('notifications.read', $notification->id) }}" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-slate-700/50 border-b border-gray-100 dark:border-slate-700 transition-colors">
                                                <div class="flex items-start">
                                                    <div class="flex-shrink-0 mt-1">
                                                        <i class="fas fa-bell text-blue-500 dark:text-blue-400"></i>
                                                    </div>
                                                    <div class="mr-3 flex-1 min-w-0">
                                                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200 truncate">{{ $notification->data['title'] ?? 'اعلان' }}</p>
                                                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mt-1 truncate">{{ \Illuminate\Support\Str::limit($notification->data['message'] ?? '', 50) }}</p>
                                                        <p class="text-[10px] font-bold text-gray-400 dark:text-slate-500 mt-1 text-left dir-ltr">{{ $notification->created_at->diffForHumans() }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        @empty
                                            <div class="px-4 py-8 text-center text-gray-500 dark:text-slate-400 text-sm font-medium flex flex-col items-center justify-center">
                                                <i class="fas fa-inbox text-3xl mb-2 opacity-20"></i>
                                                اعلان جدیدی ندارید.
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                
                {{-- 3. MAIN CONTENT AREA (Now completely free of redundant spacing) --}}
                <main class="flex-grow p-4 sm:p-6 lg:p-8">
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
                if (mobileToggleSidebar) {
                    mobileToggleSidebar.addEventListener('click', () => {
                        sidebar.classList.add('open');
                        sidebarOverlay.classList.add('open');
                    });
                }
                if (sidebarOverlay) {
                    sidebarOverlay.addEventListener('click', () => {
                        sidebar.classList.remove('open');
                        sidebarOverlay.classList.remove('open');
                    });
                }
            });
        </script>
        
        @stack('scripts')
    </body>
</html>