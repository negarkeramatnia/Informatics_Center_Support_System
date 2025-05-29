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
            background-color: #f4f7f6; /* Light gray background for a softer look */
        }
        .hero-gradient {
            background: linear-gradient(135deg, #4A00E0 0%, #8E2DE2 100%); /* Professional purple gradient */
        }
        .card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        }
        .card-icon {
            background-color: rgba(74, 0, 224, 0.1); /* Light purple tint for icon background */
            color: #4A00E0; /* Main purple for icon color */
        }
        .btn-primary {
            background-color: #4A00E0; /* Main purple */
            border-color: #4A00E0;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #3a00b3; /* Darker purple on hover */
            transform: translateY(-2px);
        }
        .btn-secondary {
            background-color: #6c757d; /* Neutral gray */
            border-color: #6c757d;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }
        .section-title {
            position: relative;
            padding-bottom: 0.75rem; /* 12px */
            margin-bottom: 1.5rem; /* 24px */
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0; /* For RTL */
            width: 50px;
            height: 3px;
            background-color: #4A00E0; /* Main purple accent */
            border-radius: 2px;
        }
    </style>
</head>
<body class="antialiased">

    <nav class="bg-white shadow-md fixed w-full z-10 top-0">
        <div class="container mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-headset text-2xl text-indigo-600 mr-2 rtl:ml-2 rtl:mr-0"></i>
                <a class="text-xl font-semibold text-gray-700 hover:text-indigo-600" href="{{ url('/') }}">
                    سامانه پشتیبانی انفورماتیک
                </a>
            </div>
            <div class="flex items-center">
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 mx-2 px-3 py-2 rounded-md text-sm font-medium">
                    <i class="fas fa-sign-in-alt ml-1 rtl:mr-1 rtl:ml-0"></i>ورود
                </a>
                <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white mx-2 px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                    <i class="fas fa-user-plus ml-1 rtl:mr-1 rtl:ml-0"></i>ثبت نام
                </a>
            </div>
        </div>
    </nav>

    <header class="hero-gradient text-white pt-32 pb-20 text-center">
        <div class="container mx-auto px-6">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
                به سامانه یکپارچه درخواست و پشتیبانی خوش آمدید
            </h1>
            <p class="text-lg md:text-xl mb-8 text-indigo-100 leading-relaxed max-w-2xl mx-auto">
                مرکز انفورماتیک شرکت بهره برداری از آب و برق ناحیه شمال خوزستان
                <br>
                راهکاری نوین برای مدیریت کارآمد درخواست‌های شما
            </p>
            <div class="flex justify-center space-x-4 rtl:space-x-reverse">
                <a href="{{ route('login') }}" class="btn-primary text-white font-semibold py-3 px-8 rounded-lg shadow-lg text-lg">
                    ورود به سامانه
                </a>
                <a href="{{ route('register') }}" class="bg-white text-indigo-600 font-semibold py-3 px-8 rounded-lg shadow-lg text-lg hover:bg-gray-100 transition duration-300">
                    ایجاد حساب کاربری
                </a>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-6 py-16">
        <section class="mb-16">
            <h2 class="section-title text-3xl font-bold text-gray-800 mb-10 text-center">چرا از این سامانه استفاده کنیم؟</h2>
            <p class="text-center text-gray-600 leading-relaxed max-w-3xl mx-auto mb-12 text-lg">
                این سیستم به منظور تعریف نیازها، اهداف و محدوده پروژه سیستم درخواست و پشتیبانی مرکز انفورماتیک تهیه شده است. هدف ما افزایش سرعت پاسخ‌دهی، بهبود کیفیت خدمات و ایجاد شفافیت در مدیریت درخواست‌ها و منابع می‌باشد.
            </p>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="card p-6">
                    <div class="flex items-center mb-4">
                        <div class="card-icon p-3 rounded-full mr-4 rtl:ml-4 rtl:mr-0">
                            <i class="fas fa-bullseye text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-700">اهداف کلیدی سامانه</h3>
                    </div>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 text-sm">
                        <li>کاهش مراجعات حضوری و تماس‌های تلفنی</li>
                        <li>افزایش سرعت و کیفیت خدمات پشتیبانی</li>
                        <li>بهبود نظم و شفافیت در مدیریت درخواست‌ها</li>
                        <li>مدیریت متمرکز قطعات و منابع</li>
                        <li>ارتباط آسان و مستند برای هر درخواست</li>
                    </ul>
                </div>

                <div class="card p-6">
                    <div class="flex items-center mb-4">
                        <div class="card-icon p-3 rounded-full mr-4 rtl:ml-4 rtl:mr-0">
                            <i class="fas fa-cogs text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-700">امکانات و بخش‌های اصلی</h3>
                    </div>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 text-sm">
                        <li>ثبت، پیگیری و حل مکانیزه درخواست‌ها</li>
                        <li>مدیریت جامع کاربران با سطوح دسترسی</li>
                        <li>ثبت، تخصیص و پیگیری وضعیت قطعات</li>
                        <li>سیستم پیام‌رسان داخلی برای هر تیکت</li>
                        <li>گزارش‌گیری و تحلیل عملکرد (برای مدیران)</li>
                    </ul>
                </div>

                <div class="card p-6">
                    <div class="flex items-center mb-4">
                        <div class="card-icon p-3 rounded-full mr-4 rtl:ml-4 rtl:mr-0">
                            <i class="fas fa-users-cog text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-700">نقش کاربران در سیستم</h3>
                    </div>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 text-sm">
                        <li><strong>کارمندان:</strong> ثبت درخواست و پیگیری وضعیت</li>
                        <li><strong>کارکنان انفورماتیک:</strong> مدیریت، اولویت‌بندی و پاسخ به درخواست‌ها</li>
                        <li><strong>مدیر سیستم:</strong> نظارت کامل، مدیریت کاربران و تنظیمات کلی</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="text-center py-12 bg-gray-100 rounded-xl">
             <h2 class="section-title text-2xl font-bold text-gray-800 mb-6 inline-block">آماده شروع هستید؟</h2>
            <p class="text-gray-600 mb-8 max-w-xl mx-auto">
                با ورود یا ثبت‌نام در سامانه، به جمع کاربران ما بپیوندید و از خدمات پشتیبانی انفورماتیک به شکلی نوین بهره‌مند شوید
            </p>
            <div class="flex justify-center space-x-4 rtl:space-x-reverse">
                 <a href="{{ route('login') }}" class="btn-primary text-white font-semibold py-3 px-8 rounded-lg shadow-lg text-lg">
                    ورود
                </a>
                <a href="{{ route('register') }}" class="btn-secondary text-white font-semibold py-3 px-8 rounded-lg shadow-lg text-lg">
                    ثبت نام
                </a>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white text-center py-8">
        <div class="container mx-auto px-6">
            <p class="text-sm">
                تمامی حقوق این سامانه متعلق به شرکت بهره برداری از آب و برق ناحیه شمال خوزستان می‌باشد.
            </p>
        </div>
    </footer>

</body>
</html>