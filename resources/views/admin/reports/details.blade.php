<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                {{-- Link back to the main reports dashboard --}}
                <a href="{{ route('admin.reports.index') }}" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-right ml-1"></i> بازگشت به گزارش‌ها
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="w-full text-right border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="p-4">عنوان</th>
                                <th class="p-4">درخواست دهنده</th>
                                <th class="p-4">دسته‌بندی</th>
                                <th class="p-4">تاریخ ثبت</th>
                                <th class="p-4">وضعیت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-4 font-medium">
                                        {{-- FIX: Changed 'admin.tickets.show' to 'tickets.show' --}}
                                        <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-600 hover:underline">
                                            {{ $ticket->title }}
                                        </a>
                                    </td>
                                    <td class="p-4">
                                        {{ $ticket->user->name }} 
                                        <span class="text-xs text-gray-500">({{ $ticket->user->department ?? '---' }})</span>
                                    </td>
                                    <td class="p-4">{{ __($ticket->category) }}</td>
                                    <td class="p-4 text-sm text-gray-500">{{ $ticket->created_at->diffForHumans() }}</td>
                                    <td class="p-4">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'in_progress' => 'bg-blue-100 text-blue-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'closed' => 'bg-gray-100 text-gray-800',
                                            ];
                                            $statusClass = $statusClasses[$ticket->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 py-1 rounded text-xs {{ $statusClass }}">
                                            {{ __($ticket->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="p-4 text-center text-gray-500">موردی یافت نشد.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4">
                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>