<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ویرایش مقاله: ') . $article->title }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- Form points to update route with PUT method --}}
                <form action="{{ route('admin.articles.update', $article->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- Title Input --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 mb-1">عنوان مقاله</label>
                        <input type="text" name="title" value="{{ old('title', $article->title) }}" class="form-input-custom w-full" required>
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        {{-- Category Select --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">دسته‌بندی</label>
                            <select name="category" class="form-input-custom w-full">
                                @foreach(['general' => 'عمومی', 'software' => 'نرم‌افزار', 'hardware' => 'سخت‌افزار', 'network' => 'شبکه', 'security' => 'امنیت'] as $key => $label)
                                    <option value="{{ $key }}" {{ old('category', $article->category) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Published Status Checkbox --}}
                        <div class="flex items-center mt-6">
                            <input type="hidden" name="is_published" value="0"> {{-- Fallback for unchecked --}}
                            <input type="checkbox" name="is_published" value="1" id="is_published" 
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 ml-2"
                                   {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                            <label for="is_published" class="font-medium text-sm text-gray-700 select-none cursor-pointer">
                                انتشار عمومی این مقاله در پایگاه دانش
                            </label>
                        </div>
                    </div>

                    {{-- Content Textarea --}}
                    <div class="mb-6">
                        <label class="block font-medium text-sm text-gray-700 mb-1">محتوای مقاله</label>
                        <textarea name="content" rows="15" class="form-input-custom w-full leading-relaxed" required>{{ old('content', $article->content) }}</textarea>
                        @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-2 border-t pt-4">
                        <a href="{{ route('admin.articles.index') }}" class="btn-secondary-custom py-2 px-4">انصراف</a>
                        <button type="submit" class="btn-primary-custom py-2 px-6">
                            <i class="fas fa-save ml-2"></i> به‌روزرسانی مقاله
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>