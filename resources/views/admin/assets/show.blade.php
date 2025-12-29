<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('تاریخچه قطعه: ') . $asset->name }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- 1. Asset Details Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-bold text-gray-700">مشخصات دستگاه</h3>
                    <a href="{{ route('admin.assets.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                        <i class="fas fa-arrow-right ml-1"></i> بازگشت به لیست
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 text-sm">
                    <div>
                        <span class="block text-gray-500 mb-1">نام قطعه</span>
                        <span class="font-semibold">{{ $asset->name }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 mb-1">شماره سریال</span>
                        <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ $asset->serial_number }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 mb-1">وضعیت فعلی</span>
                        <span class="px-2 py-1 rounded-full text-xs font-bold
                            {{ $asset->status == 'available' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $asset->status == 'assigned' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $asset->status == 'under_maintenance' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $asset->status == 'decommissioned' ? 'bg-gray-100 text-gray-800' : '' }}">
                            {{ __($asset->status) }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-gray-500 mb-1">محل استقرار / دست</span>
                        @if($asset->assignedToUser)
                            <span class="text-blue-600 font-bold"><i class="fas fa-user ml-1"></i> {{ $asset->assignedToUser->name }}</span>
                        @else
                            <span>{{ $asset->location ?? '---' }}</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 2. Ticket History Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-700">تاریخچه درخواست‌ها (تیکت‌ها)</h3>
                    <p class="text-xs text-gray-500 mt-1">لیست تمام درخواست‌هایی که این قطعه در آن‌ها استفاده یا تعمیر شده است.</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-right border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="p-4 text-sm font-semibold text-gray-600">شماره تیکت</th>
                                <th class="p-4 text-sm font-semibold text-gray-600">عنوان درخواست</th>
                                <th class="p-4 text-sm font-semibold text-gray-600">درخواست کننده</th>
                                <th class="p-4 text-sm font-semibold text-gray-600">تاریخ</th>
                                <th class="p-4 text-sm font-semibold text-gray-600">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($asset->tickets as $ticket)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="p-4 font-mono text-gray-500">#{{ $ticket->id }}</td>
                                    <td class="p-4 font-medium">{{ $ticket->title }}</td>
                                    <td class="p-4">{{ $ticket->user->name }}</td>
                                    <td class="p-4 text-sm text-gray-500">{{ $ticket->created_at->format('Y/m/d') }}</td>
                                    <td class="p-4">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                            مشاهده تیکت <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-400">
                                        <i class="fas fa-history text-3xl mb-2 block"></i>
                                        هیچ سابقه‌ای برای این قطعه ثبت نشده است.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>