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
        {{ __('reports.overview_users') }}
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
    <div class="card">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header text-white">
                <h5 class="card-title mb-0">{{ __('reports.users_report') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('reports.users.export') }}" method="GET" class="needs-validation" novalidate>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="form-floating">
                            <label for="date_from" class="text-sm">{{ __('reports.date_from') }}</label>
                            <input type="date" class="input input-sm w-full" id="date_from" name="date_from">
                        </div>
                        <div class="form-floating">
                            <label for="date_to" class="text-sm">{{ __('reports.date_to') }}</label>
                            <input type="date" class="input input-sm w-full" id="date_to" name="date_to">
                        </div>
                        <div class="form-floating">
                            <label for="version" class="text-sm">{{ __('reports.app_version') }}</label>
                            <select class="select select-sm w-full" id="version" name="version">
                                <option value="">{{ __('reports.all') }}</option>
                                <option value="1.0.0">1.0.0</option>
                            </select>
                        </div>
                        <div class="form-floating">
                            <label for="active" class="text-sm">{{ __('reports.status') }}</label>
                            <select class="select select-sm w-full" id="active" name="active">
                                <option value="">{{ __('reports.all') }}</option>
                                <option value="1">{{ __('reports.active') }}</option>
                                <option value="0">{{ __('reports.inactive') }}</option>
                            </select>
                        </div>
                        <div class="form-floating">
                            <label for="blocked" class="text-sm">{{ __('reports.block_status') }}</label>
                            <select class="select select-sm w-full" id="blocked" name="blocked">
                                <option value="">{{ __('reports.all') }}</option>
                                <option value="1">{{ __('reports.blocked') }}</option>
                                <option value="0">{{ __('reports.not_blocked') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-sm btn-primary btn-lg">
                            {{ __('reports.export') }} <i class="ki-filled ki-right-square"></i>
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
