<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('مدیریت کاربران') }}
            </h2>
            <a href="{{ route('admin.users.create') }}" class="btn-primary-custom">
                <i class="fas fa-plus mr-2"></i>
                افزودن کاربر جدید
            </a>
        </div>
    </x-slot>

    @pushOnce('styles')
    <style>
        .table-bordered {
            border-collapse: collapse;
        }
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #e5e7eb; /* gray-200 */
            padding: 0.75rem;
        }
        /* FIX: Set all table headers to be center-aligned */
        .table-bordered th {
            text-align: center;
        }
        /* Center all data cells... */
        .table-bordered td {
            text-align: center;
        }
        /* ...except for the first one, which looks better right-aligned */
        .table-bordered td:first-child {
            text-align: right;
        }
    </style>
    @endPushOnce

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full table-custom table-bordered">
                        <thead>
                            <tr class="bg-gray-50">
                                <th>نام</th>
                                <th>شماره تلفن</th>
                                <th>نقش</th>
                                <th>وضعیت</th>
                                <th>تاریخ عضویت</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>
                                        <div class="flex items-center">
                                            <img class="h-10 w-10 rounded-full object-cover ml-4" src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" alt="{{ $user->name }}">
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->username }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->phone }}</td>
                                    <td><span class="priority-badge priority-{{ strtolower($user->role) }}">{{ __($user->role) }}</span></td>
                                    <td>
                                        <div class="flex items-center justify-center">
                                            <div class="h-2.5 w-2.5 rounded-full {{ $user->status === 'active' ? 'bg-green-500' : 'bg-red-500' }} ml-2"></div>
                                            {{ __($user->status) }}
                                        </div>
                                    </td>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="flex items-center justify-center gap-x-4">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="text-gray-400 hover:text-blue-600" title="ویرایش"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('آیا از حذف این کاربر اطمینان دارید؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600" title="حذف"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center py-10 text-gray-500">هیچ کاربری یافت نشد.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($users->hasPages())
                    <div class="p-4 border-t border-gray-200">{{ $users->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>