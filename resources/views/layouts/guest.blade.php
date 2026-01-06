<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <script src="https://cdn.tailwindcss.com"></script>
        
        <script>
            tailwind.config = { darkMode: 'class' }
        </script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />

        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <style>
            /* === LIGHT MODE (Default) === */
            body {
                font-family: 'Vazirmatn', sans-serif !important;
                background-color: #f3f4f6; /* Gray 100 */
                color: #1f2937; /* Gray 900 */
                transition: background-color 0.3s ease, color 0.3s ease;
            }
            .guest-card {
                background-color: #ffffff;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                border-radius: 0.5rem; /* rounded-lg */
                border: 1px solid #e5e7eb; /* Gray 200 */
                transition: background-color 0.3s ease, border-color 0.3s ease;
            }
            .form-input {
                background-color: #ffffff;
                border: 1px solid #d1d5db; /* Gray 300 */
                color: #1f2937;
                transition: all 0.2s;
            }
            .form-input:focus {
                border-color: #2563eb; /* Blue 600 */
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
            }
            .toggle-btn {
                background-color: #ffffff;
                color: #6b7280; /* Gray 500 */
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                transition: all 0.3s ease;
            }
            .toggle-btn:hover {
                background-color: #f9fafb; /* Gray 50 */
                color: #374151; /* Gray 700 */
            }

            /* === DARK MODE OVERRIDES === */
            html.dark body {
                background-color: #111827; /* Gray 900 */
                color: #f3f4f6; /* Gray 100 */
            }
            html.dark .guest-card {
                background-color: #1f2937; /* Gray 800 */
                border-color: #374151; /* Gray 700 */
                box-shadow: none;
            }
            html.dark .form-input {
                background-color: #374151; /* Gray 700 */
                border-color: #4b5563; /* Gray 600 */
                color: #ffffff;
            }
            html.dark .form-input:focus {
                border-color: #60a5fa; /* Blue 400 */
                box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.3);
            }
            html.dark label {
                color: #d1d5db; /* Gray 300 */
            }
            html.dark .toggle-btn {
                background-color: #1f2937; /* Gray 800 */
                color: #9ca3af; /* Gray 400 */
                border: 1px solid #374151;
            }
            html.dark .toggle-btn:hover {
                background-color: #374151; /* Gray 700 */
                color: #f3f4f6; /* Gray 100 */
            }
            html.dark .text-gray-600 {
                color: #9ca3af !important; /* Fix for muted text */
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            {{-- THEME TOGGLE (Absolute Top-Left) --}}
            <div class="absolute top-5 left-5">
                <button onclick="toggleTheme()" class="toggle-btn p-3 rounded-full focus:outline-none" title="تغییر پوسته">
                    <i id="theme-icon" class="fas fa-moon text-lg"></i>
                </button>
            </div>

            {{-- LOGO --}}
            <div class="mb-6">
                <a href="/">
                    <img src="{{ asset('images/company-logo.png') }}" alt="Logo" class="w-24 h-24 fill-current">
                </a>
            </div>

            {{-- MAIN CARD --}}
            <div class="w-full sm:max-w-md px-6 py-6 guest-card overflow-hidden">
                {{ $slot }}
            </div>

            {{-- FOOTER COPYRIGHT --}}
            <div class="mt-8 text-center text-xs text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} مرکز انفورماتیک. تمامی حقوق محفوظ است.
            </div>
        </div>

        {{-- SCRIPT --}}
        <script>
            const themeIcon = document.getElementById('theme-icon');

            function updateIcon(isDark) {
                if (isDark) {
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun', 'text-yellow-400');
                } else {
                    themeIcon.classList.remove('fa-sun', 'text-yellow-400');
                    themeIcon.classList.add('fa-moon');
                }
            }

            // Initialize Icon
            if (document.documentElement.classList.contains('dark')) {
                updateIcon(true);
            }

            function toggleTheme() {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.theme = 'light';
                    updateIcon(false);
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.theme = 'dark';
                    updateIcon(true);
                }
            }
        </script>
    </body>
</html>