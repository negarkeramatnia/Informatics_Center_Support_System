<x-app-layout>
<x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center w-full gap-4">
            
            <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight flex items-center gap-2">
                <i class="fas fa-ticket-alt text-blue-500"></i>
                {{ __('همه درخواست‌ها') }}
            </h2>
            
            <a href="{{ route('tickets.create') }}" class="group flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-all duration-300 shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5">
                <i class="fas fa-plus-circle transition-transform group-hover:rotate-90"></i>
                <span>ثبت درخواست جدید</span>
            </a>

        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full text-right border-collapse">
                        
                        <thead class="bg-gray-50 dark:bg-slate-900/50 text-gray-500 dark:text-gray-400 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">عنوان درخواست</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">ایجاد کننده</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">دسته‌بندی</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">وضعیت</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">اولویت</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">آخرین بروزرسانی</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">عملیات</th>
                            </tr>
                        </thead>
                        
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700 text-sm">
                            @forelse ($tickets as $ticket)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                                    
                                    {{-- 🔴 THE FIX: Added dark:text-white to ensure the title is highly visible --}}
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                        {{ Str::limit($ticket->title, 45) }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300 font-medium">
                                        {{ $ticket->user->name ?? 'کاربر' }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                        {{ $ticket->category_label ?? $ticket->category }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <span class="status-badge status-{{$ticket->status}} dark:opacity-90">
                                            {{ __($ticket->status) }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <span class="priority-badge priority-{{$ticket->priority}} dark:opacity-90">
                                            {{ __($ticket->priority) }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 dir-ltr">
                                        {{ $ticket->updated_at->diffForHumans() }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-bold transition-colors">
                                            مشاهده
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-12 text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-inbox text-4xl mb-3 opacity-30"></i>
                                            <span>هیچ درخواستی یافت نشد.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links (if they exist) --}}
                @if(method_exists($tickets, 'links'))
                    <div class="p-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                        {{ $tickets->links() }}
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</x-app-layout>