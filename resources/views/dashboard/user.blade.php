@pushOnce('styles')
<style>
    /* --- FIX: Added styles for the dashboard statistic cards --- */
    .stat-card {
        background-color: #ffffff;
        border-radius: 0.75rem;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.07), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
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
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="stat-card">
            <div class="stat-icon bg-red-100 text-red-600"><i class="fas fa-folder-open fa-lg"></i></div>
            <div>
                <p class="text-sm font-medium text-gray-500">درخواست‌های فعال</p>
                <p class="text-3xl font-bold text-gray-800">{{ $employeeData['open_tickets_count'] ?? 0 }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-green-100 text-green-600"><i class="fas fa-check-circle fa-lg"></i></div>
            <div>
                <p class="text-sm font-medium text-gray-500">درخواست‌های تکمیل شده</p>
                <p class="text-3xl font-bold text-gray-800">{{ $employeeData['resolved_tickets_count'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    {{-- Recent Tickets Table --}}
    <div class="dashboard-card">
        <div class="dashboard-card-header flex justify-between items-center">
            <h3 class="dashboard-card-title"><i class="fas fa-history mr-2 text-gray-400"></i> آخرین درخواست‌های من</h3>
            <a href="{{ route('tickets.my') }}" class="text-sm text-blue-600 hover:underline font-medium">مشاهده همه</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full table-custom">
                <thead>
                    <tr>
                        <th>عنوان</th>
                        <th>وضعیت</th>
                        <th>آخرین بروزرسانی</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employeeData['recent_tickets'] as $ticket)
                        <tr>
                            <td class="font-medium text-gray-900">{{ Str::limit($ticket->title, 50) }}</td>
                            <td><span class="status-badge status-{{$ticket->status}}">{{ __($ticket->status) }}</span></td>
                            <td class="text-sm text-gray-500">{{ $ticket->updated_at->diffForHumans() }}</td>
                            <td><a href="{{ route('tickets.show', $ticket) }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">مشاهده</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-6 text-gray-500">شما تاکنون درخواستی ثبت نکرده‌اید.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Assigned Assets Table --}}
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <h3 class="dashboard-card-title"><i class="fas fa-laptop mr-2 text-gray-400"></i> دستگاه‌های اختصاص یافته به من</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full table-custom">
                <thead>
                    <tr>
                        <th>نام دستگاه</th>
                        <th>شماره سریال</th>
                        <th>وضعیت</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employeeData['userAssets'] as $asset)
                        <tr>
                            <td class="font-medium text-gray-900">{{ $asset->name }}</td>
                            <td><span class="font-mono bg-gray-200 text-gray-700 px-2 py-1 rounded">{{ $asset->serial_number }}</span></td>
                            <td><span class="status-badge status-{{ str_replace('_', '-', $asset->status) }}">{{ __($asset->status) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center py-6 text-gray-500">هیچ دستگاهی به شما اختصاص داده نشده است.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
