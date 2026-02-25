<x-app-layout>
    @section('title', 'افزودن کاربر جدید')

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center">
                    <i class="fas fa-user-plus text-blue-600 dark:text-blue-400 text-lg"></i>
                </div>
                <h2 class="font-black text-xl text-gray-900 dark:text-white leading-tight">
                    افزودن کاربر جدید
                </h2>
            </div>
            
            {{-- NEW: Back Button --}}
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300 px-5 py-2.5 rounded-xl font-bold transition-all shadow-sm">
                بازگشت <i class="fas fa-arrow-left text-sm"></i>
            </a>
        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- GLOBAL ALERTS --}}
            @if(session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-6 py-4 rounded-2xl font-bold flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle text-xl"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white dark:bg-slate-800 shadow-sm rounded-3xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
                @csrf

                {{-- Form Header --}}
                <div class="px-8 py-5 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 flex justify-between items-center">
                    <h3 class="font-black text-gray-800 dark:text-white flex items-center gap-2 text-lg">
                        <i class="fas fa-id-card text-blue-500"></i> اطلاعات هویتی و سازمانی
                    </h3>
                </div>

                {{-- Form Body (6-Column Grid for perfect alignment) --}}
                <div class="p-8 grid grid-cols-1 md:grid-cols-6 gap-6">
                    
                    {{-- Name (Full Width) --}}
                    <div class="col-span-1 md:col-span-6">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">نام و نام خانوادگی <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="مثال: علی محمدی"
                               class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder-gray-400 dark:placeholder-gray-500">
                        @error('name') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Username (Half Width) --}}
                    <div class="col-span-1 md:col-span-3">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">نام کاربری (انگلیسی) <span class="text-red-500">*</span></label>
                        <input type="text" name="username" value="{{ old('username') }}" required dir="ltr" placeholder="ali.mohammadi"
                               class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-left placeholder-gray-400 dark:placeholder-gray-500">
                        @error('username') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Email (Half Width) --}}
                    <div class="col-span-1 md:col-span-3">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">ایمیل</label>
                        <input type="email" name="email" value="{{ old('email') }}" dir="ltr" placeholder="example@company.com"
                               class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-left placeholder-gray-400 dark:placeholder-gray-500">
                        @error('email') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Phone Number (1/3 Width) --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">شماره تلفن</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" dir="ltr" placeholder="09123456789"
                               class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-left tracking-widest font-mono placeholder-gray-400 dark:placeholder-gray-500">
                        @error('phone') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Department (1/3 Width) --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">واحد سازمانی <span class="text-red-500">*</span></label>
                        <select name="department" required class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="" disabled selected>-- انتخاب واحد --</option>
                            @php $departments = ['مدیریت', 'مالی', 'منابع انسانی', 'فنی', 'خدمات مشترکین', 'فروش']; @endphp
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}" @selected(old('department') == $dept)>{{ $dept }}</option>
                            @endforeach
                        </select>
                        @error('department') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- System Role (1/3 Width) --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">نقش سیستم <span class="text-red-500">*</span></label>
                        <select name="role" required class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="user" @selected(old('role') === 'user')>کاربر عادی</option>
                            <option value="support" @selected(old('role') === 'support')>کارشناس پشتیبانی</option>
                            <option value="admin" @selected(old('role') === 'admin')>مدیر سیستم</option>
                        </select>
                        @error('role') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Password Section (Distinct visual block - REQUIRED for Create) --}}
                <div class="bg-gray-50/50 dark:bg-slate-900/30 p-8 border-t border-gray-100 dark:border-slate-700">
                    <div class="mb-4">
                        <h4 class="font-bold text-gray-800 dark:text-white flex items-center gap-2">
                            <i class="fas fa-lock text-orange-500"></i> تنظیم رمز عبور
                        </h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">رمز عبور باید حداقل ۸ کاراکتر باشد.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">رمز عبور <span class="text-red-500">*</span></label>
                            <input type="password" name="password" required dir="ltr"
                                   class="w-full bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors text-left font-mono" placeholder="••••••••">
                            @error('password') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">تکرار رمز عبور <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" required dir="ltr"
                                   class="w-full bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors text-left font-mono" placeholder="••••••••">
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="px-8 py-5 border-t border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 flex items-center justify-between">
                    <a href="{{ route('admin.users.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-bold text-sm px-4 py-2 transition-colors">
                        انصراف
                    </a>
                    
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-xl font-black transition-all shadow-lg shadow-green-500/30 flex items-center gap-2 hover:-translate-y-0.5">
                        <i class="fas fa-plus-circle"></i> ثبت کاربر جدید
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>