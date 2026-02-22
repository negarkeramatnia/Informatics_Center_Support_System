<x-app-layout>
    @section('title', 'درخواست #' . $ticket->id)

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight flex items-center gap-3">
                    {{ $ticket->title }}
                    <span class="text-lg text-gray-400 dark:text-slate-500 font-mono">#{{ $ticket->id }}</span>
                </h2>
                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-2">
                    <i class="far fa-clock"></i> {{ $ticket->created_at->diffForHumans() }}
                    <span class="px-2">|</span>
                    <i class="far fa-user"></i> {{ $ticket->user->name ?? 'کاربر نامشخص' }}
                </div>
            </div>

            <div class="flex items-center gap-3">
                {{-- Complete Ticket Button (Only for Support/Admin) --}}
                @if(in_array(Auth::user()->role, ['admin', 'support']) && $ticket->status !== 'completed')
                    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-green-500/30">
                            <i class="fas fa-check-circle"></i> تکمیل درخواست
                        </button>
                    </form>
                @endif
                
                {{-- Back Button --}}
                <a href="{{ url()->previous() }}" class="flex items-center gap-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300 px-5 py-2.5 rounded-xl font-bold transition-all">
                    بازگشت <i class="fas fa-arrow-left text-sm"></i>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- LEFT COLUMN: Description & Messenger (Takes up 2/3 of space) --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- 1. Description Card --}}
                    <div class="bg-white dark:bg-slate-800 shadow-sm rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50">
                            <h3 class="font-black text-gray-800 dark:text-white flex items-center gap-2">
                                <i class="fas fa-align-right text-blue-500"></i> شرح مشکل
                            </h3>
                        </div>
                        <div class="p-6 text-gray-700 dark:text-gray-300 leading-relaxed text-sm whitespace-pre-wrap">
                            {{ $ticket->description }}
                        </div>
                    </div>

                    {{-- 2. Messenger / Chat History --}}
                    <div class="bg-white dark:bg-slate-800 shadow-sm rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors flex flex-col">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 flex justify-center">
                            <span class="bg-gray-200 dark:bg-slate-700 text-gray-600 dark:text-gray-300 text-xs font-bold px-4 py-1 rounded-full">
                                تاریخچه گفتگو
                            </span>
                        </div>
                        
                        {{-- Chat Bubbles --}}
                        <div class="p-6 overflow-y-auto max-h-[500px] space-y-4 bg-gray-50/30 dark:bg-slate-900/20 custom-scrollbar">
                            @forelse($ticket->messages ?? [] as $msg)
                                @php $isOwn = $msg->user_id === Auth::id(); @endphp
                                <div class="flex {{ $isOwn ? 'justify-start' : 'justify-end' }}">
                                    <div class="max-w-[85%] sm:max-w-[75%] rounded-2xl p-4 shadow-sm {{ $isOwn ? 'bg-blue-600 text-white rounded-tr-none' : 'bg-white dark:bg-slate-700 border border-gray-100 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-tl-none' }}">
                                        <div class="flex justify-between items-center mb-2 gap-4">
                                            <span class="font-bold text-xs {{ $isOwn ? 'text-blue-100' : 'text-blue-600 dark:text-blue-400' }}">{{ $msg->user->name ?? 'کاربر' }}</span>
                                            <span class="text-[10px] {{ $isOwn ? 'text-blue-200' : 'text-gray-400 dark:text-gray-400' }} dir-ltr font-mono">{{ $msg->created_at->format('Y/m/d H:i') }}</span>
                                        </div>
                                        <p class="text-sm whitespace-pre-wrap leading-relaxed">{{ $msg->message ?? $msg->content }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-500 dark:text-gray-400 text-sm font-medium">
                                    هنوز پاسخی ثبت نشده است.
                                </div>
                            @endforelse
                        </div>

                        {{-- 3. Reply Form (FIXED: Now a real working form) --}}
                        @if($ticket->status !== 'closed' && $ticket->status !== 'resolved')
                            <div class="p-4 bg-white dark:bg-slate-800 border-t border-gray-100 dark:border-slate-700">
                                {{-- Make sure you have a route named 'messages.store' in your web.php! --}}
                                <form action="{{ route('messages.store', $ticket->id) }}" method="POST" class="relative">
                                    @csrf
                                    <textarea name="message" rows="2" required
                                              placeholder="پاسخ خود را بنویسید..."
                                              class="w-full bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-600 text-gray-900 dark:text-white rounded-xl py-3 pr-4 pl-24 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none placeholder-gray-400"></textarea>
                                    
                                    <button type="submit" class="absolute left-2 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-bold transition-all shadow-md">
                                        <i class="fas fa-paper-plane ml-1"></i> ارسال
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="p-4 bg-gray-100 dark:bg-slate-700 text-center text-gray-500 dark:text-gray-400 text-sm font-bold border-t border-gray-200 dark:border-slate-600">
                                این درخواست بسته شده است و امکان ارسال پیام جدید وجود ندارد.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- RIGHT COLUMN: Info & Tools (Takes up 1/3 of space) --}}
                <div class="space-y-6">
                    
                    {{-- Ticket Details --}}
                    <div class="bg-white dark:bg-slate-800 shadow-sm rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50">
                            <h3 class="font-black text-gray-800 dark:text-white flex items-center gap-2">
                                <i class="fas fa-info-circle text-blue-500"></i> مشخصات تیکت
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            
                            {{-- Status --}}
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500 dark:text-gray-400">وضعیت:</span>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        'open' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                        'in_progress' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                        'completed' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                    ];
                                    $badgeClass = $statusColors[$ticket->status] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">
                                    {{ __($ticket->status) }}
                                </span>
                            </div>

                            {{-- Priority --}}
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500 dark:text-gray-400">اولویت:</span>
                                @if($ticket->priority === 'high')
                                    <span class="bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-full text-xs font-bold px-3 py-1">بالا</span>
                                @elseif($ticket->priority === 'medium')
                                    <span class="bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full text-xs font-bold px-3 py-1">متوسط</span>
                                @else
                                    <span class="bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full text-xs font-bold px-3 py-1">عادی</span>
                                @endif
                            </div>

                            {{-- Category --}}
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500 dark:text-gray-400">دسته‌بندی:</span>
                                <span class="text-sm font-bold text-gray-900 dark:text-white">{{ __($ticket->category) }}</span>
                            </div>

                            <hr class="border-gray-100 dark:border-slate-700">

                            {{-- Assigned User (FIXED: Now checks database properly) --}}
                            <div>
                                <span class="block text-sm text-gray-500 dark:text-gray-400 mb-2">کارشناس مسئول:</span>
                                <div class="bg-gray-50 dark:bg-slate-900/50 rounded-xl p-3 text-center border border-gray-100 dark:border-slate-700">
                                    {{-- Checks if relation 'assignedUser' or 'assignee' exists. Adjust if your model uses a different name --}}
                                    @if($ticket->assigned_to || $ticket->assignedUser)
                                        <span class="text-blue-600 dark:text-blue-400 font-black flex items-center justify-center gap-2">
                                            <i class="fas fa-user-check"></i> 
                                            {{ $ticket->assignedUser->name ?? ($ticket->assignee->name ?? 'کارشناس تخصیص یافته') }}
                                        </span>
                                    @else
                                        <span class="text-orange-500 dark:text-orange-400 font-bold flex items-center justify-center gap-2 text-sm">
                                            <span class="relative flex h-3 w-3">
                                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                                              <span class="relative inline-flex rounded-full h-3 w-3 bg-orange-500"></span>
                                            </span>
                                            منتظر تعیین کارشناس
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Support Tools (Only for Admin/Support) --}}
                    @if(in_array(Auth::user()->role, ['admin', 'support']))
                        <div class="bg-white dark:bg-slate-800 shadow-sm rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
                            <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50">
                                <h3 class="font-black text-gray-800 dark:text-white flex items-center gap-2">
                                    <i class="fas fa-toolbox text-purple-500"></i> ابزارهای پشتیبانی
                                </h3>
                            </div>
                            <div class="p-6 space-y-5">
                                
                                {{-- Purchase Request Link --}}
                                <a href="{{ route('admin.purchase-requests.create', ['ticket_id' => $ticket->id]) }}" class="w-full flex items-center justify-between bg-purple-50 hover:bg-purple-100 dark:bg-purple-900/20 dark:hover:bg-purple-900/40 border border-purple-200 dark:border-purple-800 text-purple-700 dark:text-purple-400 px-4 py-3 rounded-xl font-bold transition-all">
                                    <span class="flex items-center gap-2"><i class="fas fa-shopping-cart"></i> ثبت درخواست خرید قطعه</span>
                                    <i class="fas fa-chevron-left text-sm"></i>
                                </a>

                                <hr class="border-gray-100 dark:border-slate-700">

                                {{-- Asset Allocation (FIXED: Now a real working form) --}}
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-2">تخصیص قطعه از انبار:</label>
                                    {{-- Make sure you have a route named 'tickets.assets.attach' in your web.php! --}}
                                    <form action="{{ route('tickets.assets.attach', $ticket->id ?? 1) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        <select name="asset_id" required class="flex-1 bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-600 text-gray-900 dark:text-white rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                                            <option value="" disabled selected>انتخاب قطعه...</option>
                                            {{-- Assuming you pass $availableAssets from controller --}}
                                            @if(isset($availableAssets))
                                                @foreach($availableAssets as $asset)
                                                    <option value="{{ $asset->id }}">{{ $asset->name }} ({{ $asset->serial_number }})</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white w-10 h-10 rounded-lg flex items-center justify-center transition-colors shadow-sm" title="تخصیص قطعه">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>