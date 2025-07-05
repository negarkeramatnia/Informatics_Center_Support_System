@pushOnce('styles')
<style>
    .stat-card {
        background-color: #ffffff;
        border-radius: 0.75rem;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 9999px;
        margin-left: 1rem;
    }
</style>
@endPushOnce

<div class="space-y-8">
    {{-- Top Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="stat-card">
            <div class="stat-icon bg-blue-100 text-blue-600"><i class="fas fa-inbox fa-lg"></i></div>
            <div>
                <p class="text-sm font-medium text-gray-500"> درخواست‌های فعال من </p>
                <p class="text-3xl font-bold text-gray-800">{{ $supportData['my_active_tickets_count'] ?? 0 }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-red-100 text-red-600"><i class="fas fa-exclamation-triangle fa-lg"></i></div>
            <div>
                <p class="text-sm font-medium text-gray-500">اولویت بالا</p>
                <p class="text-3xl font-bold text-gray-800">{{ $supportData['high_priority_count'] ?? 0 }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-green-100 text-green-600"><i class="fas fa-check-circle fa-lg"></i></div>
            <div>
                <p class="text-sm font-medium text-gray-500">تکمیل شده (هفته اخیر)</p>
                <p class="text-3xl font-bold text-gray-800">{{ $supportData['completed_last_week'] ?? 0 }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-indigo-100 text-indigo-600"><i class="fas fa-stopwatch fa-lg"></i></div>
            <div>
                <p class="text-sm font-medium text-gray-500">میانگین زمان پاسخ</p>
                <p class="text-3xl font-bold text-gray-800">{{ $supportData['avg_response_time'] ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
    
    {{-- My Active Tickets Table --}}
    <div class="dashboard-card">
        <div class="dashboard-card-header flex justify-between items-center">
            <h3 class="dashboard-card-title"><i class="fas fa-tasks mr-2 text-gray-400"></i> درخواست‌های فعال من</h3>
            <a href="{{ route('tickets.index') }}" class="text-sm text-blue-600 hover:underline font-medium">مشاهده همه</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full table-custom">
                <thead>
                    <tr>
                        <th>اولویت</th>
                        <th>عنوان</th>
                        <th>کاربر</th>
                        <th>آخرین بروزرسانی</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($supportData['my_active_tickets_list'] ?? [] as $ticket)
                        <tr>
                            <td><span class="priority-badge priority-{{$ticket->priority}}">{{ __($ticket->priority) }}</span></td>
                            <td class="font-medium text-gray-900">{{ Str::limit($ticket->title, 50) }}</td>
                            <td>{{ $ticket->user->name ?? 'N/A' }}</td>
                            <td class="text-sm text-gray-500">{{ $ticket->updated_at->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('tickets.show', $ticket) }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">مشاهده و پاسخ</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-8 text-gray-500">
                            <i class="fas fa-check-circle text-2xl text-green-500 mb-2"></i><br>
                            شما هیچ درخواست فعالی ندارید. کار عالی!
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
