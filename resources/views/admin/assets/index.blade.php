<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('مدیریت دستگاه‌ها') }}
            </h2>
            <a href="{{ route('admin.assets.create') }}" class="btn-primary-custom">
                <i class="fas fa-plus ml-2"></i> افزودن دستگاه جدید
            </a>
        </div>
    </x-slot>

    @pushOnce('styles')
    <style>
        .table-custom th { background-color: #f9fafb; color: #374151; font-weight: 600; text-align: right; font-size: 0.85rem; padding: 1rem; }
        .table-custom td { padding: 1rem; border-bottom: 1px solid #e5e7eb; color: #374151; vertical-align: middle; }
        .status-badge { padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
        .status-available { background-color: #dcfce7; color: #166534; }
        .status-assigned { background-color: #dbeafe; color: #1e40af; }
        .status-under_maintenance { background-color: #fef9c3; color: #854d0e; }
        .status-decommissioned { background-color: #f3f4f6; color: #374151; }
        .action-icon { font-size: 1.1rem; padding: 0.5rem; transition: color 0.2s; }
        .action-icon:hover { opacity: 0.8; }
    </style>
    @endPushOnce

    <div class="py-6" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- SEARCH & FILTER BAR --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-4">
                <form method="GET" action="{{ route('admin.assets.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        
                        {{-- 1. Search Input --}}
                        <div class="md:col-span-1">
                            <label for="search" class="block font-medium text-sm text-gray-700 mb-1">جستجو</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="نام، سریال یا IP..." class="form-input-custom w-full text-sm">
                        </div>

                        {{-- 2. Location Filter (NOW FILLED WITH DATA) --}}
                        <div>
                            <label for="location" class="block font-medium text-sm text-gray-700 mb-1">محل استقرار</label>
                            <select name="location" class="form-input-custom w-full text-sm">
                                <option value="">همه مکان‌ها</option>
                                {{-- The Loop that was missing: --}}
                                @foreach($locations as $loc)
                                    <option value="{{ $loc }}" @selected(request('location') == $loc)>{{ $loc }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- 3. Status Filter --}}
                        <div>
                            <label for="status" class="block font-medium text-sm text-gray-700 mb-1">وضعیت</label>
                            <select name="status" class="form-input-custom w-full text-sm">
                                <option value="">همه وضعیت‌ها</option>
                                <option value="available" @selected(request('status') == 'available')>موجود</option>
                                <option value="assigned" @selected(request('status') == 'assigned')>واگذار شده</option>
                                <option value="under_maintenance" @selected(request('status') == 'under_maintenance')>در حال تعمیر</option>
                                <option value="decommissioned" @selected(request('status') == 'decommissioned')>اسقاط</option>
                            </select>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex gap-2">
                            <button type="submit" class="btn-primary-custom flex-1 justify-center text-sm py-2">
                                <i class="fas fa-filter ml-1"></i> فیلتر
                            </button>
                            <a href="{{ route('admin.assets.index') }}" class="btn-secondary-custom flex-1 justify-center text-sm py-2 text-center" title="پاک کردن فیلترها">
                                <i class="fas fa-times ml-1"></i> حذف
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="w-full table-custom">
                        <thead>
                            <tr>
                                <th>نام قطعه</th>
                                <th>شماره سریال</th>
                                <th>وضعیت</th>
                                <th>محل استقرار</th>
                                <th>اختصاص به</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assets as $asset)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="font-bold">{{ $asset->name }}</td>
                                    <td class="font-mono text-sm text-gray-600">{{ $asset->serial_number }}</td>
                                    <td><span class="status-badge status-{{ str_replace('_', '-', $asset->status) }}">{{ __($asset->status) }}</span></td>
                                    
                                    {{-- Location --}}
                                    <td>
                                        @if($asset->location)
                                            <span class="text-sm text-gray-700">{{ $asset->location }}</span>
                                        @else
                                            <span class="text-gray-400 text-xs">---</span>
                                        @endif
                                    </td>

                                    <td>{{ $asset->assignedToUser->name ?? '---' }}</td>
                                    
<td>
                                        <div class="flex items-center justify-center gap-x-3">
                                            {{-- View History Button --}}
                                            <a href="{{ route('admin.assets.show', $asset) }}" class="text-gray-500 hover:text-green-600" title="مشاهده تاریخچه">
                                                <i class="fas fa-history text-lg"></i>
                                            </a>

                                            {{-- Edit Button --}}
                                            <a href="{{ route('admin.assets.edit', $asset) }}" class="text-gray-400 hover:text-blue-600" title="ویرایش">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- Delete Form --}}
                                            <form action="{{ route('admin.assets.destroy', $asset) }}" method="POST" onsubmit="return confirm('آیا حذف می‌کنید؟');" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600" title="حذف">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-gray-500">هیچ قطعه‌ای یافت نشد.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t">
                    {{ $assets->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>