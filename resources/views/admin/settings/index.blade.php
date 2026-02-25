<x-app-layout>
    @section('title', 'تنظیمات سیستم')

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center">
                    <i class="fas fa-cogs text-emerald-600 dark:text-emerald-400 text-lg"></i>
                </div>
                <h2 class="font-black text-xl text-gray-900 dark:text-white leading-tight">
                    تنظیمات سیستم
                </h2>
            </div>
            
<a href="{{ route('dashboard') }}" class="flex items-center gap-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300 px-5 py-2.5 rounded-xl font-bold transition-all shadow-sm">
                بازگشت<i class="fas fa-arrow-left text-sm"></i>
            </a>
        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- GLOBAL ALERTS --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-6 py-4 rounded-2xl font-bold flex items-center gap-3">
                    <i class="fas fa-check-circle text-xl"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-6 py-4 rounded-2xl font-bold flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle text-xl"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ url('/admin/settings') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    {{-- CARD 1: Departments --}}
                    <div class="bg-white dark:bg-slate-800 shadow-sm rounded-3xl border border-gray-100 dark:border-slate-700 overflow-hidden flex flex-col transition-colors">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-blue-50/50 dark:bg-blue-900/10 flex items-center gap-3">
                            <i class="fas fa-building text-blue-500 text-xl"></i>
                            <h3 class="font-black text-gray-800 dark:text-white text-lg">مدیریت واحدها (دپارتمان‌ها)</h3>
                        </div>
                        <div class="p-6 flex-grow flex flex-col">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                                لیست واحدهای سازمانی را وارد کنید. هر واحد را در یک خط جدید بنویسید. این لیست در فرم‌های ثبت کاربر و ثبت قطعات نمایش داده می‌شود.
                            </p>
                            <textarea name="departments" rows="10" required
                                      class="w-full flex-grow bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-600 text-gray-900 dark:text-white rounded-xl p-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors custom-scrollbar resize-none leading-loose placeholder-gray-400 dark:placeholder-gray-600" 
                                      placeholder="مدیریت&#10;فناوری اطلاعات&#10;منابع انسانی&#10;مالی&#10;حراست">{{ old('departments', $departments ?? '') }}</textarea>
                            @error('departments') <span class="text-red-500 text-xs mt-2 block font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- CARD 2: Ticket Categories (FIXED: Now perfectly matches Departments layout) --}}
                    <div class="bg-white dark:bg-slate-800 shadow-sm rounded-3xl border border-gray-100 dark:border-slate-700 overflow-hidden flex flex-col transition-colors">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-emerald-50/50 dark:bg-emerald-900/10 flex items-center gap-3">
                            <i class="fas fa-tags text-emerald-500 text-xl"></i>
                            <h3 class="font-black text-gray-800 dark:text-white text-lg">دسته‌بندی‌های تیکت</h3>
                        </div>
                        <div class="p-6 flex-grow flex flex-col">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                                لیست دسته‌بندی‌های موضوعی برای تیکت‌ها را وارد کنید. هر دسته را در یک خط جدید بنویسید. این لیست هنگام ثبت تیکت جدید به کاربران نمایش داده می‌شود.
                            </p>
                            <textarea name="ticket_categories" rows="10" required
                                      class="w-full flex-grow bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-600 text-gray-900 dark:text-white rounded-xl p-4 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors custom-scrollbar resize-none leading-loose placeholder-gray-400 dark:placeholder-gray-600" 
                                      placeholder="نرم‌افزار&#10;سخت‌افزار&#10;شبکه و اینترنت&#10;دسترسی و اکانت&#10;سایر موارد">{{ old('ticket_categories', $ticketCategories ?? '') }}</textarea>
                            @error('ticket_categories') <span class="text-red-500 text-xs mt-2 block font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                </div>

                {{-- Unified Action Footer --}}
                <div class="mt-8 bg-white dark:bg-slate-800 shadow-sm rounded-2xl border border-gray-100 dark:border-slate-700 p-4 flex items-center justify-end transition-colors">
                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-3.5 rounded-xl font-black transition-all shadow-lg shadow-emerald-500/30 flex items-center gap-2 hover:-translate-y-0.5">
                        <i class="fas fa-save"></i> ذخیره تنظیمات سیستم
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>