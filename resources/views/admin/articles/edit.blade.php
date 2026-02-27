<x-app-layout>
    @section('title', 'ویرایش مقاله')

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center">
                    <i class="fas fa-book-open text-blue-600 dark:text-blue-400 text-lg"></i>
                </div>
                <h2 class="font-black text-xl text-gray-900 dark:text-white leading-tight">
                    ویرایش مقاله
                </h2>
            </div>
            
            {{-- THE BACK BUTTON --}}
            <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300 px-5 py-2.5 rounded-xl font-bold transition-all shadow-sm">
                بازگشت <i class="fas fa-arrow-left text-sm"></i>
            </a>
        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
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

            <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" class="bg-white dark:bg-slate-800 shadow-sm rounded-3xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
                @csrf
                @method('PUT')

                {{-- Form Header --}}
                <div class="px-8 py-5 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 flex justify-between items-center">
                    <h3 class="font-black text-gray-800 dark:text-white flex items-center gap-2 text-lg">
                        <i class="fas fa-edit text-blue-500"></i> محتوای مقاله پایگاه دانش
                    </h3>
                </div>

                {{-- Form Body (6-Column Grid) --}}
                <div class="p-8 grid grid-cols-1 md:grid-cols-6 gap-6">
                    
                    {{-- Title (4 Columns Wide) --}}
                    <div class="col-span-1 md:col-span-4">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">عنوان مقاله <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $article->title) }}" required
                               class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder-gray-400 dark:placeholder-gray-500">
                        @error('title') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Category (2 Columns Wide) --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">دسته‌بندی <span class="text-red-500">*</span></label>
                        {{-- Make sure the name matches your DB, like 'category' or 'category_id' --}}
                        <select name="category" required class="w-full bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="" disabled>-- انتخاب دسته‌بندی --</option>
                            <option value="عمومی" @selected(old('category', $article->category) === 'عمومی')>عمومی</option>
                            <option value="فنی" @selected(old('category', $article->category) === 'فنی')>فنی</option>
                            <option value="آموزش" @selected(old('category', $article->category) === 'آموزش')>آموزش</option>
                        </select>
                        @error('category') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- PREMIUM REDESIGN: Publication Status Cards (Full Width) --}}
                    <div class="col-span-1 md:col-span-6 bg-gray-50/50 dark:bg-slate-900/30 p-6 rounded-2xl border border-gray-100 dark:border-slate-700">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-4">وضعیت انتشار مقاله <span class="text-red-500">*</span></label>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            
                            {{-- Option 1: Published --}}
                            <label class="relative flex-1 cursor-pointer">
                                {{-- Assuming your DB field is a boolean named 'is_published' --}}
                                <input type="radio" name="is_published" value="1" class="peer sr-only" @checked(old('is_published', $article->is_published) == 1)>
                                <div class="flex items-center gap-4 p-5 border-2 border-transparent bg-white dark:bg-slate-800 shadow-sm rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900/20">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 dark:border-slate-500 flex items-center justify-center bg-white dark:bg-slate-800 peer-checked:border-blue-500">
                                        <div class="w-3 h-3 bg-blue-500 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                    </div>
                                    <div>
                                        <span class="block font-black text-gray-900 dark:text-white text-base mb-1">
                                            <i class="fas fa-globe text-blue-500 ml-1"></i> منتشر شده (عمومی)
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">قابل مشاهده برای تمامی کاربران در پایگاه دانش.</span>
                                    </div>
                                </div>
                            </label>

                            {{-- Option 2: Draft --}}
                            <label class="relative flex-1 cursor-pointer">
                                <input type="radio" name="is_published" value="0" class="peer sr-only" @checked(old('is_published', $article->is_published) == 0)>
                                <div class="flex items-center gap-4 p-5 border-2 border-transparent bg-white dark:bg-slate-800 shadow-sm rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-all peer-checked:border-orange-500 peer-checked:bg-orange-50 dark:peer-checked:border-orange-500 dark:peer-checked:bg-orange-900/20">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 dark:border-slate-500 flex items-center justify-center bg-white dark:bg-slate-800 peer-checked:border-orange-500">
                                        <div class="w-3 h-3 bg-orange-500 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                    </div>
                                    <div>
                                        <span class="block font-black text-gray-900 dark:text-white text-base mb-1">
                                            <i class="fas fa-file-signature text-orange-500 ml-1"></i> پیش‌نویس (مخفی)
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">ذخیره در سیستم. کاربران عادی آن را نمی‌بینند.</span>
                                    </div>
                                </div>
                            </label>

                        </div>
                        @error('is_published') <span class="text-red-500 text-xs mt-2 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Content (Full Width) --}}
                    <div class="col-span-1 md:col-span-6">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">محتوای مقاله <span class="text-red-500">*</span></label>
                        <textarea name="content" rows="12" required
                                  class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-4 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder-gray-400 dark:placeholder-gray-500 leading-loose">{{ old('content', $article->content) }}</textarea>
                        @error('content') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="px-8 py-5 border-t border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 flex items-center justify-between">
                    <a href="{{ route('admin.articles.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-bold text-sm px-4 py-2 transition-colors">
                        انصراف
                    </a>
                    
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-black transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2 hover:-translate-y-0.5">
                        <i class="fas fa-save"></i> ذخیره تغییرات
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>