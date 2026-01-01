<x-app-layout>
    {{-- 1. STYLES & VARIABLES --}}
    @pushOnce('styles')
    <style>
        .btn-secondary-custom { @apply bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 font-bold py-2 px-4 rounded-lg shadow-sm transition flex items-center gap-2; }
        .btn-primary-custom { @apply bg-blue-600 text-white hover:bg-blue-700 font-bold py-2 px-4 rounded-lg shadow-sm transition flex items-center gap-2; }
        .btn-success-custom { @apply bg-green-600 text-white hover:bg-green-700 font-bold py-2 px-4 rounded-lg shadow-sm transition flex items-center gap-2; }
        .form-input-custom { @apply border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm w-full; }
    </style>
    @endPushOnce

    @php
        // Resolve Support Agent
        $assignedSupport = $ticket->assignedToUser ?? $ticket->assignedTo;

        // Status Colors
        $statusStyles = [
            'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
            'in_progress' => 'bg-blue-100 text-blue-800 border-blue-200',
            'completed' => 'bg-green-100 text-green-800 border-green-200',
            'closed' => 'bg-gray-100 text-gray-600 border-gray-200',
        ];
        // Priority Colors
        $priorityStyles = [
            'low' => 'text-gray-600 bg-gray-50',
            'medium' => 'text-blue-600 bg-blue-50',
            'high' => 'text-orange-600 bg-orange-50',
            'critical' => 'text-red-600 bg-red-50',
        ];
    @endphp

    {{-- 2. HEADER --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            {{-- Title --}}
            <div>
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <span class="text-gray-400 text-lg">#{{ $ticket->id }}</span>
                    {{ $ticket->title }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    ایجاد شده توسط <span class="font-medium text-gray-700">{{ $ticket->user->name }}</span>
                    <span class="mx-1">•</span>
                    {{ $ticket->created_at->diffForHumans() }}
                </p>
            </div>

            {{-- Actions --}}
            <div class="flex flex-wrap items-center gap-2">
{{-- Actions with SMOOTH BUTTONS --}}
            <div class="flex flex-wrap items-center gap-3">
                {{-- Back Button --}}
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-800 hover:border-gray-300 transition-all shadow-sm">
                    <i class="fas fa-arrow-right"></i>
                    <span>بازگشت</span>
                </a>

                {{-- Edit Button (Admin or Creator) --}}
                @if($ticket->status !== 'completed' && (Auth::id() === $ticket->user_id || Auth::user()->role === 'admin'))
                    <a href="{{ route('tickets.edit', $ticket) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-50 border border-blue-100 rounded-xl text-sm font-medium text-blue-600 hover:bg-blue-100 hover:text-blue-700 transition-all shadow-sm">
                        <i class="fas fa-edit"></i>
                        <span>ویرایش</span>
                    </a>
                @endif

                {{-- Completion Logic --}}
                @if($ticket->status !== 'completed')
                    @if(Auth::id() === $ticket->user_id)
                        {{-- User: Modal for Rating --}}
                        <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-ticket-completion')" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-50 border border-emerald-100 rounded-xl text-sm font-medium text-emerald-600 hover:bg-emerald-100 hover:text-emerald-700 transition-all shadow-sm">
                            <i class="fas fa-check-circle"></i>
                            <span>تکمیل و امتیازدهی</span>
                        </button>
                    @elseif(in_array(Auth::user()->role, ['admin', 'support']))
                        {{-- Support/Admin: Direct Complete --}}
                        <form action="{{ route('tickets.complete', $ticket) }}" method="POST" onsubmit="return confirm('آیا از تکمیل کردن این درخواست اطمینان دارید؟');">
                            @csrf
                            <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-50 border border-emerald-100 rounded-xl text-sm font-medium text-emerald-600 hover:bg-emerald-100 hover:text-emerald-700 transition-all shadow-sm">
                                <i class="fas fa-check-circle"></i>
                                <span>تکمیل درخواست</span>
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </x-slot>

    {{-- 3. MAIN CONTENT GRID --}}
    <div class="py-8" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

                {{-- SIDEBAR (Col Span 4) --}}
                <div class="lg:col-span-4 space-y-6 order-last lg:order-first">
                    
                    {{-- Status Card --}}
                    <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 px-5 py-3 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800 text-sm">جزئیات درخواست</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $statusStyles[$ticket->status] ?? 'bg-gray-100' }}">
                                {{ __($ticket->status) }}
                            </span>
                        </div>
                        <div class="p-5 space-y-4 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">اولویت</span>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold {{ $priorityStyles[$ticket->priority] ?? 'bg-gray-100' }}">
                                    {{ __($ticket->priority) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">دسته‌بندی</span>
                                <span class="font-medium">{{ $ticket->category_label ?? __($ticket->category) }}</span>
                            </div>
                            <hr class="border-gray-100">
                            <div>
                                <span class="text-gray-500 block mb-2">کارشناس مسئول</span>
                                <div class="font-medium text-gray-800 bg-gray-50 p-2 rounded border border-gray-100 flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">
                                        {{ $assignedSupport ? mb_substr($assignedSupport->name, 0, 1) : '?' }}
                                    </div>
                                    {{ $assignedSupport->name ?? 'منتظر تعیین کارشناس' }}
                                </div>
                                {{-- Admin Assign --}}
                                @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('tickets.assign', $ticket) }}" method="POST" class="mt-2">
                                        @csrf
                                        <select name="assigned_to" onchange="this.form.submit()" class="w-full text-xs border-gray-200 rounded-lg">
                                            <option value="">-- تغییر --</option>
                                            @foreach(\App\Models\User::whereIn('role', ['support', 'admin'])->get() as $sup)
                                                <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Tools (Admin/Support Only) --}}
                    @if(in_array(auth()->user()->role, ['admin', 'support']))
                        {{-- Purchase Requests --}}
                        <div class="bg-white shadow-sm rounded-xl border border-purple-100 overflow-hidden">
                            <div class="bg-purple-50 px-5 py-3 border-b border-purple-100 flex justify-between items-center">
                                <h3 class="font-bold text-purple-900 text-sm"><i class="fas fa-shopping-cart ml-1"></i>درخواست خرید</h3>
                                <a href="{{ route('admin.purchase-requests.create', ['ticket_id' => $ticket->id]) }}" class="text-xs bg-white text-purple-700 hover:bg-purple-100 border border-purple-200 px-2 py-1 rounded transition">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                            <div class="p-4">
                                @forelse($ticket->purchaseRequests as $pr)
                                    <div class="flex justify-between items-center text-xs bg-gray-50 p-2 rounded border border-gray-100 mb-1">
                                        <span class="truncate">{{ $pr->item_name }}</span>
                                        <span class="font-bold {{ $pr->status == 'approved' ? 'text-green-600' : 'text-yellow-600' }}">{{ __($pr->status) }}</span>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-400 text-center">موردی ثبت نشده است.</p>
                                @endforelse
                            </div>
                        </div>
                    @endif

                </div>

                {{-- MAIN CONTENT (Col Span 8) --}}
                <div class="lg:col-span-8 space-y-6">

                    {{-- Description --}}
                    <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-6">
                        <div class="flex items-start gap-4">
                            <img src="{{ $ticket->user->profile_picture ? asset('storage/'.$ticket->user->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($ticket->user->name) }}" class="w-12 h-12 rounded-full">
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 text-lg">شرح درخواست</h3>
                                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap mt-2 text-sm">{{ $ticket->description }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Messages --}}
                    <div class="relative flex justify-center py-4">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
                        <span class="relative bg-gray-100 px-3 py-1 rounded-full text-xs font-medium text-gray-500">تاریخچه پیام‌ها</span>
                    </div>

                    <div class="space-y-6">
                        @forelse($ticket->messages as $message)
                            @php
                                $isMe = $message->user_id == auth()->id();
                                $sender = $message->user;
                                $isSupport = $sender && ($sender->role == 'admin' || $sender->role == 'support');
                            @endphp
                            <div class="flex w-full {{ $isMe ? 'justify-start' : 'justify-end' }}">
                                <div class="flex max-w-[85%] gap-3 {{ $isMe ? 'flex-row' : 'flex-row-reverse' }}">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white shadow-sm border-2 border-white
                                            {{ $isSupport ? 'bg-blue-600' : 'bg-gray-400' }}">
                                            {{ $sender ? mb_substr($sender->name, 0, 1) : '?' }}
                                        </div>
                                    </div>
                                    <div class="shadow-sm rounded-2xl p-4 text-sm leading-relaxed border relative min-w-[150px]
                                        {{ $isMe ? 'bg-blue-50 border-blue-100 text-gray-800 rounded-tr-none' : 'bg-white border-gray-100 text-gray-700 rounded-tl-none' }}">
                                        <div class="flex justify-between items-center gap-4 mb-2 border-b border-black/5 pb-2">
                                            <span class="font-bold text-xs {{ $isSupport ? 'text-blue-600' : 'text-gray-900' }}">
                                                {{ $sender->name ?? 'کاربر' }}
                                            </span>
                                            <span class="text-[10px] text-gray-400 dir-ltr">{{ $message->created_at->format('H:i') }}</span>
                                        </div>
                                        <div class="whitespace-pre-wrap">{{ $message->message }}</div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 text-sm">هنوز پیامی ثبت نشده است.</p>
                        @endforelse
                    </div>

                    {{-- Reply Box --}}
                    @if($ticket->status !== 'closed' && $ticket->status !== 'completed')
                        <div class="bg-white shadow-lg rounded-xl border border-gray-200 p-4 sticky bottom-4 z-10">
                            <form action="{{ route('tickets.messages.store', $ticket) }}" method="POST">
                                @csrf
                                <textarea name="body" rows="3" class="form-input-custom mb-3 text-sm" placeholder="پاسخ خود را بنویسید..." required></textarea>
                                <div class="flex justify-end">
                                    <button type="submit" class="btn-primary-custom">
                                        <i class="fas fa-paper-plane"></i> ارسال
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- 4. MODAL --}}
    <x-modal name="confirm-ticket-completion" focusable>
        <form method="post" action="{{ route('tickets.complete', $ticket) }}" class="p-6 text-center">
            @csrf
            <h2 class="text-lg font-bold text-gray-900 mb-4">ثبت امتیاز</h2>
            <div class="flex flex-row-reverse justify-center gap-2 text-2xl mb-6">
                @foreach(range(5,1) as $i)
                    <button type="submit" name="rating" value="{{ $i }}" class="text-gray-300 hover:text-yellow-400 transition transform hover:scale-110">
                        <i class="fas fa-star"></i>
                    </button>
                @endforeach
            </div>
            <p class="text-sm text-gray-500 mb-6">با انتخاب ستاره، درخواست بسته می‌شود.</p>
            <x-secondary-button x-on:click="$dispatch('close')">انصراف</x-secondary-button>
        </form>
    </x-modal>
</x-app-layout>