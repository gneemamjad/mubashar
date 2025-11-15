<header class="header fixed top-0 z-10 start-0 end-0 flex items-stretch shrink-0 bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark]" data-sticky="true" data-sticky-class="shadow-sm" data-sticky-name="header" id="header">
    <!-- Container -->
    <div class="container-fluid flex justify-between items-stretch lg:gap-4" id="header_container">
     <!-- Mobile Logo -->
     <div class="flex gap-1 lg:hidden items-center -ms-1">
      <a class="shrink-0" href="{{ route('admin.dashboard') }}">
       <img class="max-h-[25px] w-full" src="{{ asset('assets/images/logo2.png') }}">
      </a>
      <div class="flex items-center">
       <button class="btn btn-icon btn-light btn-clear btn-sm" data-drawer-toggle="#sidebar">
        <i class="ki-filled ki-menu">
        </i>
       </button>
      </div>
     </div>
     <!-- End of Mobile Logo -->
     <!-- Breadcrumbs -->
     <div class="flex [.header_&]:below-lg:hidden items-center gap-1.25 text-xs lg:text-sm font-medium mb-2.5 lg:mb-0" data-reparent="true" data-reparent-mode="prepend|lg:prepend" data-reparent-target="#content_container|lg:#header_container">
      <span class="text-gray-700">
        {{ $page ?? __('admin.dashboard.title') }}
    </span>
      @if(app()->getLocale() == 'ar')
      <i class="ki-filled ki-left text-gray-500 text-3xs">
      </i>
      @else
      <i class="ki-filled ki-right text-gray-500 text-3xs">
      </i>
      @endif
      <span class="text-gray-700">
       {{ $title ?? __('admin.dashboard.subtitle') }}
      </span>
     </div>
     <!-- End of Breadcrumbs -->
     <!-- Topbar -->
     <div class="flex items-center gap-2 lg:gap-3.5">
      <input type="hidden" value="{{  app()->getLocale() }}" id="lang" />
      <div class="menu" data-menu="true">
       <div class="menu-item" data-menu-item-offset="20px, 10px" data-menu-item-offset-rtl="-20px, 10px" data-menu-item-placement="bottom-end" data-menu-item-placement-rtl="bottom-start" data-menu-item-toggle="dropdown" data-menu-item-trigger="click|lg:click">
        <div class="menu-toggle btn btn-icon rounded-full">
         <img alt="" class="size-9 rounded-full border-2 border-success shrink-0" src="{{ asset('assets/images/logo2.png') }}">
         </img>
        </div>
        <div class="menu-dropdown menu-default light:border-gray-300 w-screen max-w-[250px]">
         <div class="flex items-center justify-between px-5 py-1.5 gap-1.5">
          <div class="flex items-center gap-2">
           <img alt="" class="size-9 rounded-full border-2 border-success" src="{{ asset('assets/images/logo2.png') }}">
            <div class="flex flex-col gap-1.5">
             <span class="text-sm text-gray-800 font-semibold leading-none">
              {{ auth()->guard('admin')->user()->name }}
             </span>
             <a class="text-xs text-gray-600 hover:text-primary font-medium leading-none" href="{{ route('admin.dashboard') }}">
              {{ auth()->guard('admin')->user()->email }}
             </a>
            </div>
           </img>
          </div>
        
         </div>
         <div class="menu-separator">
         </div>
         <div class="flex flex-col">

          <div class="menu-item">
           <a class="menu-link" href="{{ route('admin.profile.show') }}">
            <span class="menu-icon">
             <i class="ki-filled ki-profile-circle">
             </i>
            </span>
            <span class="menu-title">
             {{ __('admin.profile.title') }}
            </span>
           </a>
          </div>
          <div class="menu-item menu-item-dropdown" data-menu-item-offset="-10px, 0" data-menu-item-placement="left-start" data-menu-item-toggle="dropdown" data-menu-item-trigger="click|lg:hover">
            <div class="menu-link">
             <span class="menu-icon">
              <i class="ki-filled ki-icon">
              </i>
             </span>
             <span class="menu-title">
              {{ __('admin.language.title') }}
             </span>
             <div class="flex items-center gap-1.5 rounded-md border border-gray-300 text-gray-600 p-1.5 text-2xs font-medium shrink-0">
              {{ app()->getLocale() == 'ar' ? 'عربي' : 'English' }}
             </div>
            </div>
            <div class="menu-dropdown menu-default light:border-gray-300 w-full max-w-[170px]" style="">
             <div class="menu-item {{ app()->getLocale() == 'en' ? 'active' : '' }}">
              <a class="menu-link h-10" href="{{ route('locale', 'en') }}">
               <span class="menu-icon">
                <!-- <img alt="" class="inline-block size-4 rounded-full" src="assets/media/flags/united-states.svg"> -->
               </span>
               <span class="menu-title">
                English
               </span>
                @if(app()->getLocale() == 'en')
                <span class="menu-badge">
                    <i class="ki-solid ki-check-circle text-success text-base">
                    </i>
                </span>
                @endif
              </a>
             </div>
             <div class="menu-item {{ app()->getLocale() == 'ar' ? 'active' : '' }}">
              <a class="menu-link h-10" href="{{ route('locale', 'ar') }}">
               <span class="menu-icon">
                <!-- <img alt="" class="inline-block size-4 rounded-full" src="assets/media/flags/saudi-arabia.svg"> -->
               </span>
               <span class="menu-title">
                {{ __('admin.language.ar') }}
               </span>
               @if(app()->getLocale() == 'ar')
                <span class="menu-badge">
                    <i class="ki-solid ki-check-circle text-success text-base">
                    </i>
                </span>
                @endif
              </a>
             </div>        
            </div>
           </div>


         </div>
         <div class="menu-separator">
         </div>
         <div class="flex flex-col">
          <div class="menu-item mb-0.5">
           <div class="menu-link">
            <span class="menu-icon">
             <i class="ki-filled ki-moon">
             </i>
            </span>
            <span class="menu-title">
             {{ __('admin.dark_mode.title') }}
            </span>
            <label class="switch switch-sm">
             <input data-theme-state="dark" data-theme-toggle="true" name="check" type="checkbox" value="1">
             </input>
            </label>
           </div>
          </div>
          <div class="menu-item px-4 py-1.5">
           <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="text-xs text-gray-600 hover:text-primary font-medium leading-none" style="border: none; background: none; cursor: pointer;">
                {{ __('admin.logout.title') }}
            </button>
           </form>
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
     <!-- End of Topbar -->
    </div>
    
   </header>
