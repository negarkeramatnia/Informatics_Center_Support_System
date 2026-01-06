<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('داشبورد') }}
        </h2>
    </x-slot>

    @pushOnce('styles')
    <style>
        /* === LIGHT MODE (Default Table & Badge Styles) === */
        .table-custom th { background-color: #f9fafb; color: #4b5563; font-weight: 600; text-align: right; font-size: 0.75rem; text-transform: uppercase; padding: 0.75rem 1.5rem; }
        .table-custom td { padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb; }
        .status-badge { padding: 0.25em 0.75em; font-size: 0.75rem; font-weight: 500; border-radius: 9999px; display: inline-block; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-in_progress { background-color: #dbeafe; color: #1e40af; }
        .status-completed { background-color: #d1fae5; color: #065f46; }

        /* ==========================================================
           🚀 THE ULTIMATE DARK MODE ENFORCER FOR DASHBOARD CARDS
           ========================================================== */
        
        /* 1. Force ANY white background or shadowed box to become Slate 800 */
        html.dark #dashboard-wrapper .bg-white,
        html.dark #dashboard-wrapper [class*="bg-white"],
        html.dark #dashboard-wrapper .dashboard-card { 
            background-color: #1e293b !important; /* Dark Slate */
            border: 1px solid #334155 !important; /* Slate Border */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.4) !important;
        }

        /* 2. Force all text inside the dashboard to be visible */
        html.dark #dashboard-wrapper .text-gray-900,
        html.dark #dashboard-wrapper .text-gray-800,
        html.dark #dashboard-wrapper .text-gray-700,
        html.dark #dashboard-wrapper .text-gray-600,
        html.dark #dashboard-wrapper h3,
        html.dark #dashboard-wrapper span.font-bold,
        html.dark #dashboard-wrapper p.font-bold {
            color: #f8fafc !important; /* Bright White */
        }
        
        html.dark #dashboard-wrapper .text-gray-500,
        html.dark #dashboard-wrapper .text-gray-400 {
            color: #cbd5e1 !important; /* Silver */
        }

        /* 3. Fix the colored icons inside the cards so they don't break */
        html.dark #dashboard-wrapper .bg-blue-100 { background-color: rgba(59, 130, 246, 0.2) !important; color: #93c5fd !important; }
        html.dark #dashboard-wrapper .bg-purple-100 { background-color: rgba(168, 85, 247, 0.2) !important; color: #d8b4fe !important; }
        html.dark #dashboard-wrapper .bg-yellow-100 { background-color: rgba(245, 158, 11, 0.2) !important; color: #fcd34d !important; }
        html.dark #dashboard-wrapper .bg-red-100 { background-color: rgba(239, 68, 68, 0.2) !important; color: #fca5a5 !important; }

        /* 4. Custom Tables inside Dashboard */
        html.dark #dashboard-wrapper .table-custom th { 
            background-color: #0f172a !important; 
            color: #93c5fd !important; 
            border-bottom: 2px solid #334155 !important; 
        }
        html.dark #dashboard-wrapper .table-custom td { 
            background-color: #1e293b !important; 
            color: #f8fafc !important; 
            border-bottom: 1px solid #334155 !important; 
        }
        html.dark #dashboard-wrapper .table-custom tbody tr:hover td { 
            background-color: #334155 !important; 
        }

        /* 5. Status Badges */
        html.dark #dashboard-wrapper .status-pending { background-color: rgba(245, 158, 11, 0.15) !important; color: #fcd34d !important; border: 1px solid rgba(245, 158, 11, 0.3) !important; }
        html.dark #dashboard-wrapper .status-in_progress { background-color: rgba(59, 130, 246, 0.15) !important; color: #93c5fd !important; border: 1px solid rgba(59, 130, 246, 0.3) !important; }
        html.dark #dashboard-wrapper .status-completed { background-color: rgba(16, 185, 129, 0.15) !important; color: #6ee7b7 !important; border: 1px solid rgba(16, 185, 129, 0.3) !important; }
        
        /* 6. Quick Access Hover Effects */
        html.dark #dashboard-wrapper a.bg-white:hover,
        html.dark #dashboard-wrapper a[class*="bg-white"]:hover {
            background-color: #334155 !important; /* Lighter slate on hover */
            transform: translateY(-2px);
        }
    </style>
    @endPushOnce

    {{-- The critical wrapper ID is here --}}
    <div id="dashboard-wrapper" dir="rtl">
        
        @if (session('success'))
            <div class="mb-6">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-900/40 dark:text-green-300 dark:border-green-500 p-4 rounded-md shadow-md" role="alert">
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