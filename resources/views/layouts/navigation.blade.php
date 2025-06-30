<div class="p-2">
    <div class="text-xs uppercase text-gray-500 dark:text-gray-400 font-semibold px-4 py-2 sidebar-text">منوی اصلی</div>

    <a href="{{ route('dashboard') }}" class="menu-item flex items-center px-4 py-3 rounded-lg mx-2 mt-1 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/50 dark:text-blue-300' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
        <i class="fas fa-tachometer-alt ml-3"></i>
        <span class="sidebar-text">داشبورد</span>
    </a>

    {{-- Employee Links --}}
    @if(Auth::user()->role === 'user')
        <a href="{{ route('tickets.create') }}" class="menu-item flex items-center px-4 py-3 rounded-lg mx-2 mt-1 {{ request()->routeIs('tickets.create') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/50 dark:text-blue-300' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
            <i class="fas fa-plus-circle ml-3"></i>
            <span class="sidebar-text">درخواست جدید</span>
        </a>
        <a href="{{ route('tickets.my') }}" class="menu-item flex items-center px-4 py-3 rounded-lg mx-2 mt-1 {{ request()->routeIs('tickets.my') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/50 dark:text-blue-300' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
            <i class="fas fa-tasks ml-3"></i>
            <span class="sidebar-text">درخواست‌های من</span>
        </a>
    @endif

    {{-- IT Support & Admin Links --}}
    @if(in_array(Auth::user()->role, ['support', 'admin']))
        <div class="text-xs uppercase text-gray-500 dark:text-gray-400 font-semibold px-4 py-2 mt-4 sidebar-text">مدیریت درخواست‌ها</div>
        <a href="{{ url('/tickets') }}" class="menu-item flex items-center px-4 py-3 rounded-lg mx-2 mt-1 text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
            <i class="fas fa-inbox ml-3"></i>
            <span class="sidebar-text">همه درخواست‌ها</span>
        </a>
    @endif

    {{-- Admin Only Links --}}
    @if(Auth::user()->role === 'admin')
        <div class="text-xs uppercase text-gray-500 dark:text-gray-400 font-semibold px-4 py-2 mt-4 sidebar-text">مدیریت سیستم</div>
        <a href="{{ url('/admin/users') }}" class="menu-item flex items-center px-4 py-3 rounded-lg mx-2 mt-1 text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
            <i class="fas fa-users-cog ml-3"></i>
            <span class="sidebar-text">مدیریت کاربران</span>
        </a>
        <a href="{{ url('/admin/assets') }}" class="menu-item flex items-center px-4 py-3 rounded-lg mx-2 mt-1 text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
            <i class="fas fa-hdd ml-3"></i>
            <span class="sidebar-text">مدیریت قطعات</span>
        </a>
    @endif

    {{-- General Settings Link for all roles --}}
    <div class="text-xs uppercase text-gray-500 dark:text-gray-400 font-semibold px-4 py-2 mt-4 sidebar-text">حساب کاربری</div>
    <a href="{{ route('profile.edit') }}" class="menu-item flex items-center px-4 py-3 rounded-lg mx-2 mt-1 {{ request()->routeIs('profile.edit') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/50 dark:text-blue-300' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
        <i class="fas fa-user-cog ml-3"></i>
        <span class="sidebar-text">پروفایل</span>
    </a>
</div>