<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between" style="display: flex; justify-content: space-between;">
            {{-- Group for Title and Subtitle --}}
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $ticket->title }}</h2>
                <p class="text-sm text-gray-500 mt-1">ایجاد شده توسط {{ $ticket->user->name }} در {{ $ticket->jalali_created_at }}</p>
            </div>

            {{-- Group for All Action Buttons --}}
            <div class="flex items-center gap-x-4 justify-start">
                <a href="{{ route('dashboard') }}" class="btn-secondary-custom">بازگشت به داشبورد</a>
                @if($ticket->status !== 'completed' && (Auth::id() === $ticket->user_id || Auth::user()->role === 'admin'))
                    <a href="{{ route('tickets.edit', $ticket) }}" class="btn-primary-custom"><i class="fas fa-edit ml-2"></i>ویرایش</a>
                @endif
                @if($ticket->status !== 'completed')
                    @if(Auth::id() === $ticket->user_id)
                        <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-ticket-completion')" class="btn-success-custom">
                            <i class="fas fa-check-circle ml-2"></i>تکمیل و امتیازدهی
                        </button>
                    @elseif(in_array(Auth::user()->role, ['admin', 'support']))
                        <form action="{{ route('tickets.complete', $ticket) }}" method="POST" onsubmit="return confirm('آیا از تکمیل کردن این درخواست اطمینان دارید؟');">
                            @csrf
                            <button type="submit" class="btn-success-custom">
                                <i class="fas fa-check-circle ml-2"></i>
                                تکمیل کردن درخواست
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </x-slot>

    @pushOnce('styles')
    <style>
        .btn-secondary-custom { background-color: #e5e7eb; color: #374151; padding: 0.5rem 0.9rem; border-radius: 0.5rem; font-weight: 600; transition: background-color 0.2s; border: 1px solid #d1d5db; text-decoration: none; }
        .btn-secondary-custom:hover { background-color: #d1d5db; }
        .btn-success-custom { background-color: #22c55e; color: white; padding: 0.5rem 0.9rem; border-radius: 0.5rem; font-weight: 600; transition: background-color 0.2s; border: none; display: flex; align-items: center; cursor: pointer; }
        .btn-success-custom:hover { background-color: #16a34a; }
        .workflow-step { display: flex; align-items: flex-start; }
        .workflow-step .icon { display: flex; align-items: center; justify-content: center; width: 2.5rem; height: 2.5rem; border-radius: 9999px; }
        .workflow-step .line { flex-grow: 1; width: 2px; margin-right: 1.125rem; }
        .workflow-step.completed .icon { background-color: #22c55e; color: white; }
        .workflow-step.completed .line { background-color: #22c55e; }
        .workflow-step.active .icon { background-color: #3b82f6; color: white; }
        .workflow-step.pending .icon { background-color: #e5e7eb; color: #9ca3af; }
        .workflow-step.pending .line { background-color: #e5e7eb; }
        .message-card { display: flex; align-items: flex-start; }
        .message-card:not(:last-child) { border-bottom: 1px solid #e5e7eb; padding-bottom: 1.5rem; margin-bottom: 1.5rem; }
        .message-author-avatar { width: 3rem; height: 3rem; border-radius: 9999px; object-fit: cover; margin-left: 1rem; }
        .star-rating { display: flex; flex-direction: row-reverse; justify-content: center; }
        .star-rating input { display: none; }
        .star-rating label { font-size: 2.5rem; color: #d1d5db; cursor: pointer; transition: color 0.2s; }
        .star-rating input:checked ~ label, .star-rating label:hover, .star-rating label:hover ~ label { color: #f59e0b; }
    </style>
    @endPushOnce

    <div dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                {{-- Main Content (Left Column) --}}
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-bold text-lg mb-4">شرح درخواست</h3>
                        <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $ticket->description }}</p>
                        {{-- --- RATING FORM (for ticket creator on completed tickets) --- --}}
                        @if($ticket->status === 'completed' && Auth::id() === $ticket->user_id && is_null($ticket->rating))
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <form method="post" action="{{ route('tickets.rate', $ticket) }}" class="text-center">
                                @csrf
                                <i class="fas fa-award text-4xl text-yellow-400 mb-4"></i>
                                <h3 class="font-bold text-lg">امتیاز شما به این پشتیبانی</h3>
                                <p class="mt-1 text-sm text-gray-600">لطفا برای کمک به بهبود خدمات، به این درخواست امتیاز دهید.</p>
                                <div class="my-6 star-rating">
                                    <input type="radio" id="star5" name="rating" value="5" required /><label for="star5" title="عالی">&#9733;</label>
                                    <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="خوب">&#9733;</label>
                                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="متوسط">&#9733;</label>
                                    <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="ضعیف">&#9733;</label>
                                    <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="خیلی ضعیف">&#9733;</label>
                                </div>
                                <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                                
                                <div class="mt-6 flex justify-center">
                                    <button type="submit" class="btn-success-custom">ثبت امتیاز</button>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>

                    {{-- Notes / Messaging Section --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-bold text-lg mb-6">یادداشت‌ها و پیام‌ها</h3>
                        <div class="space-y-6">
                            @forelse($ticket->messages as $message)
                                <div class="message-card">
                                    <img src="{{ $message->user->profile_picture ? asset('storage/' . $message->user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($message->user->name) }}" alt="{{ $message->user->name }}" class="message-author-avatar">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <p class="font-semibold">{{ $message->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ \Morilog\Jalali\Jalalian::fromCarbon($message->created_at)->format('%d %B %Y - H:i') }}</p>
                                        </div>
                                        <p class="mt-2 text-gray-700 whitespace-pre-wrap">{{ $message->message }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-500 py-4">هنوز هیچ پیامی ثبت نشده است.</p>
                            @endforelse
                        </div>

                        {{-- Add New Message Form --}}
                        @if(in_array(Auth::user()->role, ['admin', 'support']) || Auth::id() === $ticket->user_id)
                        <div class="mt-6 pt-6 border-t">
                            <form action="{{ route('tickets.messages.store', $ticket) }}" method="POST">
                                @csrf
                                <label for="body" class="block font-medium text-sm text-gray-700 mb-2">افزودن یادداشت یا پاسخ</label>
                                <textarea name="body" id="body" rows="3" class="form-input-custom w-full" placeholder="پاسخ خود را اینجا بنویسید..." required></textarea>
                                <div class="mt-4 flex justify-end">
                                    <button type="submit" class="btn-primary-custom"><i class="fas fa-paper-plane ml-2"></i>ارسال پاسخ</button>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Sidebar (Right Column) --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Workflow Tracker --}}
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h4 class="font-bold text-lg mb-6">روند انجام درخواست</h4>
                        @php
                            $statuses = ['pending', 'in_progress', 'completed'];
                            $currentStatusIndex = array_search($ticket->status, $statuses);
                        @endphp
                        <div class="space-y-2">
                            <div class="workflow-step {{ $currentStatusIndex >= 0 ? 'completed' : 'pending' }}"><div class="icon"><i class="fas fa-check"></i></div><div class="mr-4"><p class="font-semibold">درخواست ثبت شد</p><p class="text-sm text-gray-500">{{ $ticket->jalali_created_at }}</p></div></div>
                            <div class="h-8 workflow-step {{ $currentStatusIndex >= 1 ? 'completed' : 'pending' }}"><div class="line"></div></div>
                            <div class="workflow-step {{ $currentStatusIndex >= 1 ? ($currentStatusIndex == 1 ? 'active' : 'completed') : 'pending' }}"><div class="icon"><i class="fas fa-cogs"></i></div><div class="mr-4"><p class="font-semibold">در حال بررسی</p><p class="text-sm text-gray-500">توسط {{ $ticket->assignedTo->name ?? 'پشتیبانی' }}</p></div></div>
                            <div class="h-8 workflow-step {{ $currentStatusIndex >= 2 ? 'completed' : 'pending' }}"><div class="line"></div></div>
                            <div class="workflow-step {{ $currentStatusIndex >= 2 ? 'active' : 'pending' }}"><div class="icon"><i class="fas fa-flag-checkered"></i></div><div class="mr-4"><p class="font-semibold">تکمیل شده</p></div></div>
                        </div>
                    </div>
                    {{-- Assigned Devices Card (Visible to Admin/Support) --}}
                    @if(in_array(Auth::user()->role, ['admin', 'support']))
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h4 class="font-bold text-lg mb-4">دستگاه‌های اختصاص یافته به کاربر</h4>
                        @if($ticket->user->assets->isNotEmpty())
                            <ul class="space-y-2">
                                @foreach($ticket->user->assets as $asset)
                                    <li class="text-sm">
                                        <a href="{{ route('admin.assets.edit', $asset) }}" class="text-blue-600 hover:underline flex items-center">
                                            <i class="fas fa-desktop ml-2"></i>
                                            <span>{{ $asset->name }} ({{ $asset->serial_number }})</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-500">هیچ دستگاهی به این کاربر اختصاص داده نشده است.</p>
                        @endif
                    </div>
                    @endif

                    {{-- User Information Card --}}     
                    {{-- Details Card --}}
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h4 class="font-bold text-lg mb-4">جزئیات</h4>
                        <dl>
                            <div class="flex justify-between py-2 border-b">
                                <dt class="text-gray-600">وضعیت:</dt>
                                <dd><span class="status-badge status-{{ $ticket->status }}">{{ __($ticket->status) }}</span></dd>
                            </div>
                            <div class="flex justify-between py-2 border-b">
                                <dt class="text-gray-600">اولویت:</dt>
                                <dd><span class="priority-badge priority-{{ $ticket->priority }}">{{ __($ticket->priority) }}</span></dd>
                            </div>
                            <div class="flex justify-between pt-2">
                                <dt class="text-gray-600">ارجاع به:</dt>
                                <dd class="font-medium">{{ $ticket->assignedTo->name ?? '---' }}</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Assignment Card --}}
                    @if(Auth::user()->role === 'admin')
                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
                            <h4 class="font-bold text-lg mb-4">ارجاع درخواست</h4>
                            <form action="{{ route('tickets.assign', $ticket) }}" method="POST">
                                @csrf
                                <div>
                                    <label for="assigned_to" class="block font-medium text-sm text-gray-700">ارجاع به کارشناس:</label>
                                    <select id="assigned_to" name="assigned_to" class="form-input-custom mt-1 block w-full">
                                        <option value="">-- انتخاب کارشناس --</option>
                                        @foreach($supportUsers as $supportUser)
                                            <option value="{{ $supportUser->id }}" @selected($ticket->assigned_to == $supportUser->id)>{{ $supportUser->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-4"><button type="submit" class="btn-primary-custom w-full flex items-center justify-center"><i class="fas fa-user-check mr-2"></i>ذخیره ارجاع</button></div>
                            </form>
                        </div>
                    @endif

                    {{-- Display Rating if Completed --}}
                    @if($ticket->status === 'completed' && $ticket->rating)
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">
                        <h4 class="font-bold text-lg mb-2">امتیاز ثبت شده</h4>
                        <div class="text-3xl text-yellow-400">
                            @for ($i = 0; $i < $ticket->rating; $i++) &#9733; @endfor
                            @for ($i = $ticket->rating; $i < 5; $i++) <span class="text-gray-300">&#9733;</span> @endfor
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- RATING MODAL (Only used by the ticket creator) --}}
    <x-modal name="confirm-ticket-completion" focusable>
        <form method="post" action="{{ route('tickets.complete', $ticket) }}" class="p-6 text-center">
            @csrf
            <i class="fas fa-award text-4xl text-yellow-400 mb-4"></i>
            <h2 class="text-lg font-medium text-gray-900">امتیاز شما به این پشتیبانی</h2>
            <p class="mt-1 text-sm text-gray-600">لطفا برای کمک به بهبود خدمات، به این درخواست امتیاز دهید.</p>
            <div class="my-6 star-rating">
                <input type="radio" id="star5" name="rating" value="5" required /><label for="star5" title="عالی">&#9733;</label>
                <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="خوب">&#9733;</label>
                <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="متوسط">&#9733;</label>
                <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="ضعیف">&#9733;</label>
                <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="خیلی ضعیف">&#9733;</label>
            </div>
            <x-input-error :messages="$errors->get('rating')" class="mt-2" />
            <div class="mt-6 flex justify-center gap-x-4">
                <x-secondary-button x-on:click="$dispatch('close')">انصراف</x-secondary-button>
                <button type="submit" class="btn-success-custom">ثبت امتیاز و تکمیل درخواست</button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
