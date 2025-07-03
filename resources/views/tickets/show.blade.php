<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('مشاهده درخواست') }} #{{ $ticket->id }}
            </h2>
            <a href="{{ route('tickets.my') }}" class="btn-secondary-custom">
                <i class="fas fa-arrow-right ml-2"></i>
                بازگشت به لیست
            </a>
        </div>
    </x-slot>

    @pushOnce('styles')
    {{-- You can reuse the badge styles from my-tickets.blade.php --}}
    <style>
        .status-badge, .priority-badge { 
            padding: 0.25em 0.75em; 
            font-size: 0.8rem; 
            font-weight: 600; 
            border-radius: 9999px; 
            display: inline-block; 
            line-height: 1.5; 
        }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-in_progress { background-color: #dbeafe; color: #1e40af; }
        .status-completed { background-color: #d1fae5; color: #065f46; }
        .priority-low { background-color: #dcfce7; color: #166534; }
        .priority-medium { background-color: #fef9c3; color: #92400e; }
        .priority-high { background-color: #fee2e2; color: #991b1b; }
        .btn-secondary-custom {
            background-color: #e5e7eb;
            color: #374151;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: background-color 0.2s;
            border: 1px solid #d1d5db;
        }
        .btn-secondary-custom:hover { background-color: #d1d5db; }
    </style>
    @endPushOnce

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Ticket Header --}}
                    <div class="border-b border-gray-200 pb-5 mb-5">
                        <h3 class="text-2xl font-bold text-gray-800">{{ $ticket->title }}</h3>
                        <div class="flex items-center mt-2 text-sm text-gray-500">
                            <span>ایجاد شده توسط: {{ $ticket->user->name }}</span>
                            <span class="mx-2">&bull;</span>
                            <span>{{ $ticket->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    {{-- Ticket Details --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Main Content --}}
                        <div class="md:col-span-2">
                            <h4 class="font-bold text-lg mb-2">شرح درخواست</h4>
                            <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">
                                {{ $ticket->description }}
                            </p>
                        </div>
                        
                        {{-- Sidebar Info --}}
                        <div class="md:col-span-1">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-bold text-lg mb-4">جزئیات</h4>
                                <dl>
                                    <div class="flex justify-between py-2">
                                        <dt class="text-gray-600">وضعیت:</dt>
                                        <dd><span class="status-badge status-{{ $ticket->status }}">{{ __($ticket->status) }}</span></dd>
                                    </div>
                                    <div class="flex justify-between py-2">
                                        <dt class="text-gray-600">اولویت:</dt>
                                        <dd><span class="priority-badge priority-{{ $ticket->priority }}">{{ __($ticket->priority) }}</span></dd>
                                    </div>
                                    <div class="flex justify-between py-2">
                                        <dt class="text-gray-600">تاریخ ایجاد:</dt>
                                        <dd class="text-gray-800">{{ $ticket->created_at->format('Y-m-d H:i') }}</dd>
                                    </div>
                                    <div class="flex justify-between py-2">
                                        <dt class="text-gray-600">آخرین بروزرسانی:</dt>
                                        <dd class="text-gray-800">{{ $ticket->updated_at->format('Y-m-d H:i') }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>