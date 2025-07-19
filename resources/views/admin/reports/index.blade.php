<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('گزارش‌های عملکرد سیستم') }}
        </h2>
    </x-slot>

    @pushOnce('styles')
    <style>
        .report-card {
            background-color: #ffffff;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .report-card-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }
        .report-card-value {
            font-size: 2.25rem;
            font-weight: 700;
            color: #1f2937;
        }
        .rating-stars {
            color: #f59e0b; /* Amber-500 */
        }
        .table-bordered {
            border-collapse: collapse;
        }
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #e5e7eb; /* gray-200 */
            /* --- FIX: Added padding for more space --- */
            padding: 1rem; /* Adjust this value if you want more or less space */
        }
    </style>
    @endPushOnce

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Top Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="report-card">
                    <p class="report-card-title">کل درخواست‌ها</p>
                    <p class="report-card-value">{{ $totalTickets }}</p>
                </div>
                <div class="report-card">
                    <p class="report-card-title">درخواست‌های تکمیل شده</p>
                    <p class="report-card-value">{{ $completedTickets }}</p>
                </div>
                <div class="report-card">
                    <p class="report-card-title">میانگین رضایت کاربران</p>
                    <p class="report-card-value rating-stars">
                        {{ number_format($averageRating, 2) }} <span class="text-lg">&#9733;</span>
                    </p>
                </div>
                <div class="report-card">
                    <p class="report-card-title">میانگین زمان حل درخواست</p>
                    <p class="report-card-value">{{ $avgResolutionTime }}</p>
                </div>
            </div>

            {{-- Support Staff Performance Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold">عملکرد کارشناسان پشتیبانی</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-custom table-bordered">
                        <thead>
                            <tr class="bg-gray-50">
                                <th>نام کارشناس</th>
                                <th>تعداد درخواست‌های تکمیل شده</th>
                                <th>میانگین امتیاز رضایت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($supportPerformance as $support)
                                <tr>
                                    <td class="font-medium text-center">{{ $support->name }}</td>
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
</x-app-layout>
