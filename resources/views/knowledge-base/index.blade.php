<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('پایگاه دانش (سوالات متداول)') }}</h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- SEARCH BAR SECTION --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8 p-8 text-center">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">چطور می‌توانیم به شما کمک کنیم؟</h3>
                
                <form method="GET" action="{{ route('knowledge-base.index') }}" class="max-w-3xl mx-auto relative flex items-center">
                    
                    {{-- Search Button (Right) --}}
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-green-500 hover:bg-green-600 text-white rounded-lg w-10 h-10 flex items-center justify-center transition shadow-sm z-10">
                        <i class="fas fa-search"></i>
                    </button>

                    {{-- Input Field --}}
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="جستجو در مقالات آموزشی (مثلا: فراموشی رمز عبور)..." 
                           class="w-full border-gray-300 rounded-xl py-4 {{ request('search') ? 'pl-12' : 'pl-6' }} pr-14 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition text-gray-700 leading-tight">
                    
                    {{-- Cancel Button (Left - appears when searching) --}}
                    @if(request('search'))
                        <a href="{{ route('knowledge-base.index') }}" 
                           class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-full w-8 h-8 flex items-center justify-center transition"
                           title="پاک کردن جستجو">
                            <i class="fas fa-times text-lg"></i>
                        </a>
                    @endif
                </form>
            </div>

            {{-- ARTICLES LIST (Rows) --}}
            {{-- Changed from 'grid' to 'flex-col' so they stack vertically --}}
            <div class="flex flex-col space-y-4">
                @forelse($articles as $article)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300 border border-gray-100 overflow-hidden">
                        
                        {{-- Article Header Row --}}
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-3">
                                {{-- Title and Category --}}
                                <div class="flex items-center gap-3">
                                    @php
                                        $catColors = [
                                            'general' => 'bg-gray-100 text-gray-800',
                                            'software' => 'bg-blue-100 text-blue-800',
                                            'hardware' => 'bg-red-100 text-red-800',
                                            'network' => 'bg-green-100 text-green-800',
                                            'security' => 'bg-purple-100 text-purple-800',
                                        ];
                                        $catColor = $catColors[$article->category] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="{{ $catColor }} text-xs font-semibold px-2.5 py-1 rounded-md whitespace-nowrap">
                                        {{ __($article->category) }}
                                    </span>
                                    <h4 class="text-lg font-bold text-gray-800">{{ $article->title }}</h4>
                                </div>

                                {{-- Date --}}
                                <span class="text-gray-400 text-xs flex items-center whitespace-nowrap">
                                    <i class="far fa-clock ml-1"></i>
                                    {{ $article->created_at->diffForHumans() }}
                                </span>
                            </div>

                            {{-- Preview Text --}}
                            <p class="text-gray-600 text-sm leading-relaxed mb-4">
                                {{ Str::limit(strip_tags($article->content), 200) }}
                            </p>

                            {{-- Collapsible Details Section --}}
                            <details class="group bg-gray-50 rounded-lg border border-gray-100">
                                <summary class="list-none text-green-600 hover:text-green-700 cursor-pointer text-sm font-bold flex items-center justify-between w-full p-4 select-none transition group-open:bg-green-50 group-open:text-green-800 rounded-lg">
                                    <span>مشاهده پاسخ کامل</span>
                                    <span class="group-open:rotate-180 transition-transform duration-200">
                                        <i class="fas fa-chevron-down"></i>
                                    </span>
                                </summary>
                                <div class="p-6 border-t border-gray-100 text-gray-800 leading-8 whitespace-pre-wrap animate-fadeIn text-sm">
                                    {{ $article->content }}
                                </div>
                            </details>
                        </div>
                    </div>
                @empty
                    @if(request('search'))
                        <div class="text-center py-16 text-gray-500 bg-white rounded-xl shadow-sm border border-gray-100">
                            <i class="fas fa-search text-5xl mb-4 text-gray-200 block"></i>
                            <p class="text-lg font-medium text-gray-600">هیچ مقاله‌ای با عبارت "{{ request('search') }}" یافت نشد.</p>
                            <a href="{{ route('knowledge-base.index') }}" class="text-green-600 hover:underline mt-2 block">
                                مشاهده همه مقالات
                            </a>
                        </div>
                    @else
                         <div class="text-center py-16 text-gray-500 bg-white rounded-xl shadow-sm border border-gray-100">
                            <i class="fas fa-book-open text-5xl mb-4 text-gray-200 block"></i>
                            <p class="text-lg font-medium text-gray-600">هنوز مقاله‌ای در پایگاه دانش ثبت نشده است.</p>
                        </div>
                    @endif
                @endforelse
            </div>
            
            {{-- Pagination (if you added paginate to controller) --}}
            {{-- <div class="mt-6">{{ $articles->links() }}</div> --}}
            
        </div>
    </div>
</x-app-layout>