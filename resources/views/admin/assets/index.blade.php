<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('مدیریت قطعات') }}
            </h2>
            <a href="#" class="btn-primary-custom">
                <i class="fas fa-plus mr-2"></i>
                افزودن قطعه جدید
            </a>
        </div>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center text-gray-600">
                    <i class="fas fa-tools text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-bold">بخش مدیریت قطعات</h3>
                    <p class="mt-2">این بخش در حال توسعه می‌باشد. شما ساختار آن را با موفقیت ایجاد کرده‌اید.</p>
                     <div class="overflow-x-auto mt-6">
                        <table class="min-w-full table-custom">
                            <thead>
                                <tr>
                                    <th>نام قطعه</th>
                                    <th>تگ دارایی</th>
                                    <th>وضعیت</th>
                                    <th>اختصاص به</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($assets as $asset)
                                    <tr>
                                        <td class="font-medium">{{ $asset->name }}</td>
                                        <td>{{ $asset->asset_tag }}</td>
                                        <td>{{ $asset->status }}</td>
                                        <td>{{ $asset->assigned_to_user_id ? $asset->assignedTo->name : 'اختصاص نیافته' }}</td>
                                        <td>
                                            <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">ویرایش</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-10 text-gray-500">
                                            هیچ قطعه‌ای ثبت نشده است.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
