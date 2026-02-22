<x-app-layout>
    {{-- PREMIUM HEADER REDESIGN --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center w-full gap-4">
            
            <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight flex items-center gap-2">
                <i class="fas fa-list-alt text-blue-500"></i>
                {{ $title ?? __('جزئیات گزارش') }}
            </h2>
            
            <a href="{{ route('admin.reports.index') }}" class="group flex items-center gap-2 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 px-5 py-2.5 rounded-xl font-medium transition-all duration-300 border border-gray-200 dark:border-slate-600 hover:-translate-y-0.5">
                <i class="fas fa-arrow-right transition-transform group-hover:-translate-x-1"></i>
                <span>بازگشت به گزارش‌ها</span>
            </a>

        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- TICKETS TABLE SECTION --}}
            <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-right">
                        
                        <thead class="bg-gray-50 dark:bg-slate-900/50 text-gray-500 dark:text-gray-400 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">عنوان</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">درخواست دهنده</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">دسته‌بندی</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">تاریخ ثبت</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">وضعیت</th>
                            </tr>
                        </thead>
                        
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700 text-sm">
                            @forelse($tickets as $ticket)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                                    
                                    <td class="px-6 py-4 text-center font-bold">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline transition-colors">
                                            {{ $ticket->title }}
                                        </a>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center text-gray-700 dark:text-gray-300 font-medium">
                                        {{ $ticket->user->name ?? '---' }} 
                                        <span class="block text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            ({{ $ticket->user->department ?? 'بدون واحد' }})
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-400">
                                        {{ __($ticket->category) }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 dir-ltr text-xs">
                                        {{ $ticket->created_at->diffForHumans() }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        @if($ticket->status === 'pending')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800 rounded-full text-xs font-bold">در انتظار</span>
                                        @elseif($ticket->status === 'in_progress')
                                            <span class="px-3 py-1 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800 rounded-full text-xs font-bold">در حال بررسی</span>
                                        @elseif($ticket->status === 'completed' || $ticket->status === 'closed')
                                            <span class="px-3 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800 rounded-full text-xs font-bold">تکمیل شده</span>
                                        @else
                                            <span class="px-3 py-1 bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 border border-gray-200 dark:border-gray-600 rounded-full text-xs font-bold">{{ __($ticket->status) }}</span>
                                        @endif
                                    </td>
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-12 text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-folder-open text-4xl mb-3 opacity-30"></i>
                                            <span>هیچ موردی یافت نشد.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                @if(method_exists($tickets, 'links'))
                    <div class="p-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                        {{ $tickets->links() }}
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</x-app-layout>