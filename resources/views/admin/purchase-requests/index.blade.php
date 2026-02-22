<x-app-layout>
    {{-- PREMIUM HEADER REDESIGN (Consistent Blue Palette) --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center w-full gap-4">
            
            <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight flex items-center gap-2">
                <i class="fas fa-shopping-cart text-blue-500"></i>
                {{ __('درخواست‌های خرید') }}
            </h2>
            
            <a href="{{ route('admin.purchase-requests.create') }}" class="group flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-all duration-300 shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5">
                <i class="fas fa-plus-circle transition-transform group-hover:rotate-90"></i>
                <span>ثبت درخواست جدید</span>
            </a>

        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- PURCHASE REQUESTS TABLE SECTION --}}
            <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        
                        <thead class="bg-gray-50 dark:bg-slate-900/50 text-gray-500 dark:text-gray-400 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">عنوان کالا</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">درخواست کننده</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">تعداد</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">وضعیت</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">تاریخ</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">عملیات</th>
                            </tr>
                        </thead>
                        
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700 text-sm">
                            @forelse ($purchaseRequests as $request)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                                    
                                    <td class="px-6 py-4 text-center font-bold text-gray-900 dark:text-white">
                                        {{ $request->item_name ?? $request->title }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center text-gray-700 dark:text-gray-300 font-medium">
                                        {{ $request->user->name ?? ($request->requester_name ?? '---') }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-400 font-bold">
                                        {{ $request->quantity ?? 1 }}
                                    </td>
                                    
                                    {{-- FIX: Corrected Status Logic to Persian with Semantic Badges --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($request->status === 'pending')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800 rounded-full text-xs font-bold">در انتظار بررسی</span>
                                        @elseif($request->status === 'approved')
                                            <span class="px-3 py-1 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800 rounded-full text-xs font-bold">تایید شده</span>
                                        @elseif($request->status === 'purchased' || $request->status === 'completed')
                                            <span class="px-3 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800 rounded-full text-xs font-bold">خریداری شده</span>
                                        @elseif($request->status === 'rejected')
                                            <span class="px-3 py-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800 rounded-full text-xs font-bold">رد شده</span>
                                        @else
                                            <span class="px-3 py-1 bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 border border-gray-200 dark:border-gray-600 rounded-full text-xs font-bold">{{ str_replace('_', ' ', $request->status) }}</span>
                                        @endif
                                    </td>
                                    
                                    {{-- FIX: Shamsi Date Formatting --}}
                                    <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-400 dir-ltr text-sm font-mono">
                                        {{-- If you use Morilog/Jalali package: --}}
                                        {{ \Morilog\Jalali\Jalalian::forge($request->created_at)->format('Y/m/d') }}
                                        
                                        {{-- NOTE: If you use the Verta package instead, change the above line to: --}}
                                        {{-- {{ verta($request->created_at)->format('Y/m/d') }} --}}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-4">
                                            <a href="{{ route('admin.purchase-requests.show', $request) }}" class="text-blue-500 hover:text-blue-700 dark:hover:text-blue-400 transition transform hover:scale-110 flex items-center gap-1 font-semibold text-xs" title="مشاهده">
                                                <i class="fas fa-print"></i> مشاهده و چاپ
                                            </a>
                                            <form action="{{ route('admin.purchase-requests.destroy', $request) }}" method="POST" class="inline" onsubmit="return confirm('آیا از حذف این درخواست اطمینان دارید؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 dark:hover:text-red-400 transition transform hover:scale-110" title="حذف">
                                                    <i class="fas fa-trash-alt text-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-12 text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-shopping-cart text-4xl mb-3 opacity-30"></i>
                                            <span>هیچ درخواست خریدی یافت نشد.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if(method_exists($purchaseRequests, 'links'))
                    <div class="p-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                        {{ $purchaseRequests->links() }}
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</x-app-layout>