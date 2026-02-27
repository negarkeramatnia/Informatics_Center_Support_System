<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center">
                    <i class="fas fa-edit text-blue-600 dark:text-blue-400 text-lg"></i>
                </div>
                <h2 class="font-black text-xl text-gray-900 dark:text-white leading-tight">
                    ویرایش قطعه / دستگاه
                </h2>
            </div>
            <a href="{{ route('admin.assets.index') }}" class="flex items-center gap-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300 px-5 py-2.5 rounded-xl font-bold transition-all shadow-sm">
                بازگشت <i class="fas fa-arrow-left text-sm"></i>
            </a>
        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-6 py-4 rounded-2xl font-bold flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle text-xl"></i> {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.assets.update', $asset) }}" class="bg-white dark:bg-slate-800 shadow-sm rounded-3xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
                @csrf
                @method('PUT')
                @include('admin.assets._form')
            </form>
        </div>
    </div>
</x-app-layout>