<x-app-layout>
    @section('title', 'ثبت درخواست جدید')
    
    {{-- PREMIUM HEADER --}}
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <i class="fas fa-plus-circle text-blue-500 text-xl"></i>
            <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight">
                {{ __('ثبت درخواست جدید (تیکت)') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- FORM CONTAINER --}}
            <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
                <div class="p-6 md:p-8">
                    
                    {{-- Form Title & Subtitle --}}
                    <div class="border-b border-gray-200 dark:border-slate-700 pb-5 mb-6 transition-colors">
                        <h3 class="text-xl font-black text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="fas fa-file-signature text-blue-500"></i> جزئیات درخواست
                        </h3>
                        <p class="mt-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            برای تسریع در روند کار، لطفاً جزئیات درخواست خود را با دقت وارد نمایید. فیلدهای ستاره‌دار الزامی هستند.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('tickets.store') }}">
                        @csrf
                        <div class="space-y-6">
                            
                            {{-- Title --}}
                            <div>
                                <label for="title" class="block font-bold text-sm text-gray-700 dark:text-gray-300 mb-2">عنوان درخواست <span class="text-red-500">*</span></label>
                                <input id="title" type="text" name="title" value="{{ old('title') }}" required autofocus 
                                       placeholder="مثال: مشکل در اتصال به پرینتر طبقه دوم"
                                       class="w-full text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors py-3 px-4 shadow-sm"/>
                                @error('title') <span class="text-red-500 text-xs mt-1 font-bold block">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Category --}}
                                <div>
                                    <label for="category" class="block font-bold text-sm text-gray-700 dark:text-gray-300 mb-2">دسته‌بندی مشکل <span class="text-red-500">*</span></label>
                                    <select id="category" name="category" required 
                                            class="w-full text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors py-3 px-4 shadow-sm cursor-pointer">
                                        <option value="" disabled selected>انتخاب کنید...</option>
                                        <option value="software" @selected(old('category') == 'software')>نرم‌افزار (Software)</option>
                                        <option value="hardware" @selected(old('category') == 'hardware')>سخت‌افزار (Hardware)</option>
                                        <option value="network" @selected(old('category') == 'network')>شبکه و اینترنت (Network)</option>
                                        <option value="access_control" @selected(old('category') == 'access_control')>دسترسی و اکانت (Access)</option>
                                        <option value="other" @selected(old('category') == 'other')>سایر موارد</option>
                                    </select>
                                    @error('category') <span class="text-red-500 text-xs mt-1 font-bold block">{{ $message }}</span> @enderror
                                </div>

                                {{-- Priority --}}
                                <div>
                                    <label for="priority" class="block font-bold text-sm text-gray-700 dark:text-gray-300 mb-2">اولویت <span class="text-red-500">*</span></label>
                                    <select id="priority" name="priority" required 
                                            class="w-full text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors py-3 px-4 shadow-sm cursor-pointer">
                                        <option value="low" @selected(old('priority') == 'low')>کم (عادی)</option>
                                        <option value="medium" @selected(old('priority', 'medium') == 'medium')>متوسط (مهم)</option>
                                        <option value="high" @selected(old('priority') == 'high')>زیاد (فوری)</option>
                                    </select>
                                    @error('priority') <span class="text-red-500 text-xs mt-1 font-bold block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- Description --}}
                            <div>
                                <label for="description" class="block font-bold text-sm text-gray-700 dark:text-gray-300 mb-2">شرح درخواست <span class="text-red-500">*</span></label>
                                <textarea id="description" name="description" rows="5" required
                                          placeholder="جزئیات کامل مشکل یا درخواست خود را بنویسید. در صورت وجود پیغام خطا، آن را اینجا وارد کنید."
                                          class="w-full text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors py-3 px-4 shadow-sm leading-relaxed">{{ old('description') }}</textarea>
                                @error('description') <span class="text-red-500 text-xs mt-1 font-bold block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-col sm:flex-row items-center gap-3 mt-8 pt-6 border-t border-gray-200 dark:border-slate-700 transition-colors">
                            <button type="submit" class="w-full sm:w-auto group flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold transition-all duration-300 shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5">
                                <i class="fas fa-paper-plane transition-transform group-hover:-translate-y-1 group-hover:translate-x-1"></i>
                                <span>ثبت درخواست</span>
                            </button>
                            
                            <a href="{{ route('dashboard') }}" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 px-8 py-3 rounded-xl font-bold transition-all duration-300 border border-gray-200 dark:border-slate-600">
                                <span>انصراف</span>
                            </a>
                        </div>
                        
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>