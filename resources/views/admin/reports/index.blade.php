<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('گزارش‌های عملکرد سیستم') }}
        </h2>
    </x-slot>

    @pushOnce('styles')
    <style>
        .report-card { background-color: #ffffff; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
        .report-card-title { font-size: 0.875rem; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem; }
        .report-card-value { font-size: 2.25rem; font-weight: 700; color: #1f2937; }
        .rating-stars { color: #f59e0b; }
        .table-bordered { border-collapse: collapse; }
        .table-bordered th, .table-bordered td { border: 1px solid #e5e7eb; padding: 1rem; }
    </style>
    @endPushOnce

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 1. Top Statistics Cards (Clickable) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                {{-- Card 1: Total Tickets --}}
                <a href="{{ route('admin.reports.details') }}" class="block transform transition duration-200 hover:scale-105">
                    <div class="report-card h-full border-b-4 border-blue-500 hover:shadow-lg transition">
                        <p class="report-card-title">کل درخواست‌ها</p>
                        <p class="report-card-value text-blue-600">{{ $totalTickets }}</p>
                    </div>
                </a>

                {{-- Card 2: Completed Tickets --}}
                <a href="{{ route('admin.reports.details', ['status' => 'completed']) }}" class="block transform transition duration-200 hover:scale-105">
                    <div class="report-card h-full border-b-4 border-green-500 hover:shadow-lg transition">
                        <p class="report-card-title">درخواست‌های تکمیل شده</p>
                        <p class="report-card-value text-green-600">{{ $completedTickets }}</p>
                    </div>
                </a>

                {{-- Card 3: Average Rating --}}
                <a href="{{ route('admin.reports.details', ['rated_only' => 1]) }}" class="block transform transition duration-200 hover:scale-105">
                    <div class="report-card h-full border-b-4 border-yellow-400 hover:shadow-lg transition">
                        <p class="report-card-title">میانگین رضایت کاربران</p>
                        <p class="report-card-value rating-stars">
                            {{ number_format($averageRating, 2) }} <span class="text-lg">&#9733;</span>
                        </p>
                    </div>
                </a>

                {{-- Card 4: Avg Resolution Time --}}
                <a href="{{ route('admin.reports.details', ['status' => 'completed']) }}" class="block transform transition duration-200 hover:scale-105">
                    <div class="report-card h-full border-b-4 border-indigo-500 hover:shadow-lg transition">
                        <p class="report-card-title">میانگین زمان حل</p>
                        <p class="report-card-value text-xl mt-2 text-indigo-600">{{ $avgResolutionTime }}</p>
                    </div>
                </a>
            </div>

            {{-- 2. CHARTS SECTION --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                {{-- Chart 1: Tickets by Category --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700">توزیع موضوعی درخواست‌ها</h3>
                    <div class="relative h-64">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

                {{-- Chart 2: Assets by Department --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700">توزیع تجهیزات در واحدها</h3>
                    <div class="relative h-64">
                        <canvas id="locationChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- 3. Support Staff Performance Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold">عملکرد کارشناسان پشتیبانی</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-custom table-bordered">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="text-center">نام کارشناس</th>
                                <th class="text-center">تعداد درخواست‌های تکمیل شده</th>
                                <th class="text-center">میانگین امتیاز رضایت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($supportPerformance as $support)
                                <tr class="hover:bg-blue-50 transition cursor-pointer" onclick="window.location='{{ route('admin.reports.details', ['support_id' => $support->id]) }}'">
                                    <td class="font-medium text-center text-blue-600 underline-offset-4">{{ $support->name }}</td>
                                    <td class="text-center">{{ $support->completed_tickets_count }}</td>
                                    <td class="text-center rating-stars font-semibold">
                                        {{ $support->average_rating ? number_format($support->average_rating, 2) : 'N/A' }}
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center py-8 text-gray-500">هیچ کارشناس پشتیبانی برای نمایش عملکرد وجود ندارد.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- CHART.JS SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
        // 1. Category Chart (Clickable)
        const ctxCategory = document.getElementById('categoryChart').getContext('2d');
        
        // USE DYNAMIC LABELS FROM CONTROLLER
        const categoryLabels = @json($categoryLabels); 
        
        new Chart(ctxCategory, {
            type: 'doughnut',
            data: {
                labels: categoryLabels, // Use the variable here
                datasets: [{
                    data: @json($categoryCounts),
                    backgroundColor: ['#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#6b7280', '#8b5cf6', '#ec4899'], // Added more colors just in case you add more categories
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'right', rtl: true, labels: { font: { family: 'Vazirmatn' } } } },
                onClick: (e, activeElements) => {
                    if (activeElements.length > 0) {
                        const index = activeElements[0].index;
                        const selectedCategory = categoryLabels[index];
                        // Redirect to details page
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
                    label: 'تعداد تجهیزات (مشاهده لیست)',
                    data: @json($locationCounts),
                    backgroundColor: '#6366f1',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { display: false } },
                    x: { grid: { display: false }, ticks: { font: { family: 'Vazirmatn' } } }
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
    </script>
</x-app-layout>