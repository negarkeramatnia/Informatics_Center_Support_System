<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>سامانه پشتیبانی انفورماتیک - شرکت بهره برداری شمال خوزستان</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />

    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
            background-color: #f8f9fa; /* Light, neutral background */
            color: #333;
        }
        .navbar-custom {
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
        }
        .logo-img {
            max-height: 50px; /* Adjust as needed */
        }
        .hero-section {
            background: linear-gradient(to bottom, #005c97, #363795); /* Blue gradient - inspired by water & authority */
            color: #ffffff;
            padding-top: 120px; /* Account for fixed navbar */
        }
        .hero-section h1 {
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
        }
        .card-custom {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #e9ecef;
        }
        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .card-icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        .icon-blue { background-color: rgba(0, 123, 255, 0.1); color: #007bff; } /* Blue from logo water */
        .icon-green { background-color: rgba(40, 167, 69, 0.1); color: #28a745; } /* Green from logo plant */
        .icon-yellow { background-color: rgba(255, 193, 7, 0.1); color: #ffc107; } /* Yellow from logo ring */

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .btn-primary-custom {
            background-color: #007bff; /* Primary Blue */
            color: white;
        }
        .btn-primary-custom:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .btn-secondary-custom {
            background-color: #ffc107; /* Accent Yellow */
            color: #333;
        }
        .btn-secondary-custom:hover {
            background-color: #e0a800;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .section-title-custom {
            position: relative;
            padding-bottom: 1rem;
            margin-bottom: 2.5rem;
        }
        .section-title-custom::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 50%;
            transform: translateX(50%); /* Center the line */
            width: 80px;
            height: 4px;
            background-color: #007bff; /* Primary Blue accent */
            border-radius: 2px;
        }
        .footer-custom {
            background-color: #343a40; /* Dark footer */
            color: #f8f9fa;
        }
        .logo-img{
            margin-left: 1rem;
        }
    </style>
</head>
<body class="antialiased">

    <nav class="navbar-custom fixed w-full z-20 top-0">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex-shrink-0">
                        <img class="logo-img" src="{{ asset('images/company-logo.png') }}" alt="لوگوی شرکت">
                    </a>
                    <div class="hidden md:block mr-4 rtl:ml-4 rtl:mr-0">
                         <a href="{{ url('/') }}" class="text-xl font-bold text-gray-800 hover:text-blue-600">
                            سامانه پشتیبانی انفورماتیک
                        </a>
                        <p class="text-xs text-gray-500">شرکت بهره برداری از شبکه های آبیاری ناحیه شمال خوزستان</p>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        <a href="{{ route('login') }}" class="text-gray-700 hover:bg-gray-100 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-sign-in-alt ml-1 rtl:mr-1 rtl:ml-0"></i>ورود
                        </a>
                        <a href="{{ route('register') }}" class="ml-4 rtl:mr-4 rtl:ml-0 btn btn-primary-custom text-sm">
                            <i class="fas fa-user-plus ml-1 rtl:mr-1 rtl:ml-0"></i>ثبت نام
                        </a>
                    </div>
                </div>
                <div class="-mr-2 flex md:hidden">
                    <button type="button" onclick="toggleMobileMenu()" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('login') }}" class="text-gray-700 hover:bg-gray-100 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">ورود</a>
                <a href="{{ route('register') }}" class="text-gray-700 hover:bg-gray-100 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">ثبت نام</a>
            </div>
        </div>
    </nav>

    <header class="hero-section text-center py-20">
        <div class="container mx-auto px-6">
            <h1 class="text-4xl md:text-5xl font-bold mb-3 mt-16">سامانه درخواست و پشتیبانی مرکز انفورماتیک</h1>
            <h2 class="text-xl md:text-2xl mb-8 text-blue-200 mt-3">شرکت بهره برداری از شبکه های آبیاری ناحیه شمال خوزستان</h2>
            <p class="text-md md:text-lg mb-10 leading-relaxed max-w-2xl mx-auto text-blue-100">
                این سامانه با هدف تسهیل فرآیندهای پشتیبانی و مدیریت درخواست‌های IT برای کارمندان گرامی طراحی شده است.
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center space-y-3 sm:space-y-0 sm:space-x-4 rtl:sm:space-x-reverse">
                <a href="{{ route('login') }}" class="btn btn-primary-custom text-base">
                    <i class="fas fa-sign-in-alt ml-2 rtl:mr-2 rtl:ml-0"></i>ورود به سامانه
                </a>
                <a href="{{ route('register') }}" class="btn btn-secondary-custom text-base">
                    <i class="fas fa-user-plus ml-2 rtl:mr-2 rtl:ml-0"></i>ایجاد حساب کاربری
                </a>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-6 py-16">
        <section class="mb-20">
            <h2 class="section-title-custom text-3xl font-bold text-gray-800 text-center">معرفی سامانه</h2>
             <p class="text-center text-gray-600 leading-relaxed max-w-3xl mx-auto mb-12 text-md">
                این سامانه به کارمندان شرکت بهره برداری از آب و برق ناحیه شمال خوزستان این امکان را میدهد تا درخواستهای خود را به مرکز انفورماتیک ارسال کنند و کارکنان انفورماتیک نیز میتوانند این درخواستها را به سرعت و به طور سازمان یافته مدیریت و حل کنند.
            </p>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="card-custom p-6 text-center md:text-right">
                    <div class="flex justify-center md:justify-start mb-4">
                        <div class="card-icon-wrapper icon-blue">
                            <i class="fas fa-bullseye text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">اهداف پروژه</h3>
                    <ul class="list-none text-gray-600 space-y-2 text-sm">
                        <li><i class="fas fa-check-circle text-green-500 ml-2 rtl:mr-2 rtl:ml-0"></i>کاهش نیاز به مراجعه حضوری و تماس تلفنی</li>
                        <li><i class="fas fa-check-circle text-green-500 ml-2 rtl:mr-2 rtl:ml-0"></i>افزایش سرعت پاسخ‌دهی و بهبود کیفیت خدمات</li>
                        <li><i class="fas fa-check-circle text-green-500 ml-2 rtl:mr-2 rtl:ml-0"></i>بهبود نظم و شفافیت در مدیریت درخواست‌ها</li>
                        <li><i class="fas fa-check-circle text-green-500 ml-2 rtl:mr-2 rtl:ml-0"></i>امکان مدیریت قطعات اختصاص یافته</li>
                        <li><i class="fas fa-check-circle text-green-500 ml-2 rtl:mr-2 rtl:ml-0"></i>امکان ارسال و دریافت پیام‌های مرتبط</li>
                    </ul>
                </div>

                <div class="card-custom p-6 text-center md:text-right">
                     <div class="flex justify-center md:justify-start mb-4">
                        <div class="card-icon-wrapper icon-green">
                            <i class="fas fa-cogs text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">بخش‌های سیستم</h3>
                    <ul class="list-none text-gray-600 space-y-2 text-sm">
                        <li><i class="fas fa-tasks text-blue-500 ml-2 rtl:mr-2 rtl:ml-0"></i>مدیریت درخواست‌ها (ثبت، پیگیری، حل)</li>
                        <li><i class="fas fa-users-cog text-blue-500 ml-2 rtl:mr-2 rtl:ml-0"></i>مدیریت کاربران (نقش‌ها و دسترسی‌ها)</li>
                        <li><i class="fas fa-laptop-code text-blue-500 ml-2 rtl:mr-2 rtl:ml-0"></i>مدیریت قطعات (ثبت و تخصیص)</li>
                        <li><i class="fas fa-comments text-blue-500 ml-2 rtl:mr-2 rtl:ml-0"></i>سیستم پیام‌ها برای هر درخواست</li>
                    </ul>
                </div>

                <div class="card-custom p-6 text-center md:text-right">
                     <div class="flex justify-center md:justify-start mb-4">
                        <div class="card-icon-wrapper icon-yellow">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">کاربران سیستم</h3>
                    <ul class="list-none text-gray-600 space-y-2 text-sm">
                        <li><i class="fas fa-user text-yellow-600 ml-2 rtl:mr-2 rtl:ml-0"></i><strong>کارمندان:</strong> ثبت و پیگیری درخواست‌ها</li>
                        <li><i class="fas fa-user-shield text-yellow-600 ml-2 rtl:mr-2 rtl:ml-0"></i><strong>کارکنان انفورماتیک:</strong> مدیریت درخواست‌ها</li>
                        <li><i class="fas fa-user-tie text-yellow-600 ml-2 rtl:mr-2 rtl:ml-0"></i><strong>مدیر سیستم:</strong> نظارت و مدیریت کلی</li>
                    </ul>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer-custom text-center py-10">
        <div class="container mx-auto px-6">
            <img class="w-20 h-20 mx-auto mb-4" src="{{ asset('images/company-logo.png') }}" alt="لوگوی شرکت">
            <p class="text-sm mb-2">
                شرکت بهره برداری از شبکه های آبیاری ناحیه شمال خوزستان (سهامی خاص) - تاسیس ۱۳۷۰
            </p>
        </div>
    </footer>
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>