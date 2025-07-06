<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ویرایش درخواست') }} #{{ $ticket->id }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form method="POST" action="{{ route('tickets.update', $ticket) }}">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            {{-- Title --}}
                            <div>
                                <label for="title" class="block font-medium text-sm text-gray-700">عنوان درخواست</label>
                                <input id="title" class="form-input-custom mt-1 block w-full" type="text" name="title" value="{{ old('title', $ticket->title) }}" required />
                                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Description --}}
                            <div>
                                <label for="description" class="block font-medium text-sm text-gray-700">شرح درخواست</label>
                                <textarea id="description" name="description" rows="6" class="form-input-custom mt-1 block w-full">{{ old('description', $ticket->description) }}</textarea>
                                @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Priority --}}
                            <div>
                                <label for="priority" class="block font-medium text-sm text-gray-700">اولویت</label>
                                <select id="priority" name="priority" class="form-input-custom mt-1 block w-full" required>
                                    <option value="low" @selected(old('priority', $ticket->priority) == 'low')>کم</option>
                                    <option value="medium" @selected(old('priority', $ticket->priority) == 'medium')>متوسط</option>
                                    <option value="high" @selected(old('priority', $ticket->priority) == 'high')>زیاد</option>
                                </select>
                                @error('priority') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 pt-5 border-t border-gray-200">
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn-secondary-custom ml-4">
                                انصراف
                            </a>
                            <button type="submit" class="btn-primary-custom">
                                <i class="fas fa-save ml-2"></i>
                                ذخیره تغییرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
