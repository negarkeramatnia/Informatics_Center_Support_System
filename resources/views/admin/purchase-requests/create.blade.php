<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('ثبت درخواست خرید تجهیزات') }}</h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.purchase-requests.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">نام کالا / قطعه</label>
                            <input type="text" name="item_name" class="form-input-custom w-full" required placeholder="مثال: هارد SSD 512GB">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">تعداد مورد نیاز</label>
                            <input type="number" name="quantity" value="1" min="1" class="form-input-custom w-full" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">قیمت حدودی (تومان)</label>
                            <input type="number" name="estimated_price" class="form-input-custom w-full" placeholder="اختیاری">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">لینک خرید (اینترنتی)</label>
                            <input type="url" name="url" class="form-input-custom w-full text-left" placeholder="https://...">
                        </div>
                    </div>

                    @if(isset($ticket))
        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
        
        {{-- Show a banner that we are linking to a ticket --}}
        <div class="bg-blue-50 border-r-4 border-blue-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-link text-blue-400"></i>
                </div>
                <div class="mr-3">
                    <p class="text-sm text-blue-700">
                        این خرید برای تیکت <strong>#{{ $ticket->id }} ({{ $ticket->title }})</strong> ثبت می‌شود.
                    </p>
                </div>
            </div>
        </div>
    @endif

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-gray-700 mb-1">دلیل نیاز / توضیحات فنی</label>
                        <textarea name="reason" rows="4" class="form-input-custom w-full" required placeholder="توضیح دهید چرا به این قطعه نیاز دارید..."></textarea>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.purchase-requests.index') }}" class="btn-secondary-custom py-2 px-4">انصراف</a>
                        <button type="submit" class="btn-primary-custom py-2 px-6">ثبت درخواست</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>