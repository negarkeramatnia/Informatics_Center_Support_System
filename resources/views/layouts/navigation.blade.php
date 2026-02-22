<div class="space-y-1">
    {{-- Dashboard --}}
    <a href="{{ route('dashboard') }}" 
       class="group flex items-center px-4 py-3 mx-3 rounded-xl transition-all duration-200 
       {{ request()->routeIs('dashboard') 
          ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' 
          : 'text-slate-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-blue-600 dark:hover:text-blue-400' }}">
        <i class="fas fa-tachometer-alt w-6 text-center transition-transform group-hover:scale-110"></i>
        <span class="sidebar-text font-bold ml-3 mr-3">داشبورد</span>
    </a>

    {{-- Employee Links --}}
    @if(Auth::user()->role === 'user')
        <a href="{{ route('tickets.create') }}" 
           class="group flex items-center px-4 py-3 mx-3 rounded-xl transition-all duration-200 
           {{ request()->routeIs('tickets.create') 
              ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' 
              : 'text-slate-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-blue-600 dark:hover:text-blue-400' }}">
            <i class="fas fa-plus-circle w-6 text-center transition-transform group-hover:scale-110"></i>
            <span class="sidebar-text font-bold ml-3 mr-3">درخواست جدید</span>
        </a>
        <a href="{{ route('tickets.my') }}" 
           class="group flex items-center px-4 py-3 mx-3 rounded-xl transition-all duration-200 
           {{ request()->routeIs('tickets.my') 
              ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' 
              : 'text-slate-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-blue-600 dark:hover:text-blue-400' }}">
            <i class="fas fa-tasks w-6 text-center transition-transform group-hover:scale-110"></i>
            <span class="sidebar-text font-bold ml-3 mr-3">درخواست‌های من</span>
        </a>
    @endif

    {{-- IT Support & Admin Links --}}
    @if(in_array(Auth::user()->role, ['support', 'admin']))
        <a href="{{ route('tickets.index') }}" 
           class="group flex items-center px-4 py-3 mx-3 rounded-xl transition-all duration-200 
           {{ request()->routeIs('tickets.index') 
              ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' 
              : 'text-slate-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-blue-600 dark:hover:text-blue-400' }}">
            <i class="fas fa-inbox w-6 text-center transition-transform group-hover:scale-110"></i>
            <span class="sidebar-text font-bold ml-3 mr-3">همه درخواست‌ها</span>
        </a>
    @endif

    {{-- Admin Only Section --}}
    @if(Auth::user()->role === 'admin')

        <a href="{{ route('admin.users.index') }}" 
           class="group flex items-center px-4 py-3 mx-3 rounded-xl transition-all duration-200 
           {{ request()->routeIs('admin.users.*') 
              ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' 
              : 'text-slate-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-blue-600 dark:hover:text-blue-400' }}">
            <i class="fas fa-users-cog w-6 text-center transition-transform group-hover:scale-110"></i>
            <span class="sidebar-text font-bold ml-3 mr-3">مدیریت کاربران</span>
        </a>

        <a href="{{ route('admin.assets.index') }}" 
           class="group flex items-center px-4 py-3 mx-3 rounded-xl transition-all duration-200 
           {{ request()->routeIs('admin.assets.*') 
              ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' 
              : 'text-slate-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-blue-600 dark:hover:text-blue-400' }}">
            <i class="fas fa-hdd w-6 text-center transition-transform group-hover:scale-110"></i>
            <span class="sidebar-text font-bold ml-3 mr-3">مدیریت قطعات</span>
        </a>

        <a href="{{ route('admin.purchase-requests.index') }}" 
           class="group flex items-center px-4 py-3 mx-3 rounded-xl transition-all duration-200 
           {{ request()->routeIs('admin.purchase-requests.*') 
              ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' 
              : 'text-slate-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-blue-600 dark:hover:text-blue-400' }}">
            <i class="fas fa-shopping-cart w-6 text-center transition-transform group-hover:scale-110"></i>
            <span class="sidebar-text font-bold ml-3 mr-3">درخواست‌های خرید</span>
        </a>

        <a href="{{ route('admin.reports.index') }}" 
           class="group flex items-center px-4 py-3 mx-3 rounded-xl transition-all duration-200 
           {{ request()->routeIs('admin.reports*') 
              ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' 
              : 'text-slate-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-blue-600 dark:hover:text-blue-400' }}">
            <i class="fas fa-chart-pie w-6 text-center transition-transform group-hover:scale-110"></i>
            <span class="sidebar-text font-bold ml-3 mr-3">گزارش‌های عملکرد</span>
        </a>

        <a href="{{ route('admin.articles.index') }}" 
           class="group flex items-center px-4 py-3 mx-3 rounded-xl transition-all duration-200 
           {{ request()->routeIs('admin.articles.*') 
              ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' 
              : 'text-slate-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-blue-600 dark:hover:text-blue-400' }}">
            <i class="fas fa-pen-nib w-6 text-center transition-transform group-hover:scale-110"></i>
            <span class="sidebar-text font-bold ml-3 mr-3">مدیریت مقالات</span>
        </a>
    @endif

    <div class="my-3 mx-4 border-t border-gray-100 dark:border-slate-700/50"></div>

    {{-- Public/General Links --}}
    <a href="{{ route('knowledge-base.index') }}" 
       class="group flex items-center px-4 py-3 mx-3 rounded-xl transition-all duration-200 
       {{ request()->routeIs('knowledge-base.*') 
          ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' 
          : 'text-slate-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-blue-600 dark:hover:text-blue-400' }}">
        <i class="fas fa-book-reader w-6 text-center transition-transform group-hover:scale-110"></i>
        <span class="sidebar-text font-bold ml-3 mr-3">پایگاه دانش (FAQ)</span>
    </a>

    <a href="{{ route('phonebook.index') }}" 
       class="group flex items-center px-4 py-3 mx-3 rounded-xl transition-all duration-200 
       {{ request()->routeIs('phonebook.index') 
          ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' 
          : 'text-slate-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-blue-600 dark:hover:text-blue-400' }}">
        <i class="fas fa-address-book w-6 text-center transition-transform group-hover:scale-110"></i>
        <span class="sidebar-text font-bold ml-3 mr-3">دفترچه تلفن</span>
    </a>
    
    <a href="{{ route('profile.edit') }}" 
       class="group flex items-center px-4 py-3 mx-3 rounded-xl transition-all duration-200 
       {{ request()->routeIs('profile.edit') 
          ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' 
          : 'text-slate-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-blue-600 dark:hover:text-blue-400' }}">
        <i class="fas fa-user-cog w-6 text-center transition-transform group-hover:scale-110"></i>
        <span class="sidebar-text font-bold ml-3 mr-3">پروفایل</span>
    </a>
</div>