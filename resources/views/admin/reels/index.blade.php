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
    .required:af{!! __('admin.reels') !!} {
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
        {{ __('admin.reels') }}
       </h1>
       <div class="flex items-center gap-2 text-sm font-normal text-gray-700">
        {{ __('admin.reels_overview') }}
       </div>
      </div>
      <div class="flex items-center gap-2.5">

      </div>
     </div>
    </div>
    <!-- End of Container -->
<div class="container-fluid">
    <div class="card" style="margin:0 5% 5% 5%;">
    @if(auth()->guard('admin')->user()->hasAnyPermission(['create_ads'], 'admin'))

    <div class="d-flex justify-content-end">
        <a href="{{route('admin.reels.createReel')}}" class="btn btn-sm btn-primary" style="margin: 10px;">
            <i class="ki-duotone ki-plus fs-2"></i>{{ __('reels.add') }}
        </a>
    </div>
    @endif
    <div class="card-header py-5 flex-wrap gap-2">
        <h3 class="card-title">
         {{ __('admin.reels') }}
        </h3>
        <div class="flex gap-6">

            <div class="relative">
                <label for="from_date" class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.from_date') }}</label>
                <input type="date" class="input input-sm" name="from_date" id="from_date" data-kt-user-table-filter="from_date" />
             </div>

             <div class="relative">
                <label for="to_date" class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.to_date') }}</label>
                <input type="date" class="input input-sm" name="to_date" id="to_date" data-kt-user-table-filter="to_date" />
             </div>

            @if ($pending == 0)
            <div class="relative">
                <label for="status-filter" class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.status') }}</label>
                <select class="select select-sm" id="status-filter" data-kt-user-table-filter="select" >
                    <option value="">{{ __('admin.all') }}</option>
                    <option value="0">{{ __('admin.pending') }}</option>
                    <option value="1">{{ __('admin.approved') }}</option>
                    <option value="2">{{ __('admin.rejected') }}</option>
                </select>
             </div>
            @endif
          
         <div class="relative">
          <label for="search" class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.search') }}</label>
          <i class="ki-filled ki-magnifier leading-none text-md text-gray-500 absolute start-0 -translate-y-1/5 ms-3" style="top: 55%">
          </i>
            <input id="search" data-kt-user-table-filter="search" style="padding-right: 2rem;" class="input input-sm pl-8 " style="padding-right: 2rem;" placeholder="{{ __('admin.search_ads') }}" type="text">
         </div>
        
        
        </div>
       </div>
       
    <div class="card-body">
        
        <div data-datatable="true" data-datatable-page-size="10">
            <input type="hidden" value="{{ $pending }}" id="pending" />  
            <div class="">
                <table style="text-align: center" class="table table-border fluid" data-datatable-table="true" id="reels_table">
                    <thead>
                        <tr>               
                            <th class="" style="text-align: center">
                                    <span class="text-gray-700 font-normal">
                                        {{ __('admin.ad_number') }}
                                    </span>                                   
                            </th>
                            <th class="" style="text-align: center">
                                <span class="">
                                    <span class="text-gray-700 font-normal">
                                        {{ __('admin.title') }}
                                    </span>
                                   
                                </span>
                            </th>
                            <th class="" style="text-align: center">
                                <span class="">
                                    <span class="text-gray-700 font-normal">
                                        {{ __('admin.description') }}
                                    </span>
                                   
                                </span>
                            </th>
                            <th class="" style="text-align: center">
                                <span class="">
                                    <span class="text-gray-700 font-normal">
                                        {{ __('admin.reel') }}
                                    </span>
                                   
                                </span>
                            </th>
                            <th class="" style="text-align: center">
                                <span class="">
                                    <span class="text-gray-700 font-normal">
                                        {{ __('admin.creation_date') }}
                                    </span>                                   
                                </span>
                            </th>
                            <th class="" style="text-align: center">
                                <span class="">
                                    <span class="text-gray-700 font-normal">
                                        {{ __('admin.status') }}
                                    </span>                                   
                                </span>
                            </th>
                            <th class="" style="text-align: center">
                                    <span class="text-gray-700 font-normal">
                                        {{ __('admin.actions') }}
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
                    <div class="datatable-info d-inline-block">
                        {{ __('admin.showing') }} {{ __('admin.entries') }}
                    </div>
                 
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="videoModalLabel">Video</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <video id="videoPlayer" controls style="width: 100%; max-height: 500px;">
          <source src="" type="video/mp4">
          Your browser does not support HTML5 video.
        </video>
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

<script>
    const canEditAdmins = @json(auth()->guard('admin')->user()->hasAnyPermission(['edit_admins'], 'admin'));
    const canDeleteAdmins = @json(auth()->guard('admin')->user()->hasAnyPermission(['delete_admins'], 'admin'));
</script>
{{-- <script src="{{ asset('js/admin/core.bundle.js') }}"></script> --}}
<script src="{{ asset('assets/js/pages/reels.js') }}"></script>
<script>
    $(document).on('click', '.view-video', function () {
        let videoUrl = $(this).data('video');
        $('#videoPlayer source').attr('src', videoUrl);
        $('#videoPlayer')[0].load();
        $("#videoModal").css({
            'opacity': 1,
            'z-index': 100000
        });
    });

// Optional: Stop video when modal is closed
$('#videoModal').on('hidden.bs.modal', function () {
    $('#videoPlayer')[0].pause();
});

</script>
@endsection






