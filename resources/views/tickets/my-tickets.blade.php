<x-app-layout>
    @section('title', 'درخواست‌های من')

    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight flex items-center gap-2">
            <i class="fas fa-list-ul text-blue-500"></i>
            {{ __('درخواست‌های من') }}
        </h2>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- MAIN TABLE CONTAINER --}}
            <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
                
                {{-- Table Card Header (Premium styling) --}}
                <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-800/50 transition-colors">
                    <h3 class="font-black text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fas fa-ticket-alt text-blue-500"></i> لیست درخواست‌های ثبت شده
                    </h3>
                    
                    {{-- Quick Action Button --}}
                    <a href="{{ route('tickets.create') }}" class="group flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-bold transition-all shadow-md shadow-blue-500/20 hover:shadow-blue-500/40">
                        <i class="fas fa-plus transition-transform group-hover:rotate-90"></i>
                        <span class="hidden sm:inline">درخواست جدید</span>
                    </a>
                </div>

                {{-- Table Data --}}
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-50 dark:bg-slate-900/50 text-gray-500 dark:text-gray-400 text-xs uppercase font-semibold transition-colors">
                            <tr>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-right">عنوان درخواست</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">وضعیت</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">اولویت</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">آخرین بروزرسانی</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">عملیات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700 text-sm">
                            @forelse ($tickets as $ticket)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                                    
                                    {{-- Title --}}
                                    <td class="px-6 py-4 text-right font-bold text-gray-900 dark:text-white">
                                        {{ Str::limit($ticket->title, 50) }}
                                    </td>
                                    
                                    {{-- Status Badge --}}
                                    <td class="px-6 py-4 text-center">
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
                                        <span class="px-3 py-1 border rounded-full text-xs font-bold {{ $badgeClass }} whitespace-nowrap">
                                            {{ __($ticket->status) }}
                                        </span>
                                    </td>

                                    {{-- Priority Badge --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($ticket->priority === 'high')
                                            <span class="bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-full text-xs font-bold px-3 py-1 whitespace-nowrap">بالا</span>
                                        @elseif($ticket->priority === 'medium')
                                            <span class="bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full text-xs font-bold px-3 py-1 whitespace-nowrap">متوسط</span>
                                        @else
                                            <span class="bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full text-xs font-bold px-3 py-1 whitespace-nowrap">عادی</span>
                                        @endif
                                    </td>
                                    
                                    {{-- Last Updated --}}
                                    <td class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 text-xs">
                                        <span class="dir-ltr inline-block">{{ $ticket->updated_at->diffForHumans() }}</span>
                                    </td>
                                    
                                    {{-- Action Button --}}
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="inline-flex items-center justify-center gap-1 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-bold transition-colors">
                                            <span>مشاهده</span>
                                            <i class="fas fa-eye text-xs ml-1"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-16">
                                        <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-folder-open text-6xl mb-4 opacity-20 dark:text-slate-500 transition-colors"></i>
                                            <span class="text-lg font-bold text-gray-600 dark:text-gray-300">شما تاکنون هیچ درخواستی ثبت نکرده‌اید.</span>
                                            <a href="{{ route('tickets.create') }}" class="mt-4 text-blue-600 dark:text-blue-400 hover:underline font-bold">ثبت اولین درخواست</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination (Checks if pagination exists) --}}
                @if (method_exists($tickets, 'links') && $tickets->hasPages())
                    <div class="p-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 transition-colors">
                        {{ $tickets->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>