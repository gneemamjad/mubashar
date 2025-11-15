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
        {{ __('reports.reports') }}   
       </h1>
       <div class="flex items-center gap-2 text-sm font-normal text-gray-700">
        {{ __('reports.overview_ads') }}
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
  

    <div class="card mt-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header text-white">
                <h5 class="card-title mb-0">{{ __('reports.ads') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('reports.ads.export') }}" method="GET" class="needs-validation" novalidate>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="form-floating">
                            <label for="ads_date_from" class="text-sm">{{ __('admin.from_date') }}</label>
                            <input type="date" class="input input-sm w-full" id="ads_date_from" name="date_from">
                        </div>
                        <div class="form-floating">
                            <label for="ads_date_to" class="text-sm">{{ __('admin.to_date') }}</label>
                            <input type="date" class="input input-sm w-full" id="ads_date_to" name="date_to">
                        </div>
                        <div class="form-floating">
                            <label for="ads_active" class="text-sm">{{ __('admin.activation') }}</label>
                            <select class="select w-full select-sm" id="ads_active" name="active">
                                <option value="">{{ __('admin.all') }}</option>
                                <option value="1">{{ __('admin.active') }}</option>
                                <option value="0">{{ __('admin.inactive') }}</option>
                            </select>
                        </div>
                        <div class="form-floating">
                            <label for="ads_active" class="text-sm">{{ __('admin.status') }}</label>
                            <select class="select w-full select-sm" id="ads_active" name="status">
                                <option value="">{{ __('admin.all') }}</option>
                                <option value="0">{{ __('admin.pending') }}</option>
                                <option value="1">{{ __('admin.approved') }}</option>
                                <option value="2">{{ __('admin.rejected') }}</option>
                            </select>
                        </div>
                        <div class="form-floating">
                            <label for="paid" class="text-sm">{{ __('admin.paid_status') }}</label>
                            <select class="select w-full select-sm" id="paid" name="paid">
                                <option value="">{{ __('admin.all') }}</option>
                                <option value="1">{{ __('admin.paid') }}</option>
                                <option value="0">{{ __('admin.unpaid') }}</option>
                            </select>
                        </div>
                        <div class="form-floating">
                            <label for="category" class="text-sm">{{ __('admin.type') }}</label>
                            <select class="select w-full select-sm" id="category" name="type">
                                <option value="">{{ __('admin.all') }}</option>
                                <option value="1">{{ __('admin.realsate') }}</option>
                                <option value="15">{{ __('admin.vehicles') }}</option>
                            </select>
                        </div>

                        <div class="form-floating">
                            <label for="category" class="text-sm">{{ __('admin.category') }}</label>
                            <select class="select w-full select-sm" id="category" name="category">
                                <option value="">{{ __('admin.all') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-floating">
                            <label for="city" class="text-sm">{{ __('admin.city') }}</label>
                            <select class="select w-full select-sm" id="city" name="city">
                                <option value="">{{ __('admin.all') }}</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-floating">
                            <label for="has_location" class="text-sm">{{ __('admin.location_status') }}</label>
                            <select class="select w-full select-sm" id="has_location" name="has_location">
                                <option value="">{{ __('admin.all') }}</option>
                                <option value="1">{{ __('admin.has_location') }}</option>
                                <option value="0">{{ __('admin.no_location') }}</option>
                            </select>
                        </div>
                        <div class="form-floating">
                            <label for="admin" class="text-sm">{{ __('admin.added_by') }}</label>
                            <select class="select w-full select-sm" id="added_by" name="added_by">
                                <option value="">{{ __('admin.all') }}</option>
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-floating">
                            <label for="admin" class="text-sm">{{ __('admin.approved_by') }}</label>
                            <select class="select w-full select-sm" id="approved_by" name="approved_by">
                                <option value="">{{ __('admin.all') }}</option>
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="text-end mt-4">
                        
                        <button type="submit" class="btn btn-primary btn-sm btn-lg">
                                {{ __('admin.export') }} <i class="ki-filled ki-right-square"></i>
                        </button>
                    </div>
                </form>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


{{-- <script src="{{ asset('js/admin/core.bundle.js') }}"></script> --}}
@endsection
