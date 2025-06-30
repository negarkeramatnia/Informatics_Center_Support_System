<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="dashboard-card p-6 text-center bg-red-500 text-white">
        <p class="text-5xl font-bold">{{ $supportData['new_tickets_count'] ?? 0 }}</p><p class="font-semibold mt-1">درخواست جدید</p>
    </div>
    <div class="dashboard-card p-6 text-center bg-blue-500 text-white">
        <p class="text-5xl font-bold">{{ $supportData['assigned_to_me_count'] ?? 0 }}</p><p class="font-semibold mt-1">ارجاع شده به من</p>
    </div>
    <div class="dashboard-card p-6 text-center bg-green-500 text-white">
        <p class="text-5xl font-bold">{{ $supportData['resolved_today_count'] ?? 0 }}</p><p class="font-semibold mt-1">حل شده امروز</p>
    </div>
</div>
<div class="dashboard-card">
    <div class="dashboard-card-header"><h3 class="dashboard-card-title"><i class="fas fa-exclamation-circle mr-2 text-red-500"></i>نیاز به رسیدگی فوری</h3></div>
    <div class="overflow-x-auto">
        <table class="w-full table-custom">
            <thead><tr><th>عنوان</th><th>کاربر</th><th>اولویت</th><th>زمان ثبت</th><th></th></tr></thead>
            <tbody>
                @forelse ($supportData['new_high_priority_tickets'] ?? [] as $ticket)
                    <tr>
                        <td class="font-medium text-gray-900">{{ Str::limit($ticket->title, 50) }}</td>
                        <td>{{ $ticket->user->name ?? 'N/A' }}</td>
                        <td><span class="priority-{{$ticket->priority}} font-semibold">{{ __($ticket->priority) }}</span></td>
                        <td class="text-sm text-gray-500">{{ $ticket->created_at->diffForHumans() }}</td>
                        <td><a href="{{ route('tickets.show', $ticket) }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">بررسی</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-6 text-gray-500">درخواستی با اولویت بالا یافت نشد.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>