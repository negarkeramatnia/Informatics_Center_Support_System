<div class="space-y-8">
    
{{-- SUPPORT DASHBOARD CARDS (4-Column Grid) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    
    {{-- CARD 1: Active Tickets (Link) --}}
    <a href="{{ url('/tickets?status=active') }}" class="flex items-center justify-between p-6 bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-3xl hover:bg-gray-50 dark:hover:bg-slate-700/80 transition-all shadow-sm group">
        <div class="flex flex-col">
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-bold mb-2">درخواست‌های فعال من</h3>
            <p class="text-gray-900 dark:text-white text-3xl font-black">{{ $supportData['active_tickets'] ?? 0 }}</p>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform">
            <i class="fas fa-inbox text-2xl"></i>
        </div>
    </a>

    {{-- CARD 2: High Priority (Link) --}}
    <a href="{{ url('/tickets?priority=high') }}" class="flex items-center justify-between p-6 bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-3xl hover:bg-gray-50 dark:hover:bg-slate-700/80 transition-all shadow-sm group">
        <div class="flex flex-col">
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-bold mb-2">اولویت بالا</h3>
            <p class="text-red-600 dark:text-red-400 text-3xl font-black">{{ $supportData['high_priority'] ?? 0 }}</p>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400 group-hover:scale-110 transition-transform shadow-[0_0_15px_rgba(239,68,68,0.2)]">
            <i class="fas fa-exclamation-triangle text-2xl animate-pulse"></i>
        </div>
    </a>

    {{-- CARD 3: Completed Recently (Link with FIXED Single Checkmark) --}}
    <a href="{{ url('/tickets?status=completed_recent') }}" class="flex items-center justify-between p-6 bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-3xl hover:bg-gray-50 dark:hover:bg-slate-700/80 transition-all shadow-sm group">
        <div class="flex flex-col">
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-bold mb-2">تکمیل شده (هفته اخیر)</h3>
            <p class="text-gray-900 dark:text-white text-3xl font-black">{{ $supportData['completed_recent'] ?? 0 }}</p>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
            {{-- Fixed: Changed from fa-check-double to a clean, single fa-check --}}
            <i class="fas fa-check text-2xl"></i>
        </div>
    </a>

    {{-- CARD 4: Average Response Time (Static Metric Box - NOT a link) --}}
<div class="flex items-center justify-between p-6 bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-3xl shadow-sm">
        <div class="flex flex-col">
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-bold mb-2">میانگین زمان پاسخ</h3>
            <p class="text-gray-900 dark:text-white text-2xl font-black">{{ $supportData['avg_response_time'] ?? '---' }}</p>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
            <i class="fas fa-stopwatch text-2xl"></i>
        </div>
    </div>

    </div>

    {{-- TABLE: MY ACTIVE TICKETS (NOW FULL WIDTH) --}}
    <div class="dashboard-card bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
        <div class="dashboard-card-header px-6 py-5 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-800/50">
            <h3 class="dashboard-card-title text-lg font-black text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fas fa-inbox text-blue-500"></i> در دست اقدام من
            </h3>
            <a href="{{ route('tickets.index', ['filter' => 'my_active']) }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                مشاهده همه &leftarrow;
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full border-collapse table-custom">
                <thead class="bg-gray-50 dark:bg-slate-900/50 text-gray-500 dark:text-gray-400 text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">اولویت</th>
                        <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-right">عنوان</th>
                        <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">دسته‌بندی</th>
                        <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">کاربر</th>
                        <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">آخرین بروزرسانی</th>
                        <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700 text-sm">
                    @forelse ($supportData['my_active_tickets_list'] ?? [] as $ticket)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 text-center">
                                @if($ticket->priority === 'high')
                                    <span class="bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-full text-[10px] font-bold px-3 py-1">بالا</span>
                                @elseif($ticket->priority === 'medium')
                                    <span class="bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full text-[10px] font-bold px-3 py-1">متوسط</span>
                                @else
                                    <span class="bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full text-[10px] font-bold px-3 py-1">عادی</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-gray-900 dark:text-white">
                                {{ Str::limit($ticket->title, 50) }}
                            </td>
                            <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-400">
                                {{ __($ticket->category) }}
                            </td>
                            <td class="px-6 py-4 text-center font-medium text-gray-700 dark:text-gray-300">
                                {{ $ticket->user->name ?? '---' }}
                            </td>
                            <td class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 text-xs dir-ltr">
                                {{ $ticket->updated_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('tickets.show', $ticket) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-bold transition-colors">
                                    مشاهده
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-16 text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-check-double text-5xl mb-3 opacity-30 text-blue-500"></i>
                                    <span class="font-bold text-lg">درخواستی در دست اقدام ندارید. خسته نباشید!</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>