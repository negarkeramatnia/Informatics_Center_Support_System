<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ایجاد حساب کاربری - سامانه پشتیبانی انفورماتیک</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />

    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
            background-color: #f8f9fa;
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
            padding-top: 100px; /* Space for fixed navbar, slightly less than login for longer form */
            padding-bottom: 40px;
        }
        .register-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 2rem; /* Add some top margin for very long forms on small screens */
            margin-bottom: 2rem;
        }
        .register-card-header {
            background-color: #0069d9; /* Primary Blue */
            color: white;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #0056b3;
        }
        .register-card-header .logo-img-card {
            max-height: 60px;
            margin-bottom: 0.75rem;
        }
        .form-input, .form-select, .form-file-input {
            border-width: 1px; /* Explicitly set border width */
            border-color: #ced4da;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            width: 100%; /* Ensure full width */
            background-color: #fff; /* Ensure white background for inputs */
        }
        .form-input:focus, .form-select:focus, .form-file-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
            outline: 0;
        }
        /* Custom styling for file input to make it look more like other inputs */
        .form-file-input::file-selector-button {
            padding: 0.5rem 1rem;
            margin-right: -1rem; /* Adjust for RTL */
            margin-left: 1rem;  /* Adjust for RTL */
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-top-right-radius: 0.5rem; /* Match parent for RTL */
            border-bottom-right-radius: 0.5rem; /* Match parent for RTL */
            border: 1px solid #ced4da;
            border-left-width: 1px; /* Add border to button for RTL */
            border-right-width: 0;
            background-color: #e9ecef;
            color: #495057;
            font-weight: 500;
            cursor: pointer;
            transition: background-color .15s ease-in-out,border-color .15s ease-in-out;
        }
        .form-file-input::file-selector-button:hover {
            background-color: #dde1e5;
        }
        .form-label {
            display: block;
            font-size: 0.875rem; /* 14px */
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem; /* 8px */
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
            flex-shrink: 0;
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
                     <a href="{{ route('login') }}" class="text-gray-700 hover:bg-gray-100 hover:text-blue-700 px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200 mr-2">
                        <i class="fas fa-sign-in-alt ml-1"></i>ورود
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
                <a href="{{ route('login') }}" class="text-gray-700 hover:bg-gray-100 hover:text-blue-700 block px-3 py-2 rounded-md text-base font-medium">ورود</a>
            </div>
        </div>
    </nav>

    <div class="content-wrapper px-4">
        <div class="register-card max-w-xl w-full"> <div class="register-card-header text-center">
                 <img class="logo-img-card mx-auto" src="{{ asset('images/company-logo.png') }}" alt="لوگوی شرکت">
                <h1 class="text-2xl font-bold mt-2">ایجاد حساب کاربری جدید</h1>
                <p class="text-sm text-blue-100 mt-1">اطلاعات خود را برای عضویت در سامانه وارد نمایید.</p>
            </div>

            <div class="px-8 py-10">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="form-label">نام و نام خانوادگی</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="form-input" placeholder="مثال: علی محمدی">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="username" class="form-label">نام کاربری (انگلیسی)</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" required
                               class="form-input ltr" placeholder="مثال: alimohammadi">
                        @error('username') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="form-label">آدرس ایمیل</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="form-input ltr" placeholder="مثال: user@example.com">
                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="phone" class="form-label">شماره تلفن (اختیاری)</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                               class="form-input ltr" placeholder="مثال: 09123456789">
                        @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="role" class="form-label">نقش کاربری</label>
                        <select name="role" id="role" required class="form-select">
                            <option value="user" @if(old('role') == 'user') selected @endif>کاربر عادی (جهت ثبت درخواست)</option>
                            <option value="support" @if(old('role') == 'support') selected @endif>پشتیبان (کارمند انفورماتیک)</option>
                            <option value="admin" @if(old('role') == 'admin') selected @endif>مدیر سیستم</option>
                        </select>
                        @error('role') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="profile_picture" class="form-label">تصویر پروفایل (اختیاری)</label>
                        <input type="file" id="profile_picture" name="profile_picture"
                               class="form-file-input text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @error('profile_picture') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="form-label">کلمه عبور</label>
                            <input type="password" id="password" name="password" required
                                   class="form-input ltr" placeholder="حداقل ۶ کاراکتر">
                            @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="form-label">تکرار کلمه عبور</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   class="form-input ltr" placeholder="کلمه عبور را تکرار کنید">
                        </div>
                    </div>
                    
                    <div>
                        <button type="submit" class="btn btn-primary-custom w-full text-base py-3 mt-2">
                            <i class="fas fa-user-plus ml-2 rtl:mr-2 rtl:ml-0"></i>ایجاد حساب کاربری
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center text-sm">
                    <p class="text-gray-600">قبلاً ثبت نام کرده‌اید؟
                        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-800 hover:underline">
                            وارد شوید
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
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('mobile-menu-icon');
            const button = icon.closest('button'); // Get the button that contains the icon
            
            menu.classList.toggle('hidden');
            const isHidden = menu.classList.contains('hidden');
            
            icon.classList.toggle('fa-bars', isHidden);
            icon.classList.toggle('fa-times', !isHidden);
            
            if (button) {
                button.setAttribute('aria-expanded', !isHidden);
            }
        }
    </script>
</body>
</html>