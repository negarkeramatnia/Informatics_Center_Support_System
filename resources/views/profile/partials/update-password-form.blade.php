<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('تغییر رمز عبور') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('اطمینان حاصل کنید که حساب شما از یک رمز عبور طولانی و تصادفی برای حفظ امنیت استفاده می‌کند.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block font-medium text-sm text-gray-700">{{ __('رمز عبور فعلی') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-input-custom mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" class="block font-medium text-sm text-gray-700">{{ __('رمز عبور جدید') }}</label>
            <input id="update_password_password" name="password" type="password" class="form-input-custom mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block font-medium text-sm text-gray-700">{{ __('تکرار رمز عبور جدید') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-input-custom mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn-primary-custom">{{ __('ذخیره') }}</button>

            @if (session('status') === 'password-updated')
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
