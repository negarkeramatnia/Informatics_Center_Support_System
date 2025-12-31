<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('دفترچه تلفن سازمانی') }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Search Bar --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-4">
                <form method="GET" action="{{ route('phonebook.index') }}">
                    <div class="relative max-w-xl mx-auto">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="جستجو بر اساس نام، شماره تماس یا واحد..." 
                               class="w-full border-gray-300 rounded-full py-3 px-6 pr-12 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                        
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white rounded-full w-9 h-9 flex items-center justify-center transition">
                            <i class="fas fa-search"></i>
                        </button>

                        @if(request('search'))
                            <a href="{{ route('phonebook.index') }}" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Users Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-right">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-gray-600 text-sm uppercase tracking-wider">
                                <th class="py-4 px-6 font-semibold">نام و نام خانوادگی</th>
                                <th class="py-4 px-6 font-semibold">واحد سازمانی</th>
                                <th class="py-4 px-6 font-semibold">شماره تماس</th>
                                <th class="py-4 px-6 font-semibold">آدرس ایمیل</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold ml-3 text-lg">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $user->role === 'admin' ? 'مدیر سیستم' : ($user->role === 'support' ? 'کارشناس پشتیبانی' : 'کارمند') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($user->department)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $user->department }}
                                            </span>
                                        @else
                                            <span class="text-gray-300">---</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($user->phone)
                                            <a href="tel:{{ $user->phone }}" class="text-gray-700 font-mono hover:text-blue-600 dir-ltr inline-block">
                                                {{ $user->phone }}
                                            </a>
                                        @else
                                            <span class="text-gray-300 text-sm">ثبت نشده</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 font-mono text-sm text-gray-500">
                                        {{ $user->email }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-500">
                                        کاربری یافت نشد.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($users->hasPages())
                    <div class="p-4 border-t border-gray-100">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>