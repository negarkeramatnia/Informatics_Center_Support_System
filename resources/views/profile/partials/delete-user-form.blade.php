<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('حذف حساب کاربری') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('پس از حذف حساب شما، تمام منابع و داده‌های آن برای همیشه حذف خواهند شد. قبل از حذف، لطفاً هرگونه اطلاعاتی را که می‌خواهید حفظ کنید، دانلود نمایید.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('حذف حساب') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('آیا از حذف حساب کاربری خود اطمینان دارید؟') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('پس از حذف حساب، تمام اطلاعات آن برای همیشه پاک می‌شود. لطفاً برای تأیید، رمز عبور خود را وارد کنید.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('رمز عبور') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-input-custom mt-1 block w-3/4"
                    placeholder="{{ __('رمز عبور') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('انصراف') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('حذف حساب') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
