@extends('layouts.main')

@section('content')

<main class="grow content pt-5" id="content" role="content">
    <div class="container-fluid">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-gray-900">{{ __('admin.cities.title') }}</h1>
                <div class="flex items-center gap-2 text-sm font-normal text-gray-700">
                    {{ __('admin.cities.manage') }}
                </div>
            </div>
        </div>
    </div>
<div class="container-fluid">
    <div class="card" style="margin:0 5% 5% 5%;">


        @if(auth()->guard('admin')->user()->hasAnyPermission(['add cities'], 'admin'))

    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-sm btn-primary addCityModal" id="create-city" style="margin: 10px;" data-bs-toggle="modal" data-bs-target="#addCityModal">
            <i class="ki-duotone ki-plus fs-2"></i>{{ __('admin.cities.add') }}
        </button>
    </div>
    @endif
    <div class="card-header py-5 flex-wrap gap-2">
        <h3 class="card-title">
         {{ __('admin.cities.title') }}
        </h3>
        <div class="flex gap-6">
         <div class="relative">
          <i class="ki-filled ki-magnifier leading-none text-md text-gray-500 absolute top-1/2 start-0 -translate-y-1/2 ms-3">
          </i>
          <input  data-kt-user-table-filter="search"  class="input input-sm pl-8" style="padding-right: 2rem" placeholder="{{ __('admin.cities_areas.search_placeholder') }}" type="text">
         </div>

        </div>
       </div>


                <div class="card-body">
                    <table class="table table-bordered" style="text-align: center" id="cities-table">
                        <thead>
                            <tr>
                                <th style="text-align: center">{{ __('admin.cities_areas.name_en') }}</th>
                                <th style="text-align: center">{{ __('admin.cities_areas.name_ar') }}</th>
                                <th style="text-align: center">{{ __('admin.status') }}</th>
                                <th style="text-align: center">{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="card-footer justify-center md:justify-between flex-col md:flex-row gap-5 text-gray-600 text-2sm font-medium">
                    <div class="flex items-center gap-2 order-2 md:order-1">
                        {{ __('admin.show') }}
                        <select class="select select-sm w-16" id="datatable_length">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        {{ __('admin.per_page') }}
                    </div>
                    <div class="flex items-center gap-4 order-1 md:order-2">
                        <div class="datatable-info d-inline-block"><!-- Info will be inserted here by JavaScript --></div>

                    </div>
                </div>

    </div>
</div>

<!-- Add City Modal -->
<div class="modal fade" style="width: 50%; margin: 0 auto;" id="addCityModal" tabindex="-1" aria-labelledby="addCityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCityModalLabel">{{ __('admin.cities_areas.add_new_city') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCityForm" class="form">
                    @csrf
                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2 text-sm">{{ __('admin.cities_areas.name_en') }}</label>
                        <input type="text" name="name_en" id="name_en" class="input-sm input mb-3 mb-lg-0" placeholder="{{ __('admin.cities_areas.name_en') }}"/>
                    </div>
                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2 text-sm">{{ __('admin.cities_areas.name_ar') }}</label>
                        <input type="text" name="name_ar" id="name_ar" class="input-sm input mb-3 mb-lg-0" placeholder="{{ __('admin.cities_areas.name_ar') }}"/>
                    </div>
                </form>
            </div>
            <div class="modal-footer m-5">
                <button type="reset" class="btn btn-light me-3 btn-sm close-add-modal" data-kt-modal-action="cancel">{{ __('admin.discard') }}</button>
                <button type="button" id="saveCity" class="btn btn-primary btn-sm">
                    <span class="indicator-label">{{ __('admin.submit') }}</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit City Modal -->
<div class="modal fade" id="editCityModal" style="width: 50%; margin: 0 auto;" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2>{{ __('admin.cities_areas.edit_city') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="editCityForm" class="form">
                    @csrf
                    <input type="hidden" name="city_id" id="city_id">

                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2 text-sm">{{ __('admin.cities_areas.name_en') }}</label>
                        <input type="text" name="name_en_edit" id="name_en_edit" class="input-sm input mb-3 mb-lg-0" placeholder="{{ __('admin.cities_areas.name_en') }}"/>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2 text-sm">{{ __('admin.cities_areas.name_ar') }}</label>
                        <input type="text" name="name_ar_edit" id="name_ar_edit" class="input-sm input mb-3 mb-lg-0" placeholder="{{ __('admin.cities_areas.name_ar') }}"/>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2 text-sm">{{ __('admin.status') }}</label>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_active_edit" id="is_active_edit" class="form-check-input toggle-status" />
                            <label class="form-check-label" for="is_active_edit">{{ __('admin.active') }}</label>
                        </div>
                    </div>

                    <div class="modal-footer m-5">
                        <button type="reset" class="btn btn-light me-3 btn-sm close-edit-modal" data-kt-modal-action="cancel">{{ __('admin.discard') }}</button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <span class="indicator-label">{{ __('admin.submit') }}</span>
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
    <script src="{{ asset('js/admin/cities.js') }}"></script>
@endsection
