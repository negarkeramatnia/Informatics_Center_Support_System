<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('مدیریت کاربران') }}
            </h2>
            <a href="#" class="btn-primary-custom">
                <i class="fas fa-plus mr-2"></i>
                افزودن کاربر جدید
            </a>
        </div>
    </x-slot>

    @pushOnce('styles')
        {{-- You can reuse styles from other pages or add new ones here --}}
    @endPushOnce

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-custom">
                            <thead>
                                <tr>
                                    <th>نام</th>
                                    <th>ایمیل</th>
                                    <th>نقش</th>
                                    <th>تاریخ عضویت</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="font-medium">{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td><span class="priority-badge priority-{{ strtolower($user->role) }}">{{ __($user->role) }}</span></td>
                                        <td class="text-sm text-gray-500">{{ $user->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">ویرایش</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-10 text-gray-500">
                                            هیچ کاربری یافت نشد.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($users->hasPages())
                        <div class="p-4 border-t border-gray-200">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
