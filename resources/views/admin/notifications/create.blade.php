<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ارسال اعلان عمومی') }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="bg-blue-50 border-r-4 border-blue-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0"><i class="fas fa-info-circle text-blue-500"></i></div>
                        <div class="mr-3">
                            <p class="text-sm text-blue-700">
                                این پیام برای <strong>همه کاربران سیستم</strong> (کارمندان، پشتیبان‌ها و مدیران) ارسال خواهد شد.
                            </p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.notifications.send') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">عنوان اعلان</label>
                        <input type="text" name="title" class="form-input-custom w-full" placeholder="مثال: جلسه مهم، قطعی سیستم..." required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">متن پیام</label>
                        <textarea name="message" rows="4" class="form-input-custom w-full" placeholder="جزئیات را اینجا بنویسید..." required></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow flex items-center">
                            <i class="fas fa-bullhorn ml-2"></i>
                            ارسال همگانی
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>