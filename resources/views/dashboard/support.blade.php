<div class="space-y-8">
    
    {{-- KPI CARDS (4 Column Grid - NOW CLICKABLE) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        
        {{-- Active Tickets Link --}}
        <a href="{{ route('tickets.index', ['status' => 'active']) }}" class="dashboard-card group bg-white dark:bg-slate-800 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-700 flex items-center justify-between transition-all duration-300 hover:shadow-md hover:border-blue-300 dark:hover:border-blue-500 hover:-translate-y-1">
            <div>
                <p class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">درخواست‌های فعال من</p>
                <h4 class="text-3xl font-black text-gray-900 dark:text-white">{{ $activeTicketsCount ?? 1 }}</h4>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition-transform">
                <i class="fas fa-inbox"></i>
            </div>
        </a>

        {{-- High Priority Link --}}
        <a href="{{ route('tickets.index', ['priority' => 'high']) }}" class="dashboard-card group bg-white dark:bg-slate-800 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-700 flex items-center justify-between transition-all duration-300 hover:shadow-md hover:border-red-300 dark:hover:border-red-500 hover:-translate-y-1">
            <div>
                <p class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-1 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">اولویت بالا</p>
                <h4 class="text-3xl font-black text-gray-900 dark:text-white">{{ $highPriorityCount ?? 0 }}</h4>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition-transform">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </a>

        {{-- Completed This Week Link --}}
        <a href="{{ route('tickets.index', ['status' => 'completed']) }}" class="dashboard-card group bg-white dark:bg-slate-800 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-700 flex items-center justify-between transition-all duration-300 hover:shadow-md hover:border-green-300 dark:hover:border-green-500 hover:-translate-y-1">
            <div>
                <p class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-1 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">تکمیل شده (هفته اخیر)</p>
                <h4 class="text-3xl font-black text-gray-900 dark:text-white">{{ $completedThisWeek ?? 0 }}</h4>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition-transform">
                <i class="fas fa-check-circle"></i>
            </div>
        </a>

        {{-- Average Response Time Link --}}
        <a href="{{ route('tickets.index') }}" class="dashboard-card group bg-white dark:bg-slate-800 shadow-sm rounded-2xl p-6 border border-gray-100 dark:border-slate-700 flex items-center justify-between transition-all duration-300 hover:shadow-md hover:border-indigo-300 dark:hover:border-indigo-500 hover:-translate-y-1">
            <div>
                <p class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">میانگین زمان پاسخ</p>
                <h4 class="text-3xl font-black text-gray-900 dark:text-white">{{ $avgResponseTime ?? 'N/A' }}</h4>
            </div>
            <div class="w-12 h-12 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition-transform">
                <i class="fas fa-stopwatch"></i>
            </div>
        </a>
    </div>

    {{-- ACTIVE TICKETS TABLE SECTION --}}
    <div class="dashboard-card bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
        
        {{-- Table Header & View All Link --}}
        <div class="dashboard-card-header px-6 py-5 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-800/50">
            <h3 class="dashboard-card-title text-lg font-black text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fas fa-list-ul text-gray-400"></i> درخواست‌های فعال من
            </h3>
            <a href="{{ route('tickets.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                مشاهده همه &leftarrow;
            </a>
        </div>

        {{-- Table Data --}}
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
                    
                    @forelse ($activeTickets ?? [] as $ticket)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            {{-- Priority Badge --}}
                            <td class="px-6 py-4 text-center">
                                @if($ticket->priority === 'high')
                                    <span class="status-badge bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-full text-xs font-bold px-3 py-1">بالا</span>
                                @elseif($ticket->priority === 'medium')
                                    <span class="status-badge bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full text-xs font-bold px-3 py-1">متوسط</span>
                                @else
                                    <span class="status-badge bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full text-xs font-bold px-3 py-1">عادی</span>
                                @endif
                            </td>
                            
                            {{-- Title --}}
                            <td class="px-6 py-4 text-right font-bold text-gray-900 dark:text-white">
                                {{ Str::limit($ticket->title, 40) }}
                            </td>
                            
                            {{-- Category --}}
                            <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-400">
                                {{ __($ticket->category) }}
                            </td>
                            
                            {{-- User --}}
                            <td class="px-6 py-4 text-center font-medium text-gray-700 dark:text-gray-300">
                                {{ $ticket->user->name ?? '---' }}
                            </td>
                            
                            {{-- Last Updated --}}
                            <td class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 text-xs dir-ltr">
                                {{ $ticket->updated_at->diffForHumans() }}
                            </td>
                            
                            {{-- Action Button --}}
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('tickets.show', $ticket) }}" class="inline-flex items-center justify-center gap-1 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-bold transition-colors">
                                    <span>مشاهده و پاسخ</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        {{-- REDESIGNED EMPTY STATE (Sleek, Premium, and Centered) --}}
                        <tr>
                            <td colspan="6" class="text-center py-16 text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-inbox text-6xl mb-4 text-gray-300 dark:text-slate-600 transition-colors"></i>
                                    <span class="text-lg font-bold text-gray-600 dark:text-gray-300">هیچ درخواست فعالی در کارتابل شما وجود ندارد.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>