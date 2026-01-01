<x-app-layout>
    {{-- HEADER (Hidden when printing) --}}
    <x-slot name="header">
        <div class="flex justify-between items-center print:hidden">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('جزئیات درخواست خرید') }}</h2>
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                <i class="fas fa-print ml-2"></i> چاپ فرم
            </button>
        </div>
    </x-slot>

    {{-- 
        PRINT STYLING NOTE:
        We use 'print:hidden' to hide sidebar/nav/buttons.
        We use 'print:w-full' and 'print:shadow-none' to make the card look like paper.
    --}}
    
    <div class="py-12" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- THE PAPER FORM --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border-2 border-gray-200 p-8 print:border-2 print:border-black print:shadow-none print:w-full print:m-0 print:p-0">
                
                @if($purchaseRequest->ticket)
                    <p class="mt-2 bg-gray-100 px-2 py-1 rounded border border-gray-300 inline-block print:border-black">
                        <span class="font-bold">مربوط به تیکت:</span> #{{ $purchaseRequest->ticket->id }}
                    </p>
                @endif
                
                {{-- Form Header --}}
                <div class="border-b-2 border-gray-800 pb-6 mb-6 flex justify-between items-center">
                    <div class="text-right">
                        <h1 class="text-2xl font-bold text-gray-900 mb-1">فرم درخواست خرید کالا</h1>
                        <p class="text-gray-600 font-medium">واحد فناوری اطلاعات (IT)</p>
                    </div>
                    <div class="text-left text-sm text-gray-600">
                        <p class="mb-1"><span class="font-bold">شماره درخواست:</span> #{{ $purchaseRequest->id }}</p>
                        <p><span class="font-bold">تاریخ:</span> {{ $purchaseRequest->created_at->format('Y/m/d') }}</p>
                    </div>
                </div>

                {{-- User Info Section --}}
                <div class="bg-gray-50 border border-gray-200 p-4 rounded mb-6 print:bg-white print:border-gray-400">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <span class="text-gray-500 text-sm block">درخواست کننده:</span>
                            <span class="font-bold text-lg">{{ $purchaseRequest->user->name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-sm block">واحد سازمانی:</span>
                            <span class="font-bold text-lg">{{ $purchaseRequest->user->department ?? '---' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Item Details Table --}}
                <div class="mb-6">
                    <h3 class="font-bold text-gray-800 mb-2 border-r-4 border-gray-800 pr-2">مشخصات کالا</h3>
                    <table class="w-full border-collapse border border-gray-400">
                        <tr class="bg-gray-100 print:bg-gray-200">
                            <th class="border border-gray-400 p-3 text-right w-1/2">نام کالا / شرح خدمات</th>
                            <th class="border border-gray-400 p-3 text-center">تعداد</th>
                            <th class="border border-gray-400 p-3 text-left">قیمت واحد (حدودی)</th>
                        </tr>
                        <tr>
                            <td class="border border-gray-400 p-4 font-bold">{{ $purchaseRequest->item_name }}</td>
                            <td class="border border-gray-400 p-4 text-center text-lg">{{ $purchaseRequest->quantity }}</td>
                            <td class="border border-gray-400 p-4 text-left font-mono">
                                {{ $purchaseRequest->estimated_price ? number_format($purchaseRequest->estimated_price) . ' تومان' : '---' }}
                            </td>
                        </tr>
                    </table>
                </div>

                {{-- Justification --}}
                <div class="mb-8">
                    <h3 class="font-bold text-gray-800 mb-2 border-r-4 border-gray-800 pr-2">دلیل نیاز و توضیحات فنی</h3>
                    <div class="border border-gray-400 rounded p-4 min-h-[100px] text-justify leading-7">
                        {{ $purchaseRequest->reason }}
                        @if($purchaseRequest->url)
                            <br><br>
                            <span class="font-bold text-sm">لینک نمونه:</span> <span class="font-mono text-xs">{{ $purchaseRequest->url }}</span>
                        @endif
                    </div>
                </div>

                {{-- Signatures Area (Crucial for office forms) --}}
                <div class="grid grid-cols-3 gap-8 mt-12 pt-8 border-t-2 border-gray-800 print:mt-24">
                    <div class="text-center">
                        <p class="font-bold mb-12">امضای درخواست کننده</p>
                        <div class="border-t border-dashed border-gray-400 w-2/3 mx-auto"></div>
                    </div>
                    <div class="text-center">
                        <p class="font-bold mb-12">تایید مدیر واحد IT</p>
                        <div class="border-t border-dashed border-gray-400 w-2/3 mx-auto"></div>
                    </div>
                    <div class="text-center">
                        <p class="font-bold mb-12">تایید امور مالی / تدارکات</p>
                        <div class="border-t border-dashed border-gray-400 w-2/3 mx-auto"></div>
                    </div>
                </div>

            </div>
            
            {{-- Back Link (Hidden on Print) --}}
            <div class="mt-4 text-left print:hidden">
                <a href="{{ route('admin.purchase-requests.index') }}" class="text-gray-500 hover:text-gray-700 underline">
                    بازگشت به لیست درخواست‌ها
                </a>
            </div>

        </div>
    </div>
</x-app-layout>