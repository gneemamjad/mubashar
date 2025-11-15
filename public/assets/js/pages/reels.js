"use strict";
let lang = $('#lang').val();

// Class definition
var KTReels = function () {
    // Shared variables
    var table;
    var datatable;
    var toolbarBase;
    var toolbarSelected;
    var selectedCount;

    // Private functions
    var initDatatable = function () {

        var pending = $('#pending').val();

        var url = '/admin/reels/data';

        if(pending == 1)
            url = '/admin/reels/data-pending';

        // Init datatable --- more info on datatables: https://datatables.net/manual/
        datatable = $(table).DataTable({
            processing: true,
            serverSide: true,
            sortable: true,
            dom:'<"top"r>',
            'ajax': {
                url: url,
                type: 'POST',
                data: function(d) {
                    // Add status filter to the data sent to server
                    d.status = $('#status-filter').val();
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            'columns': [
                { data: 'ad_number', name: 'ad_number' , orderable: false},
                { data: 'ad_title', name: 'ad_title' , orderable: false},
                { data: 'description_excerpt', name: 'description' , orderable: false},
                {
                    data: 'reel',
                    name: 'reel',
                    orderable: false,
                    render: function (data, type, row) {
                        if (!data) return '';
                        return `
                            <button type="button" class="btn btn-sm btn-primary view-video" 
                                data-bs-toggle="modal" 
                                data-bs-target="#videoModal" 
                                data-video="${data}">
                                View Video
                            </button>
                        `;
                    }
                },
                // { data: 'type_name', name: 'type' , orderable: false},
                { data: 'created_at_formatted', name: 'created_at' , orderable: true},
                // { data: 'active_budge', name: 'active' , orderable: false},
                { data: 'status_badge', name: 'status', orderable: false, searchable: false },
                // { data: 'premium_ad', name: 'premium_ad', orderable: false, searchable: false },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            "order": [[ 4 , 'desc']],
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

        // Re-init functions on every table re-draw
        datatable.on('draw', function () {
            KTMenu.createInstances();
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

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-user-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    var handleSearchFromDateDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-user-table-filter="from_date"]');
        filterSearch.addEventListener('change', function (e) {
            datatable.draw();
        });
    }

    var handleButtons = () => {
        $(document).off('click', '.action-confirm').on('click', '.action-confirm', function (e) {
            e.preventDefault();

            let url = $(this).attr('href');
            let message = $(this).data('message') || 'Are you sure?';

            Swal.fire({
                title: 'Are you sure?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, continue',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    }

    var handleSearchToDateDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-user-table-filter="to_date"]');
        filterSearch.addEventListener('change', function (e) {
            datatable.draw();
        });
    }


        // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
        var handleSearchSelectDatatable = () => {
            const filterSearch = document.querySelector('[data-kt-user-table-filter="select"]');
            if (filterSearch) {
                filterSearch.addEventListener('change', function (e) {
                    datatable.draw();
                });
            }
        }



    // Public methods
    return {
        init: function () {
            table = document.querySelector('#reels_table');

            if (!table) {
                return;
            }

            initDatatable();
            handleSearchDatatable();
            handleSearchSelectDatatable();
            handleSearchToDateDatatable();
            handleSearchFromDateDatatable();
            handleButtons();
        }
    };
}();

// On document ready
$(document).ready(function() {
    KTReels.init();

    $('#status-filter')
});
