<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight flex items-center gap-2">
            <i class="fas fa-chart-pie text-blue-500"></i>
            {{ __('گزارش‌های عملکرد سیستم') }}
        </h2>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 1. Top Statistics Cards (Clickable, Dark Mode Ready) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                {{-- Card 1: Total Tickets --}}
                <a href="{{ route('admin.reports.details') }}" class="block transform transition duration-300 hover:scale-105 group">
                    <div class="bg-white dark:bg-slate-800 h-full rounded-xl p-6 shadow-sm hover:shadow-lg border border-gray-100 dark:border-slate-700 border-b-4 border-b-blue-500 transition-all flex flex-col items-center justify-center">
                        <p class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-2">کل درخواست‌ها</p>
                        <p class="text-3xl font-black text-blue-600 dark:text-blue-400">{{ $totalTickets }}</p>
                    </div>
                </a>

                {{-- Card 2: Completed Tickets --}}
                <a href="{{ route('admin.reports.details', ['status' => 'completed']) }}" class="block transform transition duration-300 hover:scale-105 group">
                    <div class="bg-white dark:bg-slate-800 h-full rounded-xl p-6 shadow-sm hover:shadow-lg border border-gray-100 dark:border-slate-700 border-b-4 border-b-green-500 transition-all flex flex-col items-center justify-center">
                        <p class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-2">درخواست‌های تکمیل شده</p>
                        <p class="text-3xl font-black text-green-600 dark:text-green-400">{{ $completedTickets }}</p>
                    </div>
                </a>

                {{-- Card 3: Average Rating --}}
                <a href="{{ route('admin.reports.details', ['rated_only' => 1]) }}" class="block transform transition duration-300 hover:scale-105 group">
                    <div class="bg-white dark:bg-slate-800 h-full rounded-xl p-6 shadow-sm hover:shadow-lg border border-gray-100 dark:border-slate-700 border-b-4 border-b-yellow-400 transition-all flex flex-col items-center justify-center">
                        <p class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-2">میانگین رضایت کاربران</p>
                        <p class="text-3xl font-black text-yellow-500 dark:text-yellow-400 flex items-center gap-2">
                            {{ number_format($averageRating, 2) }} <i class="fas fa-star text-xl"></i>
                        </p>
                    </div>
                </a>

                {{-- Card 4: Avg Resolution Time --}}
                <a href="{{ route('admin.reports.details', ['status' => 'completed']) }}" class="block transform transition duration-300 hover:scale-105 group">
                    <div class="bg-white dark:bg-slate-800 h-full rounded-xl p-6 shadow-sm hover:shadow-lg border border-gray-100 dark:border-slate-700 border-b-4 border-b-indigo-500 transition-all flex flex-col items-center justify-center">
                        <p class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-2">میانگین زمان حل</p>
                        <p class="text-3xl font-black text-indigo-600 dark:text-indigo-400">{{ $avgResolutionTime }}</p>
                    </div>
                </a>
            </div>

            {{-- 2. CHARTS SECTION --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                {{-- Chart 1: Tickets by Category --}}
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
                        <i class="fas fa-chart-pie text-gray-400"></i> توزیع موضوعی درخواست‌ها
                    </h3>
                    <div class="relative h-64 w-full">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

                {{-- Chart 2: Assets by Department --}}
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
                        <i class="fas fa-chart-bar text-gray-400"></i> توزیع تجهیزات در واحدها
                    </h3>
                    <div class="relative h-64 w-full">
                        <canvas id="locationChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- 3. Support Staff Performance Table --}}
            <div class="bg-white dark:bg-slate-800 shadow-sm rounded-xl border border-gray-300 dark:border-slate-600 mt-8 overflow-hidden">
                <div class="p-4 border-b border-gray-300 dark:border-slate-600 bg-gray-50 dark:bg-slate-900/50">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fas fa-users-cog text-blue-500"></i> عملکرد کارشناسان پشتیبانی
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-center border-collapse">
                        <thead class="bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-gray-300 text-sm font-bold uppercase">
                            <tr>
                                <th class="p-4 border-b border-gray-300 dark:border-slate-600 border-l border-gray-300 dark:border-l-slate-600">نام کارشناس</th>
                                <th class="p-4 border-b border-gray-300 dark:border-slate-600 border-l border-gray-300 dark:border-l-slate-600">تعداد درخواست‌های تکمیل شده</th>
                                <th class="p-4 border-b border-gray-300 dark:border-slate-600">میانگین امتیاز رضایت</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 dark:text-gray-200 text-sm">
                            @forelse ($supportPerformance as $support)
                                <tr class="border-b border-gray-300 dark:border-slate-600 hover:bg-blue-50 dark:hover:bg-slate-700/50 transition cursor-pointer" onclick="window.location='{{ route('admin.reports.details', ['support_id' => $support->id]) }}'">
                                    <td class="p-4 border-l border-gray-300 dark:border-l-slate-600 font-bold text-blue-600 dark:text-blue-400">
                                        {{ $support->name }}
                                    </td>
                                    <td class="p-4 border-l border-gray-300 dark:border-l-slate-600 font-bold text-lg">
                                        {{ $support->completed_tickets_count }}
                                    </td>
                                    <td class="p-4 font-bold text-yellow-500 dark:text-yellow-400 flex items-center justify-center gap-1">
                                        {{ $support->average_rating ? number_format($support->average_rating, 2) : 'N/A' }} 
                                        @if($support->average_rating) <i class="fas fa-star text-xs"></i> @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-8 text-center text-gray-500 dark:text-gray-400">
                                        هیچ کارشناس پشتیبانی برای نمایش عملکرد وجود ندارد.
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
    {{-- CHART.JS SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // Setup Dark Mode Colors for Charts
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#cbd5e1' : '#475569';
            const gridColor = isDark ? '#334155' : '#e2e8f0';

            // 1. Category Chart (Clickable)
            const ctxCategory = document.getElementById('categoryChart').getContext('2d');
            const categoryLabels = @json($categoryLabels); 
            
            new Chart(ctxCategory, {
                type: 'doughnut',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: @json($categoryCounts),
                        backgroundColor: ['#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#6b7280', '#8b5cf6', '#ec4899'], 
                        borderWidth: isDark ? 2 : 0,
                        borderColor: isDark ? '#1e293b' : '#ffffff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'right', rtl: true, labels: { color: textColor, font: { family: 'Vazirmatn' } } } },
                    cutout: '65%',
                    onClick: (e, activeElements) => {
                        if (activeElements.length > 0) {
                            const index = activeElements[0].index;
                            const selectedCategory = categoryLabels[index];
                            window.location.href = `{{ route('admin.reports.details') }}?category=${selectedCategory}`;
                        }
                    },
                    onHover: (event, chartElement) => {
                        event.native.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
                    }
                }
            });

            // 2. Location Chart 
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
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: textColor, stepSize: 1 } },
                        x: { grid: { display: false }, ticks: { color: textColor, font: { family: 'Vazirmatn' } } }
                    },
                    onClick: (e, activeElements) => {
                        if (activeElements.length > 0) {
                            const index = activeElements[0].index;
                            const selectedLocation = locationNames[index];
                            window.location.href = `{{ route('admin.reports.details') }}?location=${encodeURIComponent(selectedLocation)}`;
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