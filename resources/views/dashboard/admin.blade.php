@pushOnce('styles')
<style>
    .stat-card {
        background-color: #ffffff;
        border-radius: 0.75rem;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none; /* Ensure links don't have underlines */
        color: inherit;
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
    .quick-action-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        background-color: #f9fafb;
        border-radius: 0.75rem;
        transition: background-color 0.2s, transform 0.2s;
        color: #374151;
        font-weight: 600;
        text-decoration: none;
    }
    .quick-action-card:hover {
        background-color: #f3f4f6;
        transform: translateY(-2px);
    }
</style>
@endPushOnce

<div class="space-y-8">
    {{-- Top Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="{{ route('tickets.index', ['filter' => 'open']) }}" class="stat-card">
            <div class="stat-icon bg-red-100 text-red-600"><i class="fas fa-folder-open fa-lg"></i></div>
            <div>
                <p class="text-sm font-medium text-gray-500">درخواست‌های باز</p>
                <p class="text-3xl font-bold text-gray-800">{{ $adminData['total_open_tickets'] ?? 0 }}</p>
            </div>
        </a>
        <a href="{{ route('tickets.index', ['filter' => 'unassigned']) }}" class="stat-card">
            <div class="stat-icon bg-yellow-100 text-yellow-600"><i class="fas fa-user-clock fa-lg"></i></div>
            <div>
                <p class="text-sm font-medium text-gray-500">ارجاع نشده</p>
                <p class="text-3xl font-bold text-gray-800">{{ $adminData['unassigned_tickets'] ?? 0 }}</p>
            </div>
        </a>
        <a href="{{ route('admin.users.index') }}" class="stat-card">
            <div class="stat-icon bg-purple-100 text-purple-600"><i class="fas fa-users fa-lg"></i></div>
            <div>
                <p class="text-sm font-medium text-gray-500">کل کاربران</p>
                <p class="text-3xl font-bold text-gray-800">{{ $adminData['total_users'] ?? 0 }}</p>
            </div>
        </a>
        <a href="{{ route('admin.assets.index') }}" class="stat-card">
            <div class="stat-icon bg-blue-100 text-blue-600"><i class="fas fa-microchip fa-lg"></i></div>
            <div>
                <p class="text-sm font-medium text-gray-500">کل قطعات</p>
                <p class="text-3xl font-bold text-gray-800">{{ $adminData['total_assets'] ?? 0 }}</p>
            </div>
        </a>
    </div>

    {{-- Quick Actions Panel --}}
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <h3 class="dashboard-card-title"><i class="fas fa-bolt mr-2 text-gray-400"></i> دسترسی سریع</h3>
        </div>
        <div class="p-6 grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.users.index') }}" class="quick-action-card">
                <i class="fas fa-users-cog text-2xl text-blue-600 mb-2"></i>
                <span>مدیریت کاربران</span>
            </a>
            <a href="{{ route('admin.assets.index') }}" class="quick-action-card">
                <i class="fas fa-hdd text-2xl text-blue-600 mb-2"></i>
                <span>مدیریت قطعات</span>
            </a>
            <a href="{{ route('admin.reports.index') }}" class="quick-action-card">
                <i class="fas fa-chart-line text-2xl text-blue-600 mb-2"></i>
                <span>گزارش‌ها</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="quick-action-card">
                <i class="fas fa-cog text-2xl text-blue-600 mb-2"></i>
                <span>تنظیمات</span>
            </a>
        </div>
    </div>
    
    {{-- Unassigned Tickets Table --}}
    <div class="mt-8">
        <div class="dashboard-card">
            <div class="dashboard-card-header flex justify-between items-center">
                <h3 class="dashboard-card-title"><i class="fas fa-inbox mr-2 text-gray-400"></i> درخواست‌های ارجاع‌نشده</h3>
                <a href="{{ route('tickets.index') }}" class="text-sm text-blue-600 hover:underline font-medium">مشاهده همه</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full table-custom">
                    <thead>
                        <tr>
                            <th>عنوان</th>
                            <th>دسته‌بندی</th>
                            <th>کاربر</th>
                            <th>اولویت</th>
                            <th>زمان ثبت</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($adminData['recent_unassigned_tickets'] ?? [] as $ticket)
<tr>
            <td class="font-medium text-gray-900">{{ Str::limit($ticket->title, 45) }}</td>
            
            {{-- <--- ADD THIS LINE --}}
            <td class="text-sm text-gray-600">{{ $ticket->category_label }}</td> 
            
            <td>{{ $ticket->user->name ?? 'N/A' }}</td>
            <td><span class="priority-badge priority-{{$ticket->priority}}">{{ __($ticket->priority) }}</span></td>
            <td class="text-sm text-gray-500">{{ $ticket->created_at->diffForHumans() }}</td>
            <td>
                <a href="{{ route('tickets.show', $ticket) }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">بررسی و ارجاع</a>
            </td>
        </tr>
    @empty
                            <tr><td colspan="5" class="text-center py-6 text-gray-500">هیچ درخواست ارجاع‌نشده‌ای وجود ندارد.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>