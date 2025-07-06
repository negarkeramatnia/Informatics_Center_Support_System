<x-app-layout>
    <x-slot name="header">
        {{-- FIX: The parent div uses flex and justify-between to position items correctly --}}
        <div class="flex items-center justify-between">
            {{-- Group for Title and Subtitle (aligns to the right in RTL) --}}
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $ticket->title }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    ایجاد شده توسط {{ $ticket->user->name }} در {{ $ticket->jalali_created_at }}
                </p>
            </div>

            {{-- Group for Buttons (aligns to the left in RTL) --}}
            <div class="flex items-center gap-x-4">
                {{-- FIX: This button now has a proper style --}}
                <a href="{{ route('dashboard') }}" class="btn-secondary-custom">
                    بازگشت به داشبورد
                </a>
                @if(Auth::id() === $ticket->user_id || Auth::user()->role === 'admin')
                    <a href="{{ route('tickets.edit', $ticket) }}" class="btn-primary-custom">
                        <i class="fas fa-edit ml-2"></i>
                        ویرایش
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    @pushOnce('styles')
    <style>
        /* --- FIX: Added style for the secondary "Back" button --- */
        .btn-secondary-custom {
            background-color: #e5e7eb; /* gray-200 */
            color: #374151; /* gray-700 */
            padding: 0.6rem 1.2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: background-color 0.2s;
            border: 1px solid #d1d5db;
            text-decoration: none;
        }
        .btn-secondary-custom:hover { 
            background-color: #d1d5db; /* gray-300 */
        }

        /* Other styles for this page */
        .workflow-step { display: flex; align-items: flex-start; }
        .workflow-step .icon { display: flex; align-items: center; justify-content: center; width: 2.5rem; height: 2.5rem; border-radius: 9999px; }
        .workflow-step .line { flex-grow: 1; width: 2px; margin-right: 1.125rem; }
        .workflow-step.completed .icon { background-color: #22c55e; color: white; }
        .workflow-step.completed .line { background-color: #22c55e; }
        .workflow-step.active .icon { background-color: #3b82f6; color: white; }
        .workflow-step.pending .icon { background-color: #e5e7eb; color: #9ca3af; }
        .workflow-step.pending .line { background-color: #e5e7eb; }
    </style>
    @endPushOnce

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                {{-- Main Content (Left Column) --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Ticket Description --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="font-bold text-lg mb-4">شرح درخواست</h3>
                            <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">
                                {{ $ticket->description }}
                            </p>
                        </div>
                    </div>

                    {{-- Notes / Messaging Section --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="font-bold text-lg mb-4">پیام‌رسان</h3>
                            <div class="text-center text-gray-400 py-8">
                                <i class="fas fa-comments text-3xl mb-2"></i>
                                <p>بخش پیام‌رسانی در حال توسعه است.</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Sidebar (Right Column) --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Workflow Tracker --}}
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h4 class="font-bold text-lg mb-6">روند انجام درخواست</h4>
                        <div class="space-y-2">
                            @php
                                $statuses = ['pending', 'in_progress', 'completed'];
                                $currentStatusIndex = array_search($ticket->status, $statuses);
                            @endphp

                            <div class="workflow-step {{ $currentStatusIndex >= 0 ? 'completed' : 'pending' }}">
                                <div class="icon"><i class="fas fa-check"></i></div>
                                <div class="mr-4">
                                    <p class="font-semibold">درخواست ثبت شد</p>
                                    <p class="text-sm text-gray-500">{{ $ticket->jalali_created_at }}</p>
                                </div>
                            </div>
                            <div class="h-8 workflow-step {{ $currentStatusIndex >= 1 ? 'completed' : 'pending' }}">
                                <div class="line"></div>
                            </div>

                            <div class="workflow-step {{ $currentStatusIndex >= 1 ? ($currentStatusIndex == 1 ? 'active' : 'completed') : 'pending' }}">
                                <div class="icon"><i class="fas fa-cogs"></i></div>
                                <div class="mr-4">
                                    <p class="font-semibold">در حال بررسی</p>
                                    <p class="text-sm text-gray-500">توسط {{ $ticket->assignedTo->name ?? 'پشتیبانی' }}</p>
                                </div>
                            </div>
                            <div class="h-8 workflow-step {{ $currentStatusIndex >= 2 ? 'completed' : 'pending' }}">
                                <div class="line"></div>
                            </div>

                             <div class="workflow-step {{ $currentStatusIndex >= 2 ? 'active' : 'pending' }}">
                                <div class="icon"><i class="fas fa-flag-checkered"></i></div>
                                <div class="mr-4">
                                    <p class="font-semibold">تکمیل شده</p>
                                </div>
                            </div>
                        </div>
                    </div>
                                        {{-- Details Card --}}
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                         <h4 class="font-bold text-lg mb-4">جزئیات</h4>
                         {{-- Your existing details code --}}
                    </div>

                    {{-- Assignment Card --}}
                    @if(Auth::user()->role === 'admin')
                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
