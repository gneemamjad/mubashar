<!-- Sidebar -->
<div class="sidebar dark [&.dark]:bg-coal-600 bg-light border-e border-e-gray-200 dark:border-e-coal-100 fixed top-0 bottom-0 z-20 hidden lg:flex flex-col items-stretch shrink-0"
   data-drawer="true" data-drawer-class="drawer drawer-start top-0 bottom-0" data-drawer-enable="true|lg:false"
   id="sidebar">
   <div class="sidebar-header hidden lg:flex items-center relative justify-between px-3 lg:px-6 shrink-0"
      id="sidebar_header">
      <a href="{{ route('admin.dashboard') }}">
      <img class="default-logo min-h-[22px]" src="{{ asset('assets/images/logo.png') }}" />
      <img class="small-logo min-h-[22px]" src="{{ asset('assets/images/logo.png') }}" />
      </a>
      <div data-toggle="body" data-toggle-class="sidebar-collapse" id="sidebar_toggle">
         <div class="hidden [html.dark_&]:block">
            <button
               class="btn btn-icon btn-icon-md size-[30px] rounded-lg border border-gray-300 bg-light text-gray-500 hover:text-gray-700 toggle absolute start-full top-2/4 -translate-x-2/4 -translate-y-2/4 rtl:translate-x-2/4">
            <i class="ki-filled ki-black-left-line toggle-active:rotate-180 transition-all duration-300 rtl:translate rtl:rotate-180 rtl:toggle-active:rotate-0"></i>
            </button>
         </div>
         <div class="[html.dark_&]:hidden light">
            <button
               class="btn btn-icon btn-icon-md size-[30px] rounded-lg border border-gray-200 bg-light text-gray-500 hover:text-gray-700 toggle absolute start-full top-2/4 -translate-x-2/4 -translate-y-2/4 rtl:translate-x-2/4">
            <i class="ki-filled ki-black-left-line toggle-active:rotate-180 transition-all duration-300 rtl:translate rtl:rotate-180 rtl:toggle-active:rotate-0"></i>
            </button>
         </div>
      </div>
   </div>
   <div class="sidebar-content flex grow shrink-0 py-5 pe-2" id="sidebar_content">
      <div class="scrollable-y-hover grow shrink-0 flex ps-2 lg:ps-5 pe-1 lg:pe-3" data-scrollable="true"
         data-scrollable-dependencies="#sidebar_header" data-scrollable-height="auto" data-scrollable-offset="0px"
         data-scrollable-wrappers="#sidebar_content" id="sidebar_scrollable">
         <!-- Sidebar Menu -->
         <div class="menu flex flex-col grow gap-0.5" data-menu="true" data-menu-accordion-expand-all="false"
            id="sidebar_menu">
            @php
            $user = auth()->guard('admin')->user();
            // \Log::info('Sidebar Permissions Check:', [
            // 'admin' => $user ? $user->email : 'No user',
            // 'permissions' => $user ? $user->getAllPermissions()->pluck('name') : [],
            // 'has_view_admins' => $user ? $user->hasPermissionTo('view_admins', 'admin') : false,
            // ]);
            @endphp
                <!-- Access Management -->
                @if(auth()->guard('admin')->user()->hasAnyPermission(['view_roles', 'view_admins'], 'admin'))
                <div class="menu-item {{ request()->routeIs('admin.roles.*') || request()->routeIs('admins.*') ? 'show active' : '' }}" data-menu-item-toggle="accordion" data-menu-item-trigger="click">
                   <div class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]" tabindex="0">
                      <span class="menu-icon items-start text-gray-500 dark:text-gray-400 w-[20px]">
                      <i class="ki-filled ki-security-user text-lg"></i>
                      </span>
                      <span class="menu-title text-sm font-medium text-gray-800 menu-item-active:text-primary menu-link-hover:!text-primary">
                      {{ __('admin.sidebar.access_management') }}
                      </span>
                      <span class="menu-arrow text-gray-400 w-[20px] shrink-0 justify-end ms-1 me-[-10px]">
                      <i class="ki-filled ki-plus text-2xs menu-item-show:hidden"></i>
                      <i class="ki-filled ki-minus text-2xs hidden menu-item-show:inline-flex"></i>
                      </span>
                   </div>
                   <div class="menu-accordion gap-0.5 ps-[10px] relative before:absolute before:start-[20px] before:top-0 before:bottom-0 before:border-s before:border-gray-200">
                      @if(auth()->guard('admin')->user()->hasPermissionTo('view_roles', 'admin'))
                      <div class="menu-item {{ request()->routeIs('admin.roles.*') ? 'show active' : '' }}">
                         <a href="{{ route('admin.roles.index') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                         <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                         <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                         {{ __('admin.sidebar.roles') }}
                         </span>
                         </a>
                      </div>
                      @endif
                      @if(auth()->guard('admin')->user()->hasPermissionTo('view_admins', 'admin'))
                      <div class="menu-item {{ request()->routeIs('admins.*') ? 'show active' : '' }}">
                         <a href="{{ route('admins.index') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('admins.*') ? 'active' : '' }}">
                         <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                         <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                         {{ __('admin.adminsT') }}
                         </span>
                         </a>
                      </div>
                      @endif
                   </div>
                </div>
                @endif

            <!-- ADs Management -->
            @if(auth()->guard('admin')->user()->hasAnyPermission(['view_ads'], 'admin'))
            <div class="menu-item {{ request()->routeIs('admin.ads.*') || request()->routeIs('ads.*') ? 'show active' : '' }}" data-menu-item-toggle="accordion" data-menu-item-trigger="click">
               <div class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]" tabindex="0">
                  <span class="menu-icon items-start text-gray-500 dark:text-gray-400 w-[20px]">
                  <i class="ki-filled ki-note-2 text-lg"></i>
                  </span>
                  <span class="menu-title text-sm font-medium text-gray-800 menu-item-active:text-primary menu-link-hover:!text-primary">
                  {{ __('admin.sidebar.ads_management') }}
                  </span>
                  <span class="menu-arrow text-gray-400 w-[20px] shrink-0 justify-end ms-1 me-[-10px]">
                  <i class="ki-filled ki-plus text-2xs menu-item-show:hidden"></i>
                  <i class="ki-filled ki-minus text-2xs hidden menu-item-show:inline-flex"></i>
                  </span>
               </div>
               <div class="menu-accordion gap-0.5 ps-[10px] relative before:absolute before:start-[20px] before:top-0 before:bottom-0 before:border-s before:border-gray-200">
                  <div class="menu-item {{ request()->routeIs('admin.ads.index') ? 'show active' : '' }}">
                     <a href="{{ route('admin.ads.index') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('admin.ads.index') ? 'active' : '' }}">
                     <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                     <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                     {{ __('admin.sidebar.ads') }}
                     </span>
                     </a>
                  </div>
                  <div class="menu-item {{ request()->routeIs('admin.ads.pending') ? 'show active' : '' }}">
                     <a href="{{ route('admin.ads.pending') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('admin.ads.pending') ? 'active' : '' }}">
                     <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                     <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                     {{ __('admin.sidebar.pending_ads') }}
                     </span>
                     </a>
                  </div>
                  <div class="menu-item {{ request()->routeIs('admin.ads.reviews') ? 'show active' : '' }}">
                    <a href="{{ route('admin.ads.reviews') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('admin.ads.pending') ? 'active' : '' }}">
                    <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                    <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                    {{ __('admin.sidebar.ads_reviews') }}
                    </span>
                    </a>
                 </div>

               </div>
            </div>
            <div class="menu-item {{ request()->routeIs('admin.reels.*') || request()->routeIs('reels.*') ? 'show active' : '' }}" data-menu-item-toggle="accordion" data-menu-item-trigger="click">
               <div class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]" tabindex="0">
                  <span class="menu-icon items-start text-gray-500 dark:text-gray-400 w-[20px]">
                  <i class="ki-filled ki-note-2 text-lg"></i>
                  </span>
                  <span class="menu-title text-sm font-medium text-gray-800 menu-item-active:text-primary menu-link-hover:!text-primary">
                  {{ __('admin.sidebar.reels_management') }}
                  </span>
                  <span class="menu-arrow text-gray-400 w-[20px] shrink-0 justify-end ms-1 me-[-10px]">
                  <i class="ki-filled ki-plus text-2xs menu-item-show:hidden"></i>
                  <i class="ki-filled ki-minus text-2xs hidden menu-item-show:inline-flex"></i>
                  </span>
               </div>
               <div class="menu-accordion gap-0.5 ps-[10px] relative before:absolute before:start-[20px] before:top-0 before:bottom-0 before:border-s before:border-gray-200">
                  <div class="menu-item {{ request()->routeIs('admin.reels.index') ? 'show active' : '' }}">
                     <a href="{{ route('admin.reels.index') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('admin.ads.index') ? 'active' : '' }}">
                     <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                     <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                     {{ __('admin.sidebar.reels') }}
                     </span>
                     </a>
                  </div>
                  <div class="menu-item {{ request()->routeIs('admin.reels.pending') ? 'show active' : '' }}">
                     <a href="{{ route('admin.reels.pending') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('admin.ads.pending') ? 'active' : '' }}">
                     <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                     <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                     {{ __('admin.sidebar.pending_reels') }}
                     </span>
                     </a>
                  </div>
               </div>
            </div>
            @endif
            @if(auth()->guard('admin')->user()->hasAnyPermission(['list reports'], 'admin'))
            <div class="menu-item {{ request()->routeIs('admin.reports.*') || request()->routeIs('reports.*') ? 'show active' : '' }}" data-menu-item-toggle="accordion" data-menu-item-trigger="click">
               <div class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]" tabindex="0">
                  <span class="menu-icon items-start text-gray-500 dark:text-gray-400 w-[20px]">
                  <i class="ki-filled ki-note-2 text-lg"></i>
                  </span>
                  <span class="menu-title text-sm font-medium text-gray-800 menu-item-active:text-primary menu-link-hover:!text-primary">
                  {{ __('admin.sidebar.reports_management') }}
                  </span>
                  <span class="menu-arrow text-gray-400 w-[20px] shrink-0 justify-end ms-1 me-[-10px]">
                  <i class="ki-filled ki-plus text-2xs menu-item-show:hidden"></i>
                  <i class="ki-filled ki-minus text-2xs hidden menu-item-show:inline-flex"></i>
                  </span>
               </div>
               <div class="menu-accordion gap-0.5 ps-[10px] relative before:absolute before:start-[20px] before:top-0 before:bottom-0 before:border-s before:border-gray-200">
                  @if(auth()->guard('admin')->user()->hasAnyPermission(['ads reports'], 'admin'))
                  <div class="menu-item {{ request()->routeIs('reports.adsReport') ? 'show active' : '' }}">
                     <a href="{{ route('reports.adsReport') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('admin.ads.index') ? 'active' : '' }}">
                     <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                     <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                     {{ __('admin.sidebar.ads_reports') }}
                     </span>
                     </a>
                  </div>
                  <div class="menu-item {{ request()->routeIs('reports.adCharts') ? 'show active' : '' }}">
                     <a href="{{ route('reports.adCharts') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('reports.adCharts') ? 'active' : '' }}">
                     <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                     <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                     {{ __('admin.sidebar.ads_charts') }}
                     </span>
                     </a>
                  </div>
                  @endif
                  @if(auth()->guard('admin')->user()->hasAnyPermission(['user reports'], 'admin'))
                  <div class="menu-item {{ request()->routeIs('reports.usersReport') ? 'show active' : '' }}">
                     <a href="{{ route('reports.usersReport') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('admin.ads.index') ? 'active' : '' }}">
                     <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                     <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                     {{ __('admin.sidebar.users_reports') }}
                     </span>
                     </a>
                  </div>
                  @endif
                  @if(auth()->guard('admin')->user()->hasAnyPermission(['finicial reports'], 'admin'))
                  <div class="menu-item {{ request()->routeIs('reports.finicialReport') ? 'show active' : '' }}">
                     <a href="{{ route('reports.finicialReport') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('admin.ads.index') ? 'active' : '' }}">
                     <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                     <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                     {{ __('admin.sidebar.financial_reports') }}
                     </span>
                     </a>
                  </div>
                  @endif
               </div>
            </div>
            @endif
            <!-- Categories Management -->
            @if(auth()->guard('admin')->user()->hasAnyPermission(['view_categories'], 'admin'))
            <div class="menu-item {{ request()->routeIs('admin.categories.*') || request()->routeIs('admin.attributes.*') ? 'show active' : '' }}" data-menu-item-toggle="accordion" data-menu-item-trigger="click">
               <div class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]" tabindex="0">
                  <span class="menu-icon items-start text-gray-500 dark:text-gray-400 w-[20px]">
                  <i class="ki-filled ki-element-11 text-lg"></i>
                  </span>
                  <span class="menu-title text-sm font-medium text-gray-800 menu-item-active:text-primary menu-link-hover:!text-primary">
                  {{ __('admin.sidebar.categories_management') }}
                  </span>
                  <span class="menu-arrow text-gray-400 w-[20px] shrink-0 justify-end ms-1 me-[-10px]">
                  <i class="ki-filled ki-plus text-2xs menu-item-show:hidden"></i>
                  <i class="ki-filled ki-minus text-2xs hidden menu-item-show:inline-flex"></i>
                  </span>
               </div>
               <div class="menu-accordion gap-0.5 ps-[10px] relative before:absolute before:start-[20px] before:top-0 before:bottom-0 before:border-s before:border-gray-200">
                  <div class="menu-item {{ request()->routeIs('admin.categories.*') ? 'show active' : '' }}">
                     <a href="{{ route('admin.categories.index') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                     <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                     <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                     {{ __('admin.sidebar.categories') }}
                     </span>
                     </a>
                  </div>
                  <div class="menu-item {{ request()->routeIs('admin.attributes.*') ? 'show active' : '' }}">
                     <a href="{{ route('admin.attributes.index') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('admin.attributes.*') ? 'active' : '' }}">
                     <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                     <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                     {{ __('admin.sidebar.attributes') }}
                     </span>
                     </a>
                  </div>
               </div>
            </div>
            @endif

            <!-- Users Management -->
            @if(auth()->guard('admin')->user()->hasPermissionTo('view_users', 'admin'))
            <div class="menu-item {{ request()->routeIs('admin.users.*') ? 'show active' : '' }}" data-menu-item-toggle="accordion" data-menu-item-trigger="click">
               <div class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]" tabindex="0">
                  <span class="menu-icon items-start text-gray-500 dark:text-gray-400 w-[20px]">
                  <i class="ki-filled ki-users text-lg"></i>
                  </span>
                  <span class="menu-title text-sm font-medium text-gray-800 menu-item-active:text-primary menu-link-hover:!text-primary">
                  {{ __('admin.sidebar.users_management') }}
                  </span>
                  <span class="menu-arrow text-gray-400 w-[20px] shrink-0 justify-end ms-1 me-[-10px]">
                  <i class="ki-filled ki-plus text-2xs menu-item-show:hidden"></i>
                  <i class="ki-filled ki-minus text-2xs hidden menu-item-show:inline-flex"></i>
                  </span>
               </div>
               <div class="menu-accordion gap-0.5 ps-[10px] relative before:absolute before:start-[20px] before:top-0 before:bottom-0 before:border-s before:border-gray-200">
                  <div class="menu-item {{ request()->routeIs('admin.users.*') ? 'show active' : '' }}">
                     <a href="{{ route('admin.users.index') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                     <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                     <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                     {{ __('admin.sidebar.users') }}
                     </span>
                     </a>
                  </div>
               </div>
            </div>
            @endif
            @if(auth()->guard('admin')->user()->hasAnyPermission(['list plans'], 'admin'))
            <!-- Plans Management -->
            <div class="menu-item {{ request()->routeIs('plans.*') ? 'show active' : '' }}" data-menu-item-toggle="accordion" data-menu-item-trigger="click">
               <div class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]" tabindex="0">
                  <span class="menu-icon items-start text-gray-500 dark:text-gray-400 w-[20px]">
                  <i class="ki-filled ki-tag text-lg"></i>
                  </span>
                  <span class="menu-title text-sm font-medium text-gray-800 menu-item-active:text-primary menu-link-hover:!text-primary">
                  {{ __('admin.sidebar.plans_management') }}
                  </span>
                  <span class="menu-arrow text-gray-400 w-[20px] shrink-0 justify-end ms-1 me-[-10px]">
                  <i class="ki-filled ki-plus text-2xs menu-item-show:hidden"></i>
                  <i class="ki-filled ki-minus text-2xs hidden menu-item-show:inline-flex"></i>
                  </span>
               </div>
               <div class="menu-accordion gap-0.5 ps-[10px] relative before:absolute before:start-[20px] before:top-0 before:bottom-0 before:border-s before:border-gray-200">
                  <!-- List Plans -->
                  <div class="menu-item {{ request()->routeIs('plans.index') ? 'show active' : '' }}">
                     <a href="{{ route('plans.index') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('plans.index') ? 'active' : '' }}">
                     <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                     <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                     {{ __('admin.sidebar.plans') }}
                     </span>
                     </a>
                  </div>
                  @if(auth()->guard('admin')->user()->hasAnyPermission(['add plans'], 'admin'))
                  <!-- Create Plan -->
                  <div class="menu-item {{ request()->routeIs('plans.create') ? 'show active' : '' }}">
                     <a href="{{ route('plans.create') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('plans.create') ? 'active' : '' }}">
                     <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                     <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                     {{ __('admin.sidebar.create_plan') }}
                     </span>
                     </a>
                  </div>
                  @endif
               </div>
            </div>
            @endif
            <!-- Notifications Management -->
            @if(auth()->guard('admin')->user()->hasAnyPermission(['list notifications'], 'admin'))
            <div class="menu-item {{ request()->routeIs('admin.notifications.*') ? 'show active' : '' }}" data-menu-item-toggle="accordion" data-menu-item-trigger="click">
               <div class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]" tabindex="0">
                  <span class="menu-icon items-start text-gray-500 dark:text-gray-400 w-[20px]">
                  <i class="ki-filled ki-notification text-lg"></i>
                  </span>
                  <span class="menu-title text-sm font-medium text-gray-800 menu-item-active:text-primary menu-link-hover:!text-primary">
                  {{ __('admin.sidebar.notifications_management') }}
                  </span>
                  <span class="menu-arrow text-gray-400 w-[20px] shrink-0 justify-end ms-1 me-[-10px]">
                  <i class="ki-filled ki-plus text-2xs menu-item-show:hidden"></i>
                  <i class="ki-filled ki-minus text-2xs hidden menu-item-show:inline-flex"></i>
                  </span>
               </div>
               <div class="menu-accordion gap-0.5 ps-[10px] relative before:absolute before:start-[20px] before:top-0 before:bottom-0 before:border-s before:border-gray-200">
                  <!-- List Notifications -->
                  <div class="menu-item {{ request()->routeIs('admin.notifications.index') ? 'show active' : '' }}">
                     <a href="{{ route('admin.notifications.index') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('admin.notifications.index') ? 'active' : '' }}">
                     <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                     <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                     {{ __('admin.sidebar.all_notifications') }}
                     </span>
                     </a>
                  </div>
                  <!-- Create Notification -->
                  @if(auth()->guard('admin')->user()->hasAnyPermission(['send notifications'], 'admin'))
                  <div class="menu-item {{ request()->routeIs('admin.notifications.create') ? 'show active' : '' }}">
                     <a href="{{ route('admin.notifications.create') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('admin.notifications.create') ? 'active' : '' }}">
                     <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                     <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                     {{ __('admin.sidebar.new_notification') }}
                     </span>
                     </a>
                  </div>
                  @endif
               </div>
            </div>
            @endif


              <!-- Cities Management -->
              @if(auth()->guard('admin')->user()->hasAnyPermission(['list cities','list areas'], 'admin'))
              <div class="menu-item {{ request()->routeIs('admin.cities.*') || request()->routeIs('admin.areas.*') ? 'show active' : '' }}" data-menu-item-toggle="accordion" data-menu-item-trigger="click">
                 <div class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]" tabindex="0">
                    <span class="menu-icon items-start text-gray-500 dark:text-gray-400 w-[20px]">
                    <i class="ki-filled ki-map text-lg"></i>
                    </span>
                    <span class="menu-title text-sm font-medium text-gray-800 menu-item-active:text-primary menu-link-hover:!text-primary">
                     {{ __('admin.sidebar.cities_areas_management') }}
                    </span>
                    <span class="menu-arrow text-gray-400 w-[20px] shrink-0 justify-end ms-1 me-[-10px]">
                    <i class="ki-filled ki-plus text-2xs menu-item-show:hidden"></i>
                    <i class="ki-filled ki-minus text-2xs hidden menu-item-show:inline-flex"></i>
                    </span>
                 </div>
                 <div class="menu-accordion gap-0.5 ps-[10px] relative before:absolute before:start-[20px] before:top-0 before:bottom-0 before:border-s before:border-gray-200">
                    <!-- List Notifications -->
                    @if(auth()->guard('admin')->user()->hasAnyPermission(['list cities'], 'admin'))

                    <div class="menu-item {{ request()->routeIs('admin.cities.index') ? 'show active' : '' }}">
                       <a href="{{ route('admin.cities.index') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('admin.notifications.index') ? 'active' : '' }}">
                       <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                       <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                        {{ __('admin.sidebar.cities') }}
                       </span>
                       </a>
                    </div>
                    @endif
                    @if(auth()->guard('admin')->user()->hasAnyPermission(['list areas'], 'admin'))

                    <div class="menu-item {{ request()->routeIs('admin.areas.index') ? 'show active' : '' }}">
                     <a href="{{ route('admin.areas.index') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('admin.notifications.index') ? 'active' : '' }}">
                     <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                     <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                      {{ __('admin.sidebar.areas') }}
                     </span>
                     </a>
                    </div>
                    @endif
                 </div>
              </div>
              @endif

                <!-- Currencies Management -->
                @if(auth()->guard('admin')->user()->hasAnyPermission(['list currencies'], 'admin'))
                <div class="menu-item {{ request()->routeIs('admin.currencies.*') ? 'show active' : '' }}" data-menu-item-toggle="accordion" data-menu-item-trigger="click">
                   <div class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]" tabindex="0">
                      <span class="menu-icon items-start text-gray-500 dark:text-gray-400 w-[20px]">
                      <i class="ki-filled ki-dollar text-lg"></i>
                      </span>
                      <span class="menu-title text-sm font-medium text-gray-800 menu-item-active:text-primary menu-link-hover:!text-primary">
                      {{ __('admin.sidebar.currencies_management') }}
                      </span>
                      <span class="menu-arrow text-gray-400 w-[20px] shrink-0 justify-end ms-1 me-[-10px]">
                      <i class="ki-filled ki-plus text-2xs menu-item-show:hidden"></i>
                      <i class="ki-filled ki-minus text-2xs hidden menu-item-show:inline-flex"></i>
                      </span>
                   </div>
                   <div class="menu-accordion gap-0.5 ps-[10px] relative before:absolute before:start-[20px] before:top-0 before:bottom-0 before:border-s before:border-gray-200">
                      <!-- List Notifications -->
                      <div class="menu-item {{ request()->routeIs('admin.currencies.index') ? 'show active' : '' }}">
                         <a href="{{ route('admin.currencies.index') }}" class="menu-link border border-transparent grow cursor-pointer gap-[14px] ps-[10px] pe-[10px] py-[8px] {{ request()->routeIs('admin.notifications.index') ? 'active' : '' }}">
                         <span class="menu-bullet flex w-[6px] relative before:absolute before:top-0 before:size-[6px] before:rounded-full rtl:before:translate-x-1/2 before:-translate-y-1/2 menu-item-active:before:bg-primary menu-item-hover:before:bg-primary"></span>
                         <span class="menu-title text-2sm font-normal me-1 text-gray-800 menu-item-active:text-primary menu-item-active:font-medium menu-link-hover:!text-primary">
                          {{ __('admin.sidebar.currencies') }}
                         </span>
                         </a>
                      </div>

                   </div>
                </div>
                @endif
         </div>
         <!-- End of Sidebar Menu -->
      </div>
   </div>
</div>
<!-- End of Sidebar -->
