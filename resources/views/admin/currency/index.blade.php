@extends('layouts.main')

@section('styles')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css"/>
<!-- Custom CSS -->
<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css"/>

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
                <h1 class="text-xl font-medium leading-none text-gray-900">{{ __('currency.currencies') }}</h1>
                <div class="flex items-center gap-2 text-sm font-normal text-gray-700">
                    {{ __('currency.manage_currencies') }}
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card" style="margin:0 5% 5% 5%;">          

            <div class="card-header py-5 flex-wrap gap-2">
                <h3 class="card-title">{{ __('currency.currencies') }}</h3>               
            </div>

            <div class="card-body">
                <div data-datatable="true" data-datatable-page-size="10">
                    <div class="scrollable-x-auto">
                        <table class="table table-border" style="text-align: center;" data-datatable-table="true" id="plans_table">
                            <thead>
                                <tr>
                                    <th class="">
                                        <span class="sort-label text-gray-700 font-normal">{{ __('currency.from_currency') }}</span>
                                    </th>
                                    <th class="">
                                        <span class="sort-label text-gray-700 font-normal">{{ __('currency.to_currency') }}</span>
                                    </th>                                  
                                    <th class="">
                                        <span class="sort-label text-gray-700 font-normal">{{ __('currency.exchange_rate') }}</span>
                                    </th>          
                                    <th class="">
                                        <span class="sort-label text-gray-700 font-normal">{{ __('currency.edit') }}</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($currencies as $currency)
                                    <tr>
                                        <td>
                                            <span>{{ $currency->baseCurrency->name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $currency->targetCurrency->name }}</span>
                                        </td>
                                        <td>
                                            <span class="rate-{{ $currency->id }}">{{ rtrim($currency->rate,"0") }}</span>
                                        </td>
                                        <td>
                                            @if (auth()->guard('admin')->user()->hasAnyPermission(['edit currencies'], 'admin'))
                                            <i class="ki-filled ki-notepad-edit text-xl change-rate " style="cursor: pointer;" data-id = "{{ $currency->id }}" >
                                            </i>                                         
                                         
                                            @endif
                                      
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Plan Modal -->
    {{-- <div class="modal" data-modal="false" id="edit_plan_modal" style="display:none;">
        <div class="modal-content bg-white rounded-lg shadow-xl" style="width:50%;position:fixed; top:50%; left:50%; transform:translate(-50%, -50%);">
            <div class="modal-header flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="modal-title text-xl font-semibold text-gray-900">Edit Plan</h3>
                <button class="btn btn-icon btn-sm btn-ghost hover:bg-gray-100 rounded-full" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross text-gray-500"></i>
                </button>
            </div>
            <div class="modal-body p-6">
                <form id="editPlanForm" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="form-group mt-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="edit_name">
                            Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" class="input" id="edit_name" name="name" required>
                    </div>

                    <div class="form-group mt-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="edit_price">
                            Price <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="0.01" class="input" id="edit_price" name="price" required>
                    </div>

                    <div class="form-group mt-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="edit_duration">
                            Duration (in days) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" class="input" id="edit_duration" name="duration" required>
                    </div>

                    <div class="form-group mt-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="edit_description">
                            Description
                        </label>
                        <textarea class="input" id="edit_description" name="description" rows="3"></textarea>
                    </div>

                    <div class="form-group mt-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="edit_status">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select class="select" id="edit_status" name="is_active" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="modal-footer flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                        <button type="button" class="btn btn-ghost bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg transition duration-200" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary bg-primary hover:bg-primary-dark text-white px-6 py-2.5 rounded-lg transition duration-200">
                            Update Plan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
</main>
@endsection

@section('scripts')
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // const canEditPlans =true;
    // //  @json(auth()->guard('admin')->user()->hasAnyPermission(['edit_plans'], 'admin'));
    // const canDeletePlans = @json(auth()->guard('admin')->user()->hasAnyPermission(['delete_plans'], 'admin'));
</script>
{{-- <script src="{{ asset('js/admin/core.bundle.js') }}"></script> --}}
<script src="{{ asset('assets/js/pages/currencies.js') }}"></script>
@endsection
