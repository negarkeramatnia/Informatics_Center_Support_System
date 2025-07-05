<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('اطلاعات پروفایل') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("اطلاعات پروفایل و آدرس ایمیل حساب خود را به‌روز کنید.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Profile Picture --}}
        <div class="flex items-center space-x-4 space-x-reverse">
            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=0284C7&background=E0F2FE' }}" alt="{{ Auth::user()->name }}" class="w-20 h-20 rounded-full object-cover">
            <div>
                <label for="profile_picture" class="block font-medium text-sm text-gray-700">عکس پروفایل جدید</label>
                <input id="profile_picture" name="profile_picture" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                <p class="text-xs text-gray-500 mt-1">PNG, JPG (حداکثر 2MB)</p>
                @error('profile_picture')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Name --}}
        <div>
            <label for="name" class="block font-medium text-sm text-gray-700">{{ __('نام و نام خانوادگی') }}</label>
            <input id="name" name="name" type="text" class="form-input-custom mt-1 block w-full" value="{{ old('name', Auth::user()->name) }}" required autofocus autocomplete="name" />
            @error('name')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Username --}}
        <div>
            <label for="username" class="block font-medium text-sm text-gray-700">{{ __('نام کاربری (انگلیسی)') }}</label>
            <input id="username" name="username" type="text" class="form-input-custom mt-1 block w-full ltr" value="{{ old('username', Auth::user()->username) }}" required />
            @error('username')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>
        
        {{-- Phone --}}
        <div>
            <label for="phone" class="block font-medium text-sm text-gray-700">{{ __('شماره تلفن') }}</label>
            {{-- FIX: Added maxlength and pattern for better UX --}}
            <input 
                id="phone" 
                name="phone" 
                type="tel" 
                inputmode="numeric" 
                class="form-input-custom mt-1 block w-full ltr" 
                value="{{ old('phone', Auth::user()->phone) }}"
                maxlength="11"
                pattern="[0-9]{11}"
                required 
            />
            <p class="mt-1 text-xs text-gray-500">مثال: 09123456789</p>
            @error('phone')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block font-medium text-sm text-gray-700">{{ __('ایمیل') }}</label>
            <input id="email" name="email" type="email" class="form-input-custom mt-1 block w-full ltr" value="{{ old('email', Auth::user()->email) }}" required autocomplete="username" />
            @error('email')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror

            @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! Auth::user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('آدرس ایمیل شما تایید نشده است.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('برای ارسال مجدد ایمیل تایید اینجا کلیک کنید.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('یک لینک تایید جدید به آدرس ایمیل شما ارسال شد.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn-primary-custom">{{ __('ذخیره') }}</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('ذخیره شد.') }}</p>
            @endif
        </div>
    </form>
</section>
