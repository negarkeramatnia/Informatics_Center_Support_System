<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('اطلاعات پروفایل') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("اطلاعات حساب کاربری و آدرس ایمیل خود را بروزرسانی کنید.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Name Field --}}
        <div>
            <x-input-label for="name" :value="__('نام و نام خانوادگی')" class="dark:text-gray-300" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full dark:bg-slate-900 dark:border-slate-700 dark:text-gray-300 dark:focus:border-blue-500 dark:focus:ring-blue-500" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email Field --}}
        <div>
            <x-input-label for="email" :value="__('آدرس ایمیل')" class="dark:text-gray-300" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full dark:bg-slate-900 dark:border-slate-700 dark:text-gray-300 dark:focus:border-blue-500 dark:focus:ring-blue-500" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-300">
                        {{ __('آدرس ایمیل شما تایید نشده است.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800">
                            {{ __('برای ارسال مجدد ایمیل تایید اینجا کلیک کنید.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('یک لینک تایید جدید به آدرس ایمیل شما ارسال شد.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Phone/Mobile Field (If you added this) --}}
        <div>
             <x-input-label for="phone" :value="__('شماره تماس')" class="dark:text-gray-300" />
             <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full dark:bg-slate-900 dark:border-slate-700 dark:text-gray-300 dark:focus:border-blue-500 dark:focus:ring-blue-500 dir-ltr" :value="old('phone', $user->phone)" placeholder="0912..." />
             <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        {{-- Department Field (If you added this) --}}
        <div>
             <x-input-label for="department" :value="__('واحد سازمانی')" class="dark:text-gray-300" />
             <x-text-input id="department" name="department" type="text" class="mt-1 block w-full dark:bg-slate-900 dark:border-slate-700 dark:text-gray-300 dark:focus:border-blue-500 dark:focus:ring-blue-500" :value="old('department', $user->department)" />
             <x-input-error class="mt-2" :messages="$errors->get('department')" />
        </div>

        {{-- Profile Photo (If you added this) --}}
        <div>
            <x-input-label for="profile_picture" :value="__('تصویر پروفایل جدید')" class="dark:text-gray-300" />
            <input type="file" id="profile_picture" name="profile_picture" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                file:mr-4 file:py-2 file:px-4
                file:rounded-full file:border-0
                file:text-sm file:font-semibold
                file:bg-blue-50 file:text-blue-700
                hover:file:bg-blue-100
                dark:file:bg-slate-700 dark:file:text-slate-300
            "/>
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>


        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
    {{ __('ذخیره') }}
</button>

            @if (session('status') === 'profile-updated')
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