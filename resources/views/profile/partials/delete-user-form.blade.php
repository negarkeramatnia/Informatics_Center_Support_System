<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('حذف حساب کاربری') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('پس از حذف حساب کاربری شما، تمام منابع و داده‌های آن برای همیشه حذف خواهند شد. قبل از حذف حساب خود، لطفاً هر داده یا اطلاعاتی را که می‌خواهید نگه دارید، دانلود کنید.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('حذف حساب کاربری') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 dark:bg-slate-800">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('آیا از حذف حساب کاربری خود مطمئن هستید؟') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('پس از حذف حساب کاربری شما، تمام منابع و داده‌های آن برای همیشه حذف خواهند شد. لطفاً رمز عبور خود را برای تایید حذف دائمی حساب کاربری خود وارد کنید.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('رمز عبور') }}" class="dark:text-gray-300" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 dark:bg-slate-900 dark:border-slate-700 dark:text-gray-300 dark:focus:border-blue-500 dark:focus:ring-blue-500 dir-ltr"
                    placeholder="{{ __('رمز عبور') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('انصراف') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('حذف حساب کاربری') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>