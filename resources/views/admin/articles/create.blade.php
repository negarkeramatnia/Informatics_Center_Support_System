<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('افزودن مقاله آموزشی') }}</h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.articles.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 mb-1">عنوان مقاله</label>
                        <input type="text" name="title" class="form-input-custom w-full" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 mb-1">دسته‌بندی</label>
                        <select name="category" class="form-input-custom w-full">
                            <option value="general">عمومی</option>
                            <option value="software">نرم‌افزار</option>
                            <option value="hardware">سخت‌افزار</option>
                            <option value="network">شبکه</option>
                            <option value="security">امنیت</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 mb-1">محتوای مقاله</label>
                        <textarea name="content" rows="10" class="form-input-custom w-full" required></textarea>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.articles.index') }}" class="btn-secondary-custom py-2 px-4">انصراف</a>
                        <button type="submit" class="btn-primary-custom py-2 px-6">ذخیره مقاله</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>