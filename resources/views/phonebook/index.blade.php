<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('دفترچه تلفن سازمانی') }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Search Bar --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 p-4 transition-colors duration-300">
                <form method="GET" action="{{ route('phonebook.index') }}">
                    <div class="relative max-w-xl mx-auto">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="جستجو بر اساس نام، شماره تماس یا واحد..." 
                               class="w-full bg-white dark:bg-slate-900 text-gray-900 dark:text-white border-gray-300 dark:border-slate-600 rounded-full py-3 px-6 pr-12 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:focus:ring-blue-900/50 transition placeholder-gray-400 dark:placeholder-gray-500">
                        
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white rounded-full w-9 h-9 flex items-center justify-center transition">
                            <i class="fas fa-search"></i>
                        </button>

                        @if(request('search'))
                            <a href="{{ route('phonebook.index') }}" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 hover:text-red-500 dark:hover:text-red-400 transition">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Users Table --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-300">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-right">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-700 text-gray-600 dark:text-gray-300 text-sm uppercase tracking-wider transition-colors">
                                <th class="py-4 px-6 font-semibold">نام و نام خانوادگی</th>
                                <th class="py-4 px-6 font-semibold">واحد سازمانی</th>
                                <th class="py-4 px-6 font-semibold">شماره تماس</th>
                                <th class="py-4 px-6 font-semibold">آدرس ایمیل</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold ml-3 text-lg transition-colors">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->role === 'admin' ? 'مدیر سیستم' : ($user->role === 'support' ? 'کارشناس پشتیبانی' : 'کارمند') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($user->department)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-gray-100 dark:bg-slate-700 text-gray-800 dark:text-gray-200 transition-colors">
                                                {{ $user->department }}
                                            </span>
                                        @else
                                            <span class="text-gray-300 dark:text-slate-600">---</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($user->phone)
                                            <a href="tel:{{ $user->phone }}" class="text-gray-700 dark:text-gray-300 font-mono hover:text-blue-600 dark:hover:text-blue-400 transition-colors dir-ltr inline-block">
                                                {{ $user->phone }}
                                            </a>
                                        @else
                                            <span class="text-gray-300 dark:text-slate-600 text-sm">ثبت نشده</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 font-mono text-sm text-gray-500 dark:text-gray-400">
                                        {{ $user->email }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                        کاربری یافت نشد.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($users->hasPages())
                    <div class="p-4 border-t border-gray-100 dark:border-slate-700 transition-colors">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>