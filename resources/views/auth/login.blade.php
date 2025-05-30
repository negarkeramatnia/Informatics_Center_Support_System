<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ورود به سامانه - پشتیبانی انفورماتیک</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />

    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
            background-color: #f8f9fa; /* Consistent light, neutral background */
            color: #343a40;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar-custom {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
        }
        .logo-img-nav {
            max-height: 50px;
        }
        .content-wrapper {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 80px; /* Space for fixed navbar */
            padding-bottom: 40px; /* Space before footer */
        }
        .login-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden; /* To contain rounded corners with header */
        }
        .login-card-header {
            background-color: #0069d9; /* Primary Blue */
            color: white;
            padding: 1.5rem 2rem; /* 24px 32px */
            border-bottom: 1px solid #0056b3;
        }
         .login-card-header .logo-img-card {
            max-height: 60px; /* Slightly larger logo for card header */
            margin-bottom: 0.75rem; /* 12px */
        }
        .form-input {
            border-color: #ced4da;
            padding: 0.75rem 1rem; /* 12px 16px */
            padding-right: 2.75rem; /* Space for icon in RTL */
            border-radius: 8px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .form-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
            outline: 0;
        }
        .input-icon {
            position: absolute;
            top: 50%;
            right: 0.75rem; /* For RTL */
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
        }
        .btn-primary-custom:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0,0,0,0.15);
        }
        .footer-custom {
            background-color: #2c3e50;
            color: #ecf0f1;
            flex-shrink: 0; /* Prevent footer from shrinking */
        }
        .shake {
            animation: shake 0.5s;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
    </style>
</head>
<body>

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
                <div class="hidden md:flex items-center">
                     <a href="{{ route('welcome') }}" class="text-gray-700 hover:bg-gray-100 hover:text-blue-700 px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        <i class="fas fa-home ml-1"></i>صفحه اصلی
                    </a>
                </div>
                <div class="flex md:hidden">
                    <button type="button" onclick="toggleMobileMenu()" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">باز کردن منوی اصلی</span>
                        <i id="mobile-menu-icon" class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('welcome') }}" class="text-gray-700 hover:bg-gray-100 hover:text-blue-700 block px-3 py-2 rounded-md text-base font-medium">صفحه اصلی</a>
                <a href="{{ route('register') }}" class="text-gray-700 hover:bg-gray-100 hover:text-blue-700 block px-3 py-2 rounded-md text-base font-medium">ثبت نام</a>
            </div>
        </div>
    </nav>

    <div class="content-wrapper px-4">
        <div class="login-card max-w-lg w-full">
            <div class="login-card-header text-center">
                 <img class="logo-img-card mx-auto" src="{{ asset('images/company-logo.png') }}" alt="لوگوی شرکت">
                <h1 class="text-2xl font-bold">ورود به سامانه پشتیبانی</h1>
                <p class="text-sm text-blue-100 mt-1">لطفا اطلاعات کاربری خود را وارد نمایید.</p>
            </div>

            <div class="px-8 py-10">
                <form id="loginForm" method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">نام کاربری</label>
                        <div class="relative">
                            <span class="input-icon">
                                <i class="fas fa-user text-gray-400"></i>
                            </span>
                            <input type="text" id="username" name="username"
                                   class="form-input w-full"
                                   placeholder="نام کاربری خود را وارد کنید" required>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">کلمه عبور</label>
                        </div>
                        <div class="relative">
                            <span class="input-icon">
                                <i class="fas fa-key text-gray-400"></i>
                            </span>
                            <input type="password" id="password" name="password"
                                   class="form-input w-full"
                                   placeholder="کلمه عبور خود را وارد کنید" required>
                            <button type="button" id="togglePassword" class="absolute top-1/2 left-3 rtl:right-auto rtl:left-3 transform -translate-y-1/2 text-gray-500 hover:text-blue-700 focus:outline-none">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary-custom w-full text-base py-3">
                            <i class="fas fa-sign-in-alt ml-2 rtl:mr-2 rtl:ml-0"></i>ورود
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center text-sm">
                    <p class="text-gray-600">حساب کاربری ندارید؟
                        <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-800 hover:underline">
                            ایجاد حساب کاربری جدید
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer-custom text-center py-8">
        <div class="container mx-auto px-6">
            <p class="text-sm mb-1 text-gray-300">
                شرکت بهره برداری از شبکه های آبیاری ناحیه شمال خوزستان
            </p>
            <p class="text-xs text-gray-400">
                تمامی حقوق این سامانه محفوظ است. &copy; {{ date('Y') }}
            </p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password'); // Renamed to avoid conflict

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.querySelector('i').classList.toggle('fa-eye');
                    this.querySelector('i').classList.toggle('fa-eye-slash');
                });
            }

            const loginForm = document.getElementById('loginForm');
            if (loginForm) {
                loginForm.addEventListener('submit', function (e) {
                    const usernameInput = document.getElementById('username'); // Renamed
                    const passwordValueInput = document.getElementById('password'); // Renamed

                    if (usernameInput.value.trim() === '' || passwordValueInput.value.trim() === '') {
                        loginForm.classList.add('shake');
                        setTimeout(() => loginForm.classList.remove('shake'), 500);
                        // Consider a more subtle way to show errors than alert,
                        // perhaps by adding a message span below the form.
                        // For now, keeping alert for simplicity as in original.
                        alert('لطفا تمامی فیلدها را پر نمایید.');
                        e.preventDefault();
                    }
                });
            }
        });

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('mobile-menu-icon');
            const button = icon.closest('button');
            const isOpen = menu.classList.toggle('hidden'); // toggle returns true if class is removed (now visible)

            icon.classList.toggle('fa-bars', menu.classList.contains('hidden'));
            icon.classList.toggle('fa-times', !menu.classList.contains('hidden'));
            
            if (button) {
                button.setAttribute('aria-expanded', menu.classList.contains('hidden') ? 'false' : 'true');
            }
        }
    </script>
</body>
</html>