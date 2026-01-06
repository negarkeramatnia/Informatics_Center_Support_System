@pushOnce('styles')
<style>
    .stat-card {
        /* Removed hardcoded background-color: #ffffff */
        border-radius: 0.75rem;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s, box-shadow 0.2s, background-color 0.3s;
        text-decoration: none;
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
        border-radius: 0.75rem;
        transition: background-color 0.2s, transform 0.2s;
        font-weight: 600;
        text-decoration: none;
    }
    .quick-action-card:hover {
        transform: translateY(-2px);
    }
</style>
@endPushOnce

<div class="space-y-8">
    {{-- Top Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <a href="{{ route('tickets.index', ['filter' => 'open']) }}" class="stat-card bg-white dark:bg-gray-800 border border-transparent dark:border-gray-700">
            <div class="stat-icon bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400"><i class="fas fa-folder-open fa-lg"></i></div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">درخواست‌های باز</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $adminData['total_open_tickets'] ?? 0 }}</p>
            </div>
        </a>

        <a href="{{ route('tickets.index', ['filter' => 'unassigned']) }}" class="stat-card bg-white dark:bg-gray-800 border border-transparent dark:border-gray-700">
            <div class="stat-icon bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400"><i class="fas fa-user-clock fa-lg"></i></div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ارجاع نشده</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $adminData['unassigned_tickets'] ?? 0 }}</p>
            </div>
        </a>

        <a href="{{ route('admin.users.index') }}" class="stat-card bg-white dark:bg-gray-800 border border-transparent dark:border-gray-700">
            <div class="stat-icon bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400"><i class="fas fa-users fa-lg"></i></div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">تمام کاربران</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $adminData['total_users'] ?? 0 }}</p>
            </div>
        </a>

        <a href="{{ route('admin.assets.index') }}" class="stat-card bg-white dark:bg-gray-800 border border-transparent dark:border-gray-700">
            <div class="stat-icon bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400"><i class="fas fa-microchip fa-lg"></i></div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">تمام قطعات</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $adminData['total_assets'] ?? 0 }}</p>
            </div>
        </a>
    </div>

    {{-- Quick Actions Panel --}}
    <div class="dashboard-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-transparent dark:border-gray-700">
        <div class="dashboard-card-header border-b border-gray-100 dark:border-gray-700 p-4">
            <h3 class="dashboard-card-title text-lg font-bold text-gray-800 dark:text-white">
                <i class="fas fa-bolt mr-2 text-gray-400 dark:text-gray-500"></i> دسترسی سریع
            </h3>
        </div>
        <div class="p-6 grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.users.index') }}" class="quick-action-card bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-100 dark:border-gray-600">
                <i class="fas fa-users-cog text-2xl text-blue-600 dark:text-blue-400 mb-2"></i>
                <span>مدیریت کاربران</span>
            </a>
            <a href="{{ route('admin.assets.index') }}" class="quick-action-card bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-100 dark:border-gray-600">
                <i class="fas fa-hdd text-2xl text-blue-600 dark:text-blue-400 mb-2"></i>
                <span>مدیریت قطعات</span>
            </a>
            <a href="{{ route('admin.reports.index') }}" class="quick-action-card bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-100 dark:border-gray-600">
                <i class="fas fa-chart-line text-2xl text-blue-600 dark:text-blue-400 mb-2"></i>
                <span>گزارش‌ها</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="quick-action-card bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-100 dark:border-gray-600">
                <i class="fas fa-cog text-2xl text-blue-600 dark:text-blue-400 mb-2"></i>
                <span>تنظیمات</span>
            </a>
        </div>
    </div>
    
    {{-- Unassigned Tickets Table --}}
    <div class="mt-8">
        <div class="dashboard-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-transparent dark:border-gray-700">
            <div class="dashboard-card-header border-b border-gray-100 dark:border-gray-700 p-4 flex justify-between items-center">
                <h3 class="dashboard-card-title text-lg font-bold text-gray-800 dark:text-white">
                    <i class="fas fa-inbox mr-2 text-gray-400 dark:text-gray-500"></i> درخواست‌های ارجاع‌نشده
                </h3>
                <a href="{{ route('tickets.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline font-medium">مشاهده همه</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead class="bg-gray-50 dark:bg-gray-900/50 text-gray-500 dark:text-gray-400 text-xs uppercase font-semibold">
                        <tr>
                            <th class="px-6 py-4">عنوان</th>
                            <th class="px-6 py-4">دسته‌بندی</th>
                            <th class="px-6 py-4">کاربر</th>
                            <th class="px-6 py-4">اولویت</th>
                            <th class="px-6 py-4">زمان ثبت</th>
                            <th class="px-6 py-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                        @forelse ($adminData['recent_unassigned_tickets'] ?? [] as $ticket)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ Str::limit($ticket->title, 45) }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $ticket->category_label }}</td> 
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $ticket->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <span class="priority-badge priority-{{$ticket->priority}} dark:opacity-90">{{ __($ticket->priority) }}</span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $ticket->created_at->diffForHumans() }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-semibold">بررسی و ارجاع</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500 dark:text-gray-400">هیچ درخواست ارجاع‌نشده‌ای وجود ندارد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>