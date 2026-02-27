<div class="space-y-6">

    {{-- Section 1: Basic Information --}}
    <div class="bg-white dark:bg-slate-800 shadow-sm rounded-3xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
        <div class="px-8 py-5 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50">
            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100">مشخصات فیزیکی دستگاه</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">نام دستگاه، شماره سریال و اطلاعات پایه را وارد کنید.</p>
        </div>
        <div class="px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">نام دستگاه</label>
                    <input id="name" class="form-input-custom mt-1 block w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-900 dark:text-gray-100" type="text" name="name"
                        value="{{ old('name', $asset->name ?? '') }}" required placeholder="مثال: Laptop Dell Latitude 5520" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div>
                    <label for="serial_number" class="block font-medium text-sm text-gray-700 dark:text-gray-300">شماره سریال / اموال</label>
                    <input id="serial_number" class="form-input-custom mt-1 block w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-900 dark:text-gray-100 ltr" type="text" name="serial_number"
                        value="{{ old('serial_number', $asset->serial_number ?? '') }}" required />
                    <x-input-error :messages="$errors->get('serial_number')" class="mt-2" />
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="ip_address" class="block font-medium text-sm text-gray-700 dark:text-gray-300">آدرس IP (اختیاری)</label>
                    <input id="ip_address" class="form-input-custom mt-1 block w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-900 dark:text-gray-100 ltr" type="text" name="ip_address"
                        value="{{ old('ip_address', $asset->ip_address ?? '') }}" placeholder="192.168.1.100" />
                    <x-input-error :messages="$errors->get('ip_address')" class="mt-2" />
                </div>
                <div>
                    <label for="description" class="block font-medium text-sm text-gray-700 dark:text-gray-300">توضیحات تکمیلی</label>
                    <textarea id="description" name="description" rows="2" class="form-input-custom mt-1 block w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-900 dark:text-gray-100">{{ old('description', $asset->description ?? '') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
            </div>
        </div>
    </div>

    {{-- Section 2: Assignment & Location --}}
    <div class="bg-white dark:bg-slate-800 shadow-sm rounded-3xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
        <div class="px-8 py-5 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50">
            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100">وضعیت و محل استقرار</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">وضعیت دستگاه و کاربری فعلی آن را مشخص کنید.</p>
        </div>
        <div class="px-8 py-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="status" class="block font-medium text-sm text-gray-700 dark:text-gray-300">وضعیت فعلی</label>
                <select id="status" name="status"
                    class="form-input-custom mt-1 block w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-900 dark:text-gray-100" required>
                    <option value="available" @selected(old('status', $asset->status ?? '') == 'available')>موجود (آزاد)</option>
                    <option value="assigned" @selected(old('status', $asset->status ?? '') == 'assigned')>واگذار شده</option>
                    <option value="under_maintenance" @selected(old('status', $asset->status ?? '') == 'under_maintenance')>در حال تعمیر</option>
                    <option value="decommissioned" @selected(old('status', $asset->status ?? '') == 'decommissioned')>اسقاط شده / خارج از رده</option>
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>
            <div>
                <label for="location" class="block font-medium text-sm text-gray-700 dark:text-gray-300">محل استقرار / واحد</label>
                <select id="location" name="location" class="form-input-custom mt-1 block w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-900 dark:text-gray-100">
                    <option value="">-- انتخاب محل --</option>
                    @php $depts = ['مدیریت', 'فناوری اطلاعات', 'منابع انسانی', 'مالی', 'حراست', 'خدمات مشترکین', 'فنی و مهندسی']; @endphp
                    @foreach($depts as $dept)
                        <option value="{{ $dept }}" @selected(old('location', $asset->location ?? '') == $dept)>{{ $dept }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('location')" class="mt-2" />
            </div>
            <div>
                <label for="assigned_to" class="block font-medium text-sm text-gray-700 dark:text-gray-300">تحویل گیرنده (کاربر)</label>
                <select id="assigned_to" name="assigned_to" class="form-input-custom mt-1 block w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-900 dark:text-gray-100">
                    <option value="">-- آزاد --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" @selected(old('assigned_to', $asset->assigned_to ?? '') == $user->id)>
                            {{ $user->name }} ({{ $user->department ?? 'بدون واحد' }})
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">اگر وضعیت "واگذار شده" است، کاربر را انتخاب کنید.</p>
                <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
            </div>
        </div>
    </div>

    {{-- Section 3: Warranty & Dates --}}
    <div class="bg-white dark:bg-slate-800 shadow-sm rounded-3xl border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
        <div class="px-8 py-5 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50">
            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100">اطلاعات مالی و گارانتی</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">اگر دارید، تاریخ خرید و گارانتی را وارد کنید.</p>
        </div>
        <div class="px-8 py-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="purchase_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">تاریخ خرید</label>
                <input id="purchase_date" class="form-input-custom mt-1 block w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-900 dark:text-gray-100 ltr" type="date" name="purchase_date"
                    value="{{ old('purchase_date', isset($asset) && $asset->purchase_date ? \Carbon\Carbon::parse($asset->purchase_date)->format('Y-m-d') : '') }}" />
            </div>
            <div>
                <label for="warranty_expiration" class="block font-medium text-sm text-gray-700 dark:text-gray-300">تاریخ پایان گارانتی</label>
                <input id="warranty_expiration" class="form-input-custom mt-1 block w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-900 dark:text-gray-100 ltr" type="date" name="warranty_expiration"
                    value="{{ old('warranty_expiration', isset($asset) && $asset->warranty_expiration ? \Carbon\Carbon::parse($asset->warranty_expiration)->format('Y-m-d') : '') }}" />
            </div>
        </div>
    </div>
</div>

<div class="px-8 py-5 border-t border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex flex-col sm:flex-row items-center justify-between gap-4">
    <a href="{{ route('admin.assets.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-bold text-sm px-4 py-2 transition-colors rounded-xl border border-gray-200 dark:border-slate-700">
        انصراف
    </a>
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-black transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2 hover:-translate-y-0.5">
        <i class="fas fa-save"></i> {{ isset($asset) ? 'ذخیره تغییرات' : 'ثبت دستگاه جدید' }}
    </button>
</div>