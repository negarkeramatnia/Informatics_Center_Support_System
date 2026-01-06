<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ورود به سامانه - پشتیبانی انفورماتیک</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
        /* === LIGHT MODE STYLES (ORIGINAL) === */
        body {
            font-family: 'Vazirmatn', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .navbar-custom {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .logo-img-nav {
            max-height: 50px;
        }
        .content-wrapper {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 80px;
            padding-bottom: 40px;
        }
        .login-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        .login-card-header {
            background-color: #0069d9;
            color: white;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #0056b3;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .form-input {
            border-color: #ced4da;
            padding: 0.75rem 1rem;
            padding-right: 2.75rem;
            border-radius: 8px;
            transition: all 0.15s ease-in-out;
            background-color: #fff;
            color: #495057;
        }
        .form-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
            outline: 0;
        }
        .input-icon {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
            color: #adb5bd;
        }
        .btn {
            padding: 0.8rem 1.75rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }
        .btn-primary-custom {
            background-color: #0069d9;
            color: white;
            border: none;
        }
        .btn-primary-custom:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0,0,0,0.15);
        }
        .footer-custom {
            background-color: #2c3e50;
            color: #ecf0f1;
            flex-shrink: 0;
            transition: background-color 0.3s ease;
        }
        .shake {
            animation: shake 0.5s;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        /* === DARK MODE OVERRIDES === */
        html.dark body {
            background-color: #111827; /* Gray 900 */
            color: #f3f4f6;
        }
        html.dark .navbar-custom {
            background-color: #1f2937; /* Gray 800 */
            border-bottom-color: #374151;
        }
        html.dark .navbar-custom a {
            color: #f3f4f6 !important;
        }
        html.dark .navbar-custom p {
            color: #9ca3af !important;
        }
        html.dark .login-card {
            background-color: #1f2937;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        }
        html.dark .login-card-header {
            background-color: #1e3a8a; /* Dark Blue */
            border-bottom-color: #1e40af;
        }
        html.dark .login-card-header p {
            color: #bfdbfe !important; /* Light Blue Text */
        }
        html.dark .form-input {
            background-color: #374151; /* Gray 700 */
            border-color: #4b5563;
            color: #f3f4f6;
        }
        html.dark .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.5);
        }
        html.dark .form-input::placeholder {
            color: #9ca3af;
        }
        html.dark label {
            color: #d1d5db; /* Gray 300 */
        }
        html.dark .footer-custom {
            background-color: #0f172a; /* Gray 950 */
        }
        html.dark .mobile-menu-bg {
            background-color: #1f2937;
        }
    </style>
</head>
<body class="antialiased">

    <nav class="navbar-custom fixed w-full z-20 top-0">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex-shrink-0">
                        <img class="logo-img-nav" src="{{ asset('images/company-logo.png') }}" alt="لوگوی شرکت">
                    </a>
                    <div class="hidden md:block mr-4">
                         <a href="{{ url('/') }}" class="text-xl font-bold text-gray-800 hover:text-blue-700 transition-colors duration-200">
                            سامانه پشتیبانی انفورماتیک
                        </a>
                        <p class="text-xs text-gray-500">شرکت بهره برداری از شبکه های آبیاری ناحیه شمال خوزستان</p>
                    </div>
                </div>

                <div class="hidden md:flex items-center gap-4">
                    <button onclick="toggleTheme()" class="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 transition focus:outline-none" title="تغییر پوسته">
                        <i id="theme-icon" class="fas fa-moon text-xl"></i>
                    </button>

                    <a href="{{ route('welcome') }}" class="text-gray-700 hover:bg-gray-100 hover:text-blue-700 dark:text-gray-200 dark:hover:bg-gray-700 px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        <i class="fas fa-home ml-1"></i>صفحه اصلی
                    </a>
                </div>

                <div class="flex md:hidden items-center gap-3">
                    <button onclick="toggleTheme()" class="p-2 rounded-full text-gray-500 dark:text-gray-300">
                        <i id="mobile-theme-icon" class="fas fa-moon text-lg"></i>
                    </button>

                    <button type="button" onclick="toggleMobileMenu()" class="bg-transparent inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 focus:outline-none">
                        <span class="sr-only">باز کردن منوی اصلی</span>
                        <i id="mobile-menu-icon" class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="md:hidden hidden mobile-menu-bg bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('welcome') }}" class="text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 block px-3 py-2 rounded-md text-base font-medium">صفحه اصلی</a>
                <a href="{{ route('register') }}" class="text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 block px-3 py-2 rounded-md text-base font-medium">ثبت نام</a>
            </div>
        </div>
    </nav>

    <div class="content-wrapper px-4">
        <div class="login-card max-w-lg w-full" style="margin-top:2rem">
            
            <div class="login-card-header text-center">
                <h1 class="text-2xl font-bold">ورود به سامانه پشتیبانی</h1>
                <p class="text-sm text-blue-100 mt-1">لطفا اطلاعات کاربری خود را وارد نمایید.</p>
            </div>

            <div class="px-8 py-10">
                <form id="loginForm" method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    @if ($errors->any())
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-red-900/50 dark:text-red-300" role="alert">
                            {{ __('auth.failed') }}
                        </div>
                    @endif

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">نام کاربری</label>
                        <div class="relative">
                            <span class="input-icon">
                                <i class="fas fa-user text-gray-400"></i>
                            </span>
                            <input type="text" id="username" name="username" class="form-input w-full" style="border-width: 2px;" placeholder="نام کاربری خود را وارد کنید" required autofocus>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">کلمه عبور</label>
                        </div>
                        <div class="relative">
                            <span class="input-icon">
                                <i class="fas fa-key text-gray-400"></i>
                            </span>
                            <input type="password" id="password" name="password" class="form-input w-full" style="border-width: 2px;" placeholder="کلمه عبور خود را وارد کنید" required>
                            <button type="button" id="togglePassword" class="absolute top-1/2 left-3 rtl:right-auto rtl:left-3 transform -translate-y-1/2 text-gray-500 hover:text-blue-700 focus:outline-none">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" name="remember">
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('مرا به خاطر بسپار') }}</span>
                        </label>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary-custom w-full text-base py-3">
                            <i class="fas fa-sign-in-alt ml-2 rtl:mr-2 rtl:ml-1"></i>ورود
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center text-sm">
                    <p class="text-gray-600 dark:text-gray-400">حساب کاربری ندارید؟
                        <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:underline">
                            ایجاد حساب کاربری جدید
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer-custom text-center py-8">
        <div class="container mx-auto px-6">
            <p class="text-sm mb-1 text-gray-300 opacity-80">
                شرکت بهره برداری از شبکه های آبیاری ناحیه شمال خوزستان
            </p>
            <p class="text-xs text-gray-400 opacity-60">
                تمامی حقوق این سامانه محفوظ است. &copy; {{ date('Y') }}
            </p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Password Visibility Toggle
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.querySelector('i').classList.toggle('fa-eye');
                    this.querySelector('i').classList.toggle('fa-eye-slash');
                });
            }

            // Mobile Menu Toggle
            window.toggleMobileMenu = function() {
                const menu = document.getElementById('mobile-menu');
                const icon = document.getElementById('mobile-menu-icon');
                menu.classList.toggle('hidden');
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            }

            // Theme Toggle Logic
            const themeIcon = document.getElementById('theme-icon');
            const mobileThemeIcon = document.getElementById('mobile-theme-icon');

            function updateIcons(isDark) {
                if (isDark) {
                    if(themeIcon) {
                        themeIcon.classList.remove('fa-moon');
                        themeIcon.classList.add('fa-sun', 'text-yellow-400');
                    }
                    if(mobileThemeIcon) {
                        mobileThemeIcon.classList.remove('fa-moon');
                        mobileThemeIcon.classList.add('fa-sun', 'text-yellow-400');
                    }
                } else {
                    if(themeIcon) {
                        themeIcon.classList.remove('fa-sun', 'text-yellow-400');
                        themeIcon.classList.add('fa-moon');
                    }
                    if(mobileThemeIcon) {
                        mobileThemeIcon.classList.remove('fa-sun', 'text-yellow-400');
                        mobileThemeIcon.classList.add('fa-moon');
                    }
                }
            }

            if (document.documentElement.classList.contains('dark')) {
                updateIcons(true);
            }

            window.toggleTheme = function() {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.theme = 'light';
                    updateIcons(false);
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.theme = 'dark';
                    updateIcons(true);
                }
            }
        });
    </script>
</body>
</html>