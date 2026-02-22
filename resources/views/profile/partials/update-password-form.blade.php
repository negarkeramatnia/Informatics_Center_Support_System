<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('بروزرسانی رمز عبور') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('مطمئن شوید که از یک رمز عبور طولانی و تصادفی برای امنیت حساب خود استفاده می‌کنید.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_password" :value="__('رمز عبور فعلی')" class="dark:text-gray-300" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full dark:bg-slate-900 dark:border-slate-700 dark:text-gray-300 dark:focus:border-blue-500 dark:focus:ring-blue-500 dir-ltr" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('رمز عبور جدید')" class="dark:text-gray-300" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full dark:bg-slate-900 dark:border-slate-700 dark:text-gray-300 dark:focus:border-blue-500 dark:focus:ring-blue-500 dir-ltr" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('تکرار رمز عبور جدید')" class="dark:text-gray-300" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full dark:bg-slate-900 dark:border-slate-700 dark:text-gray-300 dark:focus:border-blue-500 dark:focus:ring-blue-500 dir-ltr" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
    {{ __('ذخیره') }}
</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('ذخیره شد.') }}</p>
            @endif
        </div>
    </form>
</section>