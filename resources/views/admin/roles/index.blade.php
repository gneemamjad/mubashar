@extends('layouts.main')

@section('content')
<main class="grow content pt-5" id="content" role="content">

  
    <div class="container-fluid">
     <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
      <div class="flex flex-col justify-center gap-2">
       <h1 class="text-xl font-medium leading-none text-gray-900">
        {{ __('admin.roles.title') }}
       </h1>
       <div class="flex items-center gap-2 text-sm font-normal text-gray-700">
        {{ __('admin.roles_overview') }}
       </div>
      </div>
      <div class="flex items-center gap-2.5">
       {{-- <a class="btn btn-sm btn-light" href="{{ route('admin.roles.create') }}">
        New Role
       </a> --}}
      </div>
     </div>
    </div>
    <!-- End of Container -->
    <!-- Container -->
    <div class="container-fluid">
     <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-5 lg:gap-7.5">

        @foreach ($roles as $role)  
        <div class="card flex flex-col gap-5 p-5 lg:p-7.5">
            <div class="flex items-center flex-wrap justify-between gap-1">
             <div class="flex items-center gap-2.5">
              <div class="relative size-[44px] shrink-0">
               <svg class="w-full h-full stroke-primary-clarity fill-primary-light" fill="none" height="48" viewbox="0 0 44 48" width="44" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 2.4641C19.7128 0.320509 24.2872 0.320508 28 2.4641L37.6506 8.0359C41.3634 10.1795 43.6506 14.141 43.6506 
                18.4282V29.5718C43.6506 33.859 41.3634 37.8205 37.6506 39.9641L28 45.5359C24.2872 47.6795 19.7128 47.6795 16 45.5359L6.34937 
                39.9641C2.63655 37.8205 0.349365 33.859 0.349365 29.5718V18.4282C0.349365 14.141 2.63655 10.1795 6.34937 8.0359L16 2.4641Z" fill="">
                </path>
                <path d="M16.25 2.89711C19.8081 0.842838 24.1919 0.842837 27.75 2.89711L37.4006 8.46891C40.9587 10.5232 43.1506 14.3196 43.1506 
                18.4282V29.5718C43.1506 33.6804 40.9587 37.4768 37.4006 39.5311L27.75 45.1029C24.1919 47.1572 19.8081 47.1572 16.25 45.1029L6.59937 
                39.5311C3.04125 37.4768 0.849365 33.6803 0.849365 29.5718V18.4282C0.849365 14.3196 3.04125 10.5232 6.59937 8.46891L16.25 2.89711Z" stroke="">
                </path>
               </svg>
               <div class="absolute leading-none start-2/4 top-2/4 -translate-y-2/4 -translate-x-2/4 rtl:translate-x-2/4">
                <i class="ki-filled ki-setting text-1.5xl text-primary">
                </i>
               </div>
              </div>
              <div class="flex flex-col">
               <a class="text-md font-medium text-gray-900 hover:text-primary-active mb-px">
                {{ $role->name }}
               </a>
               <span class="text-2sm text-gray-700">
                {{ $role->users->count() }} {{ __('admin.adminsT') }}
               </span>
              </div>
             </div>

             <div class="menu inline-flex" data-menu="true">
                <div class="menu-item" data-menu-item-offset="0, 10px" data-menu-item-placement="bottom-end" data-menu-item-placement-rtl="bottom-start" data-menu-item-toggle="dropdown" data-menu-item-trigger="click|lg:click">
            
                 <div class="flex gap-0.5">
                    @if(auth()->guard('admin')->user()->hasAnyPermission(['edit_roles'], 'admin'))

                    <div class="btn btn-sm btn-icon btn-clear btn-light">
                     <a href="{{ route('admin.roles.edit', $role) }}">
                        <i class="ki-filled ki-notepad-edit">
                        </i>
                    </a>
                    </div>
                    @endif
                    @if(auth()->guard('admin')->user()->hasAnyPermission(['delete_roles'], 'admin'))
                    <div class="btn btn-sm btn-icon btn-clear btn-light">
                     <a href="javascript:;" class="delete-role" data-role-id="{{ $role->id }}">
                        <i class="ki-filled ki-trash">
                        </i>
                    </a>
                    </div>
                    @endif
                   </div>
                </div>
               </div>


            </div>

            <div class="flex flex-col gap-2">
                @if($role->permissions->count() > 0)
                <span class="text-sm font-medium text-gray-700">{{ __('admin.roles.permissions') }}</span>
                <div class="flex flex-wrap gap-2">
                    @foreach($role->permissions as $permission)
                        <span class="badge badge-sm badge-light-primary">
                            {{ $permission->name }}
                        </span>
                    @endforeach
                </div>
                @endif
            </div>
           
        </div>
        @endforeach


    
      <style>
       .add-new-bg {
       background-image: url('assets/media/images/2600x1200/bg-4.png');
   }
   .dark .add-new-bg {
       background-image: url('assets/media/images/2600x1200/bg-4-dark.png');
   }
      </style>
    
    @if(auth()->guard('admin')->user()->hasAnyPermission(['create_roles'], 'admin'))
    <a class="card border-2 border-dashed border-brand-clarity bg-center bg-[length:600px] bg-no-repeat add-new-bg" href="{{ route('admin.roles.create') }}">
        <div class="card-body grid items-center">
         <div class="flex flex-col gap-3">
          <div class="flex justify-center pt-5">
           <div class="relative size-[60px] shrink-0">
            <svg class="w-full h-full stroke-brand-clarity fill-light" fill="none" height="48" viewbox="0 0 44 48" width="44" xmlns="http://www.w3.org/2000/svg">
             <path d="M16 2.4641C19.7128 0.320509 24.2872 0.320508 28 2.4641L37.6506 8.0359C41.3634 10.1795 43.6506 14.141 43.6506 
			18.4282V29.5718C43.6506 33.859 41.3634 37.8205 37.6506 39.9641L28 45.5359C24.2872 47.6795 19.7128 47.6795 16 45.5359L6.34937 
			39.9641C2.63655 37.8205 0.349365 33.859 0.349365 29.5718V18.4282C0.349365 14.141 2.63655 10.1795 6.34937 8.0359L16 2.4641Z" fill="">
             </path>
             <path d="M16.25 2.89711C19.8081 0.842838 24.1919 0.842837 27.75 2.89711L37.4006 8.46891C40.9587 10.5232 43.1506 14.3196 43.1506 
			18.4282V29.5718C43.1506 33.6804 40.9587 37.4768 37.4006 39.5311L27.75 45.1029C24.1919 47.1572 19.8081 47.1572 16.25 45.1029L6.59937 
			39.5311C3.04125 37.4768 0.849365 33.6803 0.849365 29.5718V18.4282C0.849365 14.3196 3.04125 10.5232 6.59937 8.46891L16.25 2.89711Z" stroke="">
             </path>
            </svg>
            <div class="absolute leading-none start-2/4 top-2/4 -translate-y-2/4 -translate-x-2/4 rtl:translate-x-2/4">
             <i class="ki-filled ki-rocket text-2xl text-brand">
             </i>
            </div>
           </div>
          </div>
          <div class="flex flex-col text-center">
           <span class="text-lg font-medium text-gray-900 hover:text-primary-active mb-px">
            {{ __('admin.add_new_role_subtitle') }}
           </span>
           <span class="text-2sm text-gray-700">
            {{-- {{ __('admin.add_new_role_subtitle') }} --}}
           </span>
          </div>
         </div>
        </div>
    </a>
    @endif
     </div>
    </div>
    <!-- End of Container -->
   </main>
@endsection 

@section('scripts')
    <script src="{{ asset('js/admin/roles.js') }}"></script>
@endsection
