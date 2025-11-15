@extends('layouts.main')

@section('content')
    <main class="grow content pt-5" id="content" role="content">
        <div class="container-fluid">
            <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
                <div class="flex flex-col justify-center gap-2">
                    <h1 class="text-xl font-medium leading-none text-gray-900">{{ __('admin.ads_reviews.reviews') }}</h1>
                    <div class="flex items-center gap-2 text-sm font-normal text-gray-700">
                        {{ __('admin.ads_reviews.reviews_description') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card" style="margin:0 5% 5% 5%;">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="reviews_table">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.ads_reviews.reviewer') }}</th>
                                    <th>{{ __('admin.ads_reviews.ad_title') }}</th>
                                    <th>{{ __('admin.ads_reviews.review_text') }}</th>
                                    <th>{{ __('admin.ads_reviews.review_date') }}</th>
                                    <th>{{ __('admin.ads_reviews.actions') }}</th>
                                </tr>
                            </thead>
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
                        <div class="datatable-info d-inline-block">
                            {{ __('admin.showing') }} {{ __('admin.entries') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
<script>
"use strict";

// Class definition
var KTReviews = function () {
    // Private variables
    var table;
    var datatable;
    var lang;

    // Handle pagination
    var handlePagination = function() {
        const info = datatable.page.info();
        const currentPage = info.page;
        const totalPages = info.pages;
        const pageSize = info.length;
        const startingNum = (currentPage * pageSize) + 1;
        const endingNum = Math.min((currentPage + 1) * pageSize, info.recordsTotal);

        // Create custom pagination HTML
        let paginationHtml = '';
        if (totalPages > 1) {
            let first_arrow_dir = lang === 'ar' ? "right" : "left";
            let second_arrow_dir = lang === 'ar' ? "left" : "right";

            paginationHtml += `
                <div class="d-flex align-items-center justify-content-between">
                    <div class="fs-10">
                        ${startingNum}-${endingNum} of ${info.recordsTotal}
                    </div>
                    <div id="custom-pagination">
                        <button class="btn btn-icon btn-sm border-0 btn-light-primary me-2"
                            data-page="prev" ${currentPage <= 0 ? 'disabled' : ''}>
                            <i class="ki-outline ki-black-${first_arrow_dir} fs-7"></i>
                        </button>`;

            // First page
            paginationHtml += `
                <button class="btn btn-icon btn-sm border-0 btn-light-primary me-2 ${currentPage === 0 ? 'active' : ''}"
                    data-page="0">1</button>`;

            // Middle pages
            if (currentPage > 2) {
                paginationHtml += '<span class="mx-2">...</span>';
            }

            for (let i = Math.max(1, currentPage - 1); i <= Math.min(totalPages - 2, currentPage + 1); i++) {
                if (i <= 0 || i >= totalPages - 1) continue;
                paginationHtml += `
                    <button class="btn btn-icon btn-sm border-0 btn-light-primary me-2 ${i === currentPage ? 'active' : ''}"
                        data-page="${i}">${i + 1}</button>`;
            }

            if (currentPage < totalPages - 3) {
                paginationHtml += '<span class="mx-2">...</span>';
            }

            // Last page
            if (totalPages > 1) {
                paginationHtml += `
                    <button class="btn btn-icon btn-sm border-0 btn-light-primary me-2 ${currentPage === totalPages - 1 ? 'active' : ''}"
                        data-page="${totalPages - 1}">${totalPages}</button>`;
            }

            // Next button
            paginationHtml += `
                        <button class="btn btn-icon btn-sm border-0 btn-light-primary"
                            data-page="next" ${currentPage >= totalPages - 1 ? 'disabled' : ''}>
                            <i class="ki-outline ki-black-${second_arrow_dir} fs-7"></i>
                        </button>
                    </div>
                </div>`;
        }

        // Update pagination container
        $('.datatable-info').html(paginationHtml);

        // Handle pagination clicks
        $('#custom-pagination button[data-page]').on('click', function() {
            const page = $(this).data('page');
            let newPage = currentPage;

            if (page === 'prev') {
                newPage = Math.max(0, currentPage - 1);
            } else if (page === 'next') {
                newPage = Math.min(totalPages - 1, currentPage + 1);
            } else {
                newPage = parseInt(page);
            }

            if (newPage !== currentPage) {
                datatable.page(newPage).draw('page');
            }
        });
    }

    // Private functions
    var initReviewsTable = function () {
        table = $('#reviews_table');
        lang = document.querySelector('html').getAttribute('lang') || 'en';

        // Init datatable
        datatable = table.DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('ads.reviews.data') }}"
            },
            columns: [
                {
                    data: null,
                    render: function(data) {
                        return `${data.user.first_name} ${data.user.last_name}<br>
                                <small>${data.user.mobile}</small>`;
                    }
                },
                {
                    data: 'ad_title'
                },
                {
                    data: 'note',
                    width: '30%',
                    render: function(data) {
                        return `<div style="word-break: break-word; white-space: pre-wrap; min-width: 200px; max-width: 300px; line-height: 1.5;">
                                    ${data}
                                </div>`;
                    }
                },
                {
                    data: 'created_at'
                },
                {
                    data: null,
                    render: function(data) {
                        return `<a href="/admin/ads/${data.ad_id}" class="btn btn-sm btn-primary">
                                    <i class="ki-duotone ki-eye fs-5">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </a>`;
                    }
                }
            ],
            order: [[3, 'desc']],
            pageLength: 10,
            dom:'<"top"r>',
            pageLength: 10,
            "drawCallback": function(settings) {
                // Update pagination info
                let info = datatable.page.info();
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
                        datatable.page(newPage).draw('page');
                    }
                });
            }
        });
    }

       // Add length change event handler
       $('#datatable_length').on('change', function() {
        datatable.page.len($(this).val()).draw();
    });

     // Function to create custom pagination
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

    // Public methods
    return {
        init: function () {
            initReviewsTable();
        }
    }
}();

// On document ready
$(document).ready(function() {
    KTReviews.init();
});
</script>
@endsection
