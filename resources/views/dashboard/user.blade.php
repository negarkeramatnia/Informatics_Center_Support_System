<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <div class="dashboard-card">
            <div class="dashboard-card-header flex justify-between items-center">
                <h3 class="dashboard-card-title"><i class="fas fa-history mr-2 text-gray-400"></i> آخرین درخواست‌های شما</h3>
                <a href="{{ url('/tickets/my') }}" class="text-sm text-blue-600 hover:underline font-medium">مشاهده همه</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full table-custom">
                    <thead><tr><th>عنوان</th><th>وضعیت</th><th>آخرین بروزرسانی</th><th></th></tr></thead>
                    <tbody>
                        @forelse ($employeeData['recent_tickets'] ?? [] as $ticket)
                            <tr>
                                <td class="font-medium text-gray-900">{{ Str::limit($ticket->title, 45) }}</td>
                                <td><span class="status-badge status-{{ $ticket->status }}">{{ __($ticket->status) }}</span></td>
                                <td class="text-sm text-gray-500">{{ $ticket->updated_at->diffForHumans() }}</td>
                                <td><a href="{{ route('tickets.show', $ticket) }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">مشاهده</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-6 text-gray-500">هیچ درخواستی یافت نشد.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="lg:col-span-1">
        <div class="dashboard-card">
             <div class="dashboard-card-header"><h3 class="dashboard-card-title"><i class="fas fa-chart-pie mr-2 text-gray-400"></i> خلاصه وضعیت</h3></div>
             <div class="p-6 space-y-4">
                <div class="flex justify-between items-center"><span class="font-medium text-gray-600">درخواست‌های باز</span><span class="font-bold text-lg text-yellow-600">{{ $employeeData['open_tickets_count'] ?? 0 }}</span></div>
                <div class="flex justify-between items-center"><span class="font-medium text-gray-600">درخواست‌های حل شده</span><span class="font-bold text-lg text-green-600">{{ $employeeData['resolved_tickets_count'] ?? 0 }}</span></div>
             </div>
         </div>
    </div>
</div>