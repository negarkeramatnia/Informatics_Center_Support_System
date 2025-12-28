<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('مدیریت کاربران') }}
            </h2>
            <a href="{{ route('admin.users.create') }}" class="btn-primary-custom">
                <i class="fas fa-user-plus ml-2"></i> افزودن کاربر جدید
            </a>
        </div>
    </x-slot>

    @pushOnce('styles')
    <style>
        .table-custom th { background-color: #f9fafb; color: #374151; font-weight: 600; text-align: right; font-size: 0.85rem; padding: 1rem; }
        .table-custom td { padding: 1rem; border-bottom: 1px solid #e5e7eb; color: #374151; vertical-align: middle; }
        .role-badge { padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
        .role-admin { background-color: #fee2e2; color: #991b1b; }
        .role-support { background-color: #fef3c7; color: #92400e; }
        .role-user { background-color: #dbeafe; color: #1e40af; }
        .action-icon { font-size: 1.1rem; padding: 0.5rem; transition: color 0.2s; }
        .action-icon:hover { opacity: 0.8; }
    </style>
    @endPushOnce

<div class="py-6" dir="rtl"> {{-- Changed from py-12 to split the spacing --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- SEARCH & FILTER BAR --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-4">
            <form method="GET" action="{{ route('admin.users.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    {{-- Search Input --}}
                    <div class="md:col-span-1">
                        <label for="search" class="block font-medium text-sm text-gray-700 mb-1">جستجو</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="نام، نام کاربری یا تلفن..." class="form-input-custom w-full text-sm">
                    </div>

                    {{-- Department Filter --}}
                    <div>
                        <label for="department" class="block font-medium text-sm text-gray-700 mb-1">واحد سازمانی</label>
                        <select name="department" class="form-input-custom w-full text-sm">
                            <option value="">همه واحدها</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}" @selected(request('department') == $dept)>{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Role Filter --}}
                    <div>
                        <label for="role" class="block font-medium text-sm text-gray-700 mb-1">نقش</label>
                        <select name="role" class="form-input-custom w-full text-sm">
                            <option value="">همه نقش‌ها</option>
                            <option value="user" @selected(request('role') == 'user')>کاربر عادی</option>
                            <option value="support" @selected(request('role') == 'support')>پشتیبان</option>
                            <option value="admin" @selected(request('role') == 'admin')>مدیر</option>
                        </select>
                    </div>

                    {{-- Filter Button --}}
                    <div class="flex gap-2">
                        <button type="submit" class="btn-primary-custom flex-1 justify-center text-sm py-2">
                            <i class="fas fa-filter ml-1"></i> فیلتر
                        </button>
                        {{-- CLEAR FILTERS BUTTON --}}
                        <a href="{{ route('admin.users.index') }}" class="btn-secondary-custom flex-1 justify-center                    text-sm py-2 text-center" title="پاک کردن فیلترها">
                            <i class="fas fa-times ml-1"></i> حذف
                        </a>
                    </div>
                </div>
            </form>
        </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="w-full table-custom">
                        <thead>
                            <tr>
                                <th>نام و نام خانوادگی</th>
                                <th>نام کاربری</th>
                                <th>شماره تماس</th> {{-- CHANGED: Email to Phone --}}
                                <th>واحد سازمانی</th>
                                <th>نقش</th>
                                <th>تاریخ عضویت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="font-bold">{{ $user->name }}</td>
                                    <td class="font-mono text-sm text-gray-600">{{ $user->username }}</td>
                                    {{-- CHANGED: Showing Phone instead of Email --}}
                                    <td class="font-mono text-sm text-gray-600">{{ $user->phone }}</td>
                                    
                                    <td>
                                        @if($user->department)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $user->department }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs">---</span>
                                        @endif
                                    </td>

                                    <td><span class="role-badge role-{{ $user->role }}">{{ $user->role === 'admin' ? 'مدیر' : ($user->role === 'support' ? 'پشتیبان' : 'کاربر') }}</span></td>
                                    <td class="text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</td>
                                    
                                    {{-- CHANGED: Actions are now Icons --}}
                                    <td class="flex items-center gap-x-2">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 action-icon" title="ویرایش">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('آیا از حذف این کاربر اطمینان دارید؟');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 action-icon" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-8 text-gray-500">هیچ کاربری یافت نشد.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>