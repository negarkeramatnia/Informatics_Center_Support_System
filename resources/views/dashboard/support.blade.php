<div class="dashboard-card">
    <div class="dashboard-card-header"><h3 class="dashboard-card-title"><i class="fas fa-inbox mr-2 text-red-500"></i>درخواست‌های جدید نیازمند بررسی</h3></div>
    <div class="overflow-x-auto">
        <table class="w-full table-custom">
            <thead><tr><th>عنوان</th><th>کاربر</th><th>اولویت</th><th>زمان ثبت</th><th></th></tr></thead>
            <tbody>
                @forelse ($supportData['new_tickets'] ?? [] as $ticket)
                    <tr>
                        <td class="font-medium text-gray-900">{{ Str::limit($ticket->title, 50) }}</td>
                        <td>{{ $ticket->user->name ?? 'N/A' }}</td>
                        <td><span class="priority-{{$ticket->priority}} font-semibold">{{ __($ticket->priority) }}</span></td>
                        <td class="text-sm text-gray-500">{{ $ticket->created_at->diffForHumans() }}</td>
                        <td><a href="{{ route('tickets.show', $ticket) }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">بررسی</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-6 text-gray-500">در حال حاضر درخواست جدیدی وجود ندارد.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>