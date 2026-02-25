<x-app-layout>
    @section('title', 'افزودن تجهیزات جدید')

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center">
                    <i class="fas fa-desktop text-blue-600 dark:text-blue-400 text-lg"></i>
                </div>
                <h2 class="font-black text-xl text-gray-900 dark:text-white leading-tight">
                    افزودن قطعه / دستگاه جدید
                </h2>
            </div>
            
            {{-- THE BACK BUTTON (Safely routed to the index page) --}}
            <a href="{{ route('admin.assets.index') }}" class="flex items-center gap-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300 px-5 py-2.5 rounded-xl font-bold transition-all shadow-sm">
                بازگشت <i class="fas fa-arrow-left text-sm"></i>
            </a>
        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            {{-- GLOBAL ALERTS --}}
            @if(session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-6 py-4 rounded-2xl font-bold flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle text-xl"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.assets.store') }}" method="POST" class="bg-white dark:bg-slate-800 shadow-sm rounded-3xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
                @csrf

                {{-- SECTION 1: Physical Specs --}}
                <div class="px-8 py-5 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 flex justify-between items-center">
                    <h3 class="font-black text-gray-800 dark:text-white flex items-center gap-2 text-lg">
                        <i class="fas fa-microchip text-blue-500"></i> مشخصات فیزیکی دستگاه
                    </h3>
                </div>

                <div class="p-8 grid grid-cols-1 md:grid-cols-6 gap-6">
                    
                    {{-- Device Name (Half Width) --}}
                    <div class="col-span-1 md:col-span-3">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">نام دستگاه <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="مثال: Laptop Dell Latitude 5520"
                               class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder-gray-400 dark:placeholder-gray-500">
                        @error('name') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Serial Number (Half Width) --}}
                    <div class="col-span-1 md:col-span-3">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">شماره سریال / اموال <span class="text-red-500">*</span></label>
                        <input type="text" name="serial_number" value="{{ old('serial_number') }}" required dir="ltr" placeholder="SN-123456789"
                               class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-left font-mono placeholder-gray-400 dark:placeholder-gray-500">
                        @error('serial_number') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- IP Address (Half Width) --}}
                    <div class="col-span-1 md:col-span-3">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">آدرس IP (اختیاری)</label>
                        <input type="text" name="ip_address" value="{{ old('ip_address') }}" dir="ltr" placeholder="192.168.1.100"
                               class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-left font-mono tracking-wider placeholder-gray-400 dark:placeholder-gray-500">
                        @error('ip_address') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Description (Half Width) --}}
                    <div class="col-span-1 md:col-span-3">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">توضیحات تکمیلی</label>
                        <textarea name="description" rows="2" placeholder="جزئیات سخت افزاری، رم، هارد و..."
                                  class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none placeholder-gray-400 dark:placeholder-gray-500">{{ old('description') }}</textarea>
                        @error('description') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- SECTION 2: Status & Location --}}
                <div class="px-8 py-5 border-y border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 flex justify-between items-center">
                    <h3 class="font-black text-gray-800 dark:text-white flex items-center gap-2 text-lg">
                        <i class="fas fa-map-marker-alt text-orange-500"></i> وضعیت و محل استقرار
                    </h3>
                </div>

                <div class="p-8 grid grid-cols-1 md:grid-cols-6 gap-6 bg-orange-50/30 dark:bg-orange-900/10">
                    
                    {{-- Status (1/3 Width) --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">وضعیت فعلی <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                            <option value="available" @selected(old('status') === 'available')>موجود (آزاد)</option>
                            <option value="assigned" @selected(old('status') === 'assigned')>واگذار شده</option>
                            <option value="in_repair" @selected(old('status') === 'in_repair')>در حال تعمیر</option>
                            <option value="retired" @selected(old('status') === 'retired')>از رده خارج / اسقاطی</option>
                        </select>
                        @error('status') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Department (1/3 Width) --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">محل استقرار / واحد</label>
                        <select name="department" class="w-full bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                            <option value="" selected>-- انتخاب محل --</option>
                            {{-- Requires $departments variable from Controller --}}
                            @if(isset($departments))
                                @foreach($departments as $dept)
                                    <option value="{{ $dept }}" @selected(old('department') == $dept)>{{ $dept }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('department') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Assigned User (1/3 Width) --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">تحویل گیرنده (کاربر)</label>
                        <select name="user_id" class="w-full bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                            <option value="" selected>-- آزاد --</option>
                            {{-- Requires $users variable from Controller --}}
                            @if(isset($users))
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <p class="text-xs text-gray-500 mt-2">اگر وضعیت "واگذار شده" است، کاربر را انتخاب کنید.</p>
                        @error('user_id') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                </div>

                {{-- SECTION 3: Financial & Warranty --}}
                <div class="px-8 py-5 border-y border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 flex justify-between items-center">
                    <h3 class="font-black text-gray-800 dark:text-white flex items-center gap-2 text-lg">
                        <i class="fas fa-file-invoice-dollar text-green-500"></i> اطلاعات مالی و گارانتی (اختیاری)
                    </h3>
                </div>

                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">ارزش حدودی / قیمت خرید (تومان)</label>
                        <input type="number" name="price" value="{{ old('price') }}" dir="ltr" placeholder="50000000"
                               class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors text-left font-mono placeholder-gray-400 dark:placeholder-gray-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">تاریخ پایان گارانتی</label>
                        <input type="date" name="warranty_expiry" value="{{ old('warranty_expiry') }}" dir="ltr"
                               class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors text-left font-mono">
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="px-8 py-5 border-t border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 flex items-center justify-between">
                    <a href="{{ route('admin.assets.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-bold text-sm px-4 py-2 transition-colors">
                        انصراف
                    </a>
                    
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-black transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2 hover:-translate-y-0.5">
                        <i class="fas fa-save"></i> ثبت تجهیزات جدید
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>