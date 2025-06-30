<x-app-layout>
    {{-- This <x-slot> populates the $header variable in your layout --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('داشبورد') }}
        </h2>
    </x-slot>

    {{-- All the content below this line is passed into the $slot variable --}}
    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 px-6 py-4 bg-white dark:bg-gray-800 shadow-md sm:rounded-lg border-l-4 border-blue-600 dark:border-blue-500">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    خوش آمدید، {{ Auth::user()->name }}!
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    در اینجا خلاصه‌ای از فعالیت‌های شما آمده است.
                </p>
            </div>

            @php
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