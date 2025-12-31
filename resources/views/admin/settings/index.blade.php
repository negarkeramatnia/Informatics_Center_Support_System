<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('تنظیمات سیستم') }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('admin.settings.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- Card 1: Departments --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center mb-4 text-blue-600">
                            <i class="fas fa-building ml-2 text-xl"></i>
                            <h3 class="text-lg font-bold text-gray-800">مدیریت واحدها (دپارتمان‌ها)</h3>
                        </div>
                        <p class="text-sm text-gray-500 mb-4">
                            لیست واحدهای سازمانی را وارد کنید. هر واحد را در یک <strong>خط جدید</strong> بنویسید.
                            این لیست در فرم‌های ثبت کاربر و ثبت قطعات نمایش داده می‌شود.
                        </p>
                        <textarea name="departments" rows="10" class="form-input-custom w-full font-medium" placeholder="مثال:&#10;فناوری اطلاعات&#10;مالی&#10;اداری">{{ $departments }}</textarea>
                    </div>

                    {{-- Card 2: Ticket Categories --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center mb-4 text-green-600">
                            <i class="fas fa-tags ml-2 text-xl"></i>
                            <h3 class="text-lg font-bold text-gray-800">دسته‌بندی‌های تیکت</h3>
                        </div>
                        <p class="text-sm text-gray-500 mb-4">
                            دسته‌بندی‌های فنی برای تیکت‌ها (مانند network, hardware). هر مورد در یک <strong>خط جدید</strong>.
                            <br><span class="text-xs text-red-500">* بهتر است از حروف انگلیسی استفاده کنید.</span>
                        </p>
                        <textarea name="ticket_categories" rows="10" class="form-input-custom w-full font-mono text-sm" placeholder="software&#10;hardware">{{ $categories }}</textarea>
                    </div>

                </div>

                {{-- Save Button --}}
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="btn-primary-custom py-3 px-8 text-lg shadow-lg transform hover:-translate-y-1 transition">
                        <i class="fas fa-save ml-2"></i> ذخیره تنظیمات
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>