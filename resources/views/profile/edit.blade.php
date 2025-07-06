<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('پروفایل کاربری') }}
        </h2>
    </x-slot>

    @pushOnce('styles')
    <style>
        /* --- FIX: Forcing green button style --- */
        .btn-primary-custom {
            background-color: #16a34a !important; /* green-600 */
            color: white !important;
            padding: 0.6rem 1.5rem !important;
            border-radius: 0.5rem !important;
            font-weight: 600 !important;
            border: none !important;
        }
        .btn-primary-custom:hover { 
            background-color: #15803d !important; /* green-700 */
        }

        /* --- Styles for Tabs --- */
        .tabs-container {
            display: flex;
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 1.5rem;
        }
        .tab-item {
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            font-weight: 600;
            color: #6b7280;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: color 0.2s, border-color 0.2s;
        }
        .tab-item:hover {
            color: #111827;
        }
        .tab-item.active {
            color: #0284c7; /* Blue Accent for active tab */
            border-color: #0284c7;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
    </style>
    @endPushOnce

    <div class="py-12" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">
                    {{-- Tab Navigation --}}
                    <div class="tabs-container">
                        <div class="tab-item active" data-tab="profileInfo">اطلاعات کاربری</div>
                        <div class="tab-item" data-tab="updatePassword">تغییر رمز عبور</div>
                        <div class="tab-item" data-tab="deleteAccount">حذف حساب</div>
                    </div>

                    {{-- Tab Content --}}
                    <div>
                        <div id="profileInfo" class="tab-content active">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                        <div id="updatePassword" class="tab-content">
                            @include('profile.partials.update-password-form')
                        </div>
                        <div id="deleteAccount" class="tab-content">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @pushOnce('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.tab-item');
            const tabContents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(item => item.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));
                    const tabId = tab.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                    tab.classList.add('active');
                });
            });

            const phoneInput = document.getElementById('phone');
            if(phoneInput) {
                phoneInput.addEventListener('input', function (e) {
                    e.target.value = e.target.value.replace(/[^0-9]/g, '');
                });
            }
        });
    </script>
    @endPushOnce
</x-app-layout>
