<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('داشبورد') }}
        </h2>
    </x-slot>

    @pushOnce('styles')
    <style>
        .dashboard-card { background-color: #fff; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.06); }
        .dashboard-card-header { border-bottom: 1px solid #e5e7eb; padding: 1rem 1.5rem; }
        .dashboard-card-title { font-size: 1.125rem; font-weight: 600; color: #1f2937; }
        .table-custom th { background-color: #f9fafb; color: #4b5563; font-weight: 600; text-align: right; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; padding: 0.75rem 1.5rem; }
        .table-custom td { padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb; }
        .status-badge { padding: 0.25em 0.75em; font-size: 0.75rem; font-weight: 500; border-radius: 9999px; display: inline-block; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-in_progress { background-color: #dbeafe; color: #1e40af; }
        .status-completed { background-color: #d1fae5; color: #065f46; }
    </style>
    @endPushOnce

    <div dir="rtl">
        @if (session('success'))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-md" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @php $userRole = Auth::user()->role; @endphp

        @if($userRole === 'admin')
            @include('dashboard.admin')
        @elseif($userRole === 'support')
            @include('dashboard.support')
        @else
            @include('dashboard.user')
        @endif
    </div>
</x-app-layout>