@extends('layouts.main')

@section('content')

<main class="grow content pt-5" id="content" role="content">
    <div class="container-fluid">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-gray-900">{{ __('areas.areas') }}</h1>
                <div class="flex items-center gap-2 text-sm font-normal text-gray-700">
                    {{ __('areas.area_management') }}
                </div>
            </div>
        </div>
    </div>
<div class="container-fluid">
    <div class="card" style="margin:0 5% 5% 5%;">

        
        @if(auth()->guard('admin')->user()->hasAnyPermission(['add areas'], 'admin'))

    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-sm btn-primary addAreaModal" id="create-area" style="margin: 10px;" data-bs-toggle="modal" data-bs-target="#addAreaModal">
            <i class="ki-duotone ki-plus fs-2"></i>{{ __('areas.add_new') }}
        </button>
    </div>
    @endif
    <div class="card-header py-5 flex-wrap gap-2">
        <h3 class="card-title">
         
            {{ __('areas.areas') }}
        </h3>
        <div class="flex gap-6">
         <div class="relative">
          <i class="ki-filled ki-magnifier leading-none text-md text-gray-500 absolute top-1/2 start-0 -translate-y-1/2 ms-3">
          </i>
          <input  data-kt-user-table-filter="search" style="padding-right: 2rem;"  class="input input-sm pl-8" placeholder="{{ __('areas.search_areas') }}" type="text">
         </div>
        
        </div>
       </div>

               
                <div class="card-body">
                    <table class="table table-bordered" style="text-align: center;" id="areas-table">
                        <thead>
                            <tr>
                                {{-- <th>ID</th> --}}
                                <th style="text-align: center;">{{ __('areas.area_name') }}</th>
                                <th style="text-align: center;">{{ __('areas.area_name') }}</th>
                                <th style="text-align: center;">{{ __('areas.city') }}</th>
                                <th style="text-align: center;">{{ __('areas.status') }}</th>
                                <th style="text-align: center;">{{ __('areas.actions') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="card-footer justify-center md:justify-between flex-col md:flex-row gap-5 text-gray-600 text-2sm font-medium">
                    <div class="flex items-center gap-2 order-2 md:order-1">
                        {{ __('areas.show') }}
                        <select class="select select-sm w-16" id="datatable_length">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        {{ __('areas.per_page') }}
                    </div>
                    <div class="flex items-center gap-4 order-1 md:order-2">
                        <div class="datatable-info d-inline-block"><!-- Info will be inserted here by JavaScript --></div>
                     
                    </div>
                </div>

    </div>
</div>

<!-- Add City Modal -->
<div class="modal fade" style="width: 50%; margin: 0 auto;" id="addAreaModal" tabindex="-1" aria-labelledby="addCityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCityModalLabel">{{ __('areas.add_new') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCityForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name_en" class="text-sm">{{ __('areas.area_name') }}</label>
                        <input type="text" class="input input-sm" id="name_en" name="name_en" required>
                    </div>
                    <div class="mb-3">
                        <label for="name_ar" class="text-sm">{{ __('areas.area_name') }}</label>
                        <input type="text" class="input input-sm" id="name_ar" name="name_ar" required>
                    </div>
                    <div class="mb-3">
                        <label for="name_ar" class="text-sm">{{ __('areas.city') }}</label>
                        <select class="select select-sm" name="city" id="city">
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer m-5">
                <button type="button" class="btn btn-secondary btn-sm input-sm text-sm  close-add-modal" data-bs-dismiss="modal">{{ __('areas.close') }}</button>
                <button type="button" class="btn btn-primary btn-sm input-sm text-sm" id="saveArea">{{ __('areas.save') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit City Modal -->
<div class="modal fade" id="editAreaModal" style="width: 50%; margin: 0 auto;" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2>{{ __('areas.edit') }}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary close-edit-modal" data-kt-modal-action="close">
                    <i class="ki-outline ki-cross fs-1"></i>
                </div>
            </div>

            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="editAreaForm" class="form">
                    @csrf
                    <input type="hidden" name="area_id" id="area_id">
                    
                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2 text-sm">{{ __('areas.area_name') }}</label>
                        <input type="text" name="name_en_edit" id="name_en_edit" class="input-sm input mb-3 mb-lg-0" placeholder="English name"/>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2 text-sm">{{ __('areas.area_name') }}</label>
                        <input type="text" name="name_ar_edit" id="name_ar_edit" class="input-sm input mb-3 mb-lg-0" placeholder="Arabic name"/>
                    </div>

                    <div class="mb-3">
                        <label for="name_ar" class="text-sm">{{ __('areas.city') }}</label>
                        <select class="select select-sm" name="city_edit" id="city_edit">
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2 text-sm">{{ __('areas.status') }}</label>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_active_edit" id="is_active_edit" class="form-check-input toggle-status" />
                            <label class="form-check-label" for="is_active_edit">{{ __('areas.active') }}</label>
                        </div>
                    </div>

                    <div class="modal-footer m-5">
                        <button type="reset" class="btn btn-light me-3 btn-sm close-edit-modal" data-kt-modal-action="cancel">Discard</button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <span class="indicator-label">{{ __('areas.submit') }}</span>
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
    <script src="{{ asset('js/admin/areas.js') }}"></script>
@endsection
