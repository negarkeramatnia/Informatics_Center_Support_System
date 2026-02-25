<x-app-layout>
    @section('title', 'ثبت درخواست خرید')

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-purple-600 dark:text-purple-400 text-lg"></i>
                </div>
                <h2 class="font-black text-xl text-gray-900 dark:text-white leading-tight">
                    ثبت درخواست خرید جدید
                </h2>
            </div>
            
            {{-- THE BACK BUTTON (Explicitly routed to your index) --}}
            <a href="{{ route('admin.purchase-requests.index') }}" class="flex items-center gap-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300 px-5 py-2.5 rounded-xl font-bold transition-all shadow-sm">
                بازگشت <i class="fas fa-arrow-left text-sm"></i>
            </a>
        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- GLOBAL ALERTS & VALIDATION CATCHER --}}
            @if(session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-6 py-4 rounded-2xl font-bold flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle text-xl"></i> {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-6 py-4 rounded-2xl font-bold">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fas fa-times-circle text-xl"></i>
                        <span>ثبت درخواست با خطا مواجه شد. لطفاً موارد زیر را بررسی کنید:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm pr-8 space-y-1 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.purchase-requests.store') }}" method="POST" class="bg-white dark:bg-slate-800 shadow-sm rounded-3xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
                @csrf
                
                {{-- DYNAMIC TICKET LINK BANNER (Dark Mode Compatible) --}}
                @if(isset($ticket) || request()->has('ticket_id') || old('ticket_id'))
                    @php $currentTicketId = isset($ticket) ? $ticket->id : old('ticket_id', request('ticket_id')); @endphp
                    <input type="hidden" name="ticket_id" value="{{ $currentTicketId }}">
                    <div class="bg-blue-50/80 dark:bg-blue-900/20 border-b border-blue-100 dark:border-blue-800/50 p-4 px-8 flex items-center gap-3">
                        <i class="fas fa-link text-blue-500"></i>
                        <span class="text-sm font-bold text-blue-700 dark:text-blue-400">
                            این خرید برای تیکت <strong>#{{ $currentTicketId }} @if(isset($ticket)) ({{ $ticket->title }}) @endif</strong> ثبت می‌شود.
                        </span>
                    </div>
                @endif

                {{-- Form Header --}}
                <div class="px-8 py-5 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 flex justify-between items-center">
                    <h3 class="font-black text-gray-800 dark:text-white flex items-center gap-2 text-lg">
                        <i class="fas fa-box-open text-purple-500"></i> مشخصات کالای درخواستی
                    </h3>
                </div>

                {{-- Form Body (6-Column Grid) --}}
                <div class="p-8 grid grid-cols-1 md:grid-cols-6 gap-6">
                    
                    {{-- Item Name --}}
                    <div class="col-span-1 md:col-span-3">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">نام کالا / قطعه <span class="text-red-500">*</span></label>
                        <input type="text" name="item_name" value="{{ old('item_name') }}" required placeholder="مثال: هارد SSD 512GB"
                               class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors placeholder-gray-400 dark:placeholder-gray-500">
                    </div>

                    {{-- Quantity --}}
                    <div class="col-span-1 md:col-span-3">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">تعداد مورد نیاز <span class="text-red-500">*</span></label>
                        <input type="number" name="quantity" value="{{ old('quantity', 1) }}" required min="1"
                               class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors placeholder-gray-400 dark:placeholder-gray-500">
                    </div>

                    {{-- Estimated Price --}}
                    <div class="col-span-1 md:col-span-3">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">قیمت حدودی (تومان)</label>
                        <input type="number" name="estimated_price" value="{{ old('estimated_price') }}" dir="ltr" placeholder="اختیاری"
                               class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors text-left font-mono placeholder-gray-400 dark:placeholder-gray-500">
                    </div>

                    {{-- Purchase Link --}}
                    <div class="col-span-1 md:col-span-3">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">لینک خرید (اینترنتی)</label>
                        <input type="url" name="url" value="{{ old('url') }}" dir="ltr" placeholder="https://..."
                               class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors text-left font-mono placeholder-gray-400 dark:placeholder-gray-500">
                    </div>

                    {{-- Reason/Description --}}
                    <div class="col-span-1 md:col-span-6">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">دلیل نیاز / توضیحات فنی <span class="text-red-500">*</span></label>
                        <textarea name="reason" rows="4" required placeholder="توضیح دهید چرا به این قطعه نیاز دارید..."
                                  class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors resize-none placeholder-gray-400 dark:placeholder-gray-500">{{ old('reason') }}</textarea>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="px-8 py-5 border-t border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 flex items-center justify-between">
                    <a href="{{ route('admin.purchase-requests.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-bold text-sm px-4 py-2 transition-colors">
                        انصراف
                    </a>
                    
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-xl font-black transition-all shadow-lg shadow-purple-500/30 flex items-center gap-2 hover:-translate-y-0.5">
                        <i class="fas fa-cart-plus"></i> ثبت درخواست
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>