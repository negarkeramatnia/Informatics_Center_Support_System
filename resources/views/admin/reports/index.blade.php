<x-app-layout>
    @section('title', 'گزارش‌های سیستم')

    {{-- FIXED ALIGNMENT HEADER --}}
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center">
                <i class="fas fa-chart-pie text-blue-600 dark:text-blue-400 text-lg"></i>
            </div>
            <h2 class="font-black text-xl text-gray-900 dark:text-white leading-tight">
                {{ __('گزارش‌های عملکرد سیستم') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 1. PREMIUM STATISTIC CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                {{-- Total Tickets --}}
                <a href="{{ route('admin.reports.details') }}" class="group bg-white dark:bg-slate-800 shadow-sm hover:shadow-md rounded-2xl p-6 border border-gray-100 dark:border-slate-700 flex flex-col items-center justify-center transition-all duration-300 hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">کل درخواست‌ها</p>
                    <p class="text-3xl font-black text-gray-900 dark:text-white">{{ $totalTickets }}</p>
                </a>

                {{-- Completed Tickets --}}
                <a href="{{ route('admin.reports.details', ['status' => 'completed']) }}" class="group bg-white dark:bg-slate-800 shadow-sm hover:shadow-md rounded-2xl p-6 border border-gray-100 dark:border-slate-700 flex flex-col items-center justify-center transition-all duration-300 hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-full bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-1 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">تکمیل شده</p>
                    <p class="text-3xl font-black text-gray-900 dark:text-white">{{ $completedTickets }}</p>
                </a>

                {{-- Average Rating --}}
                <a href="{{ route('admin.reports.details', ['rated_only' => 1]) }}" class="group bg-white dark:bg-slate-800 shadow-sm hover:shadow-md rounded-2xl p-6 border border-gray-100 dark:border-slate-700 flex flex-col items-center justify-center transition-all duration-300 hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-full bg-yellow-50 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-1 group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors">میانگین رضایت</p>
                    <p class="text-3xl font-black text-gray-900 dark:text-white">{{ number_format($averageRating, 2) }}</p>
                </a>

                {{-- Avg Resolution Time --}}
                <a href="{{ route('admin.reports.details', ['status' => 'completed']) }}" class="group bg-white dark:bg-slate-800 shadow-sm hover:shadow-md rounded-2xl p-6 border border-gray-100 dark:border-slate-700 flex flex-col items-center justify-center transition-all duration-300 hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-stopwatch"></i>
                    </div>
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">میانگین زمان حل</p>
                    <p class="text-3xl font-black text-gray-900 dark:text-white">{{ $avgResolutionTime }}</p>
                </a>
            </div>

            {{-- 2. CHARTS SECTION --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                {{-- Chart 1: Tickets by Category --}}
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 transition-colors">
                    <h3 class="text-lg font-black text-gray-800 dark:text-white mb-6 flex items-center gap-2">
                        <i class="fas fa-chart-pie text-gray-400"></i> توزیع موضوعی درخواست‌ها
                    </h3>
                    <div class="relative h-72 w-full">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

                {{-- Chart 2: Assets by Department --}}
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 transition-colors">
                    <h3 class="text-lg font-black text-gray-800 dark:text-white mb-6 flex items-center gap-2">
                        <i class="fas fa-building text-gray-400"></i> توزیع تجهیزات در واحدها
                    </h3>
                    <div class="relative h-72 w-full">
                        <canvas id="locationChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- 3. Support Staff Performance Table --}}
            <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 flex justify-between items-center">
                    <h3 class="text-lg font-black text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fas fa-users-cog text-blue-500"></i> عملکرد کارشناسان پشتیبانی
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-50 dark:bg-slate-900/50 text-gray-500 dark:text-gray-400 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-right">نام کارشناس</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">تعداد درخواست‌های تکمیل شده</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">میانگین امتیاز رضایت</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700 text-sm">
                            @forelse ($supportPerformance as $support)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors cursor-pointer" onclick="window.location='{{ route('admin.reports.details', ['support_id' => $support->id]) }}'">
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white text-right flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        {{ $support->name }}
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-green-600 dark:text-green-400 text-lg">
                                        {{ $support->completed_tickets_count }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($support->average_rating)
                                            <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 px-3 py-1 rounded-full font-bold">
                                                {{ number_format($support->average_rating, 2) }} <i class="fas fa-star text-xs"></i>
                                            </span>
                                        @else
                                            <span class="text-gray-400 dark:text-slate-500 font-medium">ثبت نشده</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-12 text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-users-slash text-4xl mb-3 opacity-30 text-gray-500"></i>
                                            <span class="font-bold">هیچ کارشناس پشتیبانی برای نمایش عملکرد وجود ندارد.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#94a3b8' : '#475569'; 
            const gridColor = isDark ? '#334155' : '#f1f5f9'; 
            const tooltipBg = isDark ? '#1e293b' : '#ffffff'; 
            const tooltipBorder = isDark ? '#334155' : '#e2e8f0'; 

            Chart.defaults.font.family = 'Vazirmatn, sans-serif';
            Chart.defaults.color = textColor;

            const ctxCategory = document.getElementById('categoryChart').getContext('2d');
            const categoryLabels = @json($categoryLabels); 
            
            new Chart(ctxCategory, {
                type: 'doughnut',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: @json($categoryCounts),
                        backgroundColor: ['#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#8b5cf6'], 
                        borderWidth: 2,
                        borderColor: isDark ? '#1e293b' : '#ffffff',
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { position: 'right', rtl: true, labels: { padding: 20, usePointStyle: true, pointStyle: 'circle' } },
                        tooltip: { backgroundColor: tooltipBg, titleColor: textColor, bodyColor: textColor, borderColor: tooltipBorder, borderWidth: 1, padding: 10 }
                    },
                    cutout: '70%',
                    onClick: (e, activeElements) => {
                        if (activeElements.length > 0) {
                            const index = activeElements[0].index;
                            window.location.href = `{{ route('admin.reports.details') }}?category=${categoryLabels[index]}`;
                        }
                    },
                    onHover: (event, chartElement) => {
                        event.native.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
                    }
                }
            });

            const ctxLocation = document.getElementById('locationChart').getContext('2d');
            const locationNames = @json($locationLabels); 

            new Chart(ctxLocation, {
                type: 'bar',
                data: {
                    labels: locationNames,
                    datasets: [{
                        label: 'تعداد تجهیزات',
                        data: @json($locationCounts),
                        backgroundColor: '#6366f1', 
                        hoverBackgroundColor: '#4f46e5',
                        borderRadius: 8,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false },
                        tooltip: { backgroundColor: tooltipBg, titleColor: textColor, bodyColor: textColor, borderColor: tooltipBorder, borderWidth: 1, padding: 10 }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { color: gridColor, drawBorder: false }, border: { dash: [4, 4] } },
                        x: { grid: { display: false }, border: { display: false } }
                    },
                    onClick: (e, activeElements) => {
                        if (activeElements.length > 0) {
                            const index = activeElements[0].index;
                            window.location.href = `{{ route('admin.reports.details') }}?location=${encodeURIComponent(locationNames[index])}`;
                        }
                    },
                    onHover: (event, chartElement) => {
                        event.native.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>