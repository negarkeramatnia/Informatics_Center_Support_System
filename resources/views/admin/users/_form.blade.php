<div class="space-y-6">
    {{-- Name --}}
    <div>
        <label for="name" class="block font-medium text-sm text-gray-700">نام و نام خانوادگی</label>
        <input id="name" class="form-input-custom mt-1 block w-full" type="text" name="name" 
               value="{{ old('name', $user->name ?? '') }}" required placeholder="مثال: علی محمدی" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    {{-- Username & Email --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="username" class="block font-medium text-sm text-gray-700">نام کاربری (انگلیسی)</label>
            <input id="username" class="form-input-custom mt-1 block w-full ltr" type="text" name="username" 
                   value="{{ old('username', $user->username ?? '') }}" required placeholder="ali.mohammadi" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>
        <div>
            <label for="email" class="block font-medium text-sm text-gray-700">ایمیل</label>
            <input id="email" class="form-input-custom mt-1 block w-full ltr" type="email" name="email" 
                   value="{{ old('email', $user->email ?? '') }}" required placeholder="example@company.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
    </div>
    
    {{-- Phone & Department & Role --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Phone --}}
        <div>
            <label for="phone" class="block font-medium text-sm text-gray-700">شماره تلفن</label>
            <input id="phone" class="form-input-custom mt-1 block w-full ltr" type="text" name="phone" 
                   value="{{ old('phone', $user->phone ?? '') }}" required placeholder="09123456789" maxlength="11" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        {{-- Department --}}
        <div>
            <label for="department" class="block font-medium text-sm text-gray-700">واحد سازمانی</label>
            <select id="department" name="department" class="form-input-custom mt-1 block w-full" required>
                <option value="">-- انتخاب واحد --</option>
                @php $depts = ['مدیریت', 'فناوری اطلاعات', 'منابع انسانی', 'مالی', 'حراست', 'خدمات مشترکین', 'فنی و مهندسی']; @endphp
                @foreach($depts as $dept)
                    <option value="{{ $dept }}" @selected(old('department', $user->department ?? '') == $dept)>{{ $dept }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('department')" class="mt-2" />
        </div>

        {{-- Role --}}
        <div>
            <label for="role" class="block font-medium text-sm text-gray-700">نقش سیستم</label>
            <select id="role" name="role" class="form-input-custom mt-1 block w-full" required>
                <option value="user" @selected(old('role', $user->role ?? '') == 'user')>کاربر عادی</option>
                <option value="support" @selected(old('role', $user->role ?? '') == 'support')>پشتیبان (IT)</option>
                <option value="admin" @selected(old('role', $user->role ?? '') == 'admin')>مدیر کل</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>
    </div>

    {{-- Password --}}
    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="password" class="block font-medium text-sm text-gray-700">رمز عبور جدید</label>
                <input id="password" class="form-input-custom mt-1 block w-full ltr" type="password" name="password" autocomplete="new-password" />
                @isset($user)
                    <p class="text-xs text-gray-500 mt-1">فقط در صورتی که می‌خواهید رمز را تغییر دهید، پر کنید.</p>
                @endisset
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div>
                <label for="password_confirmation" class="block font-medium text-sm text-gray-700">تکرار رمز عبور</label>
                <input id="password_confirmation" class="form-input-custom mt-1 block w-full ltr" type="password" name="password_confirmation" />
            </div>
        </div>
    </div>
</div>

<div class="flex items-center justify-end mt-8 pt-5 border-t border-gray-200">
    <a href="{{ route('admin.users.index') }}" class="btn-secondary-custom ml-4">انصراف</a>
    <button type="submit" class="btn-primary-custom">ذخیره تغییرات</button>
</div>