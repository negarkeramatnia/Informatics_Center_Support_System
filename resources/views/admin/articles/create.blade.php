<x-app-layout>
    {{-- PREMIUM HEADER REDESIGN --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center w-full gap-4">
            
            <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight flex items-center gap-2">
                <i class="fas fa-pen-nib text-blue-500"></i>
                {{ __('افزودن مقاله جدید') }}
            </h2>
            
            <a href="{{ route('admin.articles.index') }}" class="group flex items-center gap-2 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 px-5 py-2.5 rounded-xl font-medium transition-all duration-300 border border-gray-200 dark:border-slate-600 hover:-translate-y-0.5">
                <i class="fas fa-arrow-right transition-transform group-hover:-translate-x-1"></i>
                <span>بازگشت به لیست مقالات</span>
            </a>

        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- CREATE ARTICLE FORM --}}
            <form method="POST" action="{{ route('admin.articles.store') }}" class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 p-6 md:p-8 transition-colors duration-300">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">عنوان مقاله <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="مثال: راهنمای تنظیمات پرینتر" class="w-full text-sm border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all py-3">
                        @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">دسته‌بندی <span class="text-red-500">*</span></label>
                        <select name="category" id="category" required class="w-full text-sm border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all py-3">
                            <option value="">انتخاب کنید...</option>
                            <option value="hardware" {{ old('category') == 'hardware' ? 'selected' : '' }}>سخت‌افزار (Hardware)</option>
                            <option value="software" {{ old('category') == 'software' ? 'selected' : '' }}>نرم‌افزار (Software)</option>
                            <option value="network" {{ old('category') == 'network' ? 'selected' : '' }}>شبکه و اینترنت (Network)</option>
                            <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>عمومی (General)</option>
                        </select>
                        @error('category') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

<div>
                        <label for="is_published" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">وضعیت انتشار <span class="text-red-500">*</span></label>
                        <select name="is_published" id="is_published" required class="w-full text-sm border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all py-3">
                            <option value="1" {{ old('is_published', '1') == '1' ? 'selected' : '' }}>منتشر شده (قابل مشاهده برای همه)</option>
                            <option value="0" {{ old('is_published') == '0' ? 'selected' : '' }}>پیش‌نویس (فقط شما می‌بینید)</option>
                        </select>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">اگر مقاله هنوز کامل نیست، آن را روی پیش‌نویس قرار دهید.</p>
                        @error('is_published') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2 mt-4">
                        <label for="content" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">متن مقاله <span class="text-red-500">*</span></label>
                        <textarea name="content" id="content" rows="12" required placeholder="محتوای آموزشی خود را اینجا بنویسید..." class="w-full text-sm border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all p-4 leading-relaxed">{{ old('content') }}</textarea>
                        @error('content') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                </div>

                <div class="flex justify-end pt-4 border-t border-gray-100 dark:border-slate-700 mt-6">
                    <button type="submit" class="group flex items-center justify-center gap-2 w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold transition-all duration-300 shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5">
                        <i class="fas fa-save"></i>
                        <span>ذخیره مقاله</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>