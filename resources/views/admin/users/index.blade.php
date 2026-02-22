<x-app-layout>
    {{-- PREMIUM HEADER REDESIGN --}}
<x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center w-full gap-4">
            
            <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight flex items-center gap-2">
                <i class="fas fa-users text-blue-500"></i>
                {{ __('مدیریت کاربران') }}
            </h2>
            
            <a href="{{ route('admin.users.create') }}" class="group flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-all duration-300 shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5">
                <i class="fas fa-user-plus transition-transform group-hover:scale-110"></i>
                <span>افزودن کاربر جدید</span>
            </a>

        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- SEARCH & FILTER SECTION --}}
            <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6 bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 p-5 transition-colors duration-300">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2">جستجو</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="نام، نام کاربری یا تلفن..." class="w-full text-sm border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2">واحد سازمانی</label>
                        <select name="department" class="w-full text-sm border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">همه واحدها</option>
                            @php $depts = ['مدیریت', 'فناوری اطلاعات', 'منابع انسانی', 'مالی', 'حراست', 'خدمات مشترکین', 'فنی و مهندسی']; @endphp
                            @foreach($depts as $dept)
                                <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2">نقش</label>
                        <select name="role" class="w-full text-sm border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">همه نقش‌ها</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>مدیر</option>
                            <option value="support" {{ request('role') == 'support' ? 'selected' : '' }}>پشتیبان</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>کاربر عادی</option>
                        </select>
                    </div>

                    <div class="flex gap-2 h-[42px]"> <button type="submit" class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-bold transition flex items-center justify-center gap-2 shadow-sm">
                            <i class="fas fa-filter"></i> فیلتر
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="flex-1 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 rounded-lg text-sm font-bold transition flex items-center justify-center gap-2 border border-gray-200 dark:border-slate-600">
                            <i class="fas fa-times"></i> حذف
                        </a>
                    </div>
                </div>
            </form>

            {{-- USERS TABLE SECTION --}}
            <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        
                        <thead class="bg-gray-50 dark:bg-slate-900/50 text-gray-500 dark:text-gray-400 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">نام و نام خانوادگی</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">نام کاربری</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">شماره تماس</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">واحد سازمانی</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">نقش</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">تاریخ عضویت</th>
                                <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-center">عملیات</th>
                            </tr>
                        </thead>
                        
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700 text-sm">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                                    
                                    <td class="px-6 py-4 text-center font-bold text-gray-900 dark:text-white">
                                        {{ $user->name }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center text-gray-700 dark:text-gray-300 font-medium">
                                        {{ $user->username }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-400 dir-ltr font-mono text-xs">
                                        {{ $user->phone ?? '---' }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg text-xs font-medium border border-gray-200 dark:border-slate-600">
                                            {{ $user->department ?? '---' }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        @if($user->role === 'admin')
                                            <span class="px-3 py-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800 rounded-full text-xs font-bold">مدیر</span>
                                        @elseif($user->role === 'support')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800 rounded-full text-xs font-bold">پشتیبان</span>
                                        @else
                                            <span class="px-3 py-1 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800 rounded-full text-xs font-bold">کاربر</span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 dir-ltr text-xs">
                                        {{ $user->created_at->diffForHumans() }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-500 hover:text-blue-700 dark:hover:text-blue-400 transition transform hover:scale-110" title="ویرایش">
                                                <i class="fas fa-edit text-lg"></i>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('آیا از حذف این کاربر اطمینان دارید؟');">
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
                                    <td colspan="7" class="text-center py-12 text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-users-slash text-4xl mb-3 opacity-30"></i>
                                            <span>هیچ کاربری یافت نشد.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if(method_exists($users, 'links'))
                    <div class="p-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                        {{ $users->links() }}
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</x-app-layout>