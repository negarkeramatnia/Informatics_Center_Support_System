<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ثبت درخواست جدید') }}
        </h2>
    </x-slot>

    @pushOnce('styles')
    <style>
        .form-input-custom {
            background-color: #fff;
            border: 1px solid #d1d5db; /* gray-300 */
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            width: 100%;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-input-custom:focus {
            outline: none;
            border-color: #e91e63; /* Pink */
            box-shadow: 0 0 0 3px rgba(233, 30, 99, 0.2);
        }
        .btn-primary-custom {
            background-color: #e91e63; /* Pink */
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: background-color 0.2s;
            border: none;
        }
        .btn-primary-custom:hover { 
            background-color: #c2185b; /* Darker Pink */
        }
        .btn-secondary-custom {
            background-color: #e5e7eb; /* gray-200 */
            color: #374151; /* gray-700 */
            padding: 0.6rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: background-color 0.2s;
            border: 1px solid #d1d5db;
        }
        .btn-secondary-custom:hover { 
            background-color: #d1d5db; /* gray-300 */
        }
    </style>
    @endPushOnce

    <div class="py-12" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <div class="border-b border-gray-200 pb-5 mb-6">
                        <h3 class="text-xl font-bold text-gray-900">
                            جزئیات درخواست
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                           برای تسریع در روند کار، لطفاً جزئیات درخواست خود را با دقت وارد نمایید.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('tickets.store') }}">
                        @csrf
                        <div class="space-y-6">
                            {{-- Title --}}
                            <div>
                                <label for="title" class="block font-medium text-sm text-gray-700 mb-1">عنوان درخواست</label>
                                <input id="title" class="form-input-custom" type="text" name="title" value="{{ old('title') }}" required autofocus placeholder="مثال: مشکل در اتصال به پرینتر"/>
                                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Description --}}
                            <div>
                                <label for="description" class="block font-medium text-sm text-gray-700 mb-1">شرح درخواست</label>
                                <textarea id="description" name="description" rows="6" class="form-input-custom" placeholder="جزئیات کامل مشکل یا درخواست خود را بنویسید (شامل هرگونه پیغام خطا).">{{ old('description') }}</textarea>
                                @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Priority --}}
                            <div>
                                <label for="priority" class="block font-medium text-sm text-gray-700 mb-1">اولویت</label>
                                <select id="priority" name="priority" class="form-input-custom" required>
                                    <option value="low" @if(old('priority') == 'low') selected @endif>کم</option>
                                    <option value="medium" @if(old('priority', 'medium') == 'medium') selected @endif>متوسط</option>
                                    <option value="high" @if(old('priority') == 'high') selected @endif>زیاد</option>
                                </select>
                                @error('priority') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center justify-end mt-8 pt-5 border-t border-gray-200">
                            <a href="{{ route('dashboard') }}" class="btn-secondary-custom ml-4">
                                انصراف
                            </a>
                            <button type="submit" class="btn-primary-custom">
                                <i class="fas fa-paper-plane mr-2"></i>
                                ثبت درخواست
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>