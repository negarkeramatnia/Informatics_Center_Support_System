<x-app-layout>
    @section('title', 'ویرایش کاربر')

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center">
                <i class="fas fa-user-edit text-blue-600 dark:text-blue-400 text-lg"></i>
            </div>
            <h2 class="font-black text-xl text-gray-900 dark:text-white leading-tight">
                ویرایش کاربر: <span class="text-blue-600 dark:text-blue-400">{{ $user->name }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- GLOBAL ALERTS --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-6 py-4 rounded-2xl font-bold flex items-center gap-3">
                    <i class="fas fa-check-circle text-xl"></i> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="bg-white dark:bg-slate-800 shadow-sm rounded-3xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
                @csrf
                @method('PUT')

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
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('name') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Username (Half Width) --}}
                    <div class="col-span-1 md:col-span-3">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">نام کاربری (انگلیسی) <span class="text-red-500">*</span></label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" required dir="ltr"
                               class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-left">
                        @error('username') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Email (Half Width) --}}
                    <div class="col-span-1 md:col-span-3">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">ایمیل</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" dir="ltr"
                               class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-left">
                        @error('email') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Phone Number (1/3 Width) --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">شماره تلفن</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" dir="ltr"
                               class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-left tracking-widest font-mono">
                        @error('phone') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Department (1/3 Width) --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">واحد سازمانی <span class="text-red-500">*</span></label>
                        <select name="department" required class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="" disabled>انتخاب کنید...</option>
                            {{-- Assuming you pass a $departments array from the controller. Adjust if needed. --}}
                            @php $departments = ['مدیریت', 'مالی', 'منابع انسانی', 'فنی', 'خدمات مشترکین', 'فروش']; @endphp
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}" @selected(old('department', $user->department) == $dept)>{{ $dept }}</option>
                            @endforeach
                        </select>
                        @error('department') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- System Role (1/3 Width) --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">نقش سیستم <span class="text-red-500">*</span></label>
                        <select name="role" required class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="user" @selected(old('role', $user->role) === 'user')>کاربر عادی</option>
                            <option value="support" @selected(old('role', $user->role) === 'support')>کارشناس پشتیبانی</option>
                            <option value="admin" @selected(old('role', $user->role) === 'admin')>مدیر سیستم</option>
                        </select>
                        @error('role') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Password Section (Distinct visual block) --}}
                <div class="bg-gray-50/50 dark:bg-slate-900/30 p-8 border-t border-gray-100 dark:border-slate-700">
                    <div class="mb-4">
                        <h4 class="font-bold text-gray-800 dark:text-white flex items-center gap-2">
                            <i class="fas fa-lock text-orange-500"></i> تغییر رمز عبور
                        </h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">فقط در صورتی که می‌خواهید رمز عبور کاربر را تغییر دهید، فیلدهای زیر را پر کنید.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">رمز عبور جدید</label>
                            <input type="password" name="password" dir="ltr"
                                   class="w-full bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors text-left font-mono placeholder-gray-300 dark:placeholder-gray-600" placeholder="••••••••">
                            @error('password') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">تکرار رمز عبور جدید</label>
                            <input type="password" name="password_confirmation" dir="ltr"
                                   class="w-full bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors text-left font-mono placeholder-gray-300 dark:placeholder-gray-600" placeholder="••••••••">
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="px-8 py-5 border-t border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 flex items-center justify-between">
                    <a href="{{ route('admin.users.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-bold text-sm px-4 py-2 transition-colors">
                        انصراف و بازگشت
                    </a>
                    
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-xl font-black transition-all shadow-lg shadow-green-500/30 flex items-center gap-2 hover:-translate-y-0.5">
                        <i class="fas fa-save"></i> ذخیره تغییرات
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>