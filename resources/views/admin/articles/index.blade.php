<x-app-layout>
    {{-- PREMIUM HEADER REDESIGN --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center w-full gap-4">
            
            <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight flex items-center gap-2">
                <i class="fas fa-book text-blue-500"></i>
                {{ __('مدیریت مقالات پایگاه دانش') }}
            </h2>
            
            <a href="{{ route('admin.articles.create') }}" class="group flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-all duration-300 shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5">
                <i class="fas fa-plus-circle transition-transform group-hover:rotate-90"></i>
                <span>افزودن مقاله جدید</span>
            </a>

        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- SEARCH & FILTER SECTION --}}
            <form method="GET" action="{{ route('admin.articles.index') }}" class="mb-6 bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 p-5 transition-colors duration-300">
                <div class="flex flex-col md:flex-row gap-4 items-end">
                    
                    <div class="flex-1 w-full">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2">جستجو</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="عنوان یا متن مقاله..." class="w-full text-sm border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>

                    <div class="flex gap-2 h-[42px] w-full md:w-auto">
                        {{-- FIX: Search Button is now Green --}}
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 rounded-lg text-sm font-bold transition flex items-center justify-center gap-2 shadow-sm">
                            <i class="fas fa-search"></i> جستجو
                        </button>
                        <a href="{{ route('admin.articles.index') }}" class="bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 px-4 rounded-lg text-sm font-bold transition flex items-center justify-center gap-2 border border-gray-200 dark:border-slate-600">
                            <i class="fas fa-times"></i> حذف
                        </a>
                    </div>
                </div>
            </form>

            {{-- ARTICLES TABLE SECTION --}}
            <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        
                        <thead class="bg-gray-50 dark:bg-slate-900/50 text-gray-500 dark:text-gray-400 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">عنوان</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">دسته‌بندی</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">وضعیت</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">تاریخ انتشار</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">عملیات</th>
                            </tr>
                        </thead>
                        
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700 text-sm">
                            @forelse ($articles as $article)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                                    
                                    <td class="px-6 py-4 text-center font-bold text-gray-900 dark:text-white">
                                        {{ Str::limit($article->title, 50) }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-400">
                                        {{ __($article->category ?? '---') }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        @if($article->is_published)
                                            <span class="px-3 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800 rounded-full text-xs font-bold">منتشر شده</span>
                                        @else
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800 rounded-full text-xs font-bold">پیش‌نویس</span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-400 dir-ltr text-sm font-mono">
                                        {{-- Shamsi Date Formatting --}}
                                        {{ \Morilog\Jalali\Jalalian::forge($article->created_at)->format('Y/m/d') }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-4">
                                            <a href="{{ route('admin.articles.edit', $article) }}" class="text-blue-500 hover:text-blue-700 dark:hover:text-blue-400 transition transform hover:scale-110" title="ویرایش">
                                                <i class="fas fa-edit text-lg"></i>
                                            </a>
                                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="inline" onsubmit="return confirm('آیا از حذف این مقاله اطمینان دارید؟');">
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
                                    <td colspan="5" class="text-center py-12 text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-file-alt text-4xl mb-3 opacity-30"></i>
                                            <span>هیچ مقاله‌ای یافت نشد.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if(method_exists($articles, 'links'))
                    <div class="p-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                        {{ $articles->links() }}
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</x-app-layout>