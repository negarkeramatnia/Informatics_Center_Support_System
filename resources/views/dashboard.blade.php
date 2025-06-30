<x-app-layout>
    {{-- Page Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center" dir="rtl">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('داشبورد') }}
            </h2>
            {{-- Primary Call-to-Action button, visible only for regular users --}}
            @if(Auth::user()->role === 'user')
                <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="fas fa-plus ml-2"></i> ثبت درخواست جدید
                </a>
            @endif
        </div>
    </x-slot>

    {{-- Custom Styles for this Dashboard Page --}}
    @pushOnce('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-family: 'Vazirmatn', sans-serif !important;
            background-color: #f4f6f9; /* A professional, neutral background color */
        }
        .dashboard-card {
            background-color: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease-in-out;
        }
        .dashboard-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transform: translateY(-3px);
        }
        .dashboard-card-header {
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 1.5rem;
        }
        .dashboard-card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
        }
        .dashboard-card-content {
            padding: 1.5rem;
        }
        .table-custom th {
            background-color: #f9fafb;
            color: #374151;
            font-weight: 600;
            text-align: right;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .table-custom td, .table-custom th {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .status-badge {
            padding: 0.25em 0.75em;
            font-size: 0.75rem;
            font-weight: 500;
            border-radius: 9999px; /* pill shape */
            display: inline-block;
        }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-in_progress { background-color: #dbeafe; color: #1e40af; }
        .status-completed { background-color: #d1fae5; color: #065f46; }
        .priority-high { color: #ef4444; }
        .priority-medium { color: #f59e0b; }
        .priority-low { color: #10b981; }

        .quick-action-link {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-radius: 0.5rem;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            color: #374151;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }
        .quick-action-link:hover {
            background-color: #eff6ff;
            border-color: #93c5fd;
            color: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .quick-action-link i {
            font-size: 1.25rem;
            margin-left: 0.75rem;
            width: 2rem;
            text-align: center;
        }
    </style>
    @endPushOnce

    <div class="py-8" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Welcome Banner --}}
            <div class="mb-8 px-6 py-4 bg-white dark:bg-gray-800 shadow-md sm:rounded-lg border-l-4 border-blue-600 dark:border-blue-500">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    خوش آمدید، {{ Auth::user()->name }}!
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    در اینجا خلاصه‌ای از فعالیت‌های شما آمده است.
                </p>
            </div>

            @php
                // This is placeholder data. In your real DashboardController, you will fetch this data and pass it to the view.
                $userRole = Auth::user()->role;
            @endphp

            {{-- =================================== --}}
            {{--        EMPLOYEE DASHBOARD VIEW        --}}
            {{-- =================================== --}}
            @if ($userRole === 'user')
                <div class="dashboard-card">
                    <div class="dashboard-card-header flex justify-between items-center">
                        <h3 class="dashboard-card-title"><i class="fas fa-ticket-alt mr-2 text-gray-400"></i>آخرین درخواست‌های شما</h3>
                        <a href="{{ url('/tickets/my') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-400 font-medium">مشاهده همه</a>
                    </div>
                    <div class="dashboard-card-content p-0">
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-custom">
                                <thead>
                                    <tr>
                                        <th>عنوان</th>
                                        <th>وضعیت</th>
                                        <th>اولویت</th>
                                        <th>آخرین بروزرسانی</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800">
                                    @forelse ($employeeData['recent_tickets'] ?? [] as $ticket)
                                        <tr>
                                            <td class="font-medium text-gray-900 dark:text-white">{{ Str::limit($ticket->title, 45) }}</td>
                                            <td><span class="status-badge status-{{ $ticket->status }}">{{ __($ticket->status) }}</span></td>
                                            <td><span class="priority-{{$ticket->priority}}"><i class="fas fa-flag"></i> {{ __($ticket->priority) }}</span></td>
                                            <td class="text-sm text-gray-500 dark:text-gray-400">{{ $ticket->updated_at->diffForHumans() }}</td>
                                            <td><a href="{{ route('tickets.show', $ticket) }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">مشاهده</a></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-10 text-gray-500 dark:text-gray-400">
                                                <i class="fas fa-folder-open text-4xl mb-3"></i>
                                                <p>شما تاکنون درخواستی ثبت نکرده‌اید.</p>
                                                <a href="{{ route('tickets.create') }}" class="mt-4 inline-block text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5">ثبت اولین درخواست</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            {{-- =================================== --}}
            {{--        IT SUPPORT DASHBOARD VIEW      --}}
            {{-- =================================== --}}
            @elseif ($userRole === 'support')
                <div class="dashboard-card">
                    <div class="dashboard-card-header flex justify-between items-center">
                        <h3 class="dashboard-card-title"><i class="fas fa-inbox mr-2 text-gray-400"></i>درخواست‌های جدید</h3>
                        <a href="{{ url('/tickets/all?status=pending') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-400 font-medium">مشاهده همه</a>
                    </div>
                     <div class="dashboard-card-content p-0">
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-custom">
                                <thead>
                                    <tr>
                                        <th>عنوان</th>
                                        <th>کاربر</th>
                                        <th>اولویت</th>
                                        <th>زمان ثبت</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800">
                                    @forelse ($supportData['new_tickets'] ?? [] as $ticket)
                                        <tr>
                                            <td class="font-medium text-gray-900 dark:text-white">{{ Str::limit($ticket->title, 50) }}</td>
                                            <td>{{ $ticket->user->name ?? 'N/A' }}</td>
                                            <td><span class="priority-{{$ticket->priority}} font-semibold"><i class="fas fa-flag"></i> {{ __($ticket->priority) }}</span></td>
                                            <td class="text-sm text-gray-500 dark:text-gray-400">{{ $ticket->created_at->diffForHumans() }}</td>
                                            <td><a href="{{ route('tickets.show', $ticket) }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">بررسی و ارجاع</a></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center py-10 text-gray-500 dark:text-gray-400">در حال حاضر درخواست جدیدی وجود ندارد.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            {{-- =================================== --}}
            {{--          ADMIN DASHBOARD VIEW         --}}
            {{-- =================================== --}}
            @elseif ($userRole === 'admin')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    {{-- System Stats --}}
                    <div class="dashboard-card p-6 flex items-center">
                        <i class="fas fa-users text-3xl text-purple-500 ml-5"></i>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">کل کاربران</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $adminData['total_users'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="dashboard-card p-6 flex items-center">
                        <i class="fas fa-folder-open text-3xl text-red-500 ml-5"></i>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">درخواست‌های باز</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $adminData['total_open_tickets'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="dashboard-card p-6 flex items-center">
                        <i class="fas fa-microchip text-3xl text-blue-500 ml-5"></i>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">کل قطعات</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $adminData['total_assets'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                {{-- Quick Actions --}}
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                         <h3 class="dashboard-card-title"><i class="fas fa-bolt mr-2 text-gray-400"></i>دسترسی سریع</h3>
                    </div>
                    <div class="dashboard-card-content grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ url('/admin/tickets') }}" class="quick-action-link">
                            <i class="fas fa-tasks"></i> مدیریت درخواست‌ها
                        </a>
                        <a href="{{ url('/admin/users') }}" class="quick-action-link">
                            <i class="fas fa-users-cog"></i> مدیریت کاربران
                        </a>
                        <a href="{{ url('/admin/assets') }}" class="quick-action-link">
                            <i class="fas fa-hdd"></i> مدیریت قطعات
                        </a>
                        <a href="{{ url('/admin/reports') }}" class="quick-action-link">
                            <i class="fas fa-chart-line"></i> گزارشات سیستم
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>