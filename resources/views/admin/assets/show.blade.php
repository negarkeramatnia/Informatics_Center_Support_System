<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('تاریخچه قطعه: ') . $asset->name }}
            </h2>
            <span></span>
            <a href="{{ route('admin.assets.index') }}" class="inline-flex items-center gap-2 bg-gray-200 dark:bg-slate-700 hover:bg-gray-300 dark:hover:bg-slate-600 text-gray-800 dark:text-gray-100 px-4 py-2 rounded-xl font-bold transition-all shadow-sm">
                <span class="hidden sm:inline">بازگشت</span>

                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- 1. Asset Details Card --}}
            <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-lg border border-gray-100 dark:border-slate-700 overflow-hidden p-6 transition-colors">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-100">مشخصات دستگاه</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">اطلاعات اصلی و وضعیت فعلی این دستگاه.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 text-sm">
                    <div>
                        <span class="block text-gray-500 dark:text-gray-400 mb-1">نام قطعه</span>
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $asset->name }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 dark:text-gray-400 mb-1">شماره سریال</span>
                        <span class="font-mono bg-gray-100 dark:bg-slate-900 px-2 py-1 rounded text-gray-800 dark:text-gray-200">{{ $asset->serial_number }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 dark:text-gray-400 mb-1">وضعیت فعلی</span>
                        @php
                            $statusLabels = [
                                'available' => ['label' => 'در دسترس', 'class' => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200'],
                                'assigned' => ['label' => 'اختصاص یافته', 'class' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-200'],
                                'under_maintenance' => ['label' => 'در حال تعمیر', 'class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-200'],
                                'decommissioned' => ['label' => 'از رده خارج', 'class' => 'bg-gray-100 text-gray-800 dark:bg-slate-700 dark:text-gray-200'],
                            ];
                            $status = $asset->status;
                            $label = $statusLabels[$status]['label'] ?? $status;
                            $class = $statusLabels[$status]['class'] ?? 'bg-gray-100 text-gray-800 dark:bg-slate-700 dark:text-gray-200';
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $class }}">
                            {{ $label }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-gray-500 dark:text-gray-400 mb-1">محل استقرار / دست</span>
                        @if($asset->assignedToUser)
                            <span class="text-blue-600 dark:text-blue-300 font-bold"><i class="fas fa-user ml-1"></i> {{ $asset->assignedToUser->name }}</span>
                        @else
                            <span class="text-gray-700 dark:text-gray-200">{{ $asset->location ?? '---' }}</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 2. Ticket and Ownership History --}}
            <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-lg border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
                <div class="p-6 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-100">تاریخچه درخواست‌ها و مالکیت</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">لیست همه درخواست‌هایی که این قطعه در آن‌ها استفاده یا تخصیص یافته است، از اولین درخواست تا آخرین.</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-right border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-700">
                                <th class="p-4 text-sm font-semibold text-gray-600 dark:text-gray-300">شماره تیکت</th>
                                <th class="p-4 text-sm font-semibold text-gray-600 dark:text-gray-300">عنوان درخواست</th>
                                <th class="p-4 text-sm font-semibold text-gray-600 dark:text-gray-300">درخواست کننده / مالک</th>
                                <th class="p-4 text-sm font-semibold text-gray-600 dark:text-gray-300">تاریخ درخواست</th>
                                <th class="p-4 text-sm font-semibold text-gray-600 dark:text-gray-300">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($asset->tickets as $ticket)
                                <tr class="border-b border-gray-100 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                                    <td class="p-4 font-mono text-gray-500 dark:text-gray-400">#{{ $ticket->id }}</td>
                                    <td class="p-4 font-medium text-gray-900 dark:text-gray-100">{{ $ticket->title }}</td>
                                    <td class="p-4 text-gray-700 dark:text-gray-200">{{ $ticket->user->name ?? 'بدون نام' }}</td>
                                    <td class="p-4 text-sm text-gray-500 dark:text-gray-400">{{ $ticket->created_at->format('Y/m/d') }}</td>
                                    <td class="p-4">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-600 dark:text-blue-300 hover:text-blue-800 dark:hover:text-blue-100 text-sm font-medium">
                                            مشاهده تیکت <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-400 dark:text-gray-500">
                                        <i class="fas fa-history text-3xl mb-2 block"></i>
                                        هیچ سابقه‌ای از این قطعه ثبت نشده است.
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