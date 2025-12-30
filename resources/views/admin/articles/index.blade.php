<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('مدیریت پایگاه دانش') }}</h2>
            <a href="{{ route('admin.articles.create') }}" class="btn-primary-custom"><i class="fas fa-plus mr-2"></i>افزودن مقاله جدید</a>
        </div>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Search Bar --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-4">
                <form method="GET" action="{{ route('admin.articles.index') }}">
                    <div class="flex gap-4 items-end">
                        <div class="flex-grow max-w-md">
                            <label class="block font-medium text-sm text-gray-700 mb-1">جستجو</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="عنوان یا متن مقاله..." class="form-input-custom w-full text-sm">
                        </div>
                        <button type="submit" class="btn-primary-custom py-2 px-6">جستجو</button>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full table-custom">
                    <thead>
                        <tr class="bg-gray-50 text-right">
                            <th class="p-4">عنوان</th>
                            <th class="p-4">دسته‌بندی</th>
                            <th class="p-4">وضعیت</th>
                            <th class="p-4">تاریخ انتشار</th>
                            <th class="p-4">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4 font-bold">{{ $article->title }}</td>
                                <td class="p-4">{{ __($article->category) }}</td>
                                <td class="p-4">
                                    <span class="px-2 py-1 rounded text-xs {{ $article->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $article->is_published ? 'منتشر شده' : 'پیش‌نویس' }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-gray-500">{{ $article->created_at->format('Y/m/d') }}</td>
                                <td class="p-4 flex gap-2">
                                    <a href="{{ route('admin.articles.edit', $article) }}" class="text-blue-600"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('حذف شود؟');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="p-8 text-center text-gray-500">مقاله‌ای یافت نشد.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $articles->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>