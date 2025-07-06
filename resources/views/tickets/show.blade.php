<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $ticket->title }}</h2>
                <p class="text-sm text-gray-500 mt-1">ایجاد شده توسط {{ $ticket->user->name }} در {{ $ticket->jalali_created_at }}</p>
            </div>
            <div class="flex items-center gap-x-4">
                <a href="{{ route('dashboard') }}" class="btn-secondary-custom">بازگشت به داشبورد</a>
                @if(Auth::id() === $ticket->user_id || Auth::user()->role === 'admin')
                    <a href="{{ route('tickets.edit', $ticket) }}" class="btn-primary-custom"><i class="fas fa-edit ml-2"></i>ویرایش</a>
                @endif
            </div>
        </div>
    </x-slot>

    @pushOnce('styles')
    <style>
        .btn-secondary-custom { background-color: #e5e7eb; color: #374151; padding: 0.6rem 1.2rem; border-radius: 0.5rem; font-weight: 600; transition: background-color 0.2s; border: 1px solid #d1d5db; text-decoration: none; }
        .btn-secondary-custom:hover { background-color: #d1d5db; }
        .workflow-step { display: flex; align-items: flex-start; }
        .workflow-step .icon { display: flex; align-items: center; justify-content: center; width: 2.5rem; height: 2.5rem; border-radius: 9999px; }
        .workflow-step .line { flex-grow: 1; width: 2px; margin-right: 1.125rem; }
        .workflow-step.completed .icon { background-color: #22c55e; color: white; }
        .workflow-step.completed .line { background-color: #22c55e; }
        .workflow-step.active .icon { background-color: #3b82f6; color: white; }
        .workflow-step.pending .icon { background-color: #e5e7eb; color: #9ca3af; }
        .workflow-step.pending .line { background-color: #e5e7eb; }
        .message-card { display: flex; align-items: flex-start; }
        .message-card:not(:last-child) { border-bottom: 1px solid #e5e7eb; padding-bottom: 1.5rem; margin-bottom: 1.5rem; }
        .message-author-avatar { width: 3rem; height: 3rem; border-radius: 9999px; object-fit: cover; margin-left: 1rem; }
    </style>
    @endPushOnce

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                {{-- Main Content (Left Column) --}}
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-bold text-lg mb-4">شرح درخواست</h3>
                        <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $ticket->description }}</p>
                    </div>

                    {{-- Notes / Messaging Section --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-bold text-lg mb-6">یادداشت‌ها و پیام‌ها</h3>
                        <div class="space-y-6">
                            @forelse($ticket->messages as $message)
                                <div class="message-card">
                                    <img src="{{ $message->user->profile_picture ? asset('storage/' . $message->user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($message->user->name) }}" alt="{{ $message->user->name }}" class="message-author-avatar">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <p class="font-semibold">{{ $message->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ \Morilog\Jalali\Jalalian::fromCarbon($message->created_at)->format('%d %B %Y - H:i') }}</p>
                                        </div>
                                        {{-- FIX: Changed $message->body to $message->message --}}
                                        <p class="mt-2 text-gray-700 whitespace-pre-wrap">{{ $message->message }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-500 py-4">هنوز هیچ پیامی ثبت نشده است.</p>
                            @endforelse
                        </div>

                        {{-- Add New Message Form --}}
                        @if(in_array(Auth::user()->role, ['admin', 'support']) || Auth::id() === $ticket->user_id)
                        <div class="mt-6 pt-6 border-t">
                            <form action="{{ route('tickets.messages.store', $ticket) }}" method="POST">
                                @csrf
                                <label for="body" class="block font-medium text-sm text-gray-700 mb-2">افزودن یادداشت یا پاسخ</label>
                                <textarea name="body" id="body" rows="4" class="form-input-custom w-full" placeholder="پاسخ خود را اینجا بنویسید..." required></textarea>
                                <div class="mt-4 flex justify-end">
                                    <button type="submit" class="btn-primary-custom"><i class="fas fa-paper-plane ml-2"></i>ارسال پاسخ</button>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Sidebar (Right Column) --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Workflow Tracker --}}
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h4 class="font-bold text-lg mb-6">روند انجام درخواست</h4>
                        @php
                            $statuses = ['pending', 'in_progress', 'completed'];
                            $currentStatusIndex = array_search($ticket->status, $statuses);
                        @endphp
                        <div class="space-y-2">
                            <div class="workflow-step {{ $currentStatusIndex >= 0 ? 'completed' : 'pending' }}">
                                <div class="icon"><i class="fas fa-check"></i></div>
                                <div class="mr-4">
                                    <p class="font-semibold">درخواست ثبت شد</p>
                                    <p class="text-sm text-gray-500">{{ $ticket->jalali_created_at }}</p>
                                </div>
                            </div>
                            <div class="h-8 workflow-step {{ $currentStatusIndex >= 1 ? 'completed' : 'pending' }}"><div class="line"></div></div>
                            <div class="workflow-step {{ $currentStatusIndex >= 1 ? ($currentStatusIndex == 1 ? 'active' : 'completed') : 'pending' }}">
                                <div class="icon"><i class="fas fa-cogs"></i></div>
                                <div class="mr-4">
                                    <p class="font-semibold">در حال بررسی</p>
                                    <p class="text-sm text-gray-500">توسط {{ $ticket->assignedTo->name ?? 'پشتیبانی' }}</p>
                                </div>
                            </div>
                            <div class="h-8 workflow-step {{ $currentStatusIndex >= 2 ? 'completed' : 'pending' }}"><div class="line"></div></div>
                            <div class="workflow-step {{ $currentStatusIndex >= 2 ? 'active' : 'pending' }}">
                                <div class="icon"><i class="fas fa-flag-checkered"></i></div>
                                <div class="mr-4"><p class="font-semibold">تکمیل شده</p></div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Assignment Card --}}
                    @if(Auth::user()->role === 'admin')
                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
                            <h4 class="font-bold text-lg mb-4">ارجاع درخواست</h4>
                            <form action="{{ route('tickets.assign', $ticket) }}" method="POST">
                                @csrf
                                <div>
                                    <label for="assigned_to" class="block font-medium text-sm text-gray-700">ارجاع به کارشناس:</label>
                                    <select id="assigned_to" name="assigned_to" class="form-input-custom mt-1 block w-full">
                                        <option value="">-- انتخاب کارشناس --</option>
                                        @foreach($supportUsers as $supportUser)
                                            <option value="{{ $supportUser->id }}" @selected($ticket->assigned_to == $supportUser->id)>{{ $supportUser->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-4"><button type="submit" class="btn-primary-custom w-full flex items-center justify-center"><i class="fas fa-user-check mr-2"></i>ذخیره ارجاع</button></div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
