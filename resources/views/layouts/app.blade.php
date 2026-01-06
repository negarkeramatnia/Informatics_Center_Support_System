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
            [x-cloak] { display: none !important; }

            /* ==============================================================
               🚀 GLOBAL DARK MODE ENGINE V2 (Ultimate Visibility)
               ============================================================== */
            
            /* 1. Main Background */
            html.dark body {
                background-color: #0f172a !important; /* Deep Premium Slate */
                color: #f8fafc !important; /* Bright White */
            }

            /* 2. Force White Cards, Sidebars & Containers to turn Dark */
            html.dark .bg-white,
            html.dark .bg-gray-50,
            html.dark .bg-gray-100 {
                background-color: #1e293b !important; /* Slate 800 */
                border-color: #334155 !important; /* Slate 700 */
                color: #f8fafc !important; 
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.4) !important;
            }

            /* 3. ULTRA AGGRESSIVE TEXT FIXES (Headers, Sidebar, Lists) */
            /* Flip all dark text to bright white */
            html.dark .text-gray-900,
            html.dark .text-gray-800,
            html.dark .text-gray-700,
            html.dark .text-gray-600 {
                color: #f8fafc !important; /* Brilliant White */
            }
            
            /* Flip muted text to a visible silver */
            html.dark .text-blue-800,
            html.dark .text-blue-900 {
                color: #cbd5e1 !important; /* Silver/Slate 300 - Highly Readable */
            }

            /* Explicit headings & bold text force white */
            html.dark h1, html.dark h2, html.dark h3, html.dark h4, html.dark h5, html.dark h6, 
            html.dark .font-bold, html.dark .font-semibold {
                color: #ffffff !important; 
            }

            /* 4. Fix Tables Globally */
            html.dark table { 
                color: #f8fafc !important; 
            }
            html.dark th, html.dark thead {
                background-color: #0f172a !important; /* Darker Headers for contrast */
                color: #93c5fd !important; /* Soft Blue text for headers so they pop */
                border-bottom: 2px solid #334155 !important;
            }
            html.dark td, html.dark tr {
                background-color: #1e293b !important; /* Dark Rows */
                border-bottom: 1px solid #334155 !important;
            }
            html.dark tbody tr:hover, html.dark tbody tr:hover td {
                background-color: #334155 !important; /* Hover effect */
            }

            /* 5. Fix Form Inputs, Selects & Textareas */
            html.dark input[type="text"],
            html.dark input[type="email"],
            html.dark input[type="password"],
            html.dark input[type="number"],
            html.dark input[type="tel"],
            html.dark input[type="search"],
            html.dark select,
            html.dark textarea {
                background-color: #0f172a !important; /* Very dark inner input */
                border-color: #475569 !important;
                color: #ffffff !important;
            }
            html.dark input::placeholder,
            html.dark textarea::placeholder {
                color: #94a3b8 !important; /* Visible placeholder */
            }
            html.dark input:focus,
            html.dark select:focus,
            html.dark textarea:focus {
                border-color: #3b82f6 !important; /* Blue glow */
                box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.4) !important;
            }

            /* 6. Soft Colored Badges (Alerts, Statuses) */
            html.dark .bg-blue-50, html.dark .bg-blue-100 { background-color: rgba(59, 130, 246, 0.15) !important; border-color: rgba(59, 130, 246, 0.3) !important; color: #93c5fd !important; }
            html.dark .text-blue-600, html.dark .text-blue-700 { color: #60a5fa !important; }
            
            html.dark .bg-green-50, html.dark .bg-emerald-50 { background-color: rgba(16, 185, 129, 0.15) !important; border-color: rgba(16, 185, 129, 0.3) !important; color: #6ee7b7 !important; }
            html.dark .text-green-600, html.dark .text-green-700 { color: #34d399 !important; }
            
            html.dark .bg-yellow-50, html.dark .bg-orange-50 { background-color: rgba(245, 158, 11, 0.15) !important; border-color: rgba(245, 158, 11, 0.3) !important; color: #fcd34d !important; }
            html.dark .text-yellow-600, html.dark .text-orange-700 { color: #fbbf24 !important; }

            /* 7. Hover effects for sidebar links */
            html.dark .sidebar a:hover,
            html.dark .sidebar a:hover i,
            html.dark .sidebar a:hover span {
                color: #60a5fa !important; /* Light blue on hover */
                background-color: #334155 !important;
            }
        </style>
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-[#f4f6f9] dark:bg-[#0f172a] text-gray-900 dark:text-gray-100 transition-colors duration-300">
        <div class="flex h-screen overflow-hidden">
            
            <aside id="sidebar" class="sidebar bg-white dark:bg-[#1e293b] text-gray-800 dark:text-gray-200 w-72 shadow-lg flex flex-col flex-shrink-0 border-l dark:border-[#334155] transition-colors duration-300 z-30">
                <div class="p-4 flex items-center justify-between border-b dark:border-[#334155] h-16 transition-colors duration-300">
                    <div class="flex items-center sidebar-text">
                        <a href="{{ route('dashboard') }}" class="flex items-center">
                            <img src="{{ asset('images/company-logo.png') }}" alt="Logo" class="h-10 w-10 object-contain">
                            <span class="logo-text font-bold text-xl mr-3 text-gray-800 dark:text-white">مرکز انفورماتیک</span>
                        </a>
                    </div>
                    <button id="toggleSidebar" class="text-gray-500 hover:text-gray-700 dark:text-gray-300 hidden md:block focus:outline-none">
                        <i id="toggleSidebarIcon" class="fas fa-bars"></i>
                    </button>
                </div>
                
                <div class="p-4 border-b dark:border-[#334155] transition-colors duration-300">
                    <div class="flex items-center user-info-container">
                        <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=3B82F6&background=DBEAFE' }}" alt="User" class="w-12 h-12 rounded-full object-cover shadow-sm">
                        <div class="mr-3 sidebar-text">
                            <div class="font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-300 user-role">{{ __(ucfirst(Auth::user()->role)) }}</div>
                        </div>
                    </div>
                </div>

                <nav class="flex-1 overflow-y-auto">
                    @include('layouts.navigation')
                </nav>

                <div class="p-4 border-t dark:border-[#334155] transition-colors duration-300">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="menu-item flex items-center w-full px-4 py-3 text-gray-600 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-red-900/40 hover:text-red-600 dark:hover:text-red-400 rounded-lg transition-colors">
                            <i class="fas fa-sign-out-alt ml-3"></i>
                            <span class="sidebar-text">خروج از سیستم</span>
                        </a>
                    </form>
                </div>
            </aside>

            <div id="sidebar-overlay" class="sidebar-overlay md:hidden"></div>

            <div id="mainContent" class="main-content flex-1 flex flex-col overflow-auto relative">
                
                <header class="bg-white dark:bg-[#1e293b] shadow-sm sticky top-0 z-20 transition-colors duration-300 h-16 border-b dark:border-[#334155]">
                    <div class="w-full h-full px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                        
                        <div class="flex items-center gap-4">
                            <button id="mobileToggleSidebar" class="md:hidden text-gray-500 hover:text-gray-700 dark:text-gray-300 focus:outline-none">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            @if (isset($header))
                                <div class="font-semibold text-gray-800 dark:text-white flex items-center">
                                    {{ $header }}
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-3">
                            <form method="POST" action="{{ route('profile.theme.update') }}" class="flex items-center m-0">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="theme" value="{{ Auth::user()->theme === 'dark' ? 'light' : 'dark' }}">
                                <button type="submit" class="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-[#334155] transition focus:outline-none" title="تغییر پوسته">
                                    @if(Auth::user()->theme === 'dark')
                                        <i class="fas fa-sun text-lg text-yellow-400"></i>
                                    @else
                                        <i class="fas fa-moon text-lg text-gray-600"></i>
                                    @endif
                                </button>
                            </form>

                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="relative p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-[#334155] transition focus:outline-none">
                                    <i class="fas fa-bell text-lg"></i>
                                    @if(auth()->check() && auth()->user()->unreadNotifications && auth()->user()->unreadNotifications->count() > 0)
                                        <span class="absolute top-1.5 right-1.5 h-2.5 w-2.5 rounded-full bg-red-500 border-2 border-white dark:border-[#1e293b]"></span>
                                    @endif
                                </button>

                                <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-2 w-80 bg-white dark:bg-[#1e293b] rounded-lg shadow-xl border dark:border-[#334155] overflow-hidden z-50 origin-top-left" style="display: none;">
                                    <div class="px-4 py-3 border-b border-gray-100 dark:border-[#334155] flex justify-between items-center bg-gray-50 dark:bg-[#0f172a]/50">
                                        <span class="text-sm font-bold text-gray-700 dark:text-white">اعلان‌ها</span>
                                        @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                                            <form action="{{ route('notifications.readAll') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">خواندن همه</button>
                                            </form>
                                        @endif
                                    </div>

                                    <div class="max-h-80 overflow-y-auto">
                                        @forelse(auth()->check() ? auth()->user()->unreadNotifications : [] as $notification)
                                            <a href="{{ route('notifications.read', $notification->id) }}" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-[#334155] border-b border-gray-100 dark:border-[#334155] transition">
                                                <div class="flex items-start">
                                                    <div class="flex-shrink-0 mt-1">
                                                        <i class="fas fa-bell text-blue-500"></i>
                                                    </div>
                                                    <div class="mr-3 flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-800 dark:text-white truncate">{{ $notification->data['title'] ?? 'اعلان' }}</p>
                                                        <p class="text-[10px] text-gray-400 dark:text-gray-300 mt-1 text-left dir-ltr">{{ $notification->created_at->diffForHumans() }}</p>
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
                
                <main class="flex-grow p-6 text-gray-800 dark:text-gray-100">
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