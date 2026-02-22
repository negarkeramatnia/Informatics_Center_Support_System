<div class="space-y-8">
    
    {{-- KPI CARDS (2 Column Grid - CLICKABLE) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
        
        {{-- Active Tickets Card --}}
        <a href="{{ route('tickets.my') }}" class="dashboard-card group bg-white dark:bg-slate-800 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-700 flex items-center justify-between transition-all duration-300 hover:shadow-md hover:border-blue-300 dark:hover:border-blue-500 hover:-translate-y-1">
            <div>
                <p class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">درخواست‌های فعال من</p>
                <h4 class="text-3xl font-black text-gray-900 dark:text-white">{{ $employeeData['open_tickets_count'] ?? 0 }}</h4>
            </div>
            <div class="w-14 h-14 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-2xl shadow-inner group-hover:scale-110 transition-transform">
                <i class="fas fa-folder-open"></i>
            </div>
        </a>

        {{-- Completed Tickets Card --}}
        <a href="{{ route('tickets.my') }}" class="dashboard-card group bg-white dark:bg-slate-800 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-700 flex items-center justify-between transition-all duration-300 hover:shadow-md hover:border-green-300 dark:hover:border-green-500 hover:-translate-y-1">
            <div>
                <p class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-1 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">درخواست‌های تکمیل شده</p>
                <h4 class="text-3xl font-black text-gray-900 dark:text-white">{{ $employeeData['resolved_tickets_count'] ?? 0 }}</h4>
            </div>
            <div class="w-14 h-14 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center text-2xl shadow-inner group-hover:scale-110 transition-transform">
                <i class="fas fa-check-circle"></i>
            </div>
        </a>
    </div>

    {{-- RECENT TICKETS TABLE --}}
    <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
        
        <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-800/50">
            <h3 class="font-black text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fas fa-history text-gray-400 dark:text-gray-500"></i> آخرین درخواست‌های من
            </h3>
            <a href="{{ route('tickets.my') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                مشاهده همه &leftarrow;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-gray-50 dark:bg-slate-900/50 text-gray-500 dark:text-gray-400 text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-right">عنوان</th>
                        <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">وضعیت</th>
                        <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">آخرین بروزرسانی</th>
                        <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700 text-sm">
                    @forelse ($employeeData['recent_tickets'] as $ticket)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 text-right font-bold text-gray-900 dark:text-white">
                                {{ Str::limit($ticket->title, 50) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{-- Dynamic Tailwind Status Badges --}}
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 border-yellow-200 dark:border-yellow-800',
                                        'open' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border-red-200 dark:border-red-800',
                                        'in_progress' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border-blue-200 dark:border-blue-800',
                                        'completed' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border-green-200 dark:border-green-800',
                                        'resolved' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border-green-200 dark:border-green-800',
                                    ];
                                    $badgeClass = $statusColors[$ticket->status] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 border-gray-200 dark:border-gray-600';
                                @endphp
                                <span class="px-3 py-1 border rounded-full text-xs font-bold {{ $badgeClass }}">
                                    {{ __($ticket->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 text-xs dir-ltr">
                                {{ $ticket->updated_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('tickets.show', $ticket) }}" class="inline-flex items-center justify-center gap-1 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-bold transition-colors">
                                    مشاهده
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-12">
                                <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-inbox text-5xl mb-3 opacity-20 dark:text-slate-500"></i>
                                    <span class="font-bold">شما تاکنون درخواستی ثبت نکرده‌اید.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ASSIGNED ASSETS TABLE --}}
    <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
        
        <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50">
            <h3 class="font-black text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fas fa-laptop text-gray-400 dark:text-gray-500"></i> دستگاه‌های اختصاص یافته به من
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-gray-50 dark:bg-slate-900/50 text-gray-500 dark:text-gray-400 text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-right">نام دستگاه</th>
                        <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">شماره سریال</th>
                        <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">وضعیت</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700 text-sm">
                    @forelse ($employeeData['userAssets'] as $asset)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 text-right font-bold text-gray-900 dark:text-white">
                                {{ $asset->name }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-mono bg-gray-100 text-gray-700 dark:bg-slate-900 dark:text-gray-300 border border-gray-200 dark:border-slate-600 px-3 py-1 rounded-lg text-xs tracking-wider">
                                    {{ $asset->serial_number }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $assetStatusColors = [
                                        'active' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border-green-200 dark:border-green-800',
                                        'assigned' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border-blue-200 dark:border-blue-800',
                                        'in_repair' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400 border-orange-200 dark:border-orange-800',
                                    ];
                                    $assetBadgeClass = $assetStatusColors[$asset->status] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 border-gray-200 dark:border-gray-600';
                                @endphp
                                <span class="px-3 py-1 border rounded-full text-xs font-bold {{ $assetBadgeClass }}">
                                    {{ __($asset->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-12">
                                <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-desktop text-5xl mb-3 opacity-20 dark:text-slate-500"></i>
                                    <span class="font-bold">هیچ دستگاهی به شما اختصاص داده نشده است.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>