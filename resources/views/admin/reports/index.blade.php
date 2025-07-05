<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('گزارش‌های عملکرد') }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center text-gray-600">
                    <i class="fas fa-chart-pie text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-bold">بخش گزارش‌ها</h3>
                    <p class="mt-2">این بخش برای نمایش نمودارها و گزارش‌های مربوط به عملکرد سیستم، زمان پاسخگویی و رضایت کاربران در حال توسعه است.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
