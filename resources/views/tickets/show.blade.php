<x-app-layout>
    @section('title', 'درخواست #' . $ticket->id)

    {{-- AUTO RATING MODAL (Pops up automatically for the user if ticket is completed & unrated) --}}
    @if($ticket->status === 'completed' && Auth::id() === $ticket->user_id && !$ticket->rating)
        <div x-data="{ showRatingModal: true }" 
             @open-rating-modal.window="showRatingModal = true"
             x-cloak 
             x-show="showRatingModal" 
             class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm" 
             x-transition.opacity.duration.300ms>
            
            <div @click.away="showRatingModal = false" 
                 x-show="showRatingModal"
                 x-transition.scale.90.duration.300ms
                 class="bg-white dark:bg-slate-800 rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl border border-yellow-200 dark:border-yellow-700/50 relative">
                
                {{-- Close Button --}}
                <button @click="showRatingModal = false" type="button" class="absolute top-5 left-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>

                <div class="text-center mb-6 mt-2">
                    <div class="w-20 h-20 bg-gradient-to-br from-yellow-100 to-yellow-200 dark:from-yellow-900/40 dark:to-yellow-800/40 text-yellow-500 dark:text-yellow-400 rounded-full flex items-center justify-center mx-auto text-4xl mb-5 shadow-inner">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-2">درخواست شما تکمیل شد!</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        لطفاً میزان رضایت خود را از نحوه پاسخگویی و رسیدگی کارشناسان به این درخواست مشخص کنید.
                    </p>
                </div>

                <form action="{{ url('/tickets/' . $ticket->id . '/rate') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <div x-data="{ rating: 0, hover: 0 }" class="flex justify-center gap-3 py-2" dir="ltr">
                        @for($i = 1; $i <= 5; $i++)
                            <label @mouseenter="hover = {{ $i }}" @mouseleave="hover = 0" class="cursor-pointer transition-transform hover:scale-110">
                                <input type="radio" name="rating" value="{{ $i }}" x-model="rating" class="hidden" required>
                                <i class="fas fa-star text-5xl transition-all"
                                   :class="rating >= {{ $i }} || hover >= {{ $i }} ? 'text-yellow-400 drop-shadow-lg scale-110' : 'text-gray-200 dark:text-slate-700'"></i>
                            </label>
                        @endfor
                    </div>
                    
                    <button type="submit" class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-white px-4 py-3.5 rounded-xl font-black transition-all shadow-lg hover:shadow-xl mt-4 w-full text-lg">
                        ثبت امتیاز
                    </button>
                    @error('rating') <span class="text-red-500 text-xs font-bold block text-center mt-1">{{ $message }}</span> @enderror
                </form>
            </div>
        </div>
    @endif

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
                
                {{-- COMPLETE TICKET BUTTON & CONFIRMATION MODAL (For Support/Admin) --}}
                @if(in_array(Auth::user()->role, ['admin', 'support']) && $ticket->status !== 'completed')
                    <div x-data="{ showCompleteModal: false }">
                        <button type="button" @click="showCompleteModal = true" class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-green-500/30 hover:-translate-y-0.5">
                            <i class="fas fa-check-circle"></i> تکمیل درخواست
                        </button>

                        <div x-cloak x-show="showCompleteModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm" x-transition.opacity.duration.300ms>
                            <div @click.away="showCompleteModal = false" x-show="showCompleteModal" x-transition.scale.90.duration.300ms class="bg-white dark:bg-slate-800 rounded-3xl p-7 max-w-md w-full mx-4 shadow-2xl border border-gray-100 dark:border-slate-700">
                                <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 text-green-500 dark:text-green-400 rounded-full flex items-center justify-center mb-4 text-3xl">
                                    <i class="fas fa-question-circle"></i>
                                </div>
                                <h3 class="text-xl font-black text-gray-900 dark:text-white mb-3">آیا از تکمیل درخواست اطمینان دارید؟</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                                    با تأیید این عملیات، وضعیت درخواست به "تکمیل شده" تغییر می‌یابد و از کاربر خواسته می‌شود تا به عملکرد شما امتیاز دهد.
                                </p>
                                <div class="flex justify-end gap-3">
                                    <button type="button" @click="showCompleteModal = false" class="px-5 py-2.5 text-gray-600 dark:text-gray-300 font-bold hover:bg-gray-100 dark:hover:bg-slate-700 rounded-xl transition-colors">
                                        انصراف
                                    </button>
                                    <form action="{{ url('/tickets/' . $ticket->id . '/complete') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2.5 rounded-xl font-bold transition-colors shadow-md">
                                            بله، تکمیل شود
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                {{-- Back Button --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-gray-300 px-5 py-2.5                 rounded-xl font-bold transition-all shadow-sm border border-slate-700">
                    بازگشت <i class="fas fa-arrow-left text-sm"></i>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- GLOBAL ALERTS --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-6 py-4 rounded-2xl font-bold flex items-center gap-3">
                    <i class="fas fa-check-circle text-xl"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-6 py-4 rounded-2xl font-bold flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle text-xl"></i> {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- LEFT COLUMN --}}
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

                        {{-- 3. Reply Form --}}
                        @if($ticket->status !== 'completed')
                            <form action="{{ url('/tickets/' . $ticket->id . '/messages') }}" method="POST" class="p-4 bg-white dark:bg-slate-800 border-t border-gray-100 dark:border-slate-700">
                                @csrf
                                <div class="flex items-stretch gap-3">
                                    <textarea name="message" rows="2" required
                                              placeholder="پاسخ خود را بنویسید..."
                                              class="flex-1 bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-600 text-gray-900 dark:text-white rounded-xl py-3 px-4 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none placeholder-gray-400"></textarea>
                                    
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 rounded-xl font-bold transition-all shadow-md flex items-center justify-center shrink-0">
                                        <i class="fas fa-paper-plane ml-2"></i> ارسال
                                    </button>
                                </div>
                                @error('message') <span class="text-red-500 text-xs mt-2 block font-bold">{{ $message }}</span> @enderror
                            </form>
                        @else
                            <div class="p-4 bg-green-50 dark:bg-green-900/20 text-center text-green-700 dark:text-green-400 text-sm font-bold border-t border-green-100 dark:border-green-900/50">
                                <i class="fas fa-check-double ml-1"></i> این درخواست تکمیل شده است و امکان ارسال پیام جدید وجود ندارد.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="space-y-6">
                    
                    {{-- SIDEBAR RATING CARD (Fallback if modal is closed) --}}
                    @if($ticket->status === 'completed')
                        <div class="bg-white dark:bg-slate-800 shadow-sm rounded-2xl border border-yellow-200 dark:border-yellow-700/50 overflow-hidden transition-colors">
                            <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-yellow-50/50 dark:bg-yellow-900/10">
                                <h3 class="font-black text-gray-800 dark:text-white flex items-center gap-2">
                                    <i class="fas fa-star text-yellow-500"></i> ارزیابی عملکرد
                                </h3>
                            </div>
                            <div class="p-6">
                                @if($ticket->rating)
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <span class="text-sm font-bold text-gray-500 dark:text-gray-400">امتیاز ثبت شده:</span>
                                        <div class="flex gap-1 text-3xl" dir="ltr">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $ticket->rating ? 'text-yellow-400 drop-shadow-md scale-110' : 'text-gray-200 dark:text-slate-700' }} transition-transform"></i>
                                            @endfor
                                        </div>
                                    </div>
                                @elseif(Auth::id() === $ticket->user_id)
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">شما هنوز امتیازی ثبت نکرده‌اید.</p>
                                        <button onclick="window.dispatchEvent(new CustomEvent('open-rating-modal'))" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2.5 rounded-xl font-bold transition-all shadow-md hover:shadow-lg w-full">
                                            ثبت امتیاز اکنون
                                        </button>
                                    </div>
                                @else
                                    <div class="text-center text-gray-500 dark:text-gray-400 text-sm font-bold flex flex-col items-center justify-center">
                                        <i class="fas fa-clock text-3xl mb-3 opacity-20"></i>
                                        در انتظار ثبت امتیاز توسط کاربر
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Ticket Details --}}
                    <div class="bg-white dark:bg-slate-800 shadow-sm rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50">
                            <h3 class="font-black text-gray-800 dark:text-white flex items-center gap-2">
                                <i class="fas fa-info-circle text-blue-500"></i> مشخصات تیکت
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            
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

                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500 dark:text-gray-400">دسته‌بندی:</span>
                                <span class="text-sm font-bold text-gray-900 dark:text-white">{{ __($ticket->category) }}</span>
                            </div>

                            <hr class="border-gray-100 dark:border-slate-700">

                            {{-- Assigned Users --}}
                            <div>
                                <span class="block text-sm text-gray-500 dark:text-gray-400 mb-3">کارشناسان مسئول:</span>
                                
                                @if(Auth::user()->role === 'admin' && $ticket->status !== 'completed')
                                    <form action="{{ url('/tickets/' . $ticket->id . '/assign') }}" method="POST" class="flex flex-col gap-3">
                                        @csrf
                                        <div class="max-h-48 overflow-y-auto custom-scrollbar bg-gray-50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-xl p-2 space-y-1">
                                            @foreach($supportUsers as $support)
                                                <label class="flex items-center gap-3 p-2.5 hover:bg-white dark:hover:bg-slate-800 rounded-lg cursor-pointer transition-all border border-transparent hover:border-gray-200 dark:hover:border-slate-600 hover:shadow-sm">
                                                    <input type="checkbox" name="assigned_to[]" value="{{ $support->id }}"
                                                           @checked($ticket->assignees->contains($support->id))
                                                           class="w-4 h-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:bg-slate-700 dark:border-slate-500 cursor-pointer">
                                                    <span class="text-sm font-bold text-gray-800 dark:text-gray-200 select-none">{{ $support->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl font-bold transition-all shadow-md hover:shadow-lg flex justify-center items-center gap-2 text-sm w-full">
                                            <i class="fas fa-users-cog"></i> {{ $ticket->assignees->isNotEmpty() ? 'بروزرسانی کارشناسان' : 'ارجاع به کارشناسان' }}
                                        </button>
                                        @error('assigned_to')
                                            <span class="text-red-500 text-xs font-bold block">{{ $message }}</span>
                                        @enderror
                                    </form>
                                @else
                                    @if($ticket->assignees->isNotEmpty())
                                        <div class="bg-gray-50 dark:bg-slate-900/50 rounded-xl p-3 border border-gray-100 dark:border-slate-700 flex flex-wrap gap-2 justify-start">
                                            @foreach($ticket->assignees as $assignee)
                                                <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 font-bold px-3 py-1.5 rounded-lg text-sm flex items-center gap-2">
                                                    <i class="fas fa-user-check"></i> {{ $assignee->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="bg-gray-50 dark:bg-slate-900/50 rounded-xl p-3 text-center border border-gray-100 dark:border-slate-700">
                                            <span class="text-orange-500 dark:text-orange-400 font-bold flex items-center justify-center gap-2 text-sm">
                                                <span class="relative flex h-3 w-3">
                                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-orange-500"></span>
                                                </span>
                                                منتظر تعیین کارشناس
                                            </span>
                                        </div>
                                    @endif
                                @endif
                            </div>

                        </div>
                    </div>

                    {{-- Support Tools --}}
                    @if(in_array(Auth::user()->role, ['admin', 'support']) && $ticket->status !== 'completed')
                        <div class="bg-white dark:bg-slate-800 shadow-sm rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
                            <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50">
                                <h3 class="font-black text-gray-800 dark:text-white flex items-center gap-2">
                                    <i class="fas fa-toolbox text-purple-500"></i> ابزارهای پشتیبانی
                                </h3>
                            </div>
                            <div class="p-6 space-y-5">
                                
                                {{-- Purchase Request Link --}}
                                <a href="{{ url('/admin/purchase-requests/create?ticket_id=' . $ticket->id) }}" class="w-full flex items-center justify-between bg-purple-50 hover:bg-purple-100 dark:bg-purple-900/20 dark:hover:bg-purple-900/40 border border-purple-200 dark:border-purple-800 text-purple-700 dark:text-purple-400 px-4 py-3 rounded-xl font-bold transition-all">
                                    <span class="flex items-center gap-2"><i class="fas fa-shopping-cart"></i> ثبت درخواست خرید قطعه</span>
                                    <i class="fas fa-chevron-left text-sm"></i>
                                </a>

                                <hr class="border-gray-100 dark:border-slate-700">

                                {{-- Asset Allocation Form --}}
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-2">تخصیص قطعه از انبار:</label>
                                    <form action="{{ url('/tickets/' . $ticket->id . '/allocate-asset') }}" method="POST" class="flex flex-col gap-2">
                                        @csrf
                                        <div class="flex gap-2">
                                            <select name="asset_id" required class="flex-1 bg-gray-50 dark:bg-slate-900 border-gray-200 dark:border-slate-600 text-gray-900 dark:text-white rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                                                <option value="" disabled selected>انتخاب قطعه...</option>
                                                @if(isset($availableAssets))
                                                    @foreach($availableAssets as $asset)
                                                        <option value="{{ $asset->id }}">{{ $asset->name }} ({{ $asset->serial_number }})</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white w-10 h-10 rounded-lg flex items-center justify-center transition-colors shadow-sm" title="تخصیص قطعه">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        @error('asset_id') <span class="text-red-500 text-xs font-bold block">{{ $message }}</span> @enderror
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