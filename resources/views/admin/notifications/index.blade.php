@extends('layouts.main')

@section('content')
<style>
    .dt-row {
        position: unset !important;
    }
</style>
<main class="grow content pt-5" id="content" role="content">
    <div class="container-fluid">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-gray-900">{{ __('admin.notifications.title') }}</h1>
                <div class="flex items-center gap-2 text-sm font-normal text-gray-700">
                    {{ __('admin.notifications.manage') }}
                </div>
            </div>
        </div>
    </div>
<div class="container-fluid">
    <div class="card" style="margin:0 5% 5% 5%;">

        @if(auth()->guard('admin')->user()->hasAnyPermission(['send notifications'], 'admin'))
        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.notifications.create') }}" class="btn btn-sm btn-primary" style="margin: 10px;">
                <i class="ki-duotone ki-plus fs-2"></i>{{ __('admin.notifications.add') }}
            </a>
        </div>
        @endif

        <div class="card-header py-5 flex-wrap gap-2">


        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="notifications_table" style="text-align: center;">
                    <thead>
                        <tr>
                            <th style="text-align: center;">{{ __('admin.notifications.title') }}</th>
                            <th style="text-align: center;">{{ __('admin.notifications.type') }}</th>
                            <th style="text-align: center;">{{ __('admin.notifications.status') }}</th>
                            <th style="text-align: center;">{{ __('admin.notifications.sent_date') }}</th>
                            {{-- <th>Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
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
</main>

@endsection

@section('scripts')
<script>
    let lang = $('#lang').val();
    $(document).ready(function() {
        var table = $('#notifications_table').DataTable({
            processing: true,
            serverSide: true,
            dom:'<"top"r>',
            ajax: "{{ route('admin.notifications.data') }}",
            order: [[0, 'desc']],
            columns: [
                {data: 'title', name: 'title', orderable: false},
                {data: 'type', name: 'type', orderable: false},
                {data: 'status', name: 'status', orderable: false},
                {data: 'sent_date', name: 'sent_at', orderable: false},
                // {data: 'actions', name: 'actions', orderable: false, searchable: false}
            ]
            ,
            "order" : [ [3,'desc'] ],
            "drawCallback": function(settings) {
                // Update pagination info
                let info = table.page.info();
                let paginationHtml = createCustomPagination(info);
                
                let html = `
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="fs-10" id="custom-pagination">
                            ${info.start + 1}-${info.end} of ${info.recordsTotal}  ${paginationHtml}
                        </div>
                    </div>`;
                
                $('.datatable-info').html(html);
    
                // Bind click events for pagination buttons
                $('#custom-pagination button[data-page]').on('click', function() {
                    const page = $(this).data('page');
                    let newPage = info.page;
    
                    if (page === 'prev') {
                        newPage = Math.max(0, info.page - 1);
                    } else if (page === 'next') {
                        newPage = Math.min(info.pages - 1, info.page + 1);
                    } else {
                        newPage = parseInt(page);
                    }
    
                    if (newPage !== info.page) {
                        table.page(newPage).draw('page');
                    }
                });
            }

        });

        function createCustomPagination(info) {
        if (info.pages <= 1) return '';

        let paginationHtml = '';
        const currentPage = info.page;
        const totalPages = info.pages;
        let first_arrow_dir = "left";
        let second_arrow_dir = "right";
        if(lang == 'ar'){
            first_arrow_dir = "right";
            second_arrow_dir = "left";
        }
        // Add prev button
        paginationHtml += `
            <button class="btn btn-icon btn-sm border-0 btn-light-primary" 
                data-page="prev" ${currentPage <= 0 ? 'disabled' : ''}>
                <i class="ki-outline ki-black-`+first_arrow_dir+` fs-7"></i>
            </button>`;

        // First page
        paginationHtml += `
            <button class="btn btn-icon btn-sm border-0 btn-light-primary ${currentPage === 0 ? 'active' : ''}" 
                data-page="0">1</button>`;

        // Add ellipsis and middle pages
        if (currentPage > 2) {
            paginationHtml += '<span class="mx-2">...</span>';
        }

        for (let i = Math.max(1, currentPage - 1); i <= Math.min(totalPages - 2, currentPage + 1); i++) {
            if (i <= 0 || i >= totalPages - 1) continue;
            paginationHtml += `
                <button class="btn btn-icon btn-sm border-0 btn-light-primary ${i === currentPage ? 'active' : ''}" 
                    data-page="${i}">${i + 1}</button>`;
        }

        if (currentPage < totalPages - 3) {
            paginationHtml += '<span class="mx-2">...</span>';
        }

        // Last page
        if (totalPages > 1) {
            paginationHtml += `
                <button class="btn btn-icon btn-sm border-0 btn-light-primary ${currentPage === totalPages - 1 ? 'active' : ''}" 
                    data-page="${totalPages - 1}">${totalPages}</button>`;
        }

        // Next button
        paginationHtml += `
            <button class="btn btn-icon btn-sm border-0 btn-light-primary" 
                data-page="next" ${currentPage >= totalPages - 1 ? 'disabled' : ''}>
                <i class="ki-outline ki-black-`+second_arrow_dir+` fs-7"></i>
            </button>`;

        return paginationHtml;
    }

    
    $('#datatable_length').on('change', function() {
        table.page.len($(this).val()).draw();
    });
        // Handle delete button click
        $(document).on('click', '.delete-notification', function() {
            var notificationId = $(this).data('id');

            Swal.fire({
                title: lang == 'ar' ? "هل أنت متاكد؟" : "Are you sure?",
                text: lang == 'ar' ? "لا يمكنك التراجع عن هذا!" : "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: lang == 'ar' ? "نعم، قم بالحذف!" : "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.notifications.destroy', '') }}/" + notificationId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                // Refresh the DataTable
                                table.ajax.reload();

                                // Show success toast
                                Swal.fire({
                                    icon: 'success',
                                    title: lang == 'ar' ? "تم حذف الإشعار بنجاح!" : "Deleted!",
                                    text: lang == 'ar' ? "تم حذف الإشعار بنجاح!" : "Notification has been deleted.",
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                        },
                        error: function(xhr) {
                            // Show error toast
                            Swal.fire({
                                icon: 'error',
                                title: lang == 'ar' ? "حدث خطأ!" : "Error!",
                                text: lang == 'ar' ? "حدث خطأ أثناء حذف الإشعار!" : "Something went wrong while deleting the notification.",
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
