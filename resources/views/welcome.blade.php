<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>سامانه پشتیبانی انفورماتیک</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />

    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            scroll-behavior: smooth;
        }
        .navbar-custom {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
        }
        .logo-img-nav {
            max-height: 50px;
        }
        .hero-section {
            background: linear-gradient(135deg, #005c97 0%, #1e3a8a 100%);
            color: #ffffff;
            padding-top: 140px;
            padding-bottom: 80px;
        }
        .hero-section h1 {
            text-shadow: 0 2px 4px rgba(0,0,0,0.25);
        }
        .card-custom {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.07);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #e9ecef;
            display: flex;
            flex-direction: column;
        }
        .card-custom:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .card-content-wrapper {
            flex-grow: 1;
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
            line-height: 1.5;
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
        .btn-secondary-custom {
            background-color: #ffc107;
            color: #212529;
        }
        .btn-secondary-custom:hover {
            background-color: #e0a800;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0,0,0,0.15);
        }
        .section-title-custom {
            position: relative;
            padding-bottom: 0.75rem;
            margin-bottom: 2rem;
            display: inline-block;
        }
        .section-title-custom::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 3px;
            background-color: #0069d9;
            border-radius: 3px;
        }
        .footer-custom {
            background-color: #2c3e50;
            color: #ecf0f1;
        }
        .card-list-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 0.5rem;
        }
        .card-list-item i {
            margin-left: 0.5rem;
            flex-shrink: 0;
            margin-top: 0.25rem;
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
                <div class="hidden md:flex items-center">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:bg-gray-100 hover:text-blue-700 px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        <i class="fas fa-sign-in-alt ml-2"></i>ورود
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary-custom text-sm mr-3">
                        <i class="fas fa-user-plus ml-2"></i>ثبت نام
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
                <a href="{{ route('login') }}" class="text-gray-700 hover:bg-gray-100 hover:text-blue-700 block px-3 py-2 rounded-md text-base font-medium">ورود</a>
                <a href="{{ route('register') }}" class="text-gray-700 hover:bg-gray-100 hover:text-blue-700 block px-3 py-2 rounded-md text-base font-medium">ثبت نام</a>
            </div>
        </div>
    </nav>

    <header class="hero-section text-center">
        <div class="container mx-auto px-6">
            <img class="w-28 h-28 mx-auto mb-6 shadow-lg rounded-full border-4 border-white border-opacity-50" src="{{ asset('images/company-logo.png') }}" alt="لوگوی شرکت بهره برداری شمال خوزستان">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold mb-4">سامانه درخواست و پشتیبانی</h1>
            <h2 class="text-xl sm:text-2xl md:text-3xl mb-8 font-light text-blue-100">مرکز انفورماتیک شرکت بهره برداری از شبکه های آبیاری ناحیه شمال خوزستان</h2>
            <p class="text-lg mb-10 leading-relaxed max-w-3xl mx-auto text-blue-50">
                راهکاری مدرن و یکپارچه برای ارسال، پیگیری و مدیریت درخواست‌های IT شما، با هدف افزایش بهره‌وری و ارائه خدمات بهتر.
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-5 rtl:sm:space-x-reverse">
                <a href="{{ route('login') }}" class="btn btn-primary-custom text-lg px-10 py-3">
                    <i class="fas fa-sign-in-alt ml-2"></i>ورود به سامانه
                </a>
                <a href="{{ route('register') }}" class="btn btn-secondary-custom text-lg px-10 py-3">
                    <i class="fas fa-user-plus ml-2"></i>ایجاد حساب کاربری
                </a>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <section id="about-system" class="mb-20 text-center">
            <h2 class="section-title-custom text-3xl font-bold text-gray-800">معرفی سامانه</h2>
             <p class="text-gray-700 leading-loose max-w-3xl mx-auto mb-12 text-lg">
                این سیستم به منظور تعریف نیازها، اهداف و محدوده پروژه سیستم درخواست و پشتیبانی مرکز انفورماتیک تهیه شده است. این سیستم به کارمندان شرکت بهره برداری از آب و برق ناحیه شمال خوزستان این امکان را میدهد تا درخواستهای خود را به مرکز انفورماتیک ارسال کنند و کارکنان انفورماتیک نیز میتوانند این درخواستها را به سرعت و به طور سازمان یافته مدیریت و حل کنند.
            </p>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="card-custom p-6">
                    <div class="flex justify-center md:justify-start mb-5">
                        <div class="card-icon-wrapper icon-blue w-16 h-16">
                            <i class="fas fa-bullseye text-3xl"></i>
                        </div>
                    </div>
                    <div class="card-content-wrapper">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 text-center md:text-right">اهداف سامانه</h3>
                        <ul class="text-gray-600 space-y-2 text-sm text-right">
                            <li class="card-list-item"><i class="fas fa-check-circle text-blue-500"></i>کاهش نیاز به مراجعه حضوری و تماس تلفنی</li>
                            <li class="card-list-item"><i class="fas fa-check-circle text-blue-500"></i>افزایش سرعت پاسخ‌دهی و بهبود کیفیت خدمات</li>
                            <li class="card-list-item"><i class="fas fa-check-circle text-blue-500"></i>بهبود نظم و شفافیت در مدیریت درخواست‌ها</li>
                            <li class="card-list-item"><i class="fas fa-check-circle text-blue-500"></i>امکان مدیریت قطعات اختصاص یافته به کارمندان</li>
                            <li class="card-list-item"><i class="fas fa-check-circle text-blue-500"></i>امکان ارسال و دریافت پیام‌های مرتبط با هر درخواست</li>
                        </ul>
                    </div>
                </div>

                <div class="card-custom p-6">
                     <div class="flex justify-center md:justify-start mb-5">
                        <div class="card-icon-wrapper icon-green w-16 h-16">
                            <i class="fas fa-cogs text-3xl"></i>
                        </div>
                    </div>
                    <div class="card-content-wrapper">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 text-center md:text-right">بخش‌های سیستم</h3>
                        <ul class="text-gray-600 space-y-2 text-sm text-right">
                            <li class="card-list-item"><i class="fas fa-tasks text-green-500"></i>مدیریت درخواست‌ها (ثبت، پیگیری، حل)</li>
                            <li class="card-list-item"><i class="fas fa-users-cog text-green-500"></i>مدیریت کاربران (نقش‌ها و دسترسی‌ها)</li>
                            <li class="card-list-item"><i class="fas fa-laptop-code text-green-500"></i>مدیریت قطعات (ثبت و تخصیص)</li>
                            <li class="card-list-item"><i class="fas fa-comments text-green-500"></i>سیستم پیام‌ها برای هر درخواست</li>
                        </ul>
                    </div>
                </div>

                <div class="card-custom p-6">
                     <div class="flex justify-center md:justify-start mb-5">
                        <div class="card-icon-wrapper icon-yellow w-16 h-16">
                            <i class="fas fa-users text-3xl"></i>
                        </div>
                    </div>
                    <div class="card-content-wrapper">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 text-center md:text-right">کاربران سیستم</h3>
                        <ul class="text-gray-600 space-y-2 text-sm text-right">
                            <li class="card-list-item"><i class="fas fa-user text-yellow-500"></i><strong>کارمندان:</strong> ثبت و پیگیری درخواست‌ها</li>
                            <li class="card-list-item"><i class="fas fa-user-shield text-yellow-500"></i><strong>کارکنان انفورماتیک:</strong> مدیریت و پاسخ به درخواست‌ها</li>
                            <li class="card-list-item"><i class="fas fa-user-tie text-yellow-500"></i><strong>مدیر سیستم:</strong> نظارت و مدیریت کلی</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer-custom text-center py-12">
        <div class="container mx-auto px-6">
            <img class="w-24 h-24 mx-auto mb-5 rounded-full shadow-md" src="{{ asset('images/company-logo.png') }}" alt="لوگوی شرکت">
            <p class="text-sm mb-2 text-gray-300">
                شرکت بهره برداری از شبکه های آبیاری ناحیه شمال خوزستان (سهامی خاص) - تاسیس ۱۳۷۰
            </p>
             <p class="text-xs text-gray-500 mt-2">
                تمامی حقوق این سامانه برای شرکت مذکور محفوظ است. &copy; {{ date('Y') }}
            </p>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('mobile-menu-icon');
            const isOpen = !menu.classList.contains('hidden');
            menu.classList.toggle('hidden');
            icon.classList.toggle('fa-bars', isOpen);
            icon.classList.toggle('fa-times', !isOpen);
            const button = menu.previousElementSibling;
             if (button) {
                button.setAttribute('aria-expanded', !isOpen);
            }
        }
    </script>
</body>
</html>