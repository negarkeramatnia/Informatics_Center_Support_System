<div class="space-y-6">

    {{-- Section 1: Basic Information --}}
    <div class="p-4 border rounded-lg bg-gray-50/50">
        <h3 class="font-semibold text-lg mb-4 text-gray-800">اطلاعات عمومی دستگاه</h3>
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block font-medium text-sm text-gray-700">نام دستگاه (مثال: Laptop Dell XPS 15)</label>
                    <input id="name" class="form-input-custom mt-1 block w-full" type="text" name="name" value="{{ old('name', $asset->name ?? '') }}" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div>
                    <label for="serial_number" class="block font-medium text-sm text-gray-700">شماره سریال</label>
                    <input id="serial_number" class="form-input-custom mt-1 block w-full ltr" type="text" name="serial_number" value="{{ old('serial_number', $asset->serial_number ?? '') }}" required />
                    <x-input-error :messages="$errors->get('serial_number')" class="mt-2" />
                </div>
            </div>
            <div>
                <label for="description" class="block font-medium text-sm text-gray-700">توضیحات (اختیاری)</label>
                <textarea id="description" name="description" rows="3" class="form-input-custom mt-1 block w-full">{{ old('description', $asset->description ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
        </div>
    </div>

    {{-- Section 2: Status and Assignment --}}
    <div class="p-4 border rounded-lg bg-gray-50/50">
        <h3 class="font-semibold text-lg mb-4 text-gray-800">وضعیت و تخصیص</h3>
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="status" class="block font-medium text-sm text-gray-700">وضعیت</label>
                    <select id="status" name="status" class="form-input-custom mt-1 block w-full">
                        <option value="available" @selected(old('status', $asset->status ?? '') == 'available')>موجود</option>
                        <option value="assigned" @selected(old('status', $asset->status ?? '') == 'assigned')>اختصاص یافته</option>
                        <option value="under_maintenance" @selected(old('status', $asset->status ?? '') == 'under_maintenance')>در حال تعمیر</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
                <div>
                    <label for="assigned_to" class="block font-medium text-sm text-gray-700">اختصاص به کاربر</label>
                    <select id="assigned_to" name="assigned_to" class="form-input-custom mt-1 block w-full">
                        <option value="">-- هیچکس --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected(old('assigned_to', $asset->assigned_to ?? '') == $user->id)>{{ $user->name }} ({{ $user->username }})</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">برای اختصاص دادن، وضعیت باید "اختصاص یافته" باشد.</p>
                    <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
                </div>
            </div>
             <div>
                <label for="location" class="block font-medium text-sm text-gray-700">مکان (اختیاری)</label>
                <input id="location" class="form-input-custom mt-1 block w-full" type="text" name="location" value="{{ old('location', $asset->location ?? '') }}" />
                <x-input-error :messages="$errors->get('location')" class="mt-2" />
            </div>
        </div>
    </div>

    {{-- Section 3: Dates --}}
    <div class="p-4 border rounded-lg bg-gray-50/50">
        <h3 class="font-semibold text-lg mb-4 text-gray-800">تاریخ‌ها</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="purchase_date" class="block font-medium text-sm text-gray-700">تاریخ خرید (اختیاری)</label>
                <input id="purchase_date" class="form-input-custom mt-1 block w-full" type="date" name="purchase_date" value="{{ old('purchase_date', isset($asset) ? ($asset->purchase_date ? \Carbon\Carbon::parse($asset->purchase_date)->format('Y-m-d') : '') : '') }}" />
                <x-input-error :messages="$errors->get('purchase_date')" class="mt-2" />
            </div>
            <div>
                <label for="warranty_expiration" class="block font-medium text-sm text-gray-700">انقضای گارانتی (اختیاری)</label>
                <input id="warranty_expiration" class="form-input-custom mt-1 block w-full" type="date" name="warranty_expiration" value="{{ old('warranty_expiration', isset($asset) ? ($asset->warranty_expiration ? \Carbon\Carbon::parse($asset->warranty_expiration)->format('Y-m-d') : '') : '') }}" />
                <x-input-error :messages="$errors->get('warranty_expiration')" class="mt-2" />
            </div>
        </div>
    </div>
</div>

<div class="flex items-center justify-end mt-8 pt-5 border-t border-gray-200">
    <a href="{{ route('admin.assets.index') }}" class="btn-secondary-custom ml-4">انصراف</a>
    <button type="submit" class="btn-primary-custom">ذخیره تغییرات</button>
</div>