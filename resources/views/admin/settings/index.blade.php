<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('تنظیمات کلی سیستم') }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">تنظیمات عمومی</h3>
                    <p class="mt-1 text-sm text-gray-600 mb-6">تغییرات کلی مربوط به عملکرد و نمایش سیستم را در اینجا اعمال کنید.</p>
                    
                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        {{-- Placeholder for Site Name --}}
                        <div>
                            <label for="site_name" class="block font-medium text-sm text-gray-700">عنوان سایت</label>
                            <input id="site_name" type="text" class="form-input-custom mt-1" value="{{ config('app.name') }}">
                        </div>

                        {{-- Placeholder for Maintenance Mode --}}
                        <div>
                            <label for="maintenance_mode" class="flex items-center">
                                <input type="checkbox" id="maintenance_mode" class="rounded border-gray-300 text-pink-600 shadow-sm focus:ring-pink-500">
                                <span class="mr-2 text-sm text-gray-600">فعال‌سازی حالت تعمیر و نگهداری</span>
                            </label>
                        </div>
                        
                        <div class="flex justify-end pt-6 border-t border-gray-200">
                            <button type="submit" class="btn-primary-custom">
                                ذخیره تغییرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
