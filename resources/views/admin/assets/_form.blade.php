<div class="space-y-6">

    {{-- Section 1: Basic Information --}}
    <div class="p-4 border rounded-lg bg-gray-50/50">
        <h3 class="font-semibold text-lg mb-4 text-gray-800">مشخصات فیزیکی دستگاه</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <div>
                <label for="name" class="block font-medium text-sm text-gray-700">نام دستگاه</label>
                <input id="name" class="form-input-custom mt-1 block w-full" type="text" name="name" 
                       value="{{ old('name', $asset->name ?? '') }}" required placeholder="مثال: Laptop Dell Latitude 5520" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <label for="serial_number" class="block font-medium text-sm text-gray-700">شماره سریال / اموال</label>
                <input id="serial_number" class="form-input-custom mt-1 block w-full ltr" type="text" name="serial_number" 
                       value="{{ old('serial_number', $asset->serial_number ?? '') }}" required />
                <x-input-error :messages="$errors->get('serial_number')" class="mt-2" />
            </div>
        </div>
        
        {{-- IP Address & Description --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="ip_address" class="block font-medium text-sm text-gray-700">آدرس IP (اختیاری)</label>
                <input id="ip_address" class="form-input-custom mt-1 block w-full ltr" type="text" name="ip_address" 
                       value="{{ old('ip_address', $asset->ip_address ?? '') }}" placeholder="192.168.1.100" />
                <x-input-error :messages="$errors->get('ip_address')" class="mt-2" />
            </div>
            <div>
                <label for="description" class="block font-medium text-sm text-gray-700">توضیحات تکمیلی</label>
                <textarea id="description" name="description" rows="1" class="form-input-custom mt-1 block w-full">{{ old('description', $asset->description ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
        </div>
    </div>

    {{-- Section 2: Assignment & Location --}}
    <div class="p-4 border rounded-lg bg-gray-50/50">
        <h3 class="font-semibold text-lg mb-4 text-gray-800">وضعیت و محل استقرار</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Status --}}
            <div>
                <label for="status" class="block font-medium text-sm text-gray-700">وضعیت فعلی</label>
                <select id="status" name="status" class="form-input-custom mt-1 block w-full" required>
                    <option value="available" @selected(old('status', $asset->status ?? '') == 'available')>موجود (آزاد)</option>
                    <option value="assigned" @selected(old('status', $asset->status ?? '') == 'assigned')>واگذار شده</option>
                    <option value="under_maintenance" @selected(old('status', $asset->status ?? '') == 'under_maintenance')>در حال تعمیر</option>
                    <option value="decommissioned" @selected(old('status', $asset->status ?? '') == 'decommissioned')>اسقاط شده / خارج از رده</option>
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>

            {{-- Location Dropdown --}}
            <div>
                <label for="location" class="block font-medium text-sm text-gray-700">محل استقرار / واحد</label>
                <select id="location" name="location" class="form-input-custom mt-1 block w-full">
                    <option value="">-- انتخاب محل --</option>
                    {{-- Same list as Users --}}
                    @php $depts = ['مدیریت', 'فناوری اطلاعات', 'منابع انسانی', 'مالی', 'حراست', 'خدمات مشترکین', 'فنی و مهندسی']; @endphp
                    @foreach($depts as $dept)
                        <option value="{{ $dept }}" @selected(old('location', $asset->location ?? '') == $dept)>{{ $dept }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('location')" class="mt-2" />
            </div>

            {{-- Assigned To User --}}
            <div>
                <label for="assigned_to" class="block font-medium text-sm text-gray-700">تحویل گیرنده (کاربر)</label>
                <select id="assigned_to" name="assigned_to" class="form-input-custom mt-1 block w-full">
                    <option value="">-- آزاد --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" @selected(old('assigned_to', $asset->assigned_to ?? '') == $user->id)>
                            {{ $user->name }} ({{ $user->department ?? 'بدون واحد' }})
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">اگر وضعیت "واگذار شده" است، کاربر را انتخاب کنید.</p>
                <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
            </div>
        </div>
    </div>

    {{-- Section 3: Warranty & Dates --}}
    <div class="p-4 border rounded-lg bg-gray-50/50">
        <h3 class="font-semibold text-lg mb-4 text-gray-800">اطلاعات مالی و گارانتی</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="purchase_date" class="block font-medium text-sm text-gray-700">تاریخ خرید</label>
                <input id="purchase_date" class="form-input-custom mt-1 block w-full ltr" type="date" name="purchase_date" 
                       value="{{ old('purchase_date', isset($asset) && $asset->purchase_date ? \Carbon\Carbon::parse($asset->purchase_date)->format('Y-m-d') : '') }}" />
            </div>
            <div>
                <label for="warranty_expiration" class="block font-medium text-sm text-gray-700">تاریخ پایان گارانتی</label>
                <input id="warranty_expiration" class="form-input-custom mt-1 block w-full ltr" type="date" name="warranty_expiration" 
                       value="{{ old('warranty_expiration', isset($asset) && $asset->warranty_expiration ? \Carbon\Carbon::parse($asset->warranty_expiration)->format('Y-m-d') : '') }}" />
            </div>
        </div>
    </div>
</div>

<div class="flex items-center justify-end mt-8 pt-5 border-t border-gray-200">
    <a href="{{ route('admin.assets.index') }}" class="btn-secondary-custom ml-4">انصراف</a>
    <button type="submit" class="btn-primary-custom">ذخیره تغییرات</button>
</div>