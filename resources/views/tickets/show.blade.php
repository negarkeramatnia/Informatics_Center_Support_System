<x-app-layout>
    {{-- 1. SETUP VARIABLES --}}
    @php
        // Resolve Support Agent (Check both relationships)
        $assignedSupport = $ticket->assignedToUser ?? $ticket->assignedTo;

        // Modern Status Badges (Smooth Look)
        $statusStyles = [
            'pending' => 'bg-yellow-50 text-yellow-700 border border-yellow-200',
            'in_progress' => 'bg-blue-50 text-blue-700 border border-blue-200',
            'completed' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
            'closed' => 'bg-gray-50 text-gray-600 border border-gray-200',
        ];
        
        // Priority Badges
        $priorityStyles = [
            'low' => 'text-gray-600 bg-gray-100',
            'medium' => 'text-blue-600 bg-blue-50',
            'high' => 'text-orange-600 bg-orange-50',
            'critical' => 'text-red-600 bg-red-50',
        ];
    @endphp

    {{-- 2. PAGE HEADER --}}
    <x-slot name="header">
        {{-- Container: Use justify-between to push items to edges --}}
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 w-full">
            
            {{-- RIGHT SIDE: Title & Meta --}}
            <div class="flex flex-col items-start w-full md:w-auto">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-3">
                    <span class="text-gray-400 text-lg opacity-60">#{{ $ticket->id }}</span>
                    {{ $ticket->title }}
                </h2>
                <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                    <i class="fas fa-user-circle text-gray-400"></i>
                    <span>{{ $ticket->user->name }}</span>
                    <span class="text-gray-300">|</span>
                    <i class="far fa-clock text-gray-400"></i>
                    <span dir="ltr">{{ $ticket->created_at->diffForHumans() }}</span>
                </p>
            </div>

            {{-- LEFT SIDE: Action Buttons (Smooth Design) --}}
            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto justify-end">
                
                {{-- Back Button --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition shadow-sm font-medium">
                    <i class="fas fa-arrow-right text-xs"></i>
                    <span>بازگشت</span>
                </a>

                {{-- Edit Button (Admin/Owner) --}}
                @if($ticket->status !== 'completed' && (Auth::id() === $ticket->user_id || Auth::user()->role === 'admin'))
                    <a href="{{ route('tickets.edit', $ticket) }}" class="flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 border border-blue-100 rounded-xl hover:bg-blue-100 hover:text-blue-700 transition shadow-sm font-medium">
                        <i class="fas fa-pen text-xs"></i>
                        <span>ویرایش</span>
                    </a>
                @endif

                {{-- Complete/Rate Buttons --}}
                @if($ticket->status !== 'completed')
                    @if(Auth::id() === $ticket->user_id)
                        <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-ticket-completion')" class="flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl hover:bg-emerald-100 hover:text-emerald-700 transition shadow-sm font-bold">
                            <i class="fas fa-check-circle"></i>
                            <span>تکمیل و امتیازدهی</span>
                        </button>
                    @elseif(in_array(Auth::user()->role, ['admin', 'support']))
                        <form action="{{ route('tickets.complete', $ticket) }}" method="POST" onsubmit="return confirm('آیا اطمینان دارید؟');">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl hover:bg-emerald-100 hover:text-emerald-700 transition shadow-sm font-bold">
                                <i class="fas fa-check-circle"></i>
                                <span>تکمیل درخواست</span>
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </x-slot>

    {{-- 3. MAIN CONTENT LAYOUT (2 Columns) --}}
    <div class="py-8" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

                {{-- SIDEBAR (Right in RTL) --}}
                <div class="lg:col-span-4 space-y-6 order-last lg:order-first">
                    
                    {{-- INFO CARD --}}
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gray-50/50 dark:bg-gray-700/50 px-5 py-4 border-b border-gray-100 dark:border-gray-600 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800 dark:text-gray-100 text-sm">مشخصات تیکت</h3>
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusStyles[$ticket->status] ?? 'bg-gray-100' }}">
                                {{ __($ticket->status) }}
                            </span>
                        </div>
                        <div class="p-5 space-y-5">
                            {{-- Priority & Category --}}
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">اولویت:</span>
                                    <span class="px-2 py-0.5 rounded text-xs font-bold {{ $priorityStyles[$ticket->priority] }}">
                                        {{ __($ticket->priority) }}
                                    </span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">دسته‌بندی:</span>
                                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $ticket->category_label ?? __($ticket->category) }}</span>
                                </div>
                            </div>

                            <div class="border-t border-gray-100 dark:border-gray-700"></div>

                            {{-- ASSIGNEE SECTION (The part you circled) --}}
                            <div>
                                <span class="text-xs text-gray-400 uppercase tracking-wider block mb-2">کارشناس مسئول</span>
                                
                                @if($assignedSupport)
                                    {{-- CASE 1: Assigned (Show Name) --}}
                                    <div class="flex items-center gap-3 bg-indigo-50 border border-indigo-100 p-3 rounded-xl">
                                        <div class="w-10 h-10 rounded-full bg-indigo-200 text-indigo-700 flex items-center justify-center text-sm font-bold shadow-sm">
                                            {{ mb_substr($assignedSupport->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-indigo-900">{{ $assignedSupport->name }}</p>
                                            <p class="text-[11px] text-indigo-500">پشتیبان فنی</p>
                                        </div>
                                    </div>
                                @else
                                    {{-- CASE 2: Unassigned (Show Waiting) --}}
                                    <div class="flex items-center justify-center gap-2 bg-orange-50 border border-orange-100 text-orange-700 p-3 rounded-xl text-sm font-medium">
                                        <div class="w-2 h-2 bg-orange-400 rounded-full animate-pulse"></div>
                                        <span>منتظر تعیین کارشناس</span>
                                    </div>
                                @endif

                                {{-- Admin Assign Dropdown --}}
                                @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('tickets.assign', $ticket) }}" method="POST" class="mt-3">
                                        @csrf
                                        <select name="assigned_to" onchange="this.form.submit()" class="w-full text-xs border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50">
                                            <option value="">-- تغییر ارجاع --</option>
                                            @foreach(\App\Models\User::whereIn('role', ['support', 'admin'])->get() as $sup)
                                                <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- TOOLS (Purchase / Assets) --}}
                    @if(in_array(auth()->user()->role, ['admin', 'support']))
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700 p-5">
                            <h4 class="font-bold text-gray-800 dark:text-gray-100 text-sm mb-4">ابزارهای پشتیبانی</h4>
                            
                            {{-- Purchase Request Link --}}
                            <a href="{{ route('admin.purchase-requests.create', ['ticket_id' => $ticket->id]) }}" class="flex items-center justify-between p-3 rounded-xl bg-purple-50 text-purple-700 hover:bg-purple-100 transition border border-purple-100 mb-2">
                                <span class="text-sm font-medium flex items-center gap-2">
                                    <i class="fas fa-shopping-cart"></i> درخواست خرید قطعه
                                </span>
                                <i class="fas fa-chevron-left text-xs"></i>
                            </a>

                            {{-- Asset Allocation --}}
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <p class="text-xs text-gray-500 mb-2">تخصیص قطعه از انبار:</p>
                                <form action="{{ route('tickets.allocateAsset', $ticket) }}" method="POST" class="flex gap-2">
                                    @csrf
                                    <select name="asset_id" class="w-full text-xs border-gray-200 rounded-lg">
                                        <option value="">انتخاب...</option>
                                        @foreach(\App\Models\Asset::where('status', 'available')->get() as $asset)
                                            <option value="{{ $asset->id }}">{{ $asset->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-blue-600 text-white px-3 rounded-lg hover:bg-blue-700"><i class="fas fa-plus"></i></button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- CENTER CONTENT (Chat) --}}
                <div class="lg:col-span-8 space-y-6">
                    
                    {{-- Description --}}
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
                        <h3 class="font-bold text-gray-900 dark:text-gray-100 text-lg mb-3">شرح مشکل</h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-wrap text-sm bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">{{ $ticket->description }}</p>
                    </div>

                    {{-- Timeline --}}
                    <div class="relative py-2">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200 dark:border-gray-700"></div></div>
                        <div class="relative flex justify-center"><span class="bg-gray-100 dark:bg-gray-700 px-4 py-1 rounded-full text-xs font-medium text-gray-500 dark:text-gray-300">تاریخچه گفتگو</span></div>
                    </div>

                    {{-- Messages --}}
                    <div class="space-y-6">
                        @forelse($ticket->messages as $message)
                            @php
                                $isMe = $message->user_id == auth()->id();
                                $isSupport = ($message->user->role == 'admin' || $message->user->role == 'support');
                            @endphp
                            
                            <div class="flex w-full {{ $isMe ? 'justify-start' : 'justify-end' }}">
                                <div class="flex max-w-[85%] gap-3 {{ $isMe ? 'flex-row' : 'flex-row-reverse' }}">
                                    
                                    {{-- Avatar --}}
                                    <div class="flex-shrink-0 mt-auto">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shadow-sm border-2 border-white dark:border-gray-800
                                            {{ $isSupport ? 'bg-blue-600' : 'bg-gray-400' }}">
                                            {{ mb_substr($message->user->name ?? '?', 0, 1) }}
                                        </div>
                                    </div>
                                    
                                    {{-- Bubble --}}
                                    <div class="shadow-sm rounded-2xl p-4 text-sm leading-relaxed border relative min-w-[120px]
                                        {{ $isMe 
                                            ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-100 dark:border-blue-800 text-gray-800 dark:text-gray-200 rounded-br-none' 
                                            : 'bg-white dark:bg-gray-700 border-gray-100 dark:border-gray-600 text-gray-700 dark:text-gray-200 rounded-bl-none' }}">
                                        
                                        <div class="flex justify-between items-center gap-4 mb-2 opacity-70">
                                            <span class="font-bold text-xs">{{ $message->user->name }}</span>
                                            <span class="text-[10px] dir-ltr">{{ $message->created_at->format('H:i') }}</span>
                                        </div>
                                        <div class="whitespace-pre-wrap">{{ $message->message }}</div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <p class="text-gray-400 text-sm">هنوز پاسخی ثبت نشده است.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Reply Box --}}
                    @if($ticket->status !== 'closed' && $ticket->status !== 'completed')
                        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sticky bottom-4 z-10">
                            <form action="{{ route('tickets.messages.store', $ticket) }}" method="POST">
                                @csrf
                                <textarea name="message" rows="2" class="w-full border-gray-300 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:ring-blue-500 resize-none text-sm p-3 dark:bg-gray-700 dark:text-white" placeholder="پاسخ خود را بنویسید..." required></textarea>
                                <div class="flex justify-end mt-2">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl text-sm font-bold shadow-sm transition flex items-center gap-2">
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
            <div class="flex flex-row-reverse justify-center gap-2 text-2xl mb-6 text-gray-300">
                @foreach(range(5,1) as $i)
                    <button type="submit" name="rating" value="{{ $i }}" class="hover:text-yellow-400 transition transform hover:scale-110 focus:text-yellow-400">
                        <i class="fas fa-star"></i>
                    </button>
                @endforeach
            </div>
            <p class="text-sm text-gray-500 mb-6">با انتخاب ستاره، درخواست بسته می‌شود.</p>
            <x-secondary-button x-on:click="$dispatch('close')">انصراف</x-secondary-button>
        </form>
    </x-modal>
</x-app-layout>