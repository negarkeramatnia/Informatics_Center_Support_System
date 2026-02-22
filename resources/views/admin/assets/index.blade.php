<x-app-layout>
    {{-- PREMIUM HEADER REDESIGN (Consistent Blue Palette) --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center w-full gap-4">
            
            <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight flex items-center gap-2">
                <i class="fas fa-hdd text-blue-500"></i>
                {{ __('مدیریت قطعات') }}
            </h2>
            
            <a href="{{ route('admin.assets.create') }}" class="group flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-all duration-300 shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5">
                <i class="fas fa-plus-circle transition-transform group-hover:rotate-90"></i>
                <span>افزودن دستگاه جدید</span>
            </a>

        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- SEARCH & FILTER SECTION --}}
            <form method="GET" action="{{ route('admin.assets.index') }}" class="mb-6 bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 p-5 transition-colors duration-300">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2">جستجو</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="نام، سریال یا IP..." class="w-full text-sm border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2">محل استقرار</label>
                        <select name="location" class="w-full text-sm border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">همه مکان‌ها</option>
                            @php $locations = ['فناوری اطلاعات', 'خدمات مشترکین', 'حراست', 'مدیریت', 'مالی']; @endphp
                            @foreach($locations as $location)
                                <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>{{ $location }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2">وضعیت</label>
                        <select name="status" class="w-full text-sm border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">همه وضعیت‌ها</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>در دسترس</option>
                            <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>اختصاص یافته</option>
                            <option value="under_maintenance" {{ request('status') == 'under_maintenance' ? 'selected' : '' }}>در حال تعمیر</option>
                            <option value="retired" {{ request('status') == 'retired' ? 'selected' : '' }}>از رده خارج</option>
                        </select>
                    </div>

                    <div class="flex gap-2 h-[42px]">
                        <button type="submit" class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-bold transition flex                     items-center justify-center gap-2 shadow-sm">
                            <i class="fas fa-filter"></i> فیلتر
                        </button>
                        <a href="{{ route('admin.assets.index') }}" class="flex-1 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600                   text-gray-700 dark:text-gray-200 rounded-lg text-sm font-bold transition flex items-center justify-center gap-2 border                  border-gray-200 dark:border-slate-600">
                            <i class="fas fa-times"></i> حذف
                        </a>
                    </div>
                </div>
            </form>

            {{-- ASSETS TABLE SECTION --}}
            <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        
                        <thead class="bg-gray-50 dark:bg-slate-900/50 text-gray-500 dark:text-gray-400 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">نام قطعه</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">شماره سریال</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">وضعیت</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">محل استقرار</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">اختصاص به</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">عملیات</th>
                            </tr>
                        </thead>
                        
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700 text-sm">
                            @forelse ($assets as $asset)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                                    
                                    <td class="px-6 py-4 text-center font-bold text-gray-900 dark:text-white">
                                        {{ $asset->name }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-400 font-mono text-xs">
                                        {{ $asset->serial_number ?? '---' }}
                                    </td>
                                    
                                    {{-- FIX: Corrected Status Logic --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($asset->status === 'available')
                                            <span class="px-3 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800 rounded-full text-xs font-bold">در دسترس</span>
                                        @elseif($asset->status === 'assigned')
                                            <span class="px-3 py-1 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800 rounded-full text-xs font-bold">اختصاص یافته</span>
                                        @elseif($asset->status === 'under_maintenance' || $asset->status === 'maintenance')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800 rounded-full text-xs font-bold">در حال تعمیر</span>
                                        @elseif($asset->status === 'retired')
                                            <span class="px-3 py-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800 rounded-full text-xs font-bold">از رده خارج</span>
                                        @else
                                            {{-- Fallback for any unknown English status --}}
                                            <span class="px-3 py-1 bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 border border-gray-200 dark:border-gray-600 rounded-full text-xs font-bold">{{ str_replace('_', ' ', $asset->status) }}</span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg text-xs font-medium border border-gray-200 dark:border-slate-600">
                                            {{ $asset->location ?? '---' }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center text-gray-700 dark:text-gray-300 font-medium">
                                        {{ $asset->user->name ?? ($asset->assigned_to ?? '---') }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            <a href="#" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition transform hover:scale-110" title="تاریخچه">
                                                <i class="fas fa-history text-lg"></i>
                                            </a>
                                            <a href="{{ route('admin.assets.edit', $asset) }}" class="text-blue-500 hover:text-blue-700 dark:hover:text-blue-400 transition transform hover:scale-110" title="ویرایش">
                                                <i class="fas fa-edit text-lg"></i>
                                            </a>
                                            <form action="{{ route('admin.assets.destroy', $asset) }}" method="POST" class="inline" onsubmit="return confirm('آیا از حذف این قطعه اطمینان دارید؟');">
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
                                            <i class="fas fa-microchip text-4xl mb-3 opacity-30"></i>
                                            <span>هیچ قطعه‌ای یافت نشد.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if(method_exists($assets, 'links'))
                    <div class="p-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                        {{ $assets->links() }}
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</x-app-layout>