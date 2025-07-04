<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('همه درخواست‌ها') }}
        </h2>
    </x-slot>

    @pushOnce('styles')
    <style>
        .table-custom th { background-color: #f9fafb; color: #374151; font-weight: 600; text-align: right; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; padding: 0.75rem 1.5rem; }
        .table-custom td { padding: 1rem 1.5rem; border-bottom-width: 1px; border-color: #e5e7eb; vertical-align: middle; color: #374151; }
        .table-custom tbody tr:last-child td { border-bottom-width: 0; }
        .table-custom tbody tr:hover { background-color: #f9fafb; }
        
        .status-badge, .priority-badge { padding: 0.25em 0.75em; font-size: 0.75rem; font-weight: 600; border-radius: 9999px; display: inline-block; line-height: 1.5; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-in_progress { background-color: #dbeafe; color: #1e40af; }
        .status-completed { background-color: #d1fae5; color: #065f46; }
        .priority-low { background-color: #dcfce7; color: #166534; }
        .priority-medium { background-color: #fef9c3; color: #92400e; }
        .priority-high { background-color: #fee2e2; color: #991b1b; }
    </style>
    @endPushOnce

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-custom">
                            <thead>
                                <tr>
                                    <th>عنوان درخواست</th>
                                    <th>ایجاد کننده</th>
                                    <th>وضعیت</th>
                                    <th>اولویت</th>
                                    <th>آخرین بروزرسانی</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tickets as $ticket)
                                    <tr>
                                        <td class="font-medium">{{ Str::limit($ticket->title, 40) }}</td>
                                        <td class="text-sm text-gray-600">{{ $ticket->user->name }}</td>
                                        <td><span class="status-badge status-{{ $ticket->status }}">{{ __($ticket->status) }}</span></td>
                                        <td><span class="priority-badge priority-{{ $ticket->priority }}">{{ __($ticket->priority) }}</span></td>
                                        <td class="text-sm text-gray-500">{{ $ticket->updated_at->diffForHumans() }}</td>
                                        <td>
                                            {{-- Admin can also view the ticket details --}}
                                            <a href="{{ route('tickets.show', $ticket) }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">مشاهده</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-10 text-gray-500">
                                            در حال حاضر هیچ درخواستی در سیستم ثبت نشده است.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if ($tickets->hasPages())
                        <div class="p-4 border-t border-gray-200">
                            {{ $tickets->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>