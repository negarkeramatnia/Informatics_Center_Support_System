<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('مدیریت دستگاه‌ها') }}</h2>
            <a href="{{ route('admin.assets.create') }}" class="btn-primary-custom"><i class="fas fa-plus mr-2"></i>افزودن دستگاه جدید</a>
        </div>
    </x-slot>

    @pushOnce('styles')
    <style>
        .table-bordered {
            border-collapse: collapse;
        }
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #e5e7eb; /* gray-200 */
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        /* FIX: Set all headers to center */
        .table-bordered th {
            text-align: center;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }
        /* FIX: Set all data cells to center and increase vertical padding */
        .table-bordered td {
            text-align: center;
            padding-top: 1.25rem; /* More space */
            padding-bottom: 1.25rem; /* More space */
        }
    </style>
    @endPushOnce

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full table-custom table-bordered">
                        <thead>
                            <tr class="bg-gray-50">
                                <th>نام قطعه</th>
                                <th>شماره سریال</th>
                                <th>وضعیت</th>
                                <th>اختصاص به</th>
                                <th>مکان</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assets as $asset)
                                <tr>
                                    {{-- This cell remains right-aligned --}}
                                    <td class="font-medium">{{ $asset->name }}</td>
                                    <td><span class="font-mono bg-gray-200 text-gray-700 px-2 py-1 rounded">{{ $asset->serial_number }}</span></td>
                                    <td><span class="status-badge status-{{ str_replace('_', '-', $asset->status) }}">{{ __($asset->status) }}</span></td>
                                    <td>{{ $asset->assignedToUser->name ?? '---' }}</td>
                                    <td>{{ $asset->location ?? '---' }}</td>
                                    <td>
                                        <div class="flex items-center justify-center gap-x-4">
                                            <a href="{{ route('admin.assets.edit', $asset) }}" class="text-gray-400 hover:text-blue-600" title="ویرایش"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.assets.destroy', $asset) }}" method="POST" onsubmit="return confirm('آیا از حذف این قطعه اطمینان دارید؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600" title="حذف"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center py-10 text-gray-500">هیچ قطعه‌ای ثبت نشده است.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($assets->hasPages())
                    <div class="p-4 border-t border-gray-200">{{ $assets->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
