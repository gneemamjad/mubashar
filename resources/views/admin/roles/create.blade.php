@extends('layouts.main')

@section('content')
<div class="content px-5 py-5 lg:py-7 animate-fadeIn">
    <div class="flex flex-wrap gap-5 mb-6 animate-slideInDown">
        <h3 class="text-2xl font-semibold text-gray-900 dark:text-white hover:text-primary-500 transition-colors duration-300">
            {{ __('admin.roles.create_title') }}
        </h3>
    </div>

    <div class="card transform hover:scale-[1.01] transition-transform duration-300 animate-slideInUp">
        <div class="card-body flex flex-col gap-5 p-6">
            <form action="{{ route('admin.roles.store') }}" method="POST" class="animate-fadeIn">
                @csrf
                
                <div class="flex flex-col gap-5 mb-5">
                    <div class="flex flex-col gap-2 group">
                        <label class="form-label font-medium text-gray-700 dark:text-gray-200 group-hover:text-primary-500 transition-colors duration-300">
                            {{ __('admin.roles.role_name') }}
                        </label>
                        <input type="text" 
                               class="input @error('name') is-invalid @enderror hover:border-primary-500 focus:border-primary-500 transition-colors duration-300" 
                               placeholder="{{ __('admin.roles.role_name_placeholder') }}"
                               name="name"
                               value="{{ old('name') }}"
                               required>
                        @error('name')
                            <div class="text-red-500 text-sm mt-1 animate-shake">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-3">
                        <label class="form-label font-medium text-gray-700 dark:text-gray-200 hover:text-primary-500 transition-colors duration-300">
                            {{ __('admin.roles.permissions') }}
                        </label>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($permissions as $permission)
                            <div class="rounded-xl border p-4 flex items-center justify-between gap-2.5">
                              <div class="flex items-center gap-3.5">
                               <div class="relative size-[45px] shrink-0">
                                <svg class="w-full h-full stroke-gray-300 fill-gray-100" fill="none" height="48" viewbox="0 0 44 48" width="44" xmlns="http://www.w3.org/2000/svg">
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
                                    <i class="ki-filled ki-security-user text-lg text-gray-500">
                                    </i>
                                </div>
                               </div>
                               <div class="flex flex-col gap-1">
                                <span class="flex items-center gap-1.5 leading-none font-medium text-sm text-gray-900">
                                 {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                </span>
                                <span class="text-2sm text-gray-700">
                                </span>
                               </div>
                              </div>
                              <div class="switch switch-sm">
                               <input name="permissions[]" 
                                      type="checkbox" 
                                      value="{{ $permission->id }}"
                                      id="permission{{ $permission->id }}"
                                      {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}/>
                              </div>
                             </div>
                            @endforeach
                        </div>
                        @error('permissions')
                            <div class="text-red-500 text-sm animate-shake">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.roles.index') }}" 
                       class="btn btn-light btn-sm hover:scale-105 transition-transform duration-300">
                        {{ __('admin.roles.cancel') }}
                    </a>
                    <button type="submit" 
                            class="btn btn-sm btn-primary hover:scale-105 hover:shadow-lg transition-all duration-300">
                        {{ __('admin.roles.create_role') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideInDown {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes slideInUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.animate-fadeIn {
    animation: fadeIn 0.5s ease-out;
}

.animate-slideInDown {
    animation: slideInDown 0.5s ease-out;
}

.animate-slideInUp {
    animation: slideInUp 0.5s ease-out;
}

.animate-shake {
    animation: shake 0.5s ease-in-out;
}
</style>
@endsection