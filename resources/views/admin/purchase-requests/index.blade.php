<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('درخواست‌های خرید') }}</h2>
            <a href="{{ route('admin.purchase-requests.create') }}" class="btn-primary-custom">
                <i class="fas fa-plus ml-2"></i> ثبت درخواست جدید
            </a>
        </div>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full table-custom">
                    <thead>
                        <tr>
                            <th class="p-4 text-right">عنوان کالا</th>
                            <th class="p-4 text-right">درخواست کننده</th>
                            <th class="p-4 text-right">تعداد</th>
                            <th class="p-4 text-right">وضعیت</th>
                            <th class="p-4 text-right">تاریخ</th>
                            <th class="p-4 text-right">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4 font-bold">{{ $req->item_name }}</td>
                                <td class="p-4">{{ $req->user->name }}</td>
                                <td class="p-4">{{ $req->quantity }}</td>
                                <td class="p-4">
                                    <span class="px-2 py-1 rounded text-xs 
                                        {{ $req->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $req->status == 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $req->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $req->status == 'purchased' ? 'bg-blue-100 text-blue-800' : '' }}">
                                        {{ __($req->status) }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-gray-500">{{ $req->created_at->format('Y/m/d') }}</td>
                                <td class="p-4">
                                    <a href="{{ route('admin.purchase-requests.show', $req) }}" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-print"></i> مشاهده و چاپ
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="p-8 text-center text-gray-500">موردی یافت نشد.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $requests->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>