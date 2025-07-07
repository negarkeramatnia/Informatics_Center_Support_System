<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('ویرایش قطعه: ') . $asset->name }}</h2></x-slot>
    <div class="py-12" dir="rtl"><div class="max-w-4xl mx-auto sm:px-6 lg:px-8"><div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"><div class="p-6 md:p-8">
        <form method="POST" action="{{ route('admin.assets.update', $asset) }}">@csrf @method('PUT') @include('admin.assets._form')</form>
    </div></div></div></div>
</x-app-layout>