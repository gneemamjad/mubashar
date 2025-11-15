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
               {{ __('admin.users.title') }}
            </h1>
            <div class="flex items-center gap-2 text-sm font-normal text-gray-700">
               {{ __('admin.users.overview') }}
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
         <div class="card-header py-5 flex-wrap gap-2">
            <h3 class="card-title">
               {{ __('admin.users.title') }}
            </h3>
            <div class="flex gap-6">
               <div class="relative">
                  <i class="ki-filled ki-magnifier leading-none text-md text-gray-500 absolute top-1/2 start-0 -translate-y-1/2 ms-3">
                  </i>
                  <input  data-kt-user-table-filter="search" style="padding-right: 2rem;" class="input input-sm pl-8" placeholder="{{ __('admin.users.search') }}" type="text">
               </div>
            </div>
         </div>
         <div class="card-body" style="overflow: auto;">
            <div data-datatable="true" data-datatable-page-size="10">
               <div class="">
                  <table class="table table-border" style="text-align: center" data-datatable-table="true" id="users_table" >
                     <thead>
                        <tr>
                           <th class="" style="text-align: center">
                              <span class="text-gray-700 font-normal">
                              {{ __('admin.users.columns.first_name') }}
                              </span>
                           </th>
                           <th class="" style="text-align: center">
                              <span class="text-gray-700 font-normal">
                              {{ __('admin.users.columns.last_name') }}
                              </span>
                           </th>
                           <th class="" style="text-align: center">
                              <span class="text-gray-700 font-normal">
                              {{ __('admin.users.columns.username') }}
                              </span>
                           </th>
                           <th class="" style="text-align: center">
                              <span class="text-gray-700 font-normal">
                              {{ __('admin.users.columns.app_version') }}
                              </span>
                           </th>
                           <th class="" style="text-align: center">
                              <span class="text-gray-700 font-normal">
                              {{ __('admin.users.columns.email') }}
                              </span>
                           </th>
                           <th class="" style="text-align: center">
                              <span class="text-gray-700 font-normal">
                              {{ __('admin.users.columns.currency') }}
                              </span>
                           </th>
                           <th class="" style="text-align: center">
                              <span class="sort-label text-gray-700 font-normal">
                              {{ __('admin.users.columns.created_at') }}
                              </span>
                           </th>
                           <th class="" style="text-align: center">
                              <span class="text-gray-700 font-normal">
                              {{ __('admin.users.columns.otp') }}
                              </span>
                           </th>
                           <th class="" style="text-align: center">
                              <span class="text-gray-700 font-normal">
                              {{ __('admin.users.columns.mobile') }}
                              </span>
                           </th>
                           <th class="" style="text-align: center">
                              <span class="text-gray-700 font-normal">
                              {{ __('admin.users.columns.active') }}
                              </span>
                           </th>
                           <th class="" style="text-align: center">
                              <span class="text-gray-700 font-normal">
                              {{ __('admin.users.columns.blocked') }}
                              </span>
                           </th>
                           <th class="" style="text-align: center">
                              <span class="text-gray-700 font-normal">
                              {{ __('admin.users.columns.actions') }}
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
                     {{ __('admin.users.show') }}
                     <select class="select select-sm w-16" id="datatable_length">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                     </select>
                     {{ __('admin.users.per_page') }}
                  </div>
                  <div class="flex items-center gap-4 order-1 md:order-2">
                     <div class="datatable-info d-inline-block">
                        <!-- Info will be inserted here by JavaScript -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</main>
@endsection
@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   const canEditUsers = @json(auth()->guard('admin')->user()->hasAnyPermission(['edit_users'], 'admin'));
</script>
{{-- <script src="{{ asset('js/admin/core.bundle.js') }}"></script> --}}
<script src="{{ asset('assets/js/pages/users.js') }}"></script>
@endsection