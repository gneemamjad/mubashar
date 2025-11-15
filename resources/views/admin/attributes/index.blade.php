@extends('layouts.main')

@section('content')

<main class="grow content pt-5" id="content" role="content">
    <div class="container-fluid">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-gray-900">{{ __('admin.attributes.title') }}</h1>
                <div class="flex items-center gap-2 text-sm font-normal text-gray-700">
                    {{ __('admin.attributes.manage') }}
                </div>
            </div>
        </div>
    </div>
<div class="container-fluid">
    <div class="card" style="margin:0 5% 5% 5%;">

        {{-- @if(auth()->guard('admin')->user()->hasAnyPermission(['add attributes'], 'admin')) --}}

        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-sm btn-primary" style="margin: 10px;" data-bs-toggle="modal" data-bs-target="#my_modal">
                 <a href="{{ route('admin.attributes.create') }}">
                    {{ __('admin.attributes.add') }}
                </a>
            </button>
        </div>
        {{-- @endif --}}

        <div class="card-header py-5 flex-wrap gap-2">
            <h3 class="card-title">
             {{ __('admin.attributes.title') }}
            </h3>
            <div class="flex gap-6">
             <div class="relative">
              <i class="ki-filled ki-magnifier leading-none text-md text-gray-500 absolute top-1/2 start-0 -translate-y-1/2 ms-3">
              </i>
              <input  data-kt-user-table-filter="search" style="padding-right: 2rem;"  class="input input-sm pl-8" placeholder="{{ __('admin.attributes.search') }}" type="text">
             </div>
            
            </div>
           </div>

        {{-- <div class="card-header">
            <h3 class="card-title">Attributes</h3>
            <div class="card-toolbar">
                <a href="{{ route('admin.attributes.create') }}" class="btn btn-primary">
                    Add Attribute
                </a>
            </div>
        </div>

         --}}
        <div class="card-body">
            <table class="table table-bordered"  style="text-align: center" data-datatable-table="true" id="attributes-table">
                <thead>
                    <tr>
                        <th style="text-align: center">{{ __('admin.attributes.key') }}</th>
                        <th style="text-align: center">{{ __('admin.attributes.type') }}</th>
                        <th style="text-align: center">{{ __('admin.attributes.list_type') }}</th>
                        <th style="text-align: center">{{ __('admin.attributes.actions') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="card-footer justify-center md:justify-between flex-col md:flex-row gap-5 text-gray-600 text-2sm font-medium">
            <div class="flex items-center gap-2 order-2 md:order-1">
                {{ __('admin.attributes.show') }}
                <select class="select select-sm w-16" id="datatable_length">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                {{ __('admin.attributes.per_page') }}
            </div>
            <div class="flex items-center gap-4 order-1 md:order-2">
                <div class="datatable-info d-inline-block"><!-- Info will be inserted here by JavaScript --></div>
             
            </div>
        </div>
    </div>
</div>
</main>
@endsection

@section('styles')
<style>
    .dropdown-menu {
        min-width: 100px;
    }
    .dropdown-item {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    .dropdown-item i {
        margin-right: 0.5rem;
    }
</style>
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

{{-- <script src="{{ asset('js/admin/core.bundle.js') }}"></script> --}}

<script src="{{ asset('js/admin/attributes.js') }}"></script>

<script>
$(function() {
    // $('#attributes-table').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     ajax: '{{ route("admin.attributes.data") }}',
    //     columns: [
    //         { data: 'id', name: 'id' },
    //         { data: 'key', name: 'key' },
    //         { data: 'type', name: 'type' },
    //         { data: 'type_name', name: 'type_name', orderable: false },
    //         { data: 'actions', name: 'actions', orderable: false, searchable: false }
    //     ],
    //     order: [[0, 'desc']]
    // });
});
</script>
@endsection
