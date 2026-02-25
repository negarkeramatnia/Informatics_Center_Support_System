<x-app-layout>
    @section('title', 'جزئیات درخواست خرید #' . $purchaseRequest->id)

    {{-- PRINT STYLES: Ensures it looks perfect on paper, overriding dark mode --}}
    @push('styles')
    <style>
        @media print {
            body * { visibility: hidden; }
            #printable-form, #printable-form * { visibility: visible; }
            #printable-form {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                background-color: white !important;
                color: black !important;
            }
            /* Hide the sidebar and top navbar during print */
            header, nav, aside, .print-hide { display: none !important; }
            
            /* NEW: Force the hidden URL to show up on paper! */
            .print-show { display: inline-block !important; visibility: visible !important; }
            
            .print-border { border-color: #cbd5e1 !important; }
            .print-bg { background-color: #f8fafc !important; }
            .print-text { color: #000 !important; }
        }
    </style>
    @endpush

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center">
                    <i class="fas fa-file-invoice text-purple-600 dark:text-purple-400 text-lg"></i>
                </div>
                <h2 class="font-black text-xl text-gray-900 dark:text-white leading-tight">
                    جزئیات درخواست خرید <span class="text-purple-600 dark:text-purple-400 font-mono text-lg">#{{ $purchaseRequest->id }}</span>
                </h2>
            </div>
            
            <div class="flex items-center gap-3">
                {{-- THE PRINT BUTTON --}}
                <button onclick="window.print()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-blue-500/30">
                    <i class="fas fa-print"></i> چاپ فرم
                </button>

                {{-- THE BACK BUTTON --}}
                <a href="{{ route('admin.purchase-requests.index') }}" class="flex items-center gap-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300 px-5 py-2.5 rounded-xl font-bold transition-all shadow-sm">
                    بازگشت <i class="fas fa-arrow-left text-sm"></i>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- THE PRINTABLE CARD --}}
            <div id="printable-form" class="bg-white dark:bg-slate-800 shadow-sm rounded-3xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors p-8 print-bg">

                {{-- Document Header --}}
                <div class="flex justify-between items-start border-b-2 border-gray-200 dark:border-slate-600 pb-6 mb-6 print-border">
                    <div>
                        <h1 class="text-2xl font-black text-gray-900 dark:text-white mb-2 print-text">فرم درخواست خرید کالا</h1>
                        <p class="text-gray-600 dark:text-gray-400 font-bold print-text">واحد فناوری اطلاعات (IT)</p>
                    </div>
                    <div class="text-left text-sm text-gray-600 dark:text-gray-400 space-y-2 print-text">
                        <div><span class="font-bold">شماره درخواست:</span> <span class="font-mono" dir="ltr">#{{ $purchaseRequest->id }}</span></div>
                        
                        {{-- FIXED: Converted Date to Shamsi --}}
                        <div>
                            <span class="font-bold">تاریخ ثبت:</span> 
                            <span class="font-mono" dir="ltr">
                                {{ \Morilog\Jalali\Jalalian::fromCarbon($purchaseRequest->created_at)->format('Y/m/d') }}
                            </span>
                        </div>

                        @if($purchaseRequest->ticket_id)
                            <div><span class="font-bold">شماره تیکت مرتبط:</span> <span class="font-mono font-bold text-purple-600 dark:text-purple-400 print-text" dir="ltr">#{{ $purchaseRequest->ticket_id }}</span></div>
                        @endif
                    </div>
                </div>

                {{-- Requester Info --}}
                <div class="grid grid-cols-2 gap-6 mb-8 bg-gray-50 dark:bg-slate-900/50 p-5 rounded-2xl border border-gray-100 dark:border-slate-700 print-bg print-border">
                    <div>
                        <span class="block text-xs text-gray-500 dark:text-gray-400 font-bold mb-1 print-text">درخواست کننده:</span>
                        <span class="text-lg font-black text-gray-900 dark:text-white print-text">{{ $purchaseRequest->user->name ?? 'نامشخص' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500 dark:text-gray-400 font-bold mb-1 print-text">واحد سازمانی:</span>
                        <span class="text-lg font-black text-gray-900 dark:text-white print-text">{{ $purchaseRequest->user->department ?? 'نامشخص' }}</span>
                    </div>
                </div>

                {{-- Item Specifications --}}
                <div class="mb-8">
                    <h3 class="text-lg font-black text-gray-800 dark:text-white mb-4 flex items-center gap-2 border-r-4 border-purple-500 pr-2 print-text">
                        مشخصات کالا
                    </h3>
                    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-slate-700 print-border">
                        <table class="w-full text-sm text-right">
                            <thead class="bg-gray-50 dark:bg-slate-900/50 text-gray-700 dark:text-gray-300 font-bold border-b border-gray-200 dark:border-slate-700 print-bg print-border print-text">
                                <tr>
                                    <th class="px-5 py-4">شرح کالا / قطعه</th>
                                    <th class="px-5 py-4 text-center">تعداد</th>
                                    <th class="px-5 py-4">قیمت حدودی (تومان)</th>
                                    <th class="px-5 py-4">لینک / مرجع</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-800 dark:text-gray-200 divide-y divide-gray-100 dark:divide-slate-700 print-text print-border">
                                <tr>
                                    <td class="px-5 py-4 font-bold">{{ $purchaseRequest->item_name }}</td>
                                    <td class="px-5 py-4 text-center font-mono font-bold text-lg">{{ $purchaseRequest->quantity }}</td>
                                    <td class="px-5 py-4 font-mono">{{ $purchaseRequest->estimated_price ? number_format($purchaseRequest->estimated_price) : '---' }}</td>
                                    <td class="px-5 py-4 dir-ltr text-left">
                                        @if($purchaseRequest->url)
                                            {{-- FIXED: Show digital button on screen, show raw URL on paper --}}
                                            <a href="{{ $purchaseRequest->url }}" target="_blank" class="text-blue-500 dark:text-blue-400 hover:underline truncate inline-block max-w-[150px] print-hide" dir="ltr">مشاهده لینک</a>
                                            <span class="hidden print-show text-xs font-mono break-all text-black" dir="ltr">{{ $purchaseRequest->url }}</span>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500">---</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Reason / Technical Details --}}
                <div class="mb-12">
                    <h3 class="text-lg font-black text-gray-800 dark:text-white mb-4 flex items-center gap-2 border-r-4 border-purple-500 pr-2 print-text">
                        دلیل نیاز و توضیحات فنی
                    </h3>
                    <div class="bg-gray-50 dark:bg-slate-900/50 p-6 rounded-2xl border border-gray-100 dark:border-slate-700 min-h-[120px] text-gray-800 dark:text-gray-200 leading-loose whitespace-pre-wrap print-bg print-border print-text">
                        {{ $purchaseRequest->reason }}
                    </div>
                </div>

                {{-- Signature Fields (Essential for printed forms) --}}
                <div class="grid grid-cols-3 gap-6 pt-16 border-t-2 border-dashed border-gray-200 dark:border-slate-700 text-center print-border">
                    <div>
                        <span class="block font-bold text-gray-700 dark:text-gray-300 mb-16 print-text">امضای درخواست کننده</span>
                        <div class="border-b border-gray-300 dark:border-slate-600 mx-6 print-border"></div>
                    </div>
                    <div>
                        <span class="block font-bold text-gray-700 dark:text-gray-300 mb-16 print-text">تایید مدیر واحد</span>
                        <div class="border-b border-gray-300 dark:border-slate-600 mx-6 print-border"></div>
                    </div>
                    <div>
                        <span class="block font-bold text-gray-700 dark:text-gray-300 mb-16 print-text">تایید فناوری اطلاعات</span>
                        <div class="border-b border-gray-300 dark:border-slate-600 mx-6 print-border"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>