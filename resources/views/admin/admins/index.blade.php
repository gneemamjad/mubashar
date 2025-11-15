@extends('layouts.main')

@section('styles')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css"/>

<!-- Custom CSS -->
<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css"/>

<!-- Add these modal-specific styles -->
<style>
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5);
    }
    .modal {
        display: none;
    }
    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .required:after {
        content: " *";
        color: red;
    }
</style>
@endsection

@section('content')
<main class="grow content pt-5" id="content" role="content">

  
    <div class="container-fluid">
     <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
      <div class="flex flex-col justify-center gap-2">
       <h1 class="text-xl font-medium leading-none text-gray-900">
        {{ __('admin.adminsT') }}
    </h1>
       <div class="flex items-center gap-2 text-sm font-normal text-gray-700">
        {{ __('admin.admins.overview') }}
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
<div class="container-fluid">
    <div class="card" style="margin:0 5% 5% 5%;">

    @if(auth()->guard('admin')->user()->hasAnyPermission(['create_admins'], 'admin'))

    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-sm btn-primary" style="margin: 10px;" data-bs-toggle="modal" data-bs-target="#my_modal">
            <i class="ki-duotone ki-plus fs-2"></i>{{ __('admin.admins.add_admin') }}
        </button>
    </div>
    @endif
    {{-- <div class="card-header border-0 pt-6">
        <div class="card-title">
          
        </div>
        <div class="card-toolbar">
            @can('create_admins')
            <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#createAdminModal">
                <i class="ki-duotone ki-plus fs-2"></i>Add Admin
            </button>
            @endcan

            <div class="d-flex align-items-center position-relative my-1">
                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <input type="text" 
                    data-kt-user-table-filter="search" 
                    class="form-control form-control-solid w-250px ps-13" 
                    placeholder="Search admin"
                    autocomplete="off" />
            </div>

        </div>
    </div> --}}

    <div class="card-header py-5 flex-wrap gap-2">
        <h3 class="card-title">
         {{ __('admin.adminsT') }}
        </h3>
        <div class="flex gap-6">
         <div class="relative">
          <i class="ki-filled ki-magnifier leading-none text-md text-gray-500 absolute top-1/2 start-0 -translate-y-1/2 ms-3">
          </i>
          <input  data-kt-user-table-filter="search" style="padding-right: 2rem;"  class="input input-sm pl-8" placeholder="{{ __('admin.admins.search_admins') }}" type="text">
         </div>
        
        </div>
       </div>
       
    <div class="card-body">
        <div data-datatable="true" data-datatable-page-size="10">
            <div class="">
                <table class="table table-border" style="text-align: center" data-datatable-table="true" id="admins_table">
                    <thead>
                        <tr>                           
                            <th class="" style="text-align: center">
                                    <span class="text-gray-700 font-normal">
                                        {{ __('admin.admins.table.name') }}
                                    </span>
                                  
                            </th>
                            <th class="" style="text-align: center">
                                    <span class="text-gray-700 font-normal">
                                        {{ __('admin.admins.table.email') }}
                                    </span>
                            </th>
                            <th class="" style="text-align: center">
                                    <span class="text-gray-700 font-normal">
                                        {{ __('admin.admins.table.role') }}
                                    </span>
                            </th>
                            <th class="" style="text-align: center">
                                    <span class="text-gray-700 font-normal">
                                        {{ __('admin.admins.table.status') }}
                                    </span>
                            </th>
                            <th class="" style="text-align: center">
                                    <span class="text-gray-700 font-normal">
                                        {{ __('admin.admins.table.actions') }}
                                    </span>                                   
                            </th>
                          
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="card-footer justify-center md:justify-between flex-col md:flex-row gap-5 text-gray-600 text-2sm font-medium">
                <div class="flex items-center gap-2 order-2 md:order-1">
                    {{ __('admin.admins.show') }}
                    <select class="select select-sm w-16" id="datatable_length">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    {{ __('admin.admins.per_page') }}
                </div>
                <div class="flex items-center gap-4 order-1 md:order-2">
                    <div class="datatable-info d-inline-block"><!-- Info will be inserted here by JavaScript --></div>
                 
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</main>

<div class="modal"  data-modal="false" id="my_modal" style="display:none;">
    <div class="modal-content bg-white rounded-lg shadow-xl" style="width:50%;position:fixed; top:50%; left:50%; transform:translate(-50%, -50%);">
        <div class="modal-header flex items-center justify-between p-6 border-b border-gray-200">
            <h3 class="modal-title text-xl font-semibold text-gray-900">
                {{ __('admin.admins.create_new_admin') }}
            </h3>
            <button class="btn btn-icon btn-sm btn-ghost hover:bg-gray-100 rounded-full" data-bs-dismiss="modal">
                <i class="ki-outline ki-cross text-gray-500"></i>
            </button>
        </div>
        <div class="modal-body p-6">
            <form id="createAdminForm" method="POST" action="{{ route('admins.store') }}" class="space-y-6">
                @csrf
                <div class="form-group mt-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="name">
                        {{ __('admin.admins.form.name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" class="input" id="name" name="name" required>
                </div>

                <div class="form-group mt-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="email">
                        {{ __('admin.admins.form.email') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="email" class="input" id="email" name="email" required>
                </div>

                <div class="form-group mt-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="password">
                        {{ __('admin.admins.form.password') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" class="input" id="password" name="password" required>
                      
                    </div>
                </div>

                <div class="form-group mt-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="password_confirmation">
                        {{ __('admin.admins.form.password_confirmation') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" class="input" id="password_confirmation" name="password_confirmation" required>
                       
                    </div>
                </div>

                <div class="form-group mt-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="role">
                        {{ __('admin.admins.form.role') }} <span class="text-red-500">*</span>
                    </label>
                    <select class="select" id="role" name="role" required>
                        <option value="">{{ __('admin.admins.form.select_role') }}</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-footer flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                    <button type="button" class="btn btn-ghost bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg transition duration-200" data-bs-dismiss="c-modal">
                        {{ __('admin.admins.buttons.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary bg-primary hover:bg-primary-dark text-white px-6 py-2.5 rounded-lg transition duration-200">
                        {{ __('admin.admins.buttons.create') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal - Create Admin-->

<div class="modal" data-modal="false" id="edit_modal" style="display:none;">
    <div class="modal-content bg-white rounded-lg shadow-xl" style="width:50%;position:fixed; top:50%; left:50%; transform:translate(-50%, -50%);">
        <div class="modal-header flex items-center justify-between p-6 border-b border-gray-200">
            <h3 class="modal-title text-xl font-semibold text-gray-900">
                {{ __('admin.admins.edit_admin') }}
            </h3>
            <button class="btn btn-icon btn-sm btn-ghost hover:bg-gray-100 rounded-full" data-bs-dismiss="edit-modal">
                <i class="ki-outline ki-cross text-gray-500"></i>
            </button>
        </div>
        <div class="modal-body p-6">
            <form id="editAdminForm" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="form-group mt-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="edit_name">
                        {{ __('admin.admins.form.name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" class="input" id="edit_name" name="name" required>
                </div>

                <div class="form-group mt-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="edit_email">
                        {{ __('admin.admins.form.email') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="email" class="input" id="edit_email" name="email" required>
                </div>

                <div class="form-group mt-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="edit_password">
                        {{ __('admin.admins.form.password') }} 
                        <small>({{ __('admin.admins.form.keep_current_password') }})</small>
                    </label>
                    <div class="relative">
                        <input type="password" class="input" id="edit_password" name="password">
                    </div>
                </div>

                <div class="form-group mt-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="edit_password_confirmation">
                        {{ __('admin.admins.form.password_confirmation') }}
                    </label>
                    <div class="relative">
                        <input type="password" class="input" id="edit_password_confirmation" name="password_confirmation">
                    </div>
                </div>

                <div class="form-group mt-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="edit_role">
                        {{ __('admin.admins.form.role') }} <span class="text-red-500">*</span>
                    </label>
                    <select class="select" id="edit_role" name="role" required>
                        <option value="">{{ __('admin.admins.form.select_role') }}</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="edit_status">
                        {{ __('admin.admins.form.status') }} <span class="text-red-500">*</span>
                    </label>
                    <select class="select" id="edit_status" name="is_active" required>
                        <option value="1">{{ __('admin.admins.form.active') }}</option>
                        <option value="0">{{ __('admin.admins.form.inactive') }}</option>
                    </select>
                </div>

                <div class="modal-footer flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                    <button type="button" class="btn btn-ghost bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg transition duration-200" data-bs-dismiss="c-edit-modal">
                        {{ __('admin.admins.buttons.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary bg-primary hover:bg-primary-dark text-white px-6 py-2.5 rounded-lg transition duration-200">
                        {{ __('admin.admins.buttons.update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const canEditAdmins = @json(auth()->guard('admin')->user()->hasAnyPermission(['edit_admins'], 'admin'));
    const canDeleteAdmins = @json(auth()->guard('admin')->user()->hasAnyPermission(['delete_admins'], 'admin'));
</script>
<script src="{{ asset('assets/js/pages/admins.js') }}"></script>
@endsection
